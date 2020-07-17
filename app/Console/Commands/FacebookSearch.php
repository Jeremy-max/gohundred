<?php

namespace App\Console\Commands;

use App\Campaign;
use App\Http\Repository\SearchOptions;
use App\Http\Repository\SlackNotify;
use App\Keyword;
use App\Search;
use App\Slack;
use Illuminate\Console\Command;

class FacebookSearch extends Command
{
    protected $search_repo, $slack_repo;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'search:facebook {campaign_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->search_repo = new SearchOptions;
        $this->slack_repo = new SlackNotify;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $id = $this->argument('campaign_id');
        $campaign = Campaign::find($id);
        $facebook_array = $this->search_facebook($id);

        $slack_list = Slack::where('campaign_id', $id)->get();
        if (Count($slack_list)) {
            $slack_facebook_array = $this->slack_repo->slack_wrapper($facebook_array, $campaign, "Facebook");
            foreach ($slack_list as $slack) {
                $this->slack_repo->send_slack_message($slack_facebook_array, $slack);
            }
        }
    }

    public function search_facebook($campaign_id)
    {
        $keyword_list = Keyword::where('campaign_id', $campaign_id)->get();
        $slack_array = [];
        foreach ($keyword_list as $keyword)
        {
            $fb_array = $this->facebookApi($keyword);
            array_push($slack_array, ['keyword' => $keyword->keyword, 'array' => $fb_array]);
        }
        return $slack_array;
    }

    public function facebookApi($keyword)
    {
        $access_token = env('ACCESS_TOKEN_FB');
        $app_token = env('APP_TOKEN_FB');
        $app_secret = env('APP_SECRET_FB');
        $appsecret_proof= hash_hmac('sha256', $access_token, $app_secret);
        $fb_db = [];
        $client = new \GuzzleHttp\Client();
        try {
            $response = $client->get(
                'https://graph.facebook.com/v5.0/pages/search',
                array(
                    'query' => array(
                        'q' => $keyword->keyword,
                        'fields' => 'id,name,verification_status,location,link,is_unclaimed,is_eligible_for_branded_content',
                        'access_token' => $app_token,
                        'appsecret_proof' => $appsecret_proof
                    )
                )
            );

            $fbPageNameArray = json_decode($response->getBody()->getContents(), true);
            $pageCnt = count($fbPageNameArray['data']);
            $i = 0;
            while($i < $pageCnt)
            {
                $pageName = $fbPageNameArray['data'][$i]['id'];
                try {
                    $data = fb_feed()
                    ->setAccessToken($app_token)
                    ->setPage($pageName)
                    ->findKeyword($keyword->keyword)
                    ->fields("id,message,created_time,permalink_url")
                    ->fetch();
                    $res = $this->parseFacebook($data, $keyword->id);
                    if($res){
                        $fb_db = array_merge($fb_db, $res);
                    }
                } catch (\Exception $th) {
                    dump($th);
                }
                $i++;
            }
            Search::insert($fb_db);
        } catch (\Exception $th) {
            dump($th);
        }
     dump("Facebook search result data is added to DB successfully!");
      return $fb_db;
    }

    public function parseFacebook($fb_response, $keyword_id) {

        if($fb_response['error'] == true)
        return false;
        $cnt = count($fb_response['data']);
        $i = 0;
        $table_fb = [];
        while ($i < $cnt)
        {
            $item = $fb_response['data'][$i];

            $url = $item['permalink_url'];
            if(Search::where('url', $url)->first()){
                $i++;
                continue;
            }

            if(count($item) < 4)
            {
                $i++;
                continue;
            }
            $title = $this->search_repo->parseTitle($item["message"]);

            $date_string = substr($item['created_time'], 0, 10);

            if(date_create($date_string) < date_create("2019-11-11"))
            {
                $i++;
                continue;
            }
        $value = [
            'keyword_id' => $keyword_id,
            'social_type' => 'facebook',
            'title' => $title,
            'date' => date($date_string),
            'url' => $url,
            'sentiment' => $this->search_repo->sentimentAnalysis($title)
        ];
        array_push($table_fb,$value);

        $i++;
        }

        return $table_fb;
    }
}

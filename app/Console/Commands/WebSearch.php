<?php

namespace App\Console\Commands;

use App\Campaign;
use App\Http\Repository\SearchOptions;
use App\Http\Repository\SlackNotify;
use App\Keyword;
use App\Search;
use App\Slack;
use Illuminate\Console\Command;
use JanDrda\LaravelGoogleCustomSearchEngine\LaravelGoogleCustomSearchEngine;

class WebSearch extends Command
{
    protected $search_repo, $slack_repo;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'search:google {campaign_id}';

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
        $web_array = $this->search_web($id);

        $slack_list = Slack::where('campaign_id', $id)->get();
        if (Count($slack_list)) {
            $slack_web_array = $this->slack_repo->slack_wrapper($web_array, $campaign, "Google");
            foreach ($slack_list as $slack) {
                $this->slack_repo->send_slack_message($slack_web_array, $slack);
            }
        }
    }

    public function search_web($campaign_id)
    {

        $keyword_list = Keyword::where('campaign_id', $campaign_id)->get();

        $slack_array = [];
        foreach ($keyword_list as $keyword) {
            $web_array = $this->webApi($keyword);
            array_push($slack_array, ['keyword' => $keyword->keyword, 'array' => $web_array]);
        }
        return $slack_array;
    }
    public function webApi($keyword)
    {
        // dd('Hello, web!!');
        $engineId = env('SEARCH_ENGINE_ID');
        $apiKey = env('API_KEY_WEB');

        $fulltext = new LaravelGoogleCustomSearchEngine(); // initialize

        $fulltext->setEngineId($engineId); // sets the engine ID
        $fulltext->setApiKey($apiKey);

        $dateY = date('Y');
        $dateM = date('m');
        $dateD = date('d');
        $limit_cnt = 50;


        $sumCnt = 0;
        $params = [
        'num' => 10,
        'start' => 1,
        'dateRestrict' => 'y[$dateY],m[$dateM],d[$dateD]'
        ];
        $web_db = [];
        while(1)
        {
            try{
                $results = $fulltext->getResults($keyword->keyword, $params);
                $web_db = array_merge($web_db, $this->parseWeb($results, $keyword->id));
            } catch(\Exception $e) {
            dump('Error occurred for:\r\nSearching ' . $sumCnt . ' items exceeded free trial version limitation');
                break;
            }


            // if(count($results) < $limit_cnt)
            //   break;
            if($sumCnt >= $limit_cnt)
                break;

            $params['start'] = $params['start'] + 10;
            $sumCnt += 10;
        }
        Search::insert($web_db);
        // dump("Google data is added to DB successfully!");

        return $web_db;
    }

    public function parseWeb($response, $keywordId)
    {
        $cnt = count($response);
        $i = 0;
        $tWeb = [];
        while ($i < $cnt)
        {
            $url = $response[$i]->link;
            if(Search::where('url', $url)->first()){
                $i++;
                continue;
            }
        $title = $this->search_repo->parseTitle($response[$i]->title);
        $value = [
            'keyword_id' => $keywordId,
            'social_type' => 'web',
            'title' => $title,
            'date' => date('Y-m-d'),
            'url' => $url,
            'sentiment' => $this->search_repo->sentimentAnalysis($title)
        ];
        array_push($tWeb,$value);
    //      dump($value);
        $i++;
        }
        return $tWeb;
    }
}

<?php

namespace App\Console\Commands;

use App\Campaign;
use App\Http\Repository\SearchOptions;
use App\Http\Repository\SlackNotify;
use App\Keyword;
use App\Search;
use App\Slack;
use Google_Client;
use Google_Service_YouTube;
use Illuminate\Console\Command;

class YoutubeSearch extends Command
{
    protected $search_repo, $slack_repo;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'search:youtube {campaign_id}';

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
     * Execute the console command.s
     *
     * @return mixed
     */
    public function handle()
    {
        dump("youtube start");
        $id = $this->argument('campaign_id');
        $campaign = Campaign::find($id);
        $youtube_array = $this->search_youtube($id);

        $slack_list = Slack::where('campaign_id', $id)->get();
        if (Count($slack_list)) {
            $slack_youtube_array = $this->slack_repo->slack_wrapper($youtube_array, $campaign, "Youtube");
            foreach ($slack_list as $slack) {
                $this->slack_repo->send_slack_message($slack_youtube_array, $slack);
            }
        }
        dump("youtube end");
    }

    public function search_youtube($campaign_id)
  {
//    $campaign_list = Campaign::where('user_id', auth()->user()->id)->get();
    $keyword_list = Keyword::where('campaign_id', $campaign_id)->get();

    $slack_array = [];
    foreach ($keyword_list as $keyword)
    {
      $youtube_array = $this->youtubeApi($keyword);
      array_push($slack_array, ['keyword' => $keyword->keyword, 'array' => $youtube_array]);
    }
    return $slack_array;
  }
  public function youtubeApi($keyword)
  {
    $DEVELOPER_KEY = env('API_KEY_YOUTUBE');
    $client = new Google_Client();
    $client->setDeveloperKey($DEVELOPER_KEY);
    // Define an object that will be used to make all API requests.
    $youtube = new Google_Service_YouTube($client);

    $date=date_create("2019-11-11");
    $publishAfter = date_format($date,DATE_ATOM);

    $order = ['viewCount', 'date', 'rating', 'relevance', 'title', 'videoCount'];
    $type = ['video', 'channel', 'playlist'];
    $limit_cnt = 10;
    $params = [
      'q' => $keyword->keyword,
      'maxResults' => $limit_cnt,
      'order' => $order[1],
      'pageToken' => null,
      'type' => $type[0],
      'publishedAfter' => $publishAfter
    ];
    $sum = 0;

    $youtube_db = [];
     while(1)
     {
        try{
          $searchResponse = $youtube->search->listSearch('id,snippet', $params);
          $youtube_db = array_merge($youtube_db, $this->parseYoutube($searchResponse, $keyword->id));
        } catch(\Exception $e) {
          dump('Error occurred for:\r\nSearching ' . $limit_cnt . ' items exceeded free trial version limitation');
          dump($e->getMessage());
          break;
        }

        if(count($searchResponse->items) < $limit_cnt || $sum > 10){
          break;
        }

        $params['pageToken'] = $searchResponse->nextPageToken;
        $sum += $limit_cnt;
     }
 //     dump($youtube_db);
      Search::insert($youtube_db);
     dump("Youtube data is added to DB successfully!");
     return $youtube_db;
  }

  public function parseYoutube($response, $keywordId)
  {
    $cnt = count($response->items);
    $i = 0;
    $tYoutube = [];
    set_time_limit(3000);
    while ($i < $cnt)
    {
        $url = 'https://youtube.com/watch?v=' . $response->items[$i]->id->videoId;
        if(Search::where('url', $url)->first()){
            $i++;
            continue;
        }
        $title = $this->search_repo->parseTitle($response->items[$i]->snippet->title);
        $date = substr($response->items[$i]->snippet->publishedAt,0,10);
        $value = [
            'keyword_id' => $keywordId,
            'social_type' => 'youtube',
            'title' => $title,
            'date' => date($date),
            'url' => $url,
            'sentiment' => $this->search_repo->sentimentAnalysis($title),
            'lang_type' => $this->search_repo->getLanguageType($title)
        ];
        array_push($tYoutube,$value);
    //      dump($value);
        $i++;
    }
    return $tYoutube;
  }
}

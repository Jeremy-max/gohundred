<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Search;
use App\Keyword;
use App\Campaign;


use Google_Client;
use Google_Service_YouTube;
use JanDrda\LaravelGoogleCustomSearchEngine\LaravelGoogleCustomSearchEngine;
use Abraham\TwitterOAuth\TwitterOAuth;

class SearchAPI implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $podcast;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($campaign)
    {
        $this->podcast = $campaign;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->search_twitter($this->podcast);
        // $this->search_youtube($this->podcast);
        // $this->search_web($this->podcast);
    }


    public function search_twitter($campaign)
  {
  //  $campaign_list = Campaign::where('user_id', auth()->user()->id)->get();
    $keyword_list = Keyword::where('campaign_id', $campaign->id)->get();

    foreach ($keyword_list as $keyword)
    {
      $this->twitterApi($keyword);
    }

//    return redirect()->route('dashboard');
  }
  public function twitterApi($keyword)
  {
    $consumer_key = env('CONSUMER_KEY');
    $consumer_secret = env('CONSUMER_SECRET');
    $access_token_key = env('ACCESS_TOKEN_KEY');
    $access_token_secret = env('ACCESS_TOKEN_SECRET');

    $connection = new TwitterOAuth(
      $consumer_key,
      $consumer_secret,
      $access_token_key,
      $access_token_secret
    );

      $limit_cnt = 10;
      $params = [
        'q' => $keyword->keyword,
        'count' => $limit_cnt,
        'max_id' => null
      ];
//    $tweets = $connection->get('search/tweets', $params);
//    dd($tweets);
      $tweets_db = [];
      $sum = 0;
     while(1)
     {

       try{
          $tweets = $connection->get('search/tweets', $params);
          if(isset($tweets->errors))
          {
            dump('Error occurred for rate limit exceeded free trial version limitation');
            break;
          }
          else{
            if($this->parseTweets($tweets,$keyword->id))
              $tweets_db = array_merge($tweets_db, $this->parseTweets($tweets,$keyword->id));
          }
        } catch(\Exception $e) {
          dump('Error occurred for:\r\nSearching ' . $limit_cnt . ' items exceeded free trial version limitation');
          break;
          //return false;
        }
        if(count($tweets->statuses) < $limit_cnt || $sum > 30){
          break;
        }
        $params['max_id'] = $this->getMaxId($tweets);
        $sum += $limit_cnt;
      }
//      dump($tweets_db);
      Search::insert($tweets_db);
//    dump("Tweets search result data is added to DB successfully!");
//    return redirect()->route('dashboard');
  }

  public function getMaxId($tweets)
  {
    $startIdx = stripos($tweets->search_metadata->next_results, 'max_id=');
    $maxidstr = substr($tweets->search_metadata->next_results, $startIdx + 7);
    $endIdx = stripos($maxidstr, '&');
    if ($endIdx != -1)
      $maxidstr = substr($maxidstr,0, $endIdx);

    return (int)$maxidstr;
  }

  public function tweetsDateParse($str)
  {
    $date = date_create_from_format("D M d H:i:s O Y", $str);
    $new_date = date_format($date,"Y-m-d");
    return $new_date;
  }

  public function parseTweets($tweets, $keyword_id) {
    if(!isset($tweets->statuses))
      return false;
    $cnt = count($tweets->statuses);
    $i = 0;
    $table_tweets = [];
    while ($i < $cnt)
    {
      $title = $tweets->statuses[$i]->text;
      $date = $this->tweetsDateParse($tweets->statuses[$i]->created_at);
      if(strlen($title) > 100)
        $title = mb_substr($title, 0, 99);
      $value = [
        'keyword_id' => $keyword_id,
        'social_type' => 'twitter',
        'title' => $title,
        'date' => date($date),
        'url' => 'https://twitter.com/' . $tweets->statuses[$i]->user->screen_name . '/status/' . $tweets->statuses[$i]->id_str
      ];
      array_push($table_tweets,$value);
      // Search::firstOrCreate([
      //   'keyword_id' => 1,
      //   'social_type' => 'twitter',
      //   'title' => $title],[
      //   'date' => $tweets->statuses[$i]->user->created_at,
      //   'url' => 'https://twitter.com/' . $tweets->statuses[$i]->user->screen_name . '/status/' . $tweets->statuses[$i]->id_str
      // ]);
      $i++;
    }
    return $table_tweets;

  }

  public function search_twitch()
  {
      dd("Hello, this is twitch background!");


  }


  public function search_tiktok()
  {
//    dd('Hello, tiktok!!');
    $keyword_list = Keyword::where('campaign_id', $campaign->id)->get();
    foreach ($keyword_list as $keyword)
    {
      $this->tiktokApi($keyword);
    }
  }

  public function tiktokApi()
  {
    // dd('Hello, web!!');


    $client = new \App\sabri\tiktok\TiktokApi([
        'device_id' => env('DEVICE_ID'),
        'iid' => env('IID'),
        'openudid' => env('OPENUDID')
    ]);

    $sumCnt = 0;
    $params = [
      'keyword' => "keyword",
      'count' => 10,
      'start' => 0,
    ];

      $tiktok_db = [];
      // while(1)
      // {
      //     $sumCnt += 10;
      //     try{
            $results = $client.searchHashtags($params);
            dd($results);
//             $tiktok_db = array_merge($tiktok_db, $this->parseTiktok($results, $keyword->id));
//           } catch(\Exception $e) {
//  //           dump('Error occurred for:\r\nSearching ' . $sumCnt . ' items exceeded free trial version limitation');
//             break;
//           }


//           // if(count($results) < $limit_cnt)
//           //   break;
//            if($sumCnt > $limit_cnt)
//              break;

//           $params['cursor'] = $params['cursor'] + 10;
//       }
//       dump($tiktok_db);
 //   Search::insert($tiktok_db);
  }

  public function parseTiktok($response, $keywordId)
  {
    $cnt = count($response);
    $i = 0;
    $tWeb = [];
    while ($i < $cnt)
    {
      $title = $response[$i]->title;
      if(strlen($title) > 100)
        $title = mb_substr($title, 0, 99);
      $value = [
        'keyword_id' => $keywordId,
        'social_type' => 'tiktok',
        'title' => $title,
        'date' => date('Y-m-d'),
        'url' => $response[$i]->link
      ];
      array_push($tWeb,$value);
//      dump($value);
      $i++;
    }
    return $tWeb;
  }


  public function search_youtube($campaign)
  {
//    $campaign_list = Campaign::where('user_id', auth()->user()->id)->get();
    $keyword_list = Keyword::where('campaign_id', $campaign->id)->get();
    foreach ($keyword_list as $keyword)
    {
      $this->youtubeApi($keyword);
    }
//    dump("Youtube data is added to DB successfully!");
//    return redirect()->route('dashboard');
  }
  public function youtubeApi($keyword)
  {
//    dd('Hello, youtube!!');

    $DEVELOPER_KEY = env('API_KEY_YOUTUBE');
  //  dd($DEVELOPER_KEY);
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
//          dump('Error occurred for:\r\nSearching ' . $limit_cnt . ' items exceeded free trial version limitation');
          break;
        }

       if(count($searchResponse->items) < $limit_cnt || $sum > 10)
         break;

        $params['pageToken'] = $searchResponse->nextPageToken;
        $sum += $limit_cnt;
     }
 //     dump($youtube_db);
      Search::insert($youtube_db);

//    return redirect()->route('dashboard');

  }

  public function parseYoutube($response, $keywordId)
  {
    $cnt = count($response->items);
    $i = 0;
    $tYoutube = [];
    set_time_limit(3000);
    while ($i < $cnt)
    {
      $title = $response->items[$i]->snippet->title;
      $date = substr($response->items[$i]->snippet->publishedAt,0,10);
      if(strlen($title) > 100)
        $title = mb_substr($title, 0, 99);
      $value = [
        'keyword_id' => $keywordId,
        'social_type' => 'youtube',
        'title' =>  $title,
        'date' => date($date),
        'url' => 'https://youtube.com/watch?v=' . $response->items[$i]->id->videoId
      ];
      array_push($tYoutube,$value);
//      dump($value);
      $i++;
      break;
    }

    return $tYoutube;
  }


  public function search_web($campaign)
  {
//    $campaign_list = Campaign::where('user_id', auth()->user()->id)->get();
    $keyword_list = Keyword::where('campaign_id', $campaign->id)->get();
    foreach ($keyword_list as $keyword)
    {
      $this->webApi($keyword);
    }
//    return redirect()->route('dashboard');
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
    $limit_cnt = 40;


    $sumCnt = 0;
    $params = [
      'num' => 10,
      'start' => 1,
      'dateRestrict' => 'y[$dateY],m[$dateM],d[$dateD]'
    ];

      $web_db = [];
      while(1)
      {
          $sumCnt += 10;
          try{
            $results = $fulltext->getResults($keyword->keyword, $params);
            $web_db = array_merge($web_db, $this->parseWeb($results, $keyword->id));
          } catch(\Exception $e) {
 //           dump('Error occurred for:\r\nSearching ' . $sumCnt . ' items exceeded free trial version limitation');
            break;
          }


          // if(count($results) < $limit_cnt)
          //   break;
           if($sumCnt > $limit_cnt)
             break;

          $params['start'] = $params['start'] + 10;
      }
 //     dump($web_db);
    Search::insert($web_db);
 //   dump("Google data is added to DB successfully!");

//    return redirect()->route('dashboard');
  }

  public function parseWeb($response, $keywordId)
  {
    $cnt = count($response);
    $i = 0;
    $tWeb = [];
    while ($i < $cnt)
    {
      $title = $response[$i]->title;
      if(strlen($title) > 100)
        $title = mb_substr($title, 0, 99);
      $value = [
        'keyword_id' => $keywordId,
        'social_type' => 'web',
        'title' => $title,
        'date' => date('Y-m-d'),
        'url' => $response[$i]->link
      ];
      array_push($tWeb,$value);
//      dump($value);
      $i++;
    }
    return $tWeb;
  }
}

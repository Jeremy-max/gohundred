<?php

namespace App\Http\Controllers;


use App\Search;
use App\Keyword;

use Illuminate\Http\Request;
use Abraham\TwitterOAuth\TwitterOAuth;
use Illuminate\Support\Facades\View;

use Google_Client;
use Google_Service_YouTube;
use GoogleSearchResults;
use App\Http\Controllers\Controller;
use JanDrda\LaravelGoogleCustomSearchEngine\LaravelGoogleCustomSearchEngine;
use ButterCMS\ButterCMS;

use DateTime;
use DatePeriod;
use DateInterval;


class HomeController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    // $user = \Auth::user();
    // dd($user);
    // if($user)
    // {
    //   dd("sdf");
    //   $keyword_list = Keyword::where('user_id', $user->id)->get();
      
     
    //   View::share('keyword_list', $keyword_list);
    // }
      // $this->middleware('auth');

    $this->middleware(function ($request, $next) {
    $user = \Auth::user();
    if ($user) {
      $keyword_list = Keyword::where('user_id',$user->id)->get();  
      if ($keyword_list->count() > 0)
      {
        $keyword = $keyword_list->first()->keyword;
        View::share('keyword', $keyword);
      }
      View::share('keyword_list', $keyword_list);
    }
    return $next($request);
  });
  }

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */


  public function search_twitter()
  {
    $this->twitterApi();
    return redirect()->route('dashboard');
  }
  public function twitterApi()
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

    $keyword_list = Keyword::where('user_id', auth()->user()->id)->get();
    foreach ($keyword_list as $keyword)
    {
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
//            dump('Error occurred for rate limit exceeded free trial version limitation');
            break;
          }
          else{
            if($this->parseTweets($tweets,$keyword->id))
              $tweets_db = array_merge($tweets_db, $this->parseTweets($tweets,$keyword->id));
          }
        } catch(\Exception $e) {
//          dump('Error occurred for:\r\nSearching ' . $limit_cnt . ' items exceeded free trial version limitation');
          break;
          //return false;
        }
        if(count($tweets->statuses) < $limit_cnt || $sum > 30)
            break;
      
        $params['max_id'] = $this->getMaxId($tweets);
        $sum += $limit_cnt;
      }
//      dump($tweets_db);
      Search::insert($tweets_db);
    }
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

  public function search_facebook()
  {
      dd("Hello, this is facebook background!");
//     $app_id = env('APP_ID_FB');
//     $app_secret = env('APP_SECRET_FB');
//     $access_token = env('ACCESS_TOKEN_FB');
//     $appsecret_proof= hash_hmac('sha256', $access_token, $app_secret);
//     $app_access_token = env('APP_TOKEN_FB');
//     dump($app_id);
//     dump($app_secret);
//     dump($access_token);
//     dump($appsecret_proof);
//     dump($app_access_token);
//     $fb = new \Facebook\Facebook([
//       'app_id' => $app_id,
//       'app_secret' => $appsecret_proof,
//       'default_graph_version' => 'v5.7',
//      'default_access_token' => $access_token, // optional
//     ]);

//     try {
//       // Get the \Facebook\GraphNodes\GraphUser object for the current user.
//       // If you provided a 'default_access_token', the '{access-token}' is optional.
//  //     $response = $fb->get('/me', $access_token);
//       $request = $fb->request('get', '/search?q=freelancer&type=user');
//       $response = $fb->getClient()->sendRequest($request);
//       $graphNode = $response->getGraphNode();
//       dd($graphNode);
// //  dd(213);
//  dd($mySrch);
//     } catch(\Facebook\Exceptions\FacebookResponseException $e) {
//       // When Graph returns an error

//       echo 'Graph returned an error: ' . $e->getMessage();
//       exit;
//     } catch(\Facebook\Exceptions\FacebookSDKException $e) {
//       // When validation fails or other local issues
//       echo 'Facebook SDK returned an error: ' . $e->getMessage();
//       exit;

//     }
    
//    $me = $response->getGraphUser();
  }


  public function search_instagram()
  {
//    dd('Hello, instagram!!');
    
/*    $consumer_key = env('CONSUMER_KEY');
    $consumer_secret = env('CONSUMER_SECRET');
    $access_token_key = env('ACCESS_TOKEN_KEY');
    $access_token_secret = env('ACCESS_TOKEN_SECRET');
    $connection = new TwitterOAuth(
      $consumer_key,
      $consumer_secret,
      $access_token_key,
      $access_token_secret
    ); 
    $limit_cnt = 50;
    $params = [
      'q' => "fgkjngfdjfdslkj",
      'count' => $limit_cnt,
      'max_id' => null
    ];
      $tweets_db = [];
//     while(1)
//     {

        $tweets = $connection->get('search/tweets', $params);
        $errors = $this->parseTweets($tweets, 1);
        dd($errors);
      
      //  if(count($tweets->statuses) < $limit_cnt)
      //    break;
      
      //   $params['max_id'] = $this->getMaxId($tweets);
//   }
//   dump($tweets_db);
*/
  }


  public function search_youtube()
  {
    $this->youtubeApi();
    return redirect()->route('dashboard');
  }
  public function youtubeApi()
  {
//    dd('Hello, youtube!!');

    $DEVELOPER_KEY = env('API_KEY_YOUTUBE');
  //  dd($DEVELOPER_KEY);
    $client = new Google_Client();
    $client->setDeveloperKey($DEVELOPER_KEY);
    // Define an object that will be used to make all API requests.
    $youtube = new Google_Service_YouTube($client);

    $keyword_list = Keyword::where('user_id', auth()->user()->id)->get();

    $order = ['viewCount', 'date', 'rating', 'relevance', 'title', 'videoCount'];
    $type = ['video', 'channel', 'playlist'];
    foreach ($keyword_list as $keyword)
    {
      $limit_cnt = 10;
      $params = [
        'q' => $keyword->keyword,
        'maxResults' => $limit_cnt,
        'order' => $order[1],
        'pageToken' => null,
        'type' => $type[0]
//        'publishedAfter' => '2019-11-11'
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
    }
 //   dump("Youtube data is added to DB successfully!");
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
      if(date("2019-11-11") > date($date))
        continue;
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
    }

    return $tYoutube;
  }


  public function search_web()
  {
    $this->webApi();
    return redirect()->route('dashboard');
  }
  public function webApi()
  {
    // dd('Hello, web!!');
    $engineId = env('SEARCH_ENGINE_ID');
    $apiKey = env('API_KEY_WEB');

    $fulltext = new LaravelGoogleCustomSearchEngine(); // initialize
    
    $fulltext->setEngineId($engineId); // sets the engine ID
    $fulltext->setApiKey($apiKey);

    $keyword_list = Keyword::where('user_id', auth()->user()->id)->get();
    $dateY = date('Y');
    $dateM = date('m');
    $dateD = date('d');
    $limit_cnt = 40;

     foreach ($keyword_list as $keyword)
     {
      
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
    }

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

  public function index()
  {
    return view('home');
  }
  /*
    Return dashboard page
    
  */
  public function dashboard(Request $request) 
  {
    // if($request->user()->id == 1)
    //   return redirect()->route('adminboard');
    return view('dashboard');
  }

  public function adminBoard(Request $request)
  {
    // if($request->user()->id > 1)
    //   return redirect()->route('dashboard');
    return view('admindashboard');
  }

  public function addKeyword(Request $request)
  {
    $user_id = $request->user()->id;
//    dump(auth()->user());
//    dump(\Auth::user());

    $campaign_type = $request->input('campaign-type','brand');
    $index = 0;
    $campaign_keyword = $request->input('campaign-keyword');
    while(1)
    {
      if($index >= 5)
        break;

      if($campaign_keyword[$index] == null)
        break;
      // $campaign_notification = $request->input('campaign-notification','slack');
      $campaign_notification = 'slack';
      // $keyword_params = [
      //   'user_id' => $user_id,
      //   'keyword' => $campaign_keyword[$index],
      //   'type' => $campaign_type,
      //   'notification_type' => $campaign_notification
      // ];
      $keyword = Keyword::updateOrCreate(['user_id' => $user_id, 'keyword' => $campaign_keyword[$index], 'type' => $campaign_type], 
          ['notification_type' => $campaign_notification]);
      $index++;
    }
    
    
    $this->twitterApi();
    $this->youtubeApi();
    $this->webApi();
    return redirect()->route('dashboard');
  }

  public function showCampaignPage(Request $request, $keyword)
  {
//    dd($keyword);
    return view('dashboard')->with('keyword', $keyword);
  }

  public function getTableData(Request $request)
  {
    $keyword = $request->input('keyword', 'campaign');
    $user_id = $request->user()->id;
    $search_list = Keyword::where('user_id', $user_id)->where('keyword', $keyword)->first()->searches;
    return $search_list->toJson();
  }

  public function getGraphData(Request $request)
  {
    $socialTypeArray = ['facebook', 'twitter', 'instagram', 'youtube', 'web'];
    $keyword = $request->input('keyword', 'campaign');
    $keyword_id = Keyword::where('user_id', $request->user()->id)->where('keyword', $keyword)->first()->id;
    $search_list = Search::where('keyword_id', $keyword_id)->selectRaw('date, count(id)')->groupBy('date')->get();
    $searchArray=[];

    $dateOne = new DateTime('2019-11-11');

    $dateTwo = new DateTime( );

    $interval = new DateInterval('P1D');
    $daterange = new DatePeriod($dateOne, $interval ,$dateTwo);

    foreach($socialTypeArray as $type)
    {
       $typeArray = [];

      foreach($daterange as $dateIndex)
      {
        $item = Search::where('social_type', $type)->where('keyword_id', $keyword_id)->where('date', $dateIndex)->selectRaw('date, count(id) AS cnt')->groupBy('date')->first();  
        if($item == null)
          $itemData = ['date'=> $dateIndex->format('Y-m-d'), 'value'=> 0];
        else
          $itemData = ['date'=> $dateIndex->format('Y-m-d'), 'value'=> $item->cnt];
//        dump($item);
        
        array_push($typeArray, $itemData);
      }
      
     array_push($searchArray, $typeArray);
   }
//   dd($searchArray);
    return $searchArray;
  }

  public function deleteRowTabledata(Request $request)
  {
    $rowId = $request->input('rowId',0);
    $row = Search::where('id', $rowId);
    $row->delete();
  }
}

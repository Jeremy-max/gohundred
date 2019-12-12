<?php

namespace App\Http\Controllers;

use App\User;
use App\Search;
use App\Keyword;
use App\Campaign;

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
use Stevebauman\Location\Location;


class HomeController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */

  protected $countries = array("Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe");

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
        $campaign_list = Campaign::where('user_id', $user->id)->get();
        $array = [];
        if($campaign_list->count() > 0){
          $flag = false;
          foreach ($campaign_list as $campaign)
          {
            $keyword_list = Keyword::where('campaign_id', $campaign->id)->get();
            if ($keyword_list->count() > 0 && $flag == false)
            {
              $flag = true;
              $keyword_id = $keyword_list->first()->id;
              View::share('keyword_id', $keyword_id);
            }
            array_push($array, ['campaign' => $campaign->campaign, 'keyword_list' => $keyword_list]);
          }
        }
        $firstcharname = strtoupper(substr($user->name, 0, 1));
        View::share('namefirstchar', $firstcharname);
        View::share('campaign_list', $array);
      }

      return $next($request);
    });
  }

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */


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

  public function index()
  {
    return view('home');
  }

  public function step(Request $request)
  {

    if($request->user()->id < 2){
      return redirect()->route('adminboard');
    }

    return view('step');
  }
  /*
    Return dashboard page

  */
  public function dashboard(Request $request)
  {
    if($request->user()->id < 2){
      return redirect()->route('adminboard');
    }
    else if($request->user()->active == 0){
        return redirect()->route('plans.show');
    }

    return view('dashboard');
  }

  public function adminBoard(Request $request)
  {
    if($request->user()->id > 1){
      return redirect()->route('dashboard');
    }
    return view('admindashboard')->with('countries', $this->countries);
  }

  public function addKeyword(Request $request)
  {
    $user_id = $request->user()->id;
    if($user_id < 2){
      return redirect()->route('adminboard');
    }
    $socialite_user = User::where('id',$user_id)->where('country','callback')->get();
    if($socialite_user->count() > 0)
    {
      $location = new Location();
      $position = $location->get($request->ip());
      if($position){
        $user = User::updateOrCreate(['id' => $user_id],['country' => $position->countryName]);
      }
    }


//    dump(auth()->user());
//    dump(\Auth::user());

    $campaign_type = $request->input('campaign-type', 'brand');
    $campaign_name = $request->input('campaign-name', 'campaign');
    $campaign = Campaign::updateOrCreate(['user_id' => $user_id, 'campaign' => $campaign_name, 'type' => $campaign_type]);
    $index = 0;
    $campaign_keyword = $request->input('campaign-keyword');
    while(1)
    {
      if($index >= 5)
        break;

      if($campaign_keyword[$index] == null)
        break;
      // $campaign_notification = $request->input('campaign-notification','slack');
      // $keyword_params = [
      //   'user_id' => $user_id,
      //   'keyword' => $campaign_keyword[$index],
      //   'type' => $campaign_type,
      //   'notification_type' => $campaign_notification
      // ];
      $keyword = Keyword::updateOrCreate(['campaign_id' => $campaign->id, 'keyword' => $campaign_keyword[$index]]);
      $index++;
    }


    $this->search_twitter($campaign);
    $this->search_youtube($campaign);
    $this->search_web($campaign);
    return redirect()->route('dashboard');
  }

  public function showCampaignPage(Request $request, $keyword_id)
  {
//    dd($keyword);

    return view('dashboard', [
      'keyword_id' => $keyword_id,
      'langs' => $this->langs,
    ]);
  }

  public function getTableData(Request $request)
  {
    $keyword_id = $request->input('keyword_id');
  //  $user_id = $request->user()->id;
    $search_list = Keyword::where('id', $keyword_id)->first()->searches;
    return $search_list->toJson();
  }

  public function getGraphData(Request $request)
  {
    $socialTypeArray = ['facebook', 'twitter', 'instagram', 'youtube', 'web'];
    $keyword_id = $request->input('keyword_id');
//    $keyword_id = Keyword::where('user_id', $request->user()->id)->where('keyword', $keyword)->first()->id;
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

  public function getAdminTableData(Request $request)
  {
    $array = User::where('id', '>', '1')->get();
    $adminTable = [];
    foreach ($array as $index)
    {
      $campaign_cnt = Campaign::where('user_id',$index->id)->selectRaw('count(id) AS cnt')->first()->cnt;
    //  dd();
      if($index->payment_status)
        $payment_status = $index->payment_status->format('m/d/Y');
      else
        $payment_status = null;

      $item = [
        'id' => $index->id,
        'username' => $index->name,
        'email' => $index->email,
        'country' => $index->country,
        'login_fb' => $index->login_via_facebook,
        'login_gg' => $index->login_via_google,
        'payment_status' => $payment_status,
        'number_campaigns' => $campaign_cnt,
        'comment' => $index->comment,
        'date' => $index->created_at,

      ];
      array_push($adminTable, $item);
    }
//    dd($adminTable);
    return $adminTable;
  }

  public function deleteAdminRowTabledata(Request $request)
  {
    $rowId = $request->input('rowId',0);
    $user = User::where('id', $rowId)->first();
    foreach ($user->campaigns as $campaign){
      foreach ($campaign->keywords as $keyword){
        foreach ($keyword->searches as $search){
          $search->delete();
        }
        $keyword->delete();
      }
      $campaign->delete();
    }
    $user->delete();
  }

  public function saveAdminCommentChanges(Request $request)
  {
    $rowId = $request->input('rowId', 0);
    $comment = $request->input('comment', '');
    $user = User::where('id', $rowId)->update(['comment' => $comment]);

  }

  public function stripe()
  {
      return view('credit-card');
  }


}

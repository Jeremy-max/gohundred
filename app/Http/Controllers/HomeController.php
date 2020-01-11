<?php

namespace App\Http\Controllers;

use App\User;
use App\Search;
use App\Keyword;
use App\Campaign;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;
use App\Jobs\SearchAPI;
use App\Notifications\NewCampaignAddedNotification;
use App\Slack;
use GuzzleHttp\Client;
use App\Http\Repository\AdminUserTable;


use DateTime;
use DatePeriod;
use DateInterval;
use Illuminate\Contracts\Session\Session;
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
    $this->middleware(['auth', 'verified']);


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
              session(['keyword_id'=> $keyword_id]);
              View::share('keyword_id', $keyword_id);
            }
            array_push($array, [
                'campaign_id' => $campaign->id,
                'campaign' => $campaign->campaign,
                'keyword_list' => $keyword_list
                ]);
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
    else if(!\Auth::user()->subscribed('main')){
        return redirect()->route('plans.show')->withErrorMessage('Please upgrade your account!');
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
      if($index == 0)
        $keyword_id = $keyword->id;
      $index++;
    }


    SearchAPI::dispatch($campaign);
    return redirect()->route('campaignPage', ['keyword_id' => $keyword_id]);
  }

  public function showCampaignPage(Request $request, $keyword_id)
  {
//    dd($keyword);
    session(['keyword_id'=> $keyword_id]);
    return view('dashboard', ['keyword_id' => $keyword_id]);
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

    $tableInstance = new AdminUserTable;
    return $tableInstance->getTableData();
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

  public function getSlackWebHookURL(Request $request)
  {

    $client_id = env('SLACK_CLIENT_ID');
    $client_secret = env('SLACK_CLIENT_SECRET');
    $code = $request->get('code');

    $client = new \GuzzleHttp\Client();
    $response = $client->post(
        'https://slack.com/api/oauth.access',
        array(
            'form_params' => array(
                'client_id' => $client_id,
                'client_secret' => $client_secret,
                'code' => $code
            )
        )
    );
    $webhook_json = $response->getBody()->getContents();

    $campaign_id = session('campaign_id');
    if(isset($campaign_id))
    {
        return redirect()->route('dashboard')->withErrorMessage('Can not get campaign to add slack! Please choose correct campaign again.');
    }

    $webhook = json_decode($webhook_json);

    $slack = Slack::updateOrCreate([
        'campaign_id' => $campaign_id,
        'team_name' => $webhook->team_name,
        'channel_id' => $webhook->incoming_webhook->channel_id
        ],[
            'channel_name' => $webhook->incoming_webhook->channel,
            'webhook_url' => $webhook->incoming_webhook->url,
            'configuration_url' => $webhook->incoming_webhook->configuration_url
    ]);
    $campaign = Campaign::where('id', $campaign_id)->first();

    $response = $client->post(
        $webhook->incoming_webhook->url,
        array(
            'headers' => array('content-type' => 'application/json'),
            'json' => array(
                'text' => "Congratulations! , your campaign *$campaign->campaign* has been successfully added to Slack",
            )
        )
    );
    SearchAPI::dispatch($campaign);


    return redirect()->route('dashboard')->withSuccessMessage('Your campaign added to slack successfully!');

    }

  public function addToSlack(Request $request)
  {
    $campaign_id = $request->get('slack_campaign_id');

    if($campaign_id == '0' || $campaign_id == null)
    {
        return redirect()->route('dashboard')->withErrorMessage('Please select campaign to add to slack');
    }
    session(['campaign_id'=> $campaign_id]);

    $webhook_url = env('SLACK_WEBHOOK_URL');
    return redirect($webhook_url);
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
      Search::insert($tweets_db);
//    dump("Tweets search result data is added to DB successfully!");
      return $tweets_db;
  }

  public function facebook()
  {
    $query = "test";
    $fbPageName = $this->getFacebookPage($query);

    $data = fb_feed()
        ->setAccessToken($userAccessToken)
        ->setPage($fbPageName)
        ->fetch();
    dd($data);
  }

  public function getFacebookPage($query)
  {
    $access_token = env('ACCESS_TOKEN_FB');
    dd($access_token);

    $client = new \GuzzleHttp\Client();
    $response = $client->get(
        'https://graph.facebook.com/v3.0/pages/search',
        array(
            'form_params' => array(
                'q' => '$query',
                'fields' => 'id,name',
                'access_token' => $access_token
            )
        )
    );
    $pagename = $response->data;
    return $pagename;
  }

  public function parseFacebook($tweets, $keyword_id) {
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

      $i++;
    }
    return $table_tweets;

  }

  public function facebookDateParse($str)
  {
    $date = date_create_from_format('DATE_ISO8601', $str);
    $new_date = date_format($date,"Y-m-d");
    return $new_date;
  }
}

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
use App\Slack;
use Exception;
use Illuminate\Support\Facades\Artisan;
use PhpParser\Node\Stmt\TryCatch;

class SearchAPI implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $campaign_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($campaign_id = NULL)
    {
        $this->campaign_id = $campaign_id;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        dump('start');

        Artisan::call('search:facebook', ['campaign_id' => $this->campaign_id]);
        Artisan::call('search:twitter', ['campaign_id' => $this->campaign_id]);
        Artisan::call('search:youtube', ['campaign_id' => $this->campaign_id]);
        Artisan::call('search:google', ['campaign_id' => $this->campaign_id]);

        dump('end');

        // $slack_facebook_array = $this->slack_wrapper($facebook_array, $this->campaign->campaign, "Facebook");
        // $slack_twitter_array = $this->slack_wrapper($twitter_array, $this->campaign->campaign, "Twitter");

        // $slack_web_array = $this->slack_wrapper($web_array, $this->campaign->campaign, "Google");

        // foreach ($slack_list as $slack)
        // {
        //     $this->send_slack_message($slack_facebook_array, $slack);
        //     $this->send_slack_message($slack_twitter_array, $slack);
        //     $this->send_slack_message($slack_youtube_array, $slack);
        //     $this->send_slack_message($slack_web_array, $slack);
        // }

    }








//   public function search_tiktok()
//   {
// //    dd('Hello, tiktok!!');
//     $keyword_list = Keyword::where('campaign_id', $campaign->id)->get();
//     foreach ($keyword_list as $keyword)
//     {
//       $this->tiktokApi($keyword);
//     }
//   }

//   public function tiktokApi()
//   {
//     // dd('Hello, web!!');


//     $client = new \App\sabri\tiktok\TiktokApi([
//         'device_id' => env('DEVICE_ID'),
//         'iid' => env('IID'),
//         'openudid' => env('OPENUDID')
//     ]);

//     $sumCnt = 0;
//     $params = [
//       'keyword' => "keyword",
//       'count' => 10,
//       'start' => 0,
//     ];

//       $tiktok_db = [];
//       // while(1)
//       // {
//       //     $sumCnt += 10;
//       //     try{
//             // $results = $client.searchHashtags($params);
//             // dd($results);
// //             $tiktok_db = array_merge($tiktok_db, $this->parseTiktok($results, $keyword->id));
// //           } catch(\Exception $e) {
// //  //           dump('Error occurred for:\r\nSearching ' . $sumCnt . ' items exceeded free trial version limitation');
// //             break;
// //           }


// //           // if(count($results) < $limit_cnt)
// //           //   break;
// //            if($sumCnt > $limit_cnt)
// //              break;

// //           $params['cursor'] = $params['cursor'] + 10;
// //       }
// //       dump($tiktok_db);
//  //   Search::insert($tiktok_db);
//   }

//   public function parseTiktok($response, $keywordId)
//   {
//     $cnt = count($response);
//     $i = 0;
//     $tWeb = [];
//     while ($i < $cnt)
//     {
//       $title = $response[$i]->title;
//       $value = [
//         'keyword_id' => $keywordId,
//         'social_type' => 'tiktok',
//         'title' => $this->parseTitle($title),
//         'date' => date('Y-m-d'),
//         'url' => $response[$i]->link
//       ];
//       array_push($tWeb,$value);
// //      dump($value);
//       $i++;
//     }
//     return $tWeb;
//   }





}

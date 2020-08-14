<?php

namespace App\Console\Commands;

use Abraham\TwitterOAuth\TwitterOAuth;
use App\Campaign;
use App\Http\Repository\SearchOptions;
use App\Http\Repository\SlackNotify;
use App\Keyword;
use App\Search;
use App\Slack;
use Illuminate\Console\Command;

class TwitterSearch extends Command
{
    protected $search_repo, $slack_repo;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'search:twitter {campaign_id}';

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
        $twitter_array = $this->search_twitter($id);

        $slack_list = Slack::where('campaign_id', $id)->get();
        if (Count($slack_list)) {
            $slack_twitter_array = $this->slack_repo->slack_wrapper($twitter_array, $campaign, "Twitter");
            foreach ($slack_list as $slack) {
                $this->slack_repo->send_slack_message($slack_twitter_array, $slack);
            }
        }
    }

    public function search_twitter($campaign_id)
    {
        $keyword_list = Keyword::where('campaign_id', $campaign_id)->get();

        $slack_array = [];
        foreach ($keyword_list as $keyword)
        {
            $tweets_array = $this->twitterApi($keyword);
            array_push($slack_array, ['keyword' => $keyword->keyword, 'array' => $tweets_array]);
        }
        return $slack_array;
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
                    if($this->parseTweets($tweets,$keyword->id)){
                        $tweets_db = array_merge($tweets_db, $this->parseTweets($tweets,$keyword->id));
                    }
                }
            } catch(\Exception $e) {
                dump('Error occurred for:\r\nSearching ' . $limit_cnt . ' items exceeded free trial version limitation');
                dump($e->getMessage());
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
        dump("Tweets search result data is added to DB successfully!");
        return $tweets_db;
    }

    public function parseTweets($tweets, $keyword_id) {
        if(!isset($tweets->statuses))
        return false;
        $cnt = count($tweets->statuses);
        $i = 0;
        $table_tweets = [];
        while ($i < $cnt)
        {
            $url = 'https://twitter.com/' . $tweets->statuses[$i]->user->screen_name . '/status/' . $tweets->statuses[$i]->id_str;
            if(Search::where('url', $url)->first()){
                $i++;
                continue;
            }
        $title = $this->search_repo->parseTitle($tweets->statuses[$i]->text);
        $date = $this->tweetsDateParse($tweets->statuses[$i]->created_at);
        $value = [
            'keyword_id' => $keyword_id,
            'social_type' => 'twitter',
            'title' => $title,
            'date' => date($date),
            'url' => $url,
            'sentiment' => $this->search_repo->sentimentAnalysis($title),
            'lang_type' => $this->search_repo->getLanguageType($title)
        ];
        array_push($table_tweets,$value);

        $i++;
        }
        return $table_tweets;

    }

    public function getMaxId($tweets)
    {
        $startIdx = stripos($tweets->search_metadata->next_results, 'max_id=');
        $maxidstr = substr($tweets->search_metadata->next_results, $startIdx + 7);
        $endIdx = stripos($maxidstr, '&');
        if ($endIdx != -1)
        $maxidstr = substr($maxidstr, 0, $endIdx);

        return (int)$maxidstr;
    }

    public function tweetsDateParse($str)
    {
        $date = date_create_from_format("D M d H:i:s O Y", $str);
        $new_date = date_format($date,"Y-m-d");
        return $new_date;
    }
}

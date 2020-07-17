<?php

namespace App\Http\Repository;


class SlackNotify
{
    public function send_slack_message($slack_message_array, $slack)
    {
      $client = new \GuzzleHttp\Client();
      foreach ($slack_message_array as $item)
      {
        $response = $client->post(
            $slack->webhook_url,
            array(
                'headers' => array('content-type' => 'application/json'),
                'json' => array(
                    'blocks' => $item
                )
            )
        );
      }
    }

    public function slack_wrapper($array, $campaign, $social_type)
    {
        $slack_array = [];
        $cnt = 0;
        $block_limit = 10;
        $index = 0;
        $slack_block = [];
        foreach ($array as $item)
        {

            $cnt += count($item['array']);
            foreach($item['array'] as $tweets)
            {
              if($index < $block_limit){
                $slack_block = array_merge($slack_block, $this->slack_formatting($item['keyword'], $tweets));
              }else{
                $index = 0;
                array_push($slack_array, $slack_block);
                $slack_block = [];
              }
              $index++;
            }
            if($cnt <= $block_limit)
            {
                array_push($slack_array, $slack_block);
            }
        }
        $slack_header = [
                [
                    "type" => "section",
                    "text" => [
                        "type"=> "mrkdwn",
                        "text"=> "We found *$cnt* mentions with campaign *$campaign* in *$social_type*"
                ],
            ],
            [
                "type" => "divider"
            ]
        ];
        $result = [];
        array_push($result, $slack_header);
        $result = array_merge($result, $slack_array);
        return $result;
    }

    public function slack_formatting($keyword, $array)
    {
        $slack_message = [
            [
                "type"=> "section",
                "text"=> [
                    "type"=> "mrkdwn",
                    "text"=> "Keyword: *$keyword*\nTitle: _$array[title]_\nSocial Type: $array[social_type]\nDate: $array[date]\n"
                ]
            ],
            [
                "type"=> "section",
                "text"=> [
                    "type"=> "mrkdwn",
                    "text"=> "URL: <$array[url]>"
                ]
            ],
            [
                "type" => "divider"
            ]
        ];
        return $slack_message;
    }
}

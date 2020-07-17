<?php

namespace App\Http\Repository;

use Stichoza\GoogleTranslate\GoogleTranslate;

class SearchOptions
{
    public function parseTitle($title)
    {
        if(strlen($title) > 90){
            $it = explode("\n", $title);
            $i = 0;
            while($it[$i] == ""){
                $i++;
            }
            $title = $it[$i];
            // $title = mb_substr($title, 0, $index);
        }
        $tr = new GoogleTranslate();
        $tr->setTarget('en');
        try {
            $title = $tr->translate(html_entity_decode($title));
        } catch (\Exception $th) {
            dump($th->getMessage());
        }

        return $title;
    }

    public function sentimentAnalysis($comments) {
        $config = [
            'LanguageCode' => 'en',
            'Text' => $comments,
        ];
        try {
            $jobSentiment = \Comprehend::detectSentiment($config);
            return $jobSentiment['Sentiment'];
        } catch (\Exception $e) {
            // return 'INVALID';
        }
        return 'INVALID';
    }


}

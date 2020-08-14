<?php

namespace App\Http\Repository;

use LanguageDetection\Language;

class SearchOptions
{
    public function parseTitle($title)
    {
        if(strlen($title) > 100){
            $first = mb_substr($title, 0, 100);
            $sec = mb_substr($title, 100);
            $it = explode("\n", $sec);
            $title = $first . $it[0];
            // $title = mb_substr($title, 0, $index);
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
            dump($e->getMessage());
            // return 'INVALID';
        }
        return 'INVALID';
    }

    public function getLanguageType($title) {
        $language = 'en';
        $ld = new Language;
        try {
            $language = $ld->detect($title)->__toString();
        } catch (\Throwable $th) {
            dump($th->getMessage());
        }
        
        return $language;
    }
}

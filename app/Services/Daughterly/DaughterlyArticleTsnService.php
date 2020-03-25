<?php


namespace App\Services\Daughterly;

use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

class DaughterlyArticleTsnService
{
    protected function parsGuzzleToString(string $url) :string
    {
        $client = new Client();

        $response = $client->request(
            'GET',
            $url
        );

        $body = $response->getBody();

        return $body->getContents();
    }

    protected function getData(object $crawler) :array
    {
        $getOneNewsToHtml = $crawler
            ->filter('.h-entry > div')
            ->each(function (Crawler $node, $i) {
                return [$node->filter('div > .c-post-meta')->html()];
            });

        $articles = [];
        foreach ($getOneNewsToHtml as $element) {
            $div = new Crawler($element[0]);

            $link = $div->filter('h4 > a')->attr('href');
            $title = $div->filter('h4 > a')->text();
            $dateTime = $div->filter('div > time')->attr('datetime');
            $image = $this->parseImage($link);

            // Get correct date time
            preg_match(
                '/(\d{4}-\d{2}-\d{2}).(\d{2}:\d{2})\S+/i',
                $dateTime,
                $dateTime
            );

            // Get id article
            preg_match(
                '/https:\/\/tsn\.ua\S+\/(\S+|\D+)(\d{7})\.\D+/i',
                $link,
                $id
            );

            if (!$id) {
                continue;
            }

            $articles [] = [
                'title' => $title,
                'link' => $link,
                'date' => $dateTime[1] . ' ' . $dateTime[2],
                'id_article' => $id[2],
                'image' => $image
            ];
        }

        unset($element);

        return $articles;
    }

    protected function parseImage(string $link) :string
    {
        $str = $this->parsGuzzleToString($link);

        $crawler = new Crawler($str);

        try{
            $imageLink = $crawler
                ->filter('.has-pseudo-bg')
                ->each(function (Crawler $node, $i) {
                    return $node->filter('img')->attr('src');
                });

            if (empty($imageLink)){
                throw new \Exception();
            }
        } catch (\Exception $e){
            $imageLink = $crawler
                ->filter('.c-post-img-wrap')
                ->each(function (Crawler $node, $i) {
                    return $node->filter('img')->attr('src');
                });
        }

        return $imageLink[0];
    }
}

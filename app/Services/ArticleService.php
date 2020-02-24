<?php


namespace App\Services;

use App\Repositories\ArticleRepository;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

class ArticleService
{
    private $articleRepository;

    public function __construct(ArticleRepository $ArticleRepository)
    {
        $this->articleRepository = $ArticleRepository;
    }

    public function selectArticles()
    {
        return $this->articleRepository->articlesPaginate() ?: [];
    }

    public function insert(array $oneDaysArticles)
    {
        foreach ($oneDaysArticles as $articles) {
            foreach ($articles as $article) {
                $serchArticle = $this->articleRepository->findArticle($article['id_article']);

                if (!$serchArticle) {
                    $this->articleRepository->insertArticles($article);
                }
            }
        }
    }

    public function parser() :array
    {
        $str = $this->parsGuzzleToString(
            'https://ua.korrespondent.net/ajax/module.aspx?spm_id=1055&type=-1&IsAjax=true'
        );

        $crawler = new Crawler($str);

        return $this->getData($crawler);
    }

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
            ->filter('.time-articles > div')
            ->each(function (Crawler $node, $i) {
                return [$node->filter('div')->html()];
            });

        $result = [];
        $date = Carbon::now();
        $date->setTimezone('Europe/Kiev');

        foreach ($getOneNewsToHtml as $element){
            $div = new Crawler($element[0]);
            try{
                $title = $div->filter('.article__title')->text();
                $time = $div->filter('.article__time')->text();
                $link = $div->filter('.article__title > a')->attr('href');

                $result[$date->format('Y-m-d')][] = [
                    'title' => $title,
                    'date' => $date->format('Y-m-d') . ' ' . $time,
                    'link' => $link
                ];
            } catch (\Exception $e){
                $date->addHours(-24)->format('Y-m-d');
            }
        }
        unset($element);

        foreach ($result as $articlesOneDay){
            $articles [] = $this->addIdAndImage($articlesOneDay);
        }

        return $articles;
    }

    protected function addIdAndImage(array $articlesOneDay) :array
    {
        foreach ($articlesOneDay as $article){
            $article['image'] = $this->parseImage($article['link']);
            $article['id_article'] = $this->getIdArticle($article['link']);

            $articlesUpdate[] = $article;
        }
        unset($article);

        return $articlesUpdate;
    }

    protected function parseImage(string $link) :string
    {
        $str = $this->parsGuzzleToString($link);

        $crawler = new Crawler($str);

        $imageLink = $crawler
            ->filter('.post-item__photo')
            ->each(function (Crawler $node, $i) {
                return $node->filter('img')->attr('src');
            });

        return $imageLink[0];
    }

    protected function getIdArticle(string $link) :string
    {
        $linkPregResult = preg_match(
            '/https:\/\/ua.korrespondent\.net\/\S+\/(\d+)-.+/i',
            $link,
            $idArticle
        );

        if (!$linkPregResult) {
            return '';
        }

        return $idArticle[1];
    }
}

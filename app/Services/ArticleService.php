<?php


namespace App\Services;

use App\Repositories\ArticleRepository;
use App\Repositories\ArticleTsnRepository;
use App\Services\Daughterly\DaughterlyArticleService;
use Symfony\Component\DomCrawler\Crawler;

class ArticleService extends DaughterlyArticleService
{
    private $articleRepository;

    /**
     * ArticleService constructor.
     * @param ArticleRepository $ArticleRepository
     */
    public function __construct(
        ArticleRepository $ArticleRepository
    )
    {
        $this->articleRepository = $ArticleRepository;
    }

    /**
     * @return array
     */
    public function selectArticles()
    {
        return $this->articleRepository->articlesPaginate() ?: [];
    }

    /**
     * @param array $oneDaysArticles
     * @return void
     */
    public function insert(array $oneDaysArticles)
    {
        foreach ($oneDaysArticles as $articles) {
            foreach ($articles as $article) {
                $searchArticle = $this->articleRepository->findArticle($article['id_article']);

                if (!$searchArticle) {
                    $this->articleRepository->insertArticles($article);
                }
            }
        }
    }

    /**
     * Return parse data korrespondent
     *
     * @return array
     */
    public function parser() :array
    {
        $str = $this->parsGuzzleToString(
            'https://ua.korrespondent.net/ajax/module.aspx?spm_id=1055&type=-1&IsAjax=true'
        );

        if(!is_string($str))
        {
            return [];
        }

        $crawler = new Crawler($str);

        return $this->getData($crawler);
    }
}

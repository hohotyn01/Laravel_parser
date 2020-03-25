<?php


namespace App\Services;

use App\Repositories\ArticleTsnRepository;
use App\Services\Daughterly\DaughterlyArticleTsnService;
use Symfony\Component\DomCrawler\Crawler;

class ArticleTsnService extends DaughterlyArticleTsnService
{
    private $articleTsnRepository;

    /**
     * ArticleTsnService constructor.
     * @param $articleTsnRepository
     */
    public function __construct(ArticleTsnRepository $articleTsnRepository)
    {
        $this->articleTsnRepository = $articleTsnRepository;
    }

    /**
     * Get articles from the database
     *
     * @return array
     */
    public function selectArticles()
    {
        return $this->articleTsnRepository->articlesTsnPaginate() ?: [];
    }

    /**
     * Insert articles in database
     *
     * @param array $dataArticles
     * @return void
     */
    public function insert(array $dataArticles)
    {
        foreach ($dataArticles as $article){
            $searchArticle = $this->articleTsnRepository->findTsnArticle($article['id_article']);

            if (!$searchArticle) {
                $this->articleTsnRepository->insertTsnArticles($article);
            }
        }
    }

    /**
     * Return parse data tsn
     *
     * @return array
     */
    public function parser() :array
    {
        $str = $this->parsGuzzleToString(
            'https://tsn.ua/news'
        );

        if(!is_string($str))
        {
            return [];
        }

        $crawler = new Crawler($str);

        return $this->getData($crawler);
    }
}

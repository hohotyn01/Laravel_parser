<?php

namespace App\Http\Controllers;

use App\Services\ArticleService;

class Parser extends Controller
{
    protected $articleService;

    public function __construct(
        ArticleService $articleService
    ) {
        $this->articleService = $articleService;
    }

    public function get()
    {
        return view('welcome', ['articles' => $this->articleService->selectArticles()]);
    }

    public function getParsing()
    {
        try {

            $allDataCorespondent = $this->articleService->parser();
        }catch (\Exception $e){
            dd('Parsing failed');
        }

        $this->articleService->insert($allDataCorespondent);

        dump ('success');
    }
}

<?php

namespace App\View\Components\Site\Blocks;

use App\Models\Block;
use App\Models\Category;
use App\Repository\ArticleRepositoryInterface;
use App\Repository\CategoryRepositoryInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class News extends Component
{
    public Collection $articles;
    public Category $blogCategory;

    public function __construct(public Block $block, protected ArticleRepositoryInterface $articleRepository, CategoryRepositoryInterface $categoryRepository)
    {
        $this->articles = $this->articleRepository->lastNews();
        $this->blogCategory = $categoryRepository->getModel()->where('taxonomy', Category::BLOG)->first();
    }

    public function render(): View
    {
        return view('components.site.blocks.blog');
    }
}

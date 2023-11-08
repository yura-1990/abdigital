<?php

namespace App\Services;

use App\DTO\ArticleDataDTO;
use App\Models\Article;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class StoreArticleService
{
    public function store($data): Model|Builder
    {
        $dto = new ArticleDataDTO($data);

        return Article::query()->create([
            'image' => $dto->image,
            'content' => $dto->content,
            'title' => $dto->title,
            'user_id' => $dto->user_id
        ]);
    }
}

<?php

namespace App\DTO;

class ArticleDataDTO
{
    public readonly int $user_id;
    public readonly string $image;
    public readonly string $title;
    public readonly string $content;
    public function __construct($data)
    {
        $this->image = $data['image'];
        $this->title = $data['title'];
        $this->content = $data['content'];
        $this->user_id = auth()->guard('api')->id();
    }


}

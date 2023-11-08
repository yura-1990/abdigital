<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use App\OpenApi\Parameters\ArticleParameters;
use App\OpenApi\RequestBodies\ArticleRequestBody;
use App\OpenApi\Responses\ArticleDeleteResponse;
use App\OpenApi\Responses\ArticleListResponse;
use App\OpenApi\Responses\ArticleResponse;
use App\OpenApi\SecuritySchemes\BearerTokenSecurityScheme;
use App\Services\StoreArticleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Spatie\RouteAttributes\Attributes\Delete;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Post;
use Spatie\RouteAttributes\Attributes\Prefix;
use Vyuldashev\LaravelOpenApi\Attributes\Operation;
use Vyuldashev\LaravelOpenApi\Attributes\Parameters;
use Vyuldashev\LaravelOpenApi\Attributes\PathItem;
use Vyuldashev\LaravelOpenApi\Attributes\RequestBody;
use Vyuldashev\LaravelOpenApi\Attributes\Response;

#[Prefix('article')]
#[PathItem]
class ArticleController extends Controller
{
    /**
     * @return JsonResponse
     */
    #[Get('/get-all')]
    #[Operation(tags: ['Article'], security: BearerTokenSecurityScheme::class,  method: 'GET')]
    #[Response(factory: ArticleListResponse::class)]
    public function getAll(): JsonResponse
    {
        $articles = Cache::rememberForever('post-page-' . request('page', 1), function(){
            return ArticleResource::collection(Article::query()->with('user')->where('article_id', '=', null)->orderBy('id')->paginate(50));
        });

        return $this->success($articles);
    }

    /**
     * @param CreateArticleRequest $request
     * @param StoreArticleService $service
     * @return JsonResponse
     */
    #[Post('/create')]
    #[Operation(tags: ['Article'], security: BearerTokenSecurityScheme::class,  method: 'POST')]
    #[RequestBody(factory: ArticleRequestBody::class)]
    #[Response(factory: ArticleResponse::class)]
    public function create( CreateArticleRequest $request, StoreArticleService $service ): JsonResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')){
            $data['image'] = $this->uploadFile($request->file('image'), 'article');
        }

        return $this->success(new ArticleResource($service->store($data)));
    }

    /**
     * @param UpdateArticleRequest $request
     * @param Article $article
     * @return JsonResponse
     */
    #[Post('/update/{article}')]
    #[Operation(tags: ['Article'], security: BearerTokenSecurityScheme::class,  method: 'POST')]
    #[Parameters(factory: ArticleParameters::class)]
    #[RequestBody(factory: ArticleRequestBody::class)]
    #[Response(factory: ArticleResponse::class)]
    public function update(UpdateArticleRequest $request, Article $article): JsonResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')){
            if ($this->deleteFile($article->image)){
                $data['image'] = $this->uploadFile($request->file('image'), 'article');
            }
        }

        $article->update([
            'image' => $data['image'] ?? $article->image,
            'title' => $data['title'] ?? $article->title,
            'content' => $data['content'] ?? $article->content
        ]);

        return $this->success(new ArticleResource($article));
    }

    /**
     * @param Article $article
     * @return JsonResponse
     */
    #[Delete('/delete/{article}')]
    #[Operation(tags: ['Article'], security: BearerTokenSecurityScheme::class,  method: 'DELETE')]
    #[Parameters(factory: ArticleParameters::class)]
    #[Response(factory: ArticleDeleteResponse::class)]
    public function delete(Article $article): JsonResponse
    {
        if ($this->deleteFile($article->image)){
            $article->delete();
        }

        return $this->success(['message' => 'The Article Deleted Successfully']);
    }
}

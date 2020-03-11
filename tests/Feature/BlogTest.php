<?php

namespace Tests\Feature;

use App\Http\Controllers\BlogController;
use App\Http\Resources\Post;
use App\Http\Resources\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Wink\Wink;
use Wink\WinkPost;
use Wink\WinkTag;

class BlogTest extends TestCase
{
    /** @test */
    public function testAllPostsListCorrectly()
    {
        $posts = WinkPost::with('tags')
            ->with('author')
            ->live()
            ->orderBy('publish_date', 'DESC')
            ->get();
        $request = $this->get('/api/v1/blog/all');
        $request->assertOk();
        $response = $request->json();
        $resourceResponse = (Post::collection($posts))->response()->getData(true);
        $this->assertEquals($response, $resourceResponse);
    }

    /**
     * test if blog posts are listed in correct way
     *
     * @test
     */
    public function testAllPostsPaginatedListCorrectly()
    {
        $posts    = WinkPost::with('tags')
            ->with('author')
            ->live()
            ->orderBy('publish_date', 'DESC')
            ->simplePaginate( (new BlogController)->resultsPerPage );

        $resourceResponse = (Post::collection($posts))->response()->getData(true);

        $request = $this->get('/api/v1/blog');

        $request->assertOk();

        $response = $request->json();

        $this->assertEquals($response['data'], $resourceResponse['data']);
    }

    /** @test */
    public function testSinglePostBySlug()
    {
        $post             = WinkPost::first();
        $request          = $this->get("/api/v1/blog/{$post->slug}");
        $response         = $request->json();
        $resourceResponse = ( new Post($post) )->response()->getData(true);
        $request->assertOk();
        $this->assertEquals($response, $resourceResponse);
    }

    //TODO PAGINATE RESULTS BY CATEGORY
    /** @test */
    public function testPostsByCategoryTag()
    {
        $tag      = WinkTag::first()->only('slug')['slug'];
        $posts    = WinkTag::whereSlug($tag)->first()->posts()->paginate( (new BlogController)->resultsPerPage );
        $request  = $this->get("/api/v1/blog/category/{$tag}");
        $request->assertOk();
        $response = $request->json();
        $resourceResponse = Post::collection($posts)->response()->getData(true);
        $this->assertEquals($response['data'], $resourceResponse['data']);
    }
}

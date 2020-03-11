<?php

namespace App\Http\Controllers;

use App\Http\Resources\Post;
use App\Http\Resources\Tag;
use Wink\WinkPost;
use Illuminate\Http\Request;
use Wink\WinkTag;

class BlogController extends Controller
{
    public $resultsPerPage = 7;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = WinkPost::with('tags')
            ->with('author')
            ->live()
            ->orderBy('publish_date', 'DESC')
            ->simplePaginate($this->resultsPerPage);
        return Post::collection($posts);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        $posts = WinkPost::with('tags')
            ->with('author')
            ->live()
            ->orderBy('publish_date', 'DESC')
            ->get();
        return Post::collection($posts);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $post = WinkPost::live()->whereSlug($slug)->with('author')->with('tags')->firstOrFail();
        return new Post($post);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function postsByTag($slug)
    {
        $posts = WinkTag::whereSlug($slug)->first()->posts()->paginate($this->resultsPerPage);
        return Post::collection($posts);
    }


}

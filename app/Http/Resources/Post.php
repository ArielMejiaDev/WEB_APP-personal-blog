<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Post extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);

        return [
            "id"                        => $this->id,
            "slug"                      => $this->slug,
            "title"                     => $this->title,
            "excerpt"                   => $this->excerpt,
            "body"                      => $this->body,
            "publish_date"              => $this->publish_date,
            "featured_image"            => $this->featured_image,
            "featured_image_caption"    => $this->featured_image_caption,
            "categories"                => Category::collection($this->tags),
            "author"                    => [
                "name"   => $this->author->name,
                "email"  => $this->author->email,
                "bio"    => $this->author->bio,
                "avatar" => $this->author->avatar,
            ]
        ];
    }
}

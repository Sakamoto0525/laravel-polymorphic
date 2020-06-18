<?php

use Illuminate\Database\Seeder;
use Tests\TestCase;
use App\Post;
use App\Tag;

class PostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $post = factory(Post::class)->create();
        factory(Tag::class, 10)->create()->each(function ($tag) use ($post) {
            $post->tags()->sync([
                1 => [
                    'tag_id' => $tag->id,
                    'taggable_id' => $post->id,
                    'taggable_type' => Post::class,
                    'value' => 'テスト'
                ]
            ]);
        });
    }
}

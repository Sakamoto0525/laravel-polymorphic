<?php

namespace Tests\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Post;
use App\Tag;
use App\Taggable;

/**
 * @internal
 * @coversNothing
 */
final class TagTest extends TestCase
{
    use RefreshDatabase;

    public $tag;

    protected function setUp(): void
    {
        parent::setUp();
        $this->tag = factory(Tag::class)->create();
        $tag = $this->tag;
        factory(Post::class, 10)->create()->each(function ($post) use ($tag) {
            $tag->posts()->sync([
                1 => [
                    'tag_id' => $tag->id,
                    'taggable_id' => $post->id,
                    'taggable_type' => Post::class,
                    'value' => 'テスト'
                ],
                2 => [
                  'tag_id' => $tag->id,
                  'taggable_id' => $post->id,
                  'taggable_type' => Post::class,
                  'value' => 'テスト'
                ]
            ]);
        });
    }

    //****************************************
    //  Index
    //****************************************

    /** @test */
    public function index(): void
    {
        $response = $this->json('GET', '/api/tags');
        // $response->assertStatus(200)
        //     ->assertJsonFragment([
        //         'id'        => $this->posts[0]->id,
        //         'name'      => $this->posts[0]->name,
        //     ], [
        //         'id'        => $this->posts[2]->id,
        //         'name'      => $this->posts[2]->name,
        //     ])
        // ;
        $response->dump(); // テスト用
    }

    //****************************************
    //  Show
    //****************************************

    /** @test */
    public function show(): void
    {
        $response = $this->json('GET', "/api/posts/{$this->post->id}");
        // $response->assertStatus(200)
        //     ->assertJsonFragment([
        //         'id'        => $this->post->id,
        //         'name'      => $this->post->name,
        //     ],[
        //         'tag_id' => $this->taggables[0]->tag_id,
        //         'taggable_id' => $this->taggables[0]->taggable_id,
        //         'taggable_type' =>  $this->taggables[0]->taggable_type
        //     ])
        // ;
        $response->dump(); // テスト用
    }
}

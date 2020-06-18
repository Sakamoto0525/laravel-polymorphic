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
final class PostTest extends TestCase
{
    use RefreshDatabase;

    public $post;

    protected function setUp(): void
    {
        parent::setUp();
        $this->post = factory(Post::class)->create();
        $post = $this->post;
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

    //****************************************
    //  Index
    //****************************************

    /** @test */
    public function index(): void
    {
        $response = $this->json('GET', '/api/posts');
        $response->assertStatus(200)
            ->assertJsonFragment([
                'id'        => $this->posts[0]->id,
                'name'      => $this->posts[0]->name,
            ], [
                'id'        => $this->posts[2]->id,
                'name'      => $this->posts[2]->name,
            ])
        ;
        // $response->dump(); // テスト用
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

    //****************************************
    //  Store
    //****************************************

    /** @test */
    public function store(): void
    {
        $post = factory(Post::class)->create();
        $tag = factory(Tag::class)->create();
        $params = [
            'id' => $post->id,
            'taggables' => [
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
                ],
                3 => [
                    'tag_id' => $tag->id,
                    'taggable_id' => $post->id,
                    'taggable_type' => Post::class,
                    'value' => 'テスト'
                ]
            ]
        ];
        $response = $this->json('POST', "/api/posts", $params);
        $response->assertStatus(201)
            ->assertJsonFragment([
                'id'        => $post->id,
                'name'      => $post->name,
            ],[
                'tag_id'        => $params['taggables'][1]['tag_id'],
                'taggable_id'   => $params['taggables'][1]['taggable_id'],
                'taggable_type' => $params['taggables'][1]['taggable_type'],
                'value'         => $params['taggables'][1]['value']
            ])
        ;
        // $response->dump(); // テスト用
    }

    //****************************************
    //  Store Sync
    //****************************************

    /** @test */
    public function store_sync(): void
    {
        $post = factory(Post::class)->create();
        $tag = factory(Tag::class)->create();
        $params = [
            'id' => $post->id,
            'taggables' => [
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
                ],
                3 => [
                    'tag_id' => $tag->id,
                    'taggable_id' => $post->id,
                    'taggable_type' => Post::class,
                    'value' => 'テスト'
                ]
            ]
        ];
        $response = $this->json('POST', "/api/posts", $params);
        $response->assertStatus(201)
            ->assertJsonFragment([
                'id'        => $post->id,
                'name'      => $post->name,
            ],[
                'tag_id'        => $params['taggables'][1]['tag_id'],
                'taggable_id'   => $params['taggables'][1]['taggable_id'],
                'taggable_type' => $params['taggables'][1]['taggable_type'],
                'value'         => $params['taggables'][1]['value']
            ])
        ;
        // $response->dump(); // テスト用
    }
}

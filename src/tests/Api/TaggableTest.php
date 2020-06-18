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
final class TaggableTest extends TestCase
{
    use RefreshDatabase;

    public $post;
    public $taggable;

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
        $this->taggable = Taggable::find(1);
    }

    //****************************************
    //  Index
    //****************************************

    /** @test */
    public function index(): void
    {
        $response = $this->json('GET', '/api/taggables');
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
        $response = $this->json('GET', "/api/taggables/{$this->taggable->id}");
        // $response->assertStatus(200)
        //     ->assertJsonFragment([
        //         'id'        => $this->post->id,
        //         'name'      => $this->post->name,
        //     ],[
        //         'tag_id' => $this->taggable->tag_id,
        //         'taggable_id' => $this->taggable->taggable_id,
        //         'taggable_type' =>  $this->taggable->taggable_type
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
      $taggable = factory(Taggable::class)->make();
      $post = factory(Post::class)->create();
      $params   = [
        'tag_id' => $taggable->id,
        'taggable_id' => $post->id,
        'taggable_type' => Post::class,
        'value' => 'テスト'
      ];
      $response = $this->json('POST', '/api/taggables', $params);

      $response->dump();
      // $response->assertStatus(201)
      //     ->assertJsonFragment(
      //         [
      //             'name'     => "新規{$label}カテゴリー",
      //             'ordering' => $projectCategoryCount + 1
      //         ]
      //     )
      // ;
      // // レコードが追加されていることを確認
      // $this->assertSame(ProjectCategory::count(), $projectCategoryCount + 1);
    }
}

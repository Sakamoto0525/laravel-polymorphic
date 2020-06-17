<?php

namespace Tests\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Post;

/**
 * @internal
 * @coversNothing
 */
final class PostTest extends TestCase
{
    use RefreshDatabase;

    public $posts;

    protected function setUp(): void
    {
        parent::setUp();

        $this->posts = factory(Post::class, 10)->create();
    }

    //****************************************
    //  Post 一覧
    //****************************************

    /** @test */
    public function indexPostAll(): void
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
    }
}

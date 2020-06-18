<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Taggable;
use Faker\Generator as Faker;

$factory->define(Taggable::class, function (Faker $faker) {
    $post = factory(App\Post::class)->create();
    return [
        'tag_id' => function () {
            return factory(App\Tag::class)->create()->id;
        },
        'taggable_id' => $post->id,
        'taggable_type' => App\Post::class,
        'value'  => 'テスト'
    ];
});

$factory->state(Taggable::class, 'Post', function (Faker $faker) {
    return [
        'tag_id' => function () {
            return factory(App\Tag::class)->create()->id;
        },
        'taggable_id' => factory(App\Post::class)->create()->id,
        'taggable_type' => App\Post::class,
        'value'  => 'テスト'
    ];
});

$factory->state(Taggable::class, 'Video', function (Faker $faker) {
    return [
        'tag_id' => function () {
            return factory(App\Tag::class)->create()->id;
        },
        'taggable_id' => factory(App\Video::class)->create()->id,
        'taggable_type' => App\Video::class,
        'value'  => 'テスト'
    ];
});

$factory->state(Taggable::class, 'Random', function (Faker $faker) {
    $taggable = [
        App\Post::class,
        App\Video::class
    ];
    $taggableType = $faker->randomElement($taggable);
    $taggable = factory($taggableType)->create();

    return [
        'tag_id' => function () {
            return factory(App\Tag::class)->create()->id;
        },
        'taggable_type' => $taggableType,
        'taggable_id' => $taggable->id,
        'value'  => 'テスト'
    ];
});


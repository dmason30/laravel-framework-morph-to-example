<?php

namespace Tests\Feature;

use App\Models\Image;
use App\Models\Post;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    // This is the failing test
    public function testGetIdWithTableNameAsMorphType()
    {
        Relation::tableNameAsMorphType();

        $post = Post::factory()->create();

        $image = Image::factory()->create([
            'imageable_type' => $post->getTable(), // 'posts'
            'imageable_id' => $post->id,
        ]);

        // This will throw an exception rather than getting model
        $this->assertNotNull($image->imageable->id);
    }

    public function testGetIdWithMorphMap()
    {
        Relation::morphMap([Post::class]);

        $post = Post::factory()->create();

        $image = Image::factory()->create([
            'imageable_type' => $post->getTable(), // 'posts'
            'imageable_id' => $post->id,
        ]);

        $this->assertNotNull($image->imageable->id);
    }
}

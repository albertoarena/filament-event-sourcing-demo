<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Aggregates\PostAggregate;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class PostEventSourcingTest extends TestCase
{
    use RefreshDatabase;

    public function test_creating_a_post_through_the_aggregate_builds_the_projection(): void
    {
        $uuid = (string) Str::uuid();

        PostAggregate::retrieve($uuid)
            ->createPost('Getting started with event sourcing', 'A first draft.')
            ->persist();

        $post = Post::find($uuid);

        $this->assertNotNull($post, 'The projector should build the Post projection from PostCreated.');
        $this->assertSame('Getting started with event sourcing', $post->title);
        $this->assertSame('A first draft.', $post->body);
        $this->assertDatabaseHas('stored_events', ['aggregate_uuid' => $uuid]);
    }

    public function test_changing_the_title_updates_the_projection_and_appends_an_event(): void
    {
        $uuid = (string) Str::uuid();

        PostAggregate::retrieve($uuid)->createPost('Original title', 'Body')->persist();
        PostAggregate::retrieve($uuid)->changeTitle('Updated title')->persist();

        $this->assertSame('Updated title', Post::find($uuid)->title);
        $this->assertDatabaseCount('stored_events', 2);
    }

    public function test_deleting_through_the_aggregate_removes_the_projection(): void
    {
        $uuid = (string) Str::uuid();

        PostAggregate::retrieve($uuid)->createPost('Doomed', 'Body')->persist();
        PostAggregate::retrieve($uuid)->deletePost()->persist();

        $this->assertNull(Post::find($uuid), 'The projection should be removed after PostDeleted.');
        $this->assertDatabaseCount('stored_events', 2);
    }
}

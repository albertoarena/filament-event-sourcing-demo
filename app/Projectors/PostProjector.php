<?php

declare(strict_types=1);

namespace App\Projectors;

use App\Events\PostBodyChanged;
use App\Events\PostCreated;
use App\Events\PostDeleted;
use App\Events\PostTitleChanged;
use App\Models\Post;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

final class PostProjector extends Projector
{
    public function resetState(): void
    {
        Post::query()->delete();
    }

    public function onPostCreated(PostCreated $event): void
    {
        (new Post([
            'uuid' => $event->aggregateRootUuid(),
            'title' => $event->title,
            'body' => $event->body,
        ]))->writeable()->save();
    }

    public function onPostTitleChanged(PostTitleChanged $event): void
    {
        $post = Post::find($event->aggregateRootUuid());
        $post->title = $event->title;
        $post->writeable()->save();
    }

    public function onPostBodyChanged(PostBodyChanged $event): void
    {
        $post = Post::find($event->aggregateRootUuid());
        $post->body = $event->body;
        $post->writeable()->save();
    }

    public function onPostDeleted(PostDeleted $event): void
    {
        Post::find($event->aggregateRootUuid())?->writeable()->delete();
    }
}

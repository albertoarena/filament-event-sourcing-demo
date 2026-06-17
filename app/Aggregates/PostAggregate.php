<?php

declare(strict_types=1);

namespace App\Aggregates;

use App\Events\PostBodyChanged;
use App\Events\PostCreated;
use App\Events\PostDeleted;
use App\Events\PostTitleChanged;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;

final class PostAggregate extends AggregateRoot
{
    public function createPost(string $title, string $body): self
    {
        $this->recordThat(new PostCreated($title, $body));

        return $this;
    }

    public function changeTitle(string $title): self
    {
        $this->recordThat(new PostTitleChanged($title));

        return $this;
    }

    public function changeBody(string $body): self
    {
        $this->recordThat(new PostBodyChanged($body));

        return $this;
    }

    public function deletePost(): self
    {
        $this->recordThat(new PostDeleted);

        return $this;
    }
}

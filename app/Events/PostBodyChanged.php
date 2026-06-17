<?php

declare(strict_types=1);

namespace App\Events;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

final class PostBodyChanged extends ShouldBeStored
{
    public function __construct(
        public readonly string $body,
    ) {}
}

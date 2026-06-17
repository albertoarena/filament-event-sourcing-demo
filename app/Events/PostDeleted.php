<?php

declare(strict_types=1);

namespace App\Events;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

final class PostDeleted extends ShouldBeStored {}

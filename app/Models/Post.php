<?php

declare(strict_types=1);

namespace App\Models;

use Albertoarena\FilamentEventSourcing\Concerns\HasStoredEvents;
use Spatie\EventSourcing\Projections\Projection;

/**
 * @property string $uuid
 * @property string $title
 * @property string $body
 */
class Post extends Projection
{
    use HasStoredEvents;

    protected $guarded = [];
}

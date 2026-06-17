<?php

namespace App\Filament\Resources\Posts\Pages;

use Albertoarena\FilamentEventSourcing\Concerns\CreatesEventSourcedRecord;
use App\Aggregates\PostAggregate;
use App\Filament\Resources\Posts\PostResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePost extends CreateRecord
{
    use CreatesEventSourcedRecord;

    protected static string $resource = PostResource::class;

    protected function handleAggregateCreation(string $uuid, array $data): void
    {
        PostAggregate::retrieve($uuid)
            ->createPost($data['title'], $data['body'])
            ->persist();
    }
}

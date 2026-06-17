<?php

namespace App\Filament\Resources\Posts\Pages;

use Albertoarena\FilamentEventSourcing\Actions\EventHistoryAction;
use Albertoarena\FilamentEventSourcing\Actions\EventSourcedDeleteAction;
use Albertoarena\FilamentEventSourcing\Concerns\EditsEventSourcedRecord;
use App\Aggregates\PostAggregate;
use App\Filament\Resources\Posts\PostResource;
use App\Models\Post;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditPost extends EditRecord
{
    use EditsEventSourcedRecord;

    protected static string $resource = PostResource::class;

    protected function handleAggregateUpdate(Model $record, array $data): void
    {
        $aggregate = PostAggregate::retrieve($record->uuid);

        if ($data['title'] !== $record->title) {
            $aggregate->changeTitle($data['title']);
        }

        if ($data['body'] !== $record->body) {
            $aggregate->changeBody($data['body']);
        }

        $aggregate->persist();
    }

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            EventHistoryAction::make(),
            EventSourcedDeleteAction::make()
                ->using(fn (Post $record) => PostAggregate::retrieve($record->uuid)->deletePost()->persist()),
        ];
    }
}

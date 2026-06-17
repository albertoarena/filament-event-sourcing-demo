<?php

namespace Database\Seeders;

use App\Aggregates\PostAggregate;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        // A post with several edits, so its event history is rich.
        $first = Str::uuid()->toString();
        PostAggregate::retrieve($first)
            ->createPost('Getting started with event sourcing', 'A first draft.')
            ->persist();
        PostAggregate::retrieve($first)
            ->changeTitle('Getting started with Filament event sourcing')
            ->persist();
        PostAggregate::retrieve($first)
            ->changeBody('A revised, more complete introduction to the demo.')
            ->persist();

        // A plain post.
        $second = Str::uuid()->toString();
        PostAggregate::retrieve($second)
            ->createPost('Auditing aggregates in Filament', 'Every write is recorded as an event.')
            ->persist();

        // A post that gets created then deleted, to show the delete event in the stored events.
        $third = Str::uuid()->toString();
        PostAggregate::retrieve($third)
            ->createPost('A short-lived draft', 'This one will be removed.')
            ->persist();
        PostAggregate::retrieve($third)
            ->deletePost()
            ->persist();
    }
}

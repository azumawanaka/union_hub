<?php

namespace App\Commands;

use Illuminate\Console\Command;
use App\Models\Event;
use Carbon\Carbon;

class UpdateEventStatus extends Command
{
    protected $signature = 'events:update-status';

    protected $description = 'Update status of events whose start date has passed';

    public function handle()
    {
        $events = Event::whereDate('start_date', '<', Carbon::now())->get();

        foreach ($events as $event) {
            $event->update(['status' => 'finished']);
        }

        $this->info('Event statuses updated successfully.');
    }
}

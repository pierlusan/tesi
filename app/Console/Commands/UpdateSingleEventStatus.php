<?php

namespace App\Console\Commands;

use App\Enum\EventStatus;
use App\Models\SingleEvent;
use Illuminate\Console\Command;

class UpdateSingleEventStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:single-event-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Aggiorna lo stato degli eventi singoli';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = now();

        $plannedEvents = SingleEvent::where('status', EventStatus::PLANNED)
            ->where('date', '<=', $now)
            ->get();
        foreach ($plannedEvents as $event) {
            $event->status = EventStatus::ACTIVE;
            $event->save();
        }

        $activeEvents = SingleEvent::where('status', EventStatus::ACTIVE)
            ->where('date', '<=', $now->subHours(12))
            ->get();
        foreach ($activeEvents as $event) {
            $event->status = EventStatus::COMPLETED;
            $event->save();
        }

        $canceledEvents = SingleEvent::where('status', EventStatus::CANCELED)
            ->where('date', '<=', $now->subDays(3))
            ->get();
        foreach ($canceledEvents as $event) {
            $event->delete();
        }

        $this->info('Stati degli eventi aggiornati con successo.');
    }

}

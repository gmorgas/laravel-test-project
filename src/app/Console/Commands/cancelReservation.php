<?php

namespace App\Console\Commands;

use App\Reservation;
use Illuminate\Console\Command;

class cancelReservation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'quote:daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Daily job that is run everyday at 10:00 a.m. that will pick up all reservations in
status pending or confirmed which to date has passed and change their status to overdue.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $reservation = Reservation::whereIn('status', ['pending', 'confirmed'])
            ->where('from', '<', now())
            ->update(['status' => 'overdue']);

        $this->info('Successfully change status in: ' . $reservation . ' reservations');
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Flight;
use App\Models\User;
use App\Models\AircraftFlight;
use App\Models\FlightPassenger;
use DateTime;
use DateTimeZone;
use Carbon\Carbon;

class AutoYearPlan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auto-year-plan';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Plan all flights and passenger flights for a year.';

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
     * @return int
     */
    public function handle()
    {
        $flights = Flight::where('type', 'REGULAR')->get();
        foreach ($flights as $flight) {
            $current_date = Carbon::now()->timezone('Australia/Sydney');
            $year = $current_date->year;
            while($year == $current_date->year) {
                $current_day = $current_date->dayOfWeek;
                if ($current_day == 0) {
                    $current_day = 7;
                }
                if (in_array($current_day, $flight->operation_days)) {
                    $aircraft_flight = new AircraftFlight;
                    $aircraft_flight->flight_id = $flight->id;
                    $aircraft_flight->date = $current_date->format('Y-m-d');
                    $aircraft_flight->departure_time = $flight->departure_time;
                    $aircraft_flight->arrival_time = $flight->arrival_time;
                    $aircraft_flight->flight_time = $flight->flight_time;
                    $aircraft_flight->save();
                }
                $current_date = $current_date->addDays(1);
            }
        }

        $passengers = User::where('roster', '!=', null)->orWhere('roster', '!=', '')->get();
        $passenger = $passengers[0];
        foreach ($passengers as $passenger) {
            $roster = explode("-", $passenger->roster);
            $start_date = new Carbon($passenger->start_date);
            $current_date = Carbon::now()->timezone('Australia/Sydney');
            while($start_date->dayOfWeek != $current_date->dayOfWeek) {
                $current_date = $current_date->addDays(1);
            }
            $year = $current_date->year;
            $i = 0;
            while($year == $current_date->year) {
                $i = $i % 4;
                if (($i == 0) || ($i == 2)) {
                    $aircraft_flights = AircraftFlight::where('flight_id', $passenger->departed_flight)
                                                ->where('date', $current_date->format('Y-m-d'))->get();
                } else {
                    $aircraft_flights = AircraftFlight::where('flight_id', $passenger->landed_flight)
                                                ->where('date', $current_date->format('Y-m-d'))->get();
                }
                if (count($aircraft_flights) > 0) {
                    // var_dump($current_date);
                    $flight_passenger = new FlightPassenger;
                    $flight_passenger->aircraft_flight_id = $aircraft_flights[0]->id;
                    $flight_passenger->passenger_id = $passenger->id;
                    $flight_passenger->save();
                }
                $current_date = $current_date->addDays($roster[$i]);
                $i++;
            }
        }
    }
}

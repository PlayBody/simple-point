<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\AircraftFlight;
use App\Models\FlightPassenger;
use DateTime;
use Carbon\Carbon;
use Twilio\Rest\Client;
use App\Http\Helpers\Common;

class AutoTicketing extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auto-ticketing';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto Ticketing before 24 hours from flight';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->helper = new Common();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $current_date = Carbon::now()->timezone('Australia/Sydney');
        $aircraft_flights = AircraftFlight::where('date', '>=', $current_date->format('Y-m-d'))
                                        ->where('phase', 'CLOSED')->get();
        // $aircraft_flight = $aircraft_flights[0];
        foreach ($aircraft_flights as $aircraft_flight) {
            $departure_time  = new Carbon($aircraft_flight->date->format('Y-m-d').' '.$aircraft_flight->departure_time->format('H:i:s'));
            $between = $current_date->diffInSeconds($departure_time);
            if ($between <= 86400) {
                // var_dump($this->helper->twillo_sid);
                $flight_passengers = FlightPassenger::where('aircraft_flight_id', $aircraft_flight->id)
                                            ->where('status', 'CLOSED')->get();
                if (count($flight_passengers) > 0) {
                    foreach ($flight_passengers as $flight_passenger) {
                        if ($flight_passenger->book_reference == null || $flight_passenger->book_reference == '') {
                            $book_reference = $this->helper->generateRandomString(6);
                            $flight_passenger -> update([
                                'book_reference' => $book_reference,
                            ]);
                        }
                        $flight = $flight_passenger->aircraftFlight->flight;
                        $receiver = str_replace("+", "", $flight_passenger->passenger->phone);
                        $sender = $this->helper->twillo_number;
                        $sid = $this->helper->twillo_sid;
                        $token = $this->helper->twillo_token;
                        $client = new Client($sid, $token);
                        try {
                            $message = $client->messages->create(
                                $receiver, // Text this number
                                [
                                    'from' => $sender, // From a valid Twilio number
                                    'body' => 'You are booked on '.$flight->airline_code.$flight->flight_number.' '.$flight_passenger->aircraftFlight->date->format('Y-m-d').' from '.$flight->origin_airport_code.' to '.$flight->destination_airport_code.'. Your booking reference is: '.$flight_passenger->book_reference.'. Web check-in is available via https://flightres.tech'
                                ]
                            );
                        } catch (Exception $e) {
                            var_dump("twillo sms failed");
                        }
                        $flight_passenger -> update([
                            'status' => 'SENDED',
                        ]);
                    }
                    $aircraft_flight -> update([
                        'phase' => 'OPEN',
                    ]);
                } else {
                    $aircraft_flight -> update([
                        'phase' => 'OPEN',
                    ]);
                }
            }
        }
    }
}

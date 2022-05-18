<?php
namespace App\Http\Helpers;

use App\Models\FlightPassenger;

class Common
{
    public $twillo_number = '17752389928';
    public $twillo_sid = 'ACaf66ba19c5fd22aa450aab44eeabe06b';
    public $twillo_token = '6c1903152896b93b919a2f6cc03b8846';

    public function generateRandomString($length) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        do {
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            $flight_passengers = FlightPassenger::where('book_reference', $randomString)->get();
        } while (count($flight_passengers) > 0);
        return $randomString;
    }
}
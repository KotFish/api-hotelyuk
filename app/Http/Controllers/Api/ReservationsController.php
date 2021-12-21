<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;
use App\Models\Reservations;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReservationsController extends Controller
{
    public function index($user_id){
        $reservations = Reservations::where('user_id', $user_id)->get();

        if(!is_null($reservations)){
            return response([
                'message' => 'Retrieve All Success',
                'data' => $reservations
            ], 200);
        }

        return response([
            'message' => 'No Reservation',
            'data' => $reservations
        ], 200);
    }

    public function store(Request $request, $user_id){
        $newReservation = $request->all();

        $newReservation['user_id'] = $user_id;
        $newReservation['booking_date'] = Carbon::now();
        $newReservation['room_number'] = rand(1, 200);

        if($newReservation['room_type'] == 'Standard'){
            $pricePerDay = 200000;
        }
        elseif($newReservation['room_type'] == 'Deluxe'){
            $pricePerDay = 400000;
        }
        elseif($newReservation['room_type'] == 'Superior'){
            $pricePerDay = 600000;
        }
        else{
            $pricePerDay = 0;
        }

        if($newReservation['bed_type'] == 'Double'){
            $pricePerDay = $pricePerDay + 100000;
        }

        $checkin = Carbon::parse($newReservation['check_in']);
        $checkout = Carbon::parse($newReservation['check_out']);
        $reservationDuration = $checkin->diffInDays($checkout);

        if($reservationDuration == 0){
            $newReservation['bill'] = $pricePerDay;
        }
        else{
            $newReservation['bill'] = $reservationDuration * $pricePerDay;
        }
        
        $validate = Validator::make($newReservation, [
            'user_id' => 'required',
            'booking_date' => 'required',
            'room_type' => 'required',
            'bed_type' => 'required',
            'room_number' => 'required',
            'check_in' => 'required',
            'check_out' => 'required',
            'bill' => 'required'
        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()], 400);

        $reservation = Reservations::create($newReservation);
        return response([
            'message' => 'Add Reservation Success',
            'data' => $reservation
        ], 200);
    }

    public function update(Request $request, $id){
        $reservation = Reservations::find($id);

        if(is_null($reservation)){
            return response([
                'message' => 'Reservation Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $updateData['room_number'] = rand(1, 200);

        if($updateData['room_type'] == 'Standard'){
            $pricePerDay = 200000;
        }
        elseif($updateData['room_type'] == 'Deluxe'){
            $pricePerDay = 400000;
        }
        elseif($updateData['room_type'] == 'Superior'){
            $pricePerDay = 600000;
        }
        else{
            $pricePerDay = 0;
        }

        if($updateData['bed_type'] == 'Double'){
            $pricePerDay = $pricePerDay + 100000;
        }


        $checkin = Carbon::parse($updateData['check_in']);
        $checkout = Carbon::parse($updateData['check_out']);
        $reservationDuration = $checkin->diffInDays($checkout);

        if($reservationDuration == 0){
            $updateData['bill'] = $pricePerDay;
        }
        else{
            $updateData['bill'] = $reservationDuration * $pricePerDay;
        }

        $validate = Validator::make($updateData, [
            'room_type' => 'required',
            'bed_type' => 'required',
            'room_number' => 'required',
            'check_in' => 'required',
            'check_out' => 'required',
            'bill' => 'required'
        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()], 400);

        $reservation->room_type = $updateData['room_type'];
        $reservation->bed_type = $updateData['bed_type'];
        $reservation->room_number = $updateData['room_number'];
        $reservation->check_in = $updateData['check_in'];
        $reservation->check_out = $updateData['check_out'];
        $reservation->bill = $updateData['bill'];


        if($reservation->save()){
            return response([
                'message' => 'Update Reservation Success',
                'data' => $reservation
            ], 200);
        }

        return response([
            'message' => 'Update Reservation Failed',
            'data' => null
        ], 400);
    }

    public function destroy($id){
        $reservation = Reservations::find($id);

        if(is_null($reservation)){
            return response([
                'message' => 'Reservation Not Found',
                'data' => null
            ], 404);
        }

        if($reservation->delete()){
            return response([
                'message' => 'Delete Reservation Success',
                'data' => $reservation
            ], 200);
        }

        return response([
            'message' => 'Delete Reservation Failed',
            'data' => null
        ], 400);
    }
}

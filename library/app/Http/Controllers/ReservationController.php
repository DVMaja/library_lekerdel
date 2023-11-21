<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index(){
        //select * from reservations
        return Reservation::all();
    }

    public function show ($user_id, $book_id, $start)
    {
        return Reservation::where('user_id', $user_id)
        ->where('book_id', $book_id)
        ->where('start', $start)
        ->first();
    }


    public function destroy($user_id, $book_id, $start){
        $this->show($user_id, $book_id, $start)->delete();
    }
    
    public function update(Request $request, $user_id, $book_id, $start){
        $reservation = Reservation::show($user_id, $book_id, $start);
        //csak patch!!!
        $reservation->message = $request->message;
        $reservation->save();
    }
    
    public function store(Request $request){
        $reservation = new Reservation();
        $reservation->user_id = $request->user_id;
        $reservation->book_id = $request->book_id;
        $reservation->start = $request->start;
        $reservation->message = $request->message;
        $reservation->save();
        
    }
}
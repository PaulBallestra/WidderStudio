<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReservationFormRequest;
use Illuminate\Support\Facades\Mail;

class ReservationController extends Controller
{

    //Function qui va afficher la page de reservation
    public function show()
    {
        return view('reservation');
    }

    //Fonction qui va envoyer les infos de la reservation
    public function send(ReservationFormRequest $request)
    {

        $params = $request->all();
        dd($params);

        Mail::send('emails.reservation_mail', $params, function ($m) use ($params){
            $m->from($params['email']);
            $m->to('widdershins@studio.com', 'WidderStudio')->subject('Confirmation Réservation');
        });

        return $request;
    }
}

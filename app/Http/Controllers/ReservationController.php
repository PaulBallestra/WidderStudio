<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReservationFormRequest;
use App\Mail\Reservation;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Symfony\Bundle\SecurityBundle\Tests\Functional\Bundle\AclBundle\Entity\Car;

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
        //$params += ["subject" => "WidderStudio Confirmation Réservation"];

        //Mail::to('widdershins@studio.com', 'WidderStudio')->send(new Reservation($params));

        //Si il y a plus de 5 items c'est que l'user a selectionné plusieurs checkbox (Email, Token, Date, Creneau1 et/ou Creneau2)
        if(count($params) > 5){
            dd($params);
        }

        DB::table('reservations')->insert([
            'email' => $params['email'],
            'selectedDate' => $params['selectedDate']
        ]);

        Mail::send('emails.reservation_mail', $params, function ($m) use ($params){
            $m->from($params['email']);
            $m->to('widdershins@studio.com', 'WidderStudio')->subject('Confirmation Réservation WidderStudio');
        });

        return $request;
    }
}

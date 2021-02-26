<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReservationFormRequest;
use App\Mail\Reservation;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
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

        //Si il y a plus de 5 items c'est que l'user a selectionné plusieurs checkbox (Token, Date, Creneau1 et/ou Creneau2, email)
        if(count($params) > 5){
            dd($params);
        }

        //GESTION CRENEAUX

        //Génération du token
        $token = md5(uniqid(true));
        $params['_token'] = $token; //on modifie le token déjà existant (celui de mailtrap) avec le new

        //Stockage en bd
        DB::table('reservations')->insert([
            'email' => $params['email'],
            'selectedDate' => $params['selectedDate'],
            'token' => $token
        ]);

        //Envoi de l'email
        Mail::send('emails.reservation_mail', $params, function ($m) use ($params){
            $m->from($params['email']);
            $m->to(Config::get('information.email'), Config::get('information.name_email'))->subject('Confirmation Réservation WidderStudio');
        });

        return $request;
    }
}

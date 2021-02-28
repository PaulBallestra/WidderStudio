<?php

namespace App\Http\Controllers;

use App\Http\Requests\AnnulationFormRequest;
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

    //Function qui va afficher la page d'annulation d'une réservation
    public function showAnnulation()
    {
        return view('annulation');
    }

    //Fonction qui va envoyer les infos de la reservation
    public function send(ReservationFormRequest $request)
    {

        $params = $request->all();
        //$params += ["subject" => "WidderStudio Confirmation Réservation"];

        //Si il y a plus de 5 items c'est que l'user a selectionné plusieurs checkbox (Token, Date, Creneau1 et/ou Creneau2, email)
        if (count($params) > 5) {
            return redirect('reservation')->with('error', '2 créneaux sont possible seulement !');
        }

        //GESTION JOUR DE SEMAINE
        //On chope le jour de la semaine
        $dayOfWeek = Carbon::parse($params['selectedDate'])->dayOfWeek;

        //check du jour de la semaine
        switch ($dayOfWeek) {
            case 6:
                return redirect('reservation')->with('error', 'Fermé le samedi')->withInput();
                break;

            case 0:
                return redirect('reservation')->with('error', 'Fermé le dimanche')->withInput();
                break;
        }

        //GESTION CRENEAUX
        $selectedCreneaux = [];

        foreach (Config::get('information.open_hours') as $creneau) {
            if (isset($params[$creneau]) && $params[$creneau] === 'on')
                array_push($selectedCreneaux, $creneau); //on ajoute dans le tableau

        }

        if(count($selectedCreneaux) === 0)
            return redirect('reservation')->with('error', 'Vous devez réserver au moin 1 créneau !')->withInput();


        $params['creneau'] = $selectedCreneaux[0];

        //Stockage du creneau2 si il existe
        if (count($selectedCreneaux) > 1)
            $params['creneau2'] = $selectedCreneaux[1];


        //Génération du token
        $token = md5(uniqid(true));
        $params['_token'] = $token; //on modifie le token déjà existant (celui de mailtrap) avec le new

        //On stock si y'en des creneau deja utilisés
        $isAlreadyUsedCreneau = DB::table('reservations')->where('selectedDate', '=', $params['selectedDate'])->where('creneau1', '=', $params['creneau'])->count();

        //Si il y a un creneau 2 on vérifie aussi
        if (count($selectedCreneaux) > 1){
            $isAlreadyUsedCreneau2 = DB::table('reservations')->where('selectedDate', '=', $params['selectedDate'])->where('creneau2', '=', $params['creneau2'])->count();
            $isAlreadyUsedCreneau2ButInTheFirst = DB::table('reservations')->where('selectedDate', '=', $params['selectedDate'])->where('creneau1', '=', $params['creneau2'])->count();
        }

        //Redirect avec erreur si déjà réservé
        if ($isAlreadyUsedCreneau > 0)
            return redirect('reservation')->with('error', 'Oh quel dommage ! Votre premier créneau est déjà réservé a cette heure-ci ')->withInput();
        else if((isset($isAlreadyUsedCreneau2) && $isAlreadyUsedCreneau2 > 0) || (isset($isAlreadyUsedCreneau2ButInTheFirst) && $isAlreadyUsedCreneau2ButInTheFirst > 0))
            return redirect('reservation')->with('error', 'Oh quel dommage ! Votre second créneau est déjà réservé a cette heure-ci ')->withInput();


        //Si le créneau est libre
        if (count($selectedCreneaux) > 1) {

            //Stockage en bd des 2 créneaux
            DB::table('reservations')->insert([
                'email' => $params['email'],
                'selectedDate' => $params['selectedDate'],
                'token' => $token,
                'creneau1' => $params['creneau'],
                'creneau2' => $params['creneau2']
            ]);

        }else{
            //Stockage en bd
            DB::table('reservations')->insert([
                'email' => $params['email'],
                'selectedDate' => $params['selectedDate'],
                'token' => $token,
                'creneau1' => $params['creneau'],
                'creneau2' => '' //null en gros
            ]);
        }

        //Pas réussi avec les mailables sry :'(
        //Mail::to('widdershins@studio.com', 'WidderStudio')->send(new Reservation($params));

        //Envoi de l'email
        Mail::send('emails.reservation_mail', $params, function ($m) use ($params) {
            $m->from($params['email']);
            $m->to(Config::get('information.email'), Config::get('information.name_email'))->subject('Confirmation Réservation WidderStudio');
        });

        return redirect('reservation')->with('status', 'Votre réservation a bien été prise en compte, veuillez vérifier vos emails !');
    }

    //Fonction qui va envoyer l'annulation de la reservation
    public function sendAnnulation(AnnulationFormRequest $request)
    {

        $params = $request->all();

        $isTokenExists = DB::table('reservations')->where('token', '=', $params['token_user'])->count();

        //Si il existe alors on le delete
        if($isTokenExists > 0){

            //on renvoit l'annulation par email
            Mail::send('emails.annulation_mail', [], function ($m) {
                $m->from(Config::get('information.email'));
                $m->to(Config::get('information.email'), Config::get('information.name_email'))->subject('Annulation Réservation WidderStudio');
            });

            //DELETE de la row ayant le token
            DB::table('reservations')->where('token', '=', $params['token_user'])->delete();

        }else{
            //sinon redirect
            return redirect('reservation/annulation')->with('error', 'Ce token n\'existe pas !');
        }

        return redirect('reservation/annulation')->with('status', 'Votre annulation de réservation a bien été validée, en espérant vous revoir vite !');

    }
}

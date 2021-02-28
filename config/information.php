<?php

return [
    'email' => env('MAIL_FROM_ADDRESS'),
    'name_email' => env('MAIL_FROM_NAME'),
    'open_days' => ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi'],
    'closed_days' => [
        '6' => 6,
        '7' => 7
    ], //jour 6 et 7, samedi et dimanche
    'open_hours' => ['9-10h', '10-11h', '11-12h', '12-13h', '13-14h', '14-15h', '15-16h', '16-17h', '17-18h'],
    'max_per_creneaux' => 2
];

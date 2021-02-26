<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>WidderStudio - Mail de confirmation</title>
</head>
<body>

    <h3> Cher  {{ $email }} </h3>

    <h5> Votre réservation du {{ $selectedDate }} est validée ! </h5>

    <p> Votre créneau : {{ $creneau }} </p>

    <?php if(isset($creneau2)) : //Si il y a un 2eme créneau ?>

        <p> Votre 2ème créneau : {{ $creneau2 }} </p>

    <?php endif; ?>

    <p> Pour annuler votre reservation veuillez suivre ce lien et rentrer ce token : {{ $_token  }} </p>

    <p> Au revoir et à bientôt au WidderStudio </p>

</body>
</html>

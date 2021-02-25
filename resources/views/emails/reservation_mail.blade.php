<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>WidderStudio - Mail de confirmation</title>
</head>
<body>

    <h1> Cher </h1> <p> {{ $email }} </p>

    <h3> Votre réservation du {{ $datepicker }} est validée ! </h3>

    <p> Pour annuler votre reservation veuillez suivre ce lien </p>

    {{ $_token  }}



</body>
</html>

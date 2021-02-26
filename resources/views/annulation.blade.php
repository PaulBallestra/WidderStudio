@extends('layouts.default')

@section('content')

    <!-- INCLUDE NAVBAR -->
    @include('partials.navbar')

    <!-- GESTION POUR QUAND TOUS SE PASSE BIEN -->
    @if (session('status'))

        <div
            class="max-w-7xl text-white mt-3 px-6 py-4 border-0 rounded relative mb-3 bg-green-500 flex flex-col mx-auto">
            <span class="inline-block align-middle mr-8">

                {{ session('status') }}

            </span>
            <button
                class="absolute bg-transparent text-2xl font-semibold leading-none right-0 top-0 mt-4 mr-6 outline-none focus:outline-none">
                <span>×</span>
            </button>
        </div>

    @endif

    <!-- GESTION DES ERREURS -->
    @if ($errors->any())

        <div
            class="max-w-7xl text-white mt-3 px-6 py-4 border-0 rounded relative mb-3 bg-red-500 flex flex-col mx-auto">
            <span class="inline-block align-middle mr-8">

                <ul>
                    @foreach($errors->all() as $error)
                        <li> {{ $error  }} </li>
                    @endforeach
                </ul>

            </span>
            <button
                class="absolute bg-transparent text-2xl font-semibold leading-none right-0 top-0 mt-4 mr-6 outline-none focus:outline-none">
                <span>×</span>
            </button>
        </div>

    @endif

    <!-- SELECTION DES CRENEAUX -->
    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
            <div class="lg:text-center">

                <!-- INPUT DU TOKEN -->
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    Désolé de vous voir partir
                </p>

                <p class="mt-2 max-w-2xl text-xl text-gray-500 lg:mx-auto">
                    Veuillez renseigner le token qui vous a été envoyé par mail lors de la réservation.
                </p>

                <div class="rounded-md shadow-sm -space-y-px mt-3">
                    <div>
                        <input id="token_text" name="token_text" type="text" required
                               class="align-middle inline-block appearance-none rounded-none relative block w-3/6 px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-green-500 focus:border-green-500 focus:z-10 sm:text-sm"
                               placeholder="<?= md5(uniqid(true)) ?>" value="{{ old('email') }}">
                    </div>
                </div>

                <!-- BTN Annuler -->
                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                    <button type="submit"
                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        Annuler
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection



@extends('layouts.default')

@section('content')

    @include('partials.navbar')



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
    <div class="py-12 max-w-7xl flex flex-col mx-auto">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="lg:text-center">
                    <h2 class="text-base text-green-600 font-semibold tracking-wide uppercase"> Reservation </h2>
                    <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                        Réservez votre créneaux !
                    </p>
                    <p class="mt-2 max-w-2xl text-xl text-gray-500 lg:mx-auto">
                        Vous devez selectionner un jour ainsi qu'un ou deux créneaux de réservation si il reste de la
                        place.
                    </p>

                    <form class="mt-4 space-y-6 max-w-7x1" action="/reservation" method="POST">

                        @csrf

                        <!-- DATE PICKER -->
                        <input class="mt-3"
                               wire:model="taskduedate"
                               name="datepicker"
                               type="date" class="form-control datepicker" placeholder="Due Date" autocomplete="off"
                               data-provide="datepicker" data-date-autoclose="true" data-date-format="mm/dd/yyyy"
                               data-date-today-highlight="true"
                        >

                        <!-- SELECTION DES CRENEAUX -->
                        <div>

                        </div>


                        <!-- EMAIL ET INFOS SUR LES RESERVATIONS -->
                        <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                            Indiquez nous votre email
                        </p>
                        <p class="mt-2 max-w-2xl text-xl text-gray-500 lg:mx-auto">
                            Veuillez renseigner votre adresse email ci-dessous pour réserver.
                        </p>

                        <div class="rounded-md shadow-sm -space-y-px">
                            <div>
                                <label for="email-address" class="sr-only">Email address</label>
                                <input id="email-address" name="email" type="email" autocomplete="email" required
                                       class="align-middle inline-block appearance-none rounded-none relative block w-3/6 px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-green-500 focus:border-green-500 focus:z-10 sm:text-sm"
                                       placeholder="contact@email.example" value="{{ old('email') }}">
                            </div>
                        </div>

                        <!-- BTN Reserver -->
                        <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                            <button type="submit"
                                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                Réserver
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection



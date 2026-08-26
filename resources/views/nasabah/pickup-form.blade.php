@extends('layouts.dashboard', ['isReactDashboard' => true])

@section('content')
    @php
        $validationErrors = [];
        if ($errors->any()) {
            foreach ($errors->messages() as $field => $messages) {
                $validationErrors[$field] = $messages[0];
            }
        }
    @endphp

    <div id="pickup-booking-app"
         data-auth="{{ json_encode($authData) }}"
         data-bank-sampah="{{ json_encode($bankSampahData) }}"
         data-categories="{{ json_encode($trashCategories) }}"
         data-history="{{ json_encode($pickupHistory) }}"
         data-csrf="{{ csrf_token() }}"
         data-status="{{ session('success') ?: session('status') ?: '' }}"
         data-error="{{ session('error') ?: '' }}"
         data-errors="{{ json_encode($validationErrors) }}">
    </div>
@endsection

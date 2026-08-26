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

    @if(($userRole ?? '') === 'petugas')
        <div id="petugas-profile-app"
             data-auth="{{ json_encode($authData) }}"
             data-stats="{{ json_encode($officerStats ?? []) }}"
             data-csrf="{{ csrf_token() }}"
             data-status="{{ $sessionStatus ?? '' }}"
             data-errors="{{ json_encode($validationErrors) }}">
        </div>
    @else
        <div id="nasabah-profile-app"
             data-auth="{{ json_encode($authData) }}"
             data-csrf="{{ csrf_token() }}"
             data-status="{{ $sessionStatus ?? '' }}"
             data-errors="{{ json_encode($validationErrors) }}">
        </div>
    @endif
@endsection

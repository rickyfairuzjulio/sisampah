@extends('layouts.dashboard', ['isReactDashboard' => true])

@section('content')
    <div id="self-deposit-app"
         data-auth="{{ json_encode($authData) }}"
         data-categories="{{ json_encode($trashCategories) }}"
         data-nasabahs="{{ json_encode($registeredNasabahs) }}"
         data-csrf="{{ csrf_token() }}">
    </div>
@endsection

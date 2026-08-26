@extends('layouts.landing', ['isReactLanding' => true])

@section('content')
    <div id="landing-app"
         data-articles="{{ json_encode($articles) }}"
         data-stats="{{ json_encode($stats) }}"
         data-categories="{{ json_encode($categories) }}"
         data-auth="{{ json_encode($authData) }}">
    </div>
@endsection

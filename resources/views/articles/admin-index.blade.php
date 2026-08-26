@extends('layouts.dashboard', ['isReactDashboard' => true])

@section('content')
    <div id="admin-articles-app"
         data-auth="{{ json_encode($authData ?? []) }}"
         data-statistics="{{ json_encode($statistics ?? []) }}"
         data-articles="{{ json_encode($articlesList ?? []) }}">
    </div>
@endsection

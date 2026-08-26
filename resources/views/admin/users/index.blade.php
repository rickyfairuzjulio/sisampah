@extends('layouts.dashboard', ['isReactDashboard' => true])

@section('content')
    <div id="admin-users-app"
         data-auth="{{ json_encode($authData ?? []) }}"
         data-statistics="{{ json_encode($statistics ?? []) }}"
         data-users="{{ json_encode($usersList ?? []) }}">
    </div>
@endsection

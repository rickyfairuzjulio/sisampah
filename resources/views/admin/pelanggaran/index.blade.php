@extends('layouts.dashboard', ['isReactDashboard' => true])

@section('content')
    <div id="admin-violations-app"
         data-auth="{{ json_encode($authData ?? []) }}"
         data-statistics="{{ json_encode($statistics ?? []) }}"
         data-violations="{{ json_encode($violationsList ?? []) }}"
         data-users="{{ json_encode($usersDropdown ?? []) }}"
         data-csrf="{{ csrf_token() }}">
    </div>
@endsection

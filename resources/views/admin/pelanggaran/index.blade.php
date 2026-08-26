@extends('layouts.dashboard', ['isReactDashboard' => true])

@section('content')
    <div id="admin-violations-app"
         data-auth="{{ json_encode($authData ?? []) }}"
         data-statistics="{{ json_encode($statistics ?? []) }}"
         data-violations="{{ json_encode($violationsList ?? []) }}">
    </div>
@endsection

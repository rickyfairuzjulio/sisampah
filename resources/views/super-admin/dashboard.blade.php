@extends('layouts.dashboard', ['isReactDashboard' => true])

@section('content')
    <div id="super-admin-dashboard-app"
         data-auth="{{ json_encode($authData ?? []) }}"
         data-statistics="{{ json_encode($statistics ?? []) }}"
         data-charts="{{ json_encode($charts ?? []) }}"
         data-pending="{{ json_encode($pendingVerifications ?? []) }}"
         data-top-units="{{ json_encode($topUnits ?? []) }}">
    </div>
@endsection

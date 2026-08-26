@extends('layouts.dashboard', ['isReactDashboard' => true])

@section('content')
    <div id="certificate-app"
         data-auth="{{ json_encode($authData) }}"
         data-stats="{{ json_encode($stats) }}"
         data-impact="{{ json_encode($impact) }}"
         data-details="{{ json_encode($certificateDetails) }}"
         data-badges="{{ json_encode($badges) }}">
    </div>
@endsection

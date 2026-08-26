@extends('layouts.dashboard', ['isReactDashboard' => true])

@section('content')
    <div id="super-admin-map-app"
         data-auth="{{ json_encode($authData ?? []) }}"
         data-bank-sampahs="{{ json_encode($bankSampahs ?? []) }}"
         data-gis-stats="{{ json_encode($gisStats ?? []) }}"
         data-blank-spots="{{ json_encode($blankSpotInsights ?? []) }}"
         data-csrf-token="{{ csrf_token() }}">
    </div>
@endsection

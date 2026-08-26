@extends('layouts.dashboard', ['isReactDashboard' => true])

@section('content')
    <div id="petugas-dashboard-app"
         data-auth="{{ json_encode($authData) }}"
         data-kpi="{{ json_encode($kpiData) }}"
         data-manifest="{{ json_encode($pickupManifest) }}"
         data-recent="{{ json_encode($recentWeighings) }}">
    </div>
@endsection

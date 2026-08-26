@extends('layouts.dashboard', ['isReactDashboard' => true])

@section('content')
    <div id="nasabah-dashboard-app"
         data-auth="{{ json_encode($authData) }}"
         data-gamification="{{ json_encode($gamification) }}"
         data-kpi="{{ json_encode($kpiData) }}"
         data-impact="{{ json_encode($impact) }}"
         data-chart="{{ json_encode($chartData) }}"
         data-prices="{{ json_encode($prices) }}"
         data-transactions="{{ json_encode($recentTransactions) }}"
         data-leaderboard="{{ json_encode($leaderboard) }}"
         data-banksampahs="{{ json_encode($bankSampahs) }}">
    </div>
@endsection

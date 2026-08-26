@extends('layouts.dashboard', ['isReactDashboard' => true])

@section('content')
    <div id="admin-dashboard-app"
         data-auth="{{ json_encode($authData ?? []) }}"
         data-metrics="{{ json_encode($metrics ?? []) }}"
         data-cashflow="{{ json_encode($cashflow ?? []) }}"
         data-chart-setoran="{{ json_encode($chartSetoran ?? []) }}"
         data-chart-jenis="{{ json_encode($chartJenisSampah ?? []) }}"
         data-withdrawals="{{ json_encode($pendingWithdrawals ?? []) }}"
         data-recent="{{ json_encode($recentTransactions ?? []) }}">
    </div>
@endsection

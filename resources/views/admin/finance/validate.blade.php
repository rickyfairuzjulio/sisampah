@extends('layouts.dashboard', ['isReactDashboard' => true])

@section('content')
    <div id="admin-finance-app"
         data-auth="{{ json_encode($authData ?? []) }}"
         data-treasury="{{ json_encode($treasury ?? []) }}"
         data-pending="{{ json_encode($pendingWithdrawals ?? []) }}"
         data-approved="{{ json_encode($approvedWithdrawals ?? []) }}"
         data-rejected="{{ json_encode($rejectedWithdrawals ?? []) }}">
    </div>
@endsection

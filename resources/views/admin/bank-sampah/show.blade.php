@extends('layouts.dashboard', ['isReactDashboard' => true])

@section('content')
    <div id="super-admin-master-bs-detail-app"
         data-auth="{{ json_encode($authData ?? []) }}"
         data-unit-detail="{{ json_encode($unitDetail ?? []) }}"
         data-admins="{{ json_encode($adminsList ?? []) }}"
         data-petugas="{{ json_encode($petugasList ?? []) }}"
         data-prices="{{ json_encode($trashPricesList ?? []) }}"
         data-transactions="{{ json_encode($recentTransactionsList ?? []) }}"
         data-csrf-token="{{ csrf_token() }}">
    </div>
@endsection

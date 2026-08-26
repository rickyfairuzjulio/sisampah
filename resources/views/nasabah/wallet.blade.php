@extends('layouts.dashboard', ['isReactDashboard' => true])

@section('content')
    <div id="wallet-app"
         data-auth="{{ json_encode($authData) }}"
         data-saldo="{{ $saldo }}"
         data-stats="{{ json_encode($walletStats) }}"
         data-deposits="{{ json_encode($depositTransactions) }}"
         data-withdrawals="{{ json_encode($withdrawals) }}"
         data-csrf="{{ csrf_token() }}"
         data-status="{{ session('success') ?: session('status') ?: '' }}"
         data-error="{{ session('error') ?: '' }}">
    </div>
@endsection

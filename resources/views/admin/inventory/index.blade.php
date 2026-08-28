@extends('layouts.dashboard', ['isReactDashboard' => true])

@section('content')
    <div id="admin-inventory-app"
         data-auth="{{ json_encode($authData ?? []) }}"
         data-stock="{{ json_encode($stockData ?? []) }}"
         data-upcycling="{{ json_encode($upcyclingProducts ?? []) }}"
         data-ledgers="{{ json_encode($materialLedgers ?? []) }}"
         data-raw-categories="{{ json_encode($rawCategories ?? []) }}"
         data-csrf="{{ csrf_token() }}">
    </div>
@endsection

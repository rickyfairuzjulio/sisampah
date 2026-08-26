@extends('layouts.dashboard', ['isReactDashboard' => true])

@section('content')
    <div id="admin-inventory-app"
         data-auth="{{ json_encode($authData ?? []) }}"
         data-stock="{{ json_encode($stockData ?? []) }}">
    </div>
@endsection

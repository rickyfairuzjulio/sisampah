@extends('layouts.dashboard', ['isReactDashboard' => true])

@section('content')
    <div id="admin-reports-app"
         data-auth="{{ json_encode($authData ?? []) }}"
         data-summary="{{ json_encode($summary ?? []) }}"
         data-transactions="{{ json_encode($transactionsList ?? []) }}"
         data-rt="{{ json_encode($rtList ?? []) }}"
         data-rw="{{ json_encode($rwList ?? []) }}">
    </div>
@endsection

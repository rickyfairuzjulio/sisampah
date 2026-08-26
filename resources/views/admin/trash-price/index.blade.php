@extends('layouts.dashboard', ['isReactDashboard' => true])

@section('content')
    <div id="admin-trash-price-app"
         data-auth="{{ json_encode($authData ?? []) }}"
         data-statistics="{{ json_encode($statistics ?? []) }}"
         data-categories="{{ json_encode($categoryList ?? []) }}">
    </div>
@endsection

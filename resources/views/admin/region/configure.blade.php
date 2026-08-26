@extends('layouts.dashboard', ['isReactDashboard' => true])

@section('content')
    <div id="super-admin-config-app"
         data-auth="{{ json_encode($authData ?? []) }}"
         data-settings="{{ json_encode($settings ?? []) }}"
         data-config-stats="{{ json_encode($configStats ?? []) }}"
         data-rt-list="{{ json_encode($rtList ?? []) }}"
         data-rw-list="{{ json_encode($rwList ?? []) }}"
         data-csrf-token="{{ csrf_token() }}">
    </div>
@endsection

@extends('layouts.dashboard', ['isReactDashboard' => true])

@section('content')
    <div id="super-admin-verification-index-app"
         data-auth="{{ json_encode($authData ?? []) }}"
         data-stats="{{ json_encode($stats ?? []) }}"
         data-registrations="{{ json_encode($registrations ?? []) }}"
         data-status-filter="{{ json_encode($statusFilter ?? 'all') }}"
         data-search-query="{{ json_encode($searchQuery ?? '') }}">
    </div>
@endsection

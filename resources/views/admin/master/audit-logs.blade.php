@extends('layouts.dashboard', ['isReactDashboard' => true])

@section('content')
    <div id="super-admin-audit-logs-app"
         data-auth="{{ json_encode($authData ?? []) }}"
         data-logs="{{ json_encode($mappedLogs ?? []) }}"
         data-audit-stats="{{ json_encode($auditStats ?? []) }}"
         data-csrf-token="{{ csrf_token() }}">
    </div>
@endsection

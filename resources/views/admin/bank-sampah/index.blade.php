@extends('layouts.dashboard', ['isReactDashboard' => true])

@section('content')
    <div id="super-admin-master-bs-index-app"
         data-auth="{{ json_encode($authData ?? []) }}"
         data-stats="{{ json_encode($stats ?? []) }}"
         data-bank-sampahs="{{ json_encode($bankSampahs ?? []) }}"
         data-provinsi-list="{{ json_encode($provinsiList ?? []) }}"
         data-kabupaten-list="{{ json_encode($kabupatenList ?? []) }}"
         data-csrf-token="{{ csrf_token() }}">
    </div>
@endsection

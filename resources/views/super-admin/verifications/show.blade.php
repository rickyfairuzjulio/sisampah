@extends('layouts.dashboard', ['isReactDashboard' => true])

@section('content')
    <div id="super-admin-verification-detail-app"
         data-auth="{{ json_encode($authData ?? []) }}"
         data-bank-sampah="{{ json_encode($bankSampahData ?? []) }}"
         data-documents="{{ json_encode($documents ?? []) }}"
         data-verifications="{{ json_encode($verifications ?? []) }}"
         data-csrf-token="{{ csrf_token() }}">
    </div>
@endsection

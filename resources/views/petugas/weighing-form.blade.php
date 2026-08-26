@extends('layouts.dashboard', ['isReactDashboard' => true])

@section('content')
    <div id="weighing-form-app"
         data-auth="{{ json_encode($authData) }}"
         data-target="{{ json_encode($targetNasabah) }}"
         data-categories="{{ json_encode($trashCategories) }}"
         data-pending="{{ json_encode($pendingItems) }}"
         data-csrf="{{ csrf_token() }}">
    </div>
@endsection

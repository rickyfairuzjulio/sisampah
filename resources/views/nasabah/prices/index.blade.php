@extends('layouts.dashboard', ['isReactDashboard' => true])

@section('content')
    <div id="price-catalog-app"
         data-auth="{{ json_encode($authData) }}"
         data-selected-bs="{{ json_encode($selectedBankSampahData) }}"
         data-nearby-bs="{{ json_encode($nearbyBankSampahs) }}"
         data-radius="{{ $radiusKm ?? 5 }}"
         data-selected-bs-id="{{ $selectedBsId ?? 1 }}"
         data-active-category="{{ $activeCategory ?? 'all' }}"
         data-prices="{{ json_encode($prices) }}"
         data-counts="{{ json_encode($categoryCounts) }}">
    </div>
@endsection

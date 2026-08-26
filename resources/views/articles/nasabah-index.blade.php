@extends('layouts.dashboard', ['isReactDashboard' => true])

@section('content')
    <div id="education-app"
         data-auth="{{ json_encode($authData) }}"
         data-articles="{{ json_encode($allArticles) }}"
         data-featured="{{ json_encode($featuredArticle) }}"
         data-categories="{{ json_encode($categories) }}">
    </div>
@endsection

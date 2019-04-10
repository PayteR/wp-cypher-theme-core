@extends('layouts.app')

@section('content')
  @include('partials.header.page')

  @if (!have_posts())
    <div class="notification is-danger">
      {{ __('Sorry, but the page you were trying to view does not exist.', 'cypher') }}
    </div>
    {!! get_search_form(false) !!}
  @endif
@endsection

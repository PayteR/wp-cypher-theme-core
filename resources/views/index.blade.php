@extends('layouts.app')

@section('content')
  @include('partials.header.page')

  @if (!have_posts())
    <div class="alert alert-warning">
      {{ __('Sorry, no results were found.', 'cypher') }}
    </div>
    {!! get_search_form(false) !!}
  @endif

  @while(have_posts()) @php the_post() @endphp
    @include('loop.')
  @endwhile

  @php \Cypher\pagination() @endphp
@endsection

@section('sidebar')
  @include('sidebar.')
@endsection

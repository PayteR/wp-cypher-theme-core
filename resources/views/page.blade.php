@extends('layouts.app')

@section('content')
  @while(have_posts()) @php the_post() @endphp
    @include('content.page')
  @endwhile
@endsection

@section('sidebar')
  @include('sidebar.index')
@endsection

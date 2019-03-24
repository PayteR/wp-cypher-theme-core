@extends('layouts.app')

@section('content')
  @while(have_posts()) @php the_post() @endphp
    @include('content.single-'.get_post_type())
  @endwhile
@endsection

@section('sidebar')
  @include('sidebar.index')
@endsection

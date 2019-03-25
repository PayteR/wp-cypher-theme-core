{{--
  Template Name: Template Fullwidth
--}}

@extends('layouts.app')

@section('content')
  @while(have_posts()) @php the_post() @endphp
    @include('content.')
  @endwhile
@endsection

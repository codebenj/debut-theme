@extends('layouts.debutify-new')
@section('title', $course->title)
@section('view-course','view-course')

@section('content')
  <div id="app-single-course" data-title="{{ $course->title }}"></div>
@endsection

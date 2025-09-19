@extends('hr_manager.layouts.app')

@section('title')
  <title>HR Dashboard</title>
@endsection

@section('Page_title')
<div class="pagetitle">
    <h1>Welcome Manager {{ Auth::user()->name }}</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item active">Dashboard</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->
@endsection

@section('content')

@endsection
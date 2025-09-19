@extends('employee.layouts.app')

@section('title')
  <title>Employee Dashboard</title>
@endsection

@section('Page_title')
<div class="pagetitle">
    <h1>Welcome {{ Auth::user()->name }}</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('employee.dashboard')}}">Dashboard</a></li>
      </ol>
    </nav>
  </div><!-- End Page Title -->
@endsection
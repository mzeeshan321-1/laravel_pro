@extends('admin.layouts.app')

@section('title')
  <title>Admin Dashboard</title>
@endsection

@section('Page_title')
<div class="pagetitle">
    <h1>Welcome {{ Auth::user()->name }}</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard')}}">Dashboard</a></li>
      </ol>
    </nav>
  </div><!-- End Page Title -->
@endsection

@section('content')
<div class="row gy-3">
    <div class="col-lg-3 col-md-6">
        <div class="card border-primary h-100">
            <div class="card-body">
                <h6 class="card-title">Total HR Managers</h6>
                <h2>{{ number_format($hrCount) }}</h2>
            </div>
        </div>
    </div>
</div>
@endsection
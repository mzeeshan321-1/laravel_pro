@extends('admin.layouts.app')

@section('title')
    <title>HR Managers</title>
@endsection

@section('Page_title')
    <div class="pagetitle">
        <h1>HR Managers</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">HR Managers</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">HR Managers List</h5>
                <a href="{{ route('admin.hr.create') }}" class="btn btn-primary mb-3">
                    <i class="ri-add-fill"></i>
                </a>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($hrs as $hr)
                        <tr>
                            <td>{{ $hr->id }}</td>
                            <td>{{ $hr->name }}</td>
                            <td>{{ $hr->email }}</td>
                            <td>{{ $hr->created_at->format('M d, Y') }}</td>
                            <td>
                                <a href="{{ route('admin.hr.edit', $hr->id) }}" title="Edit" class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.hr.destroy', $hr->id) }}"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" title="Delete" class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('Are you sure?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">No HR Managers found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $hrs->links() }}
        </div>
    </div>
@endsection

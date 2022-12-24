@extends('layouts.dashboard')

@section('title', 'Deleted Categories')

@section('content')

<x-flash-message />

<div class="mb-4">
    <a href="{{ route('dashboard.categories.index') }}" class="btn btn-outline-primary">
        Categories</a>
</div>

<table class="table">
    <thead>
        <tr>
            <th></th>
            <th>Name</th>
            <th>Parent</th>
            <th>Deleted At</th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($categories as $category)
        <tr>
            <td><img class="img-fluid" src="{{ $category->image_url }}" width="80" alt=""></td>
            <td><strong>{{ $category->name }}</strong><br>
            <span class="text-muted">{{ $category->slug }}</span></td>
            <td>{{ $category->parent_name }}</td>
            <td>{{ $category->deleted_at }}</td>
            <td>
                <form action="{{ route('dashboard.categories.restore', $category->id) }}" method="post">
                    @csrf
                    @method('patch')
                    <button type="submit" class="btn btn-sm btn-outline-success">
                        Restore
                    </button>
                </form>
            </td>
            <td>
                <form action="{{ route('dashboard.categories.force-delete', $category->id) }}" method="post">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-sm btn-outline-danger">
                        <i class="fas fa-trash"></i> Delete For Ever
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection
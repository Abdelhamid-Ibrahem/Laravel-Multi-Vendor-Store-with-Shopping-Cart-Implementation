@extends('layouts.dashboard')

@section('title', $category->name )

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Categories</li>
    <li class="breadcrumb-item active">{{ $category->name }}</li>
@endsection

@section('content')
    <table class="table">
        <thead>
        <tr>
            <th></th>
            <th>Name</th>
            <th>Store</th>
            <th>Status</th>
            <th>Created At</th>
        </tr>
        </thead>
        <tbody>
        @php
           $products = $category->products()->with('store')->latest()->paginate(5);
        @endphp
        @forelse($products as $Product)
            <tr>
                <td><img src="{{ asset('storage/'.$Product->image) }}" alt="" height="50px"></td>
                <td>{{ $Product->name }}</td>
                <td>{{ $Product->store->name }}</td>
                <td>{{ $Product->status }}</td>
                <td>{{ $Product->created_at }}</td>

            </tr>
        @empty
            <tr>
                <td colspan="5">No products defined.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
        {{ $products->links() }}

@endsection
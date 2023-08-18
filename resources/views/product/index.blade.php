@extends('layouts.app')

@section('content')
{{-- @include('product.modal') --}}
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7">
            @if (session('message'))
                <div class="alert alert-success">{{ session('message') }}</div>
            @endif
            @if (session('message_error'))
                <div class="alert alert-danger">{{ session('message_error') }}</div>
            @endif
            <h4 class="mb-3">All Products
                <a class="btn btn-sm btn-success float-end" href="create"><i class="fa fa-plus"></i> Add Product</a>
            </h4>
            <div class="card">
                {{-- <div class="card-header">{{ __('All Products') }}</div> --}}

                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Price</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            @forelse ($products as $product)
                            <tr>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->description }}</td>
                                <td>{{ $product->price }}</td>
                                <td class="">
                                    <a href="{{ url('read/'.$product->id) }}" class="btn btn-sm btn-primary text-decoration-none m-1"><i class="fa fa-eye"></i> </a>
                                    <a href="{{ url('update/'.$product->id.'/edit') }}" class="btn btn-sm btn-success text-decoration-none m-1"><i class="fa fa-pencil"></i> </a>
                                        <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                            <span><i class="fa-solid fa-trash"></i></span></span>
                                        </button>
                                    </a>
                                </td>
                            </tr>
                            @include('product.modal')
                            @empty
                            <tr>
                                <td class="text-center" colspan="7">No Products Available</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="mt-5 mb-3 clearfix">
                <a href="{{ url('/') }}" class=" btn btn-sm btn-outline-primary float-end"><i class="fa fa-arrow-left"></i> Back</a>
            </div>
            <div class="card bg-dark text-light border-secondary">
                <div class="card-header">{{ __('Product Details') }}</div>

                @if ($product)
                    
                <div class="card-body">
                    <div class="form-group mb-3">
                        <label for="name">{{ __('Name') }}</label>
                        <input id="name" type="text" class="form-control bg-dark text-light border-secondary" value="{{ $product->name }}" readonly>
                    </div>

                    <div class="form-group mb-3">
                        <label for="description">{{ __('Description') }}</label>
                        <textarea id="description" class="form-control bg-dark text-light border-secondary" readonly>{{ $product->description }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="price">{{ __('Price') }}</label>
                        <input id="price" type="text" class="form-control bg-dark text-light border-secondary" value="{{ $product->price }}" readonly>
                    </div>
                </div>
                @else
                    <h4 class="alert-danger">Something Went Wrong</h4>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

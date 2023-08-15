@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Product Details') }}</div>

                @if ($product)
                    
                <div class="card-body">
                    <div class="form-group mb-3">
                        <label for="name">{{ __('Name') }}</label>
                        <input id="name" type="text" class="form-control" value="{{ $product->name }}" readonly>
                    </div>

                    <div class="form-group mb-3">
                        <label for="description">{{ __('Description') }}</label>
                        <textarea id="description" class="form-control" readonly>{{ $product->description }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="price">{{ __('Price') }}</label>
                        <input id="price" type="text" class="form-control" value="{{ $product->price }}" readonly>
                    </div>
                </div>
                @else
                    <h4 class="alert-danger">Error</h4>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

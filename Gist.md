## Step by step on how to code a product crud on Laravel.

## 1. Installing the Authentication
```html
i. Install the Laravel UI package.
ii. Generate the authentication scaffolding.
iii. Migrate the database.
iv. Configure the authentication views.

Here are the detailed steps for each:
```

##

**1i. Install the Laravel UI package by running the following command:**
```bash
composer require laravel/ui
```
##

**1ii. Generate the authentication scaffolding by running the following command:**
```bash
php artisan ui vue --auth
```
**This command will create the following files and directories:**
```html
resources/views/auth/login.blade.php <!-- The login view. -->
resources/views/auth/register.blade.php <!-- The registration view. --> 
resources/views/auth/passwords/reset.blade.php <!-- The password reset view. -->
resources/views/auth/passwords/confirm.blade.php <!-- The password confirmation view. -->
resources/views/layouts/app.blade.php <!-- The base layout for your application. --> 
app/Http/Controllers/Auth/LoginController.php <!-- The login controller. --> 
app/Http/Controllers/Auth/RegisterController.php <!-- The registration controller. --> 
app/Http/Controllers/Auth/ForgotPasswordController.php <!-- The password reset controller. --> 
app/Http/Controllers/Auth/ResetPasswordController.php <!-- The password confirmation controller. --> 
```

##

**1iii**
```html
You need to migrate the database after this.
But I will suggest you set the Product table migration-
'create_product_table' first before running the migration.
```

## 

**1iv**
```html
You can customize the authentication views to match your application's branding and requirements.
But in this CRUD, configure the authentication by using the HomeController as your index.
By this, only the logged in user can perform the CRUD operation.
```

##

##

## 2. Configuring the CRUD CSS with Bootstrap CDN links in the app.blade.php file
```html
Go to the Bootstrap website https://www.getbootstrap.com, and copy the web link in the CSS CND link like this:
https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css
Open a New Tab in your browser and paste the link in the url and hit Enter.
Ctr + A and Ctr + C to highlight and copy all the code in the browser.
Go to your Laravel application (not the app folder) and open the 'Public/css' folder, create a new css file name it 'bootstrap.min.css'
Or any name of your choice, and paste the code you copied from your browser.
Do the same process with the 'js' folder but copy the JS CDN like this: https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js let the js file name be 'bootstrap.bundle.min.js'
Or any name you want and paste the copied js code from your browser.

Go to the 'resources/view/layouts/app.blade.php' and link the Bootstrap CSS and JS links like this:

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">

    <!-- Bootstrap JS -->
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

    OR

    Just copy the CSS and JS CND links and paste them to the app.blade.php head section like this:

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>

    But you have the benefit to use the links still if your computer is off from the internet if you use the first method above.
```
##

##

## 3. Migration
```php 
public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->longText('description');
            $table->integer('price');
            $table->timestamps();
        });
    }
```
##

##

## 4. Model
```php
protected $table = 'products';

    protected $fillable = [
        'name',
        'description',
        'price',
    ];
```
##

##

## .5 Routes
```php
<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;


Auth::routes();

// Index route
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


// // Use the ProductController for handling product-related routes
Route::middleware(['auth'])->group(function () {

    // Route for creating a new product
    Route::get('create', [ProductController::class, 'create'])->name('product.create');
    
    // Route for creating a new product
    Route::post('store', [ProductController::class, 'store'])->name('product.store');
    
    // Route for displaying a specific product
    Route::get('read/{id}', [ProductController::class, 'read'])->name('product.read');

    // Route for updating an existing product
    Route::get('update/{id}/edit', [ProductController::class, 'edit'])->name('product.edit');

    // Route for updating an existing product
    Route::put('update/{id}', [ProductController::class, 'update'])->name('product.update');

    // Route for deleting a product
    Route::delete('delete/{id}', [ProductController::class, 'delete'])->name('product.delete');

});
```
##

##

## 6. HomeController
**Remenber to imort the Product model**
```php
public function index()
    {
        // Fetch all products from the database
        $products = Product::all();

        // return view('index');
        return view('product.index', compact('products'));
    }
```
##

##

## 7. ProductController
**Remenber to imort the Product model**
```php
public function create() {
        return view('product.create');
    }
    // View a product by its ID
    public function read($id)
    {
        // Find a product by its ID
        $product = Product::find($id);

        if (!$product) {

            // Return the selected product
            return response()->with('message_error', 'Something Went Wrong!', 404);

        }
        // Return a JSON response with a 404 error message
        return view('product.read', compact('product'));
        
    }

    // Store a new product
    public function store(Request $request)
    {
        // Validate the incoming data
        $validatedData = $request->validate([
            'name' => 'required|max:191',
            'description' => 'required|max:191',
            'price' => 'required|numeric',
        ]);

        // Create a new Product instance with the validated data
        $product = new Product([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'price' => $validatedData['price'],
        ]);

        // Save the product to the database
        $product->save();

        return redirect('/')->with('message', 'Product Added Successfully.', 200);
    }

    // Open Product edit form
    public function edit($id) {
        // Find the product by its ID
        $product = Product::find($id);

        return view('product.update', compact('product'));
    }

    // Update an existing product
    public function update(Request $request, $id)
    {
        // Validate the incoming data
        $validatedData = $request->validate([
            'name' => 'required|max:191',
            'description' => 'required|max:191',
            'price' => 'required|numeric',
        ]);

        // Find the product by its ID
        $product = Product::find($id);

        if (!$product) {
            // Return a JSON response with a 404 error message
            return redirect('/')->with('message_error', 'Something Went Wrong!', 404);
        }

        // Update the product attributes
        $product->update([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'price' => $validatedData['price'],
        ]);

        // Return a JSON response indicating success
        return redirect('/')->with('message', 'Product Updated Successfully', 200);
    }

    // Delete a product
    public function delete($id)
    {

        // // Find the product by its ID
        $product = Product::find($id);

        // 
        if (!$product) {
            return response()->with('message_error', 'Something Went Wrong!', 404);
        }

        // Delete the product
        $product->delete();

        return redirect('/')->with('message', 'Product Deleted Successfully', 200);

    }
```
##

##

## 9. The views:
##

## 9i App
**resources/views/layouts/app.blade.php**
```php
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">

    <!-- Bootstrap JS -->
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

    {{-- Fontawesome CDN --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    {{-- Bootstrap js --}}
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
```
##

##

## 9ii. Index
**resources/views/product/index.blade.php**
```php
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
                <a class="btn btn-sm btn-primary float-end" href="create">Add Product</a>
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

```
##

##

## 9iii. Create Product
**resources/views/product/create.blade.php**
```php
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Create Product') }}</div>

                <div class="card-body">
                    {{-- THIS IS OPTIONAL --}}
                    {{-- Display validation errors if any --}}
                    {{-- @if ($errors->any())
                    <div class="alert alert-warning">
                        @foreach ($errors->all() as $error)
                            <div>{{$error}}</div>
                        @endforeach
                    </div>
                    @endif --}}
                    <form action="{{ url('store') }}" method="POST" >
                        @csrf

                        <div class="form-group mb-3">
                            <label for="name">{{ __('Name') }}</label>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}"  autocomplete="name">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="description">{{ __('Description') }}</label>
                            <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" >{{ old('description') }}</textarea>
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="price">{{ __('Price') }}</label>
                            <input id="price" type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" name="price" value="{{ old('price') }}" >
                            @error('price')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <button type="submit" class="btn btn-sm btn-primary">
                                {{ __('Create Product') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

```
##

##

## 9v. Read Product
**resources/views/product/read.blade.php**
```php
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

```
##

##

## 9vi. Update Product
**resources/views/product/update.blade.php**
```php
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Update Product') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ url('update/'.$product->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="form-group mb-3">
                            <label for="name">{{ __('Name') }}</label>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $product->name) }}" required autocomplete="name" autofocus>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="description">{{ __('Description') }}</label>
                            <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" required>{{ old('description', $product->description) }}</textarea>
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="price">{{ __('Price') }}</label>
                            <input id="price" type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" name="price" value="{{ old('price', $product->price) }}" required>
                            @error('price')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Update Product') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
```
##

##

## 9vii. The Delete button is on the index
**The index consists of read, update, and delete buttons. It also displays all the products in a default**

##

##

## 9viii. The Bootstrap Modal for Delete confirmation
**resources/views/product/modal.blade.php**
```php
<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-dark">
            <div class="modal-header">
                <button type="button" class="btn-close bg-secondary" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h5 class="mt-4 text-white">Are you sure you want to delete this Product?</h5>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-primary" data-bs-dismiss="modal">Cancel</button>

                <form method="POST" action="{{ url('delete/'.$product->id) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
```

## THE END.

## Thanks for Viewing. 🙂
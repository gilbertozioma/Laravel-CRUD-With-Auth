<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{

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

        return redirect('/')->with('message', 'Product Added Successfull.', 200);
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
            return response()->with('message_error', 'Somthing Went Wrong!', 404);
        }

        // Delete the product
        $product->delete();

        return redirect('/')->with('message', 'Product Deleted Successfully', 200);

    }

}

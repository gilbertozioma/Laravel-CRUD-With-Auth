<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_list_products()
    {
        // Create some dummy products
        Product::factory(3)->create();

        // Send a GET request to the index endpoint
        $response = $this->get(route('products.index'));

        // Assert that the response has a successful status code
        $response->assertStatus(200);

        // Assert that the response contains the correct number of products
        $response->assertJsonCount(3);

        // Additional assertions can be added to check the structure of the JSON response
    }

    /** @test */
    public function it_can_show_a_single_product()
    {
        // Create a dummy product
        $product = Product::factory()->create();

        // Send a GET request to the read endpoint with the product's ID
        $response = $this->get(route('products.read', ['id' => $product->id]));

        // Assert that the response has a successful status code
        $response->assertStatus(200);

        // Additional assertions can be added to check the content of the JSON response
    }

    /** @test */
    public function it_can_create_a_product()
    {
        // Prepare data for creating a product
        $productData = [
            'name' => 'Sample Product',
            'description' => 'This is a sample product.',
            'price' => 2000,
        ];

        // Send a POST request to the create endpoint with product data
        $response = $this->post(route('products.create'), $productData);

        // Assert that the response has a successful status code
        $response->assertStatus(200);

        // Additional assertions can be added to check the response message or data
    }

    /** @test */
    public function it_can_update_a_product()
    {
        // Create a dummy product
        $product = Product::factory()->create();

        // Prepare data for updating the product
        $updatedData = [
            'name' => 'Updated Product',
            'description' => 'This product has been updated.',
            'price' => 400,
        ];

        // Send a PUT request to the update endpoint with updated data
        $response = $this->put(route('products.update', ['id' => $product->id]), $updatedData);

        // Assert that the response has a successful status code
        $response->assertStatus(200);

        // Additional assertions can be added to check the response message or data
    }

    /** @test */
    public function it_can_delete_a_product()
    {
        // Create a dummy product
        $product = Product::factory()->create();

        // Send a DELETE request to the delete endpoint with the product's ID
        $response = $this->delete(route('products.delete', ['id' => $product->id]));

        // Assert that the response has a successful status code
        $response->assertStatus(200);

        // Additional assertions can be added to check the response message
    }

    // You can add more test cases or edge cases as needed
}

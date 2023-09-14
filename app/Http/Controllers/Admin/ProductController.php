<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Api\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function getAllProducts()
    {
        $products = $this->productService->getAllProducts();
        return response()->json(['data' => $products]);
    }

    public function store(Request $request)
    {
        $rules = [
            'product_name' => 'required|unique:products',
            'quantity' => 'required',
            'price' => 'required',
            'short_desc' => 'required',
            'desc' => 'required',
            'product_img' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $category_id = $request->input('category_id');

        $data = [
            'product_name' => $request->input('product_name'),
            'category_id' => $request->input('category_id'),
            'short_desc' => $request->input('short_desc'),
            'desc' => $request->input('desc'),
            'color' => $request->input('color'),
            'size' => $request->input('size'),
            'product_img' => $request->file('product_img'),
            'category_name' => $this->productService->getCategoryName($category_id),
            'price' => $request->input('price'),
            'quantity' => $request->input('quantity'),
        ];


        $product = $this->productService->createProduct($data);

        if ($product) {
            return response()->json(['message' => 'Product updated successfully']);
        } else {
            return response()->json(['message' => 'Failed to create product']);
        }

    }

    public function destroy($id)
    {
        $product = $this->productService->getProductById($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $this->productService->deleteProduct($product);

        return response()->json(['message' => 'Product deleted successfully']);
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'product_name' => 'required|unique:products',
            'quantity' => 'required',
            'price' => 'required',
            'short_desc' => 'required',
            'desc' => 'required',
            'product_img' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $product = $this->productService->getProductById($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $category_id = $request->input('category_id');

        $data = [
            'product_name' => $request->input('product_name'),
            'short_desc' => $request->input('short_desc'),
            'desc' => $request->input('desc'),
            'color' => $request->input('color'),
            'size' => $request->input('size'),
            'product_img' => $request->file('product_img'),
            'price' => $request->input('price'),
            'quantity' => $request->input('quantity'),
        ];

        $updatedProduct = $this->productService->updateProduct($product, $data);

        if ($updatedProduct) {
            return response()->json(['message' => 'Product updated successfully']);
        } else {
            return response()->json(['message' => 'Product update failed']);
        }
    }

    public function deleteSelectedProducts($ids)
    {
        $productIds = explode(",", $ids);

        if (empty($productIds)) {
            return response()->json(['message' => 'No products selected'], 400);
        }

        $this->productService->deleteSelectedProducts($productIds);

        return response()->json(['message' => 'Selected products deleted successfully']);
    }
}
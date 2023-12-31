<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Api\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    protected ProductService $productService;

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

        $data = $request->only([
            'product_name',
            'category_id',
            'short_desc',
            'desc',
            'color',
            'size',
            'price',
            'quantity'
        ]);

        $data['product_img'] = $request->file('product_img');
        $data['category_name'] = $this->productService->getCategoryName($request->input('category_id'));

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
            'product_name' => 'required',
            'quantity' => 'required',
            'price' => 'required',
            'short_desc' => 'required',
            'desc' => 'required',
        ];

        if ($request->hasFile('product_img')) {
            $rules['product_img'] = 'image|mimes:jpeg,png,jpg,gif,svg|max:2048';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $product = $this->productService->getProductById($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $category_id = $request->input('category_id');

        $data = $request->only([
            'product_name',
            'short_desc',
            'desc',
            'color',
            'size',
            'price',
            'quantity'
        ]);


        if ($request->hasFile('product_img')) {
            $data['product_img'] = $request->file('product_img');
        }

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
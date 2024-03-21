<?php

namespace App\Http\Controllers;

use App\Models\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProductServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->can('manage product')) {
            $products = ProductService::get();

            return view('product.index', compact('products'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::user()->can('create product')) {
            return view('product.create');
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (Auth::user()->can('create product')) {
            $validatorArray = [
                'name' => 'required|max:120',
                'SKU' => 'required',
                'product_type' => 'required',
                'unit_price' => 'required',
                'unit_cost' => 'required',
            ];
            $validator = Validator::make(
                $request->all(),
                $validatorArray
            );
            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors()->first());
            }

            $productService = new ProductService();
            $productService->name = $request->name;
            $productService->SKU = $request->SKU;
            $productService->product_type = $request->product_type;
            $productService->unit_price = $request->unit_price;
            $productService->unit_cost = $request->unit_cost;
            $productService->description = $request->description ?? '';
            $image = $request->file('image');

            if ($image != null) {
                if ($request->hasFile('image')) {
                    $upload_image = UploadImageFolder('product_service', $image);
                    $productService['image'] = $upload_image;
                }
            }

            $productService->save();

            return redirect()->back()->with('success', __('Product Service create successfully!'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductService $productService)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if (Auth::user()->can('edit product')) {
            $productService = ProductService::find($id);
            return view('product.edit',compact('productService'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        if (Auth::user()->can('edit product')) {
            $validatorArray = [
                'name' => 'required|max:120',
                'SKU' => 'required',
                'product_type' => 'required',
                'unit_price' => 'required',
                'unit_cost' => 'required',
            ];
            $validator = Validator::make(
                $request->all(),
                $validatorArray
            );
            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors()->first());
            }

            $productService = ProductService::find($id);
            $productService->name = $request->name;
            $productService->SKU = $request->SKU;
            $productService->product_type = $request->product_type;
            $productService->unit_price = $request->unit_price;
            $productService->unit_cost = $request->unit_cost;
            $productService->description = $request->description ?? '';
            $image = $request->file('image');

            if ($image != null) {
                if ($request->hasFile('image')) {
                    $upload_image = UploadImageFolder('product_service', $image);
                    $productService['image'] = $upload_image;
                }
            }

            $productService->save();

            return redirect()->back()->with('success', __('Product Service update successfully!'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if(Auth::user()->can('delete product')) {
            ProductService::find($id)->delete();
            return redirect()->route('products.index')
                ->with('success', 'Product Service deleted successfully');
        } else {
            return redirect()->back()->with('error', 'Permission denied.');
        }
    }
}

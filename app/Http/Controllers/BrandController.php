<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBrandRequest;
use App\Http\Requests\UpdateBrandRequest;
use App\Models\Brand;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $brands = Brand::all();
        $brands = Brand::with(['cars' => function ($q) {
            $q->where('colors', '==', 'black');
        }])->get();
        return response()->json([
            'status' => 'success',
            'brand'  =>  $brands
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBrandRequest $request)
    {
        try {
            DB::beginTransaction();

            $brand = Brand::create([
                // 'name' => $request->name,
                'country' => $request->country,
            ]);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'brand'  =>  $brand
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();

            Log::error($th);
            return response()->json([
                'status' => 'error'
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Brand $brand)
    {
        return response()->json([
            'status' => 'success',
            'brand'  =>  $brand
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBrandRequest $request, Brand $brand)
    {
        $newData = [];
        if (isset($request->name)) {
            $newData['name'] = $request->name;
        }

        if (isset($request->country)) {
            $newData['country'] = $request->country;
        }

        $brand->update($newData);

        return response()->json([
            'status' => 'success',
            'brand'  =>  $brand
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
        $brand->delete();
        return response()->json([
            'status' => 'success',
            'brand'  =>  $brand
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCarRequest;
use App\Http\Requests\UpdateCarRequest;
use App\Models\Car;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cars = Car::all();
        return response()->json([
            'status' => 'success',
            'car'    => $cars
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCarRequest $request)
    {
        try {
            DB::beginTransaction();

            $car = Car::create([
                'model'     => $request->model,
                'price'     => $request->price,
                'colors'    => $request->colors,
                'gear_type' => $request->gear_type,
                'year'      => $request->year,
            ]);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'car'    =>  $car
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
    public function show(Car $car)
    {
        return response()->json([
            'status' => 'success',
            'car'    =>  $car
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCarRequest $request, Car $car)
    {
        $newData = [];
        if (isset($request->price)) {
            $newData['price'] = $request->price;
        }

        if (isset($request->gear_type)) {
            $newData['gear_type'] = $request->gear_type;
        }

        if (isset($request->colors)) {
            $newData['colors'] = $request->colors;
        }

        $car->update($newData);

        return response()->json([
            'status' => 'success',
            'car'    =>  $car
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Car $car)
    {
        $car->delete();
        return response()->json([
            'status' => 'success',
            'car'    =>  $car
        ]);
    }
}

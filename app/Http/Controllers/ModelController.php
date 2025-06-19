<?php

namespace App\Http\Controllers;

use App\Models\DeviceModel;
use App\Models\Brand;
use Illuminate\Http\Request;

class ModelController extends Controller
{
    public function index()
    {
         $models = DeviceModel::with(['brand', 'items'])->paginate(10);
        return view('modal.index', compact('models'));
    }

    public function create()
    {
        $brands = Brand::all();
        return view('modal.create', compact('brands'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'brand_id' => 'required|exists:brands,id',
        ]);

        DeviceModel::create($request->only('name', 'brand_id'));

        return redirect()->route('modal.index')->with('success', 'Model added successfully.');
    }

    public function edit(DeviceModel $model)
    {
        $brands = Brand::all();
        return view('modal.edit', compact('model', 'brands'));
    }

    public function update(Request $request, DeviceModel $model)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'brand_id' => 'required|exists:brands,id',
        ]);

        $model->update($request->only('name', 'brand_id'));

        return redirect()->route('modal.index')->with('success', 'Model updated successfully.');
    }

    public function destroy(DeviceModel $model)
    {
        $model->delete();
        return redirect()->route('modal.index')->with('success', 'Model deleted successfully.');
    }
}

<?php
namespace App\Http\Controllers;
use App\Models\Brand;
use Illuminate\Http\Request;
use App\Models\DeviceModel;
use App\Models\Item;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::withCount(['items', 'models'])->paginate(10);
        return view('brands.index', compact('brands'));
    }

    public function create()
    {
        return view('brands.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        Brand::create($request->only('name'));
        return redirect()->route('brands.index')->with('success', 'Brand added successfully.');
    }

    public function edit(Brand $brand)
    {
        return view('brands.edit', compact('brand'));
    }

    public function update(Request $request, Brand $brand)
    {
        $request->validate(['name' => 'required|string|max:255']);
        $brand->update($request->only('name'));
        return redirect()->route('brands.index')->with('success', 'Brand updated successfully.');
    }

    public function destroy(Brand $brand)
    {
        $brand->items()->delete();
        $brand->models()->delete();
        $brand->delete();

        return redirect()->route('brands.index')->with('success', 'Brand and related records deleted.');
    }
}
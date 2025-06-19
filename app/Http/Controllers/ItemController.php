<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Brand;
use App\Models\DeviceModel;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewItemAdded;

class ItemController extends Controller
{
    // Show paginated list of items
    public function index()
    {
        $items = Item::with('brand', 'model')->latest()->paginate(10);
        $brands = Brand::all();
        return view('items.index', compact('items', 'brands'));
    }

    // Show the create item form
    public function create()
    {
        $brands = Brand::all();
        return view('items.create', compact('brands'));
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'amount' => 'required|numeric',
        'brand_id' => 'required|exists:brands,id',
        'device_model_id' => 'nullable|exists:device_models,id',
        'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
    ]);

    // Handle image upload
    if ($request->hasFile('image')) {
        $filename = time() . '_' . uniqid() . '.' . $request->image->extension();
        $request->image->move(public_path('uploads/items'), $filename);
        $validated['image'] = $filename;
    }

    // Create and load relationships
    $item = Item::create($validated);
    $item->load('brand', 'model'); 

    // Send email
    Mail::to('umairadd@gmail.com')->send(new NewItemAdded($item));

    return redirect()->route('items.index')->with('success', 'Item added successfully!');
}

    // Show the edit item form
    public function edit($id)
    {
        $item = Item::findOrFail($id);
        $brands = Brand::all();
        $models = DeviceModel::where('brand_id', $item->brand_id)->get();

        return view('items.edit', compact('item', 'brands', 'models'));
    }

    // Handle updating the item
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'brand_id' => 'required|exists:brands,id',
            'device_model_id' => 'nullable|exists:device_models,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $item = Item::findOrFail($id);

        // If new image uploaded, replace old one
        if ($request->hasFile('image')) {
            $filename = time() . '_' . uniqid() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads/items'), $filename);
            $validated['image'] = $filename;
        }

        $item->update($validated);

        return redirect()->route('items.index')->with('success', 'Item updated successfully!');
    }

    // Handle deleting the item via AJAX
    public function destroy($id)
    {
        $item = Item::findOrFail($id);

        // Optionally: delete image file from server
        if ($item->image && file_exists(public_path('uploads/items/' . $item->image))) {
            unlink(public_path('uploads/items/' . $item->image));
        }

        $item->delete();

        return response()->json(['success' => true]);
    }
}

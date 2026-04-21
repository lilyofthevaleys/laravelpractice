<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $query = Item::query();
        if ($request->filled('category') && in_array($request->query('category'), Item::CATEGORIES, true)) {
            $query->where('category', $request->query('category'));
        }
        $items = $query->orderBy('category')->orderBy('name')->paginate(20)->withQueryString();

        return view('admin.items.index', [
            'items'           => $items,
            'activeCategory'  => $request->query('category'),
            'categoryLabels'  => Item::CATEGORY_LABELS,
        ]);
    }

    public function create()
    {
        return view('admin.items.form', ['item' => new Item()]);
    }

    public function store(Request $request)
    {
        $data = $this->validateItem($request);

        if ($request->hasFile('image')) {
            $data['image_path'] = $this->uploadImage($request->file('image'));
        }

        $data['is_best_seller'] = $request->boolean('is_best_seller');

        Item::create($data);

        return redirect()->route('admin.items.index')
            ->with('success', "{$data['name']} was added to the shop.");
    }

    public function edit(Item $item)
    {
        return view('admin.items.form', compact('item'));
    }

    public function update(Request $request, Item $item)
    {
        $data = $this->validateItem($request);

        if ($request->hasFile('image')) {
            if ($item->image_path && !str_starts_with($item->image_path, 'http') && file_exists(public_path($item->image_path))) {
                @unlink(public_path($item->image_path));
            }
            $data['image_path'] = $this->uploadImage($request->file('image'));
        }

        $data['is_best_seller'] = $request->boolean('is_best_seller');

        $item->update($data);

        return redirect()->route('admin.items.index')
            ->with('success', "{$item->name} has been updated.");
    }

    public function toggleBestSeller(Item $item)
    {
        $item->update(['is_best_seller' => ! $item->is_best_seller]);

        return back()->with('success', $item->is_best_seller
            ? "{$item->name} is now a Best Seller."
            : "{$item->name} removed from Best Sellers.");
    }

    public function destroy(Item $item)
    {
        if ($item->image_path && !str_starts_with($item->image_path, 'http') && file_exists(public_path($item->image_path))) {
            @unlink(public_path($item->image_path));
        }

        $name = $item->name;
        $item->delete();

        return redirect()->route('admin.items.index')
            ->with('success', "{$name} was removed from the shop.");
    }

    private function validateItem(Request $request): array
    {
        return $request->validate([
            'name'     => 'required|string|max:100',
            'category' => 'required|string|in:' . implode(',', Item::CATEGORIES),
            'price'    => 'required|numeric|min:0',
            'stock'    => 'required|integer|min:0',
            'details'  => 'nullable|string|max:1000',
            'image'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'name.required'     => 'The item needs a name.',
            'category.required' => 'Pick a category.',
            'category.in'       => 'Category must be one of: Poké Ball, Berry, Medicine, General.',
            'price.required'    => 'Set a price in Rupiah.',
            'image.image'       => 'Upload an image file.',
            'image.max'         => 'Image must be 2MB or smaller.',
        ]);
    }

    private function uploadImage($file): string
    {
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('item_image'), $filename);
        return 'item_image/' . $filename;
    }
}

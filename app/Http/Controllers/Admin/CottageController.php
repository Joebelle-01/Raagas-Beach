<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cottage;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CottageController extends Controller
{
    use LogsActivity;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Cottage::with(['images', 'inclusions'])->latest();

        if ($request->has('status') && $request->status != '') {
            if ($request->status === 'archived') {
                $query = Cottage::onlyTrashed()->with(['images', 'inclusions'])->latest();
            } else {
                $query->where('status', $request->status);
            }
        }

        $cottages = $query->paginate(10);
        return view('admin.cottages.index', compact('cottages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.cottages.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'capacity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:available,booked,maintenance',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $cottage = Cottage::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'capacity' => $request->capacity,
            'price' => $request->price,
            'status' => $request->status,
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('cottages', 'public');
                $cottage->images()->create(['image_path' => $path]);
            }
        }

        $this->logActivity('Cottage Created', "Created new cottage: {$request->name}");

        return redirect()->route('admin.cottages.index')->with('success', 'Cottage created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $cottage = Cottage::withTrashed()->findOrFail($id);
        return view('admin.cottages.show', compact('cottage'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $cottage = Cottage::withTrashed()->findOrFail($id);
        $archivedImages = \App\Models\CottageImage::onlyTrashed()
            ->where('cottage_id', $cottage->id)
            ->latest()
            ->get();

        return view('admin.cottages.edit', compact('cottage', 'archivedImages'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $cottage = Cottage::withTrashed()->findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'capacity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:available,booked,maintenance',
        ]);

        $cottage->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'capacity' => $request->capacity,
            'price' => $request->price,
            'status' => $request->status,
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('cottages', 'public');
                $cottage->images()->create(['image_path' => $path]);
            }
        }

        $this->logActivity('Cottage Updated', "Updated cottage details: {$request->name}");

        return redirect()->route('admin.cottages.index')->with('success', 'Cottage updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $cottage = Cottage::findOrFail($id);
        $name = $cottage->name;
        $cottage->delete();

        $this->logActivity('Cottage Deleted', "Deleted cottage: {$name}");

        return redirect()->route('admin.cottages.index')->with('success', 'Cottage deleted successfully.');
    }

    /**
     * Restore a soft-deleted cottage.
     */
    public function restore($id)
    {
        $cottage = Cottage::onlyTrashed()->findOrFail($id);
        $cottage->restore();

        $this->logActivity('Cottage Restored', "Restored cottage: {$cottage->name}");

        return redirect()->route('admin.cottages.index')->with('success', 'Cottage restored successfully.');
    }

    /**
     * Permanently delete a cottage and its inclusions/images.
     */
    public function forceDelete($id)
    {
        $cottage = Cottage::onlyTrashed()->findOrFail($id);
        $name = $cottage->name;

        // Delete associated inclusions
        $cottage->inclusions()->delete();

        // Permanently delete associated images and files
        foreach ($cottage->images()->withTrashed()->get() as $image) {
            if ($image->image_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($image->image_path)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($image->image_path);
            }
            $image->forceDelete();
        }

        $cottage->forceDelete();

        $this->logActivity('Cottage Purged', "Permanently deleted cottage: {$name}");

        return redirect()->route('admin.cottages.index')->with('success', 'Cottage permanently deleted.');
    }

    /**
     * Archive (soft delete) a cottage image.
     */
    public function archiveImage(\App\Models\CottageImage $image)
    {
        $cottage = Cottage::find($image->cottage_id);
        $image->delete();

        $this->logActivity('Cottage Photo Archived', "Archived a photo from cottage: {$cottage->name}");

        return redirect()->back()->with('success', 'Photo archived successfully.');
    }

    /**
     * Restore a soft-deleted cottage image.
     */
    public function restoreImage($imageId)
    {
        $image = \App\Models\CottageImage::onlyTrashed()->findOrFail($imageId);
        $cottage = Cottage::find($image->cottage_id);
        $image->restore();

        $this->logActivity('Cottage Photo Restored', "Restored an archived photo for cottage: {$cottage->name}");

        return redirect()->back()->with('success', 'Photo restored successfully.');
    }

    /**
     * Permanently delete (purge) a cottage image and remove its file from storage.
     */
    public function purgeImage($imageId)
    {
        $image = \App\Models\CottageImage::onlyTrashed()->findOrFail($imageId);
        $cottage = Cottage::find($image->cottage_id);

        // Delete physical file if it exists
        if ($image->image_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($image->image_path)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($image->image_path);
        }

        $image->forceDelete();

        $this->logActivity('Cottage Photo Purged', "Permanently deleted an archived photo for cottage: {$cottage->name}");

        return redirect()->back()->with('success', 'Photo permanently deleted.');
    }
}

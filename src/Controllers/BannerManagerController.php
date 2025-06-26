<?php

namespace admin\banners\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use admin\banners\Requests\BannerCreateRequest;
use admin\banners\Requests\BannerUpdateRequest;
use admin\banners\Models\Banner;

class BannerManagerController extends Controller
{
    public function index(Request $request)
    {
        try {
            $banners = Banner::
                filter($request->query('keyword'))
                ->latest()
                ->paginate(5)
                ->withQueryString();

            return view('banner::admin.index', compact('banners'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to load banners: ' . $e->getMessage());
        }
    }

    public function create()
    {
        try {
            return view('banner::admin.createOrEdit');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to load banners: ' . $e->getMessage());
        }
    }

    public function store(BannerCreateRequest $request)
    {
        try {
            $requestData = $request->validated();

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('banners', $imageName, 'public');
                $requestData['image'] = $imagePath;
            }

            $banner = Banner::create($requestData);
            return redirect()->route('admin.banners.index')->with('success', 'Banner created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to create banner: ' . $e->getMessage());
        }
    }

    /**
     * show banner details
     */
    public function show(Banner $banner)
    {
        try {
            return view('banner::admin.show', compact('banner'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to load banners: ' . $e->getMessage());
        }
    }

    public function edit(Banner $banner)
    {
        try {
            return view('banner::admin.createOrEdit', compact('banner'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to load banner for editing: ' . $e->getMessage());
        }
    }

    public function update(BannerUpdateRequest $request, Banner $banner)
    {
        try {
            $requestData = $request->validated();

            if ($request->hasFile('image')) {
                // Optionally, delete the old image file here if needed
                $image = $request->file('image');
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('banners', $imageName, 'public');
                $requestData['image'] = $imagePath;
            }

            $banner->update($requestData);
            return redirect()->route('admin.banners.index')->with('success', 'Banner updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update banner: ' . $e->getMessage());
        }
    }

    public function destroy(Banner $banner)
    {
        try {
            // Delete the image file if it exists
            if ($banner->image && \Storage::disk('public')->exists($banner->image)) {
                \Storage::disk('public')->delete($banner->image);
            }

            $banner->delete();
            return response()->json(['success' => true, 'message' => 'Record deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to delete record.', 'error' => $e->getMessage()], 500);
        }
    }
}


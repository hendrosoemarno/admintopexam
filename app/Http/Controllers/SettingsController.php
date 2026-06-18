<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Package;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key');

        $packages = Package::latest()->get();
        $coupons = Coupon::latest()->get();

        return view('settings.index', compact('settings', 'packages', 'coupons'));
    }

    public function storePackage(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'min_students' => 'required|integer|min:1',
            'course_id' => 'required|integer|min:1',
            'course_name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $validated['is_active'] = $request->has('is_active');

        Package::create($validated);

        return redirect()->route('settings.index')->with('success', 'Paket berhasil ditambahkan.');
    }

    public function updatePackage(Request $request)
    {
        $request->validate([
            'package_id' => 'required|exists:packages,id',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'min_students' => 'required|integer|min:1',
            'course_id' => 'required|integer|min:1',
            'course_name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $package = Package::findOrFail($request->package_id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'min_students' => 'required|integer|min:1',
            'course_id' => 'required|integer|min:1',
            'course_name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $package->update($validated);

        return redirect()->route('settings.index')->with('success', 'Paket berhasil diperbarui.');
    }

    public function destroyPackage(Request $request)
    {
        $request->validate([
            'package_id' => 'required|exists:packages,id',
        ]);

        $package = Package::findOrFail($request->package_id);
        $package->delete();

        return redirect()->route('settings.index')->with('success', 'Paket berhasil dihapus.');
    }

    public function storeCoupon(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:coupons,code',
            'discount_type' => 'required|in:fixed,percentage',
            'discount_value' => 'required|numeric|min:0',
            'max_uses' => 'nullable|integer|min:1',
            'expires_at' => 'nullable|date',
        ]);

        $validated['is_active'] = $request->has('is_active');

        Coupon::create($validated);

        return redirect()->route('settings.index')->with('success', 'Kupon berhasil ditambahkan.');
    }

    public function updateCoupon(Request $request)
    {
        $request->validate([
            'coupon_id' => 'required|exists:coupons,id',
            'code' => 'required|string|max:50',
            'discount_type' => 'required|in:fixed,percentage',
            'discount_value' => 'required|numeric|min:0',
            'max_uses' => 'nullable|integer|min:1',
            'expires_at' => 'nullable|date',
        ]);

        $coupon = Coupon::findOrFail($request->coupon_id);

        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:coupons,code,' . $coupon->id,
            'discount_type' => 'required|in:fixed,percentage',
            'discount_value' => 'required|numeric|min:0',
            'max_uses' => 'nullable|integer|min:1',
            'expires_at' => 'nullable|date',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $coupon->update($validated);

        return redirect()->route('settings.index')->with('success', 'Kupon berhasil diperbarui.');
    }

    public function destroyCoupon(Request $request)
    {
        $request->validate([
            'coupon_id' => 'required|exists:coupons,id',
        ]);

        $coupon = Coupon::findOrFail($request->coupon_id);
        $coupon->delete();

        return redirect()->route('settings.index')->with('success', 'Kupon berhasil dihapus.');
    }

    public function saveSettings(Request $request)
    {
        $request->validate([
            'duitku_merchant_code' => 'nullable|string',
            'duitku_api_key' => 'nullable|string',
            'duitku_sandbox' => 'nullable|string',
            'moodle_api_url' => 'nullable|string',
            'moodle_api_token' => 'nullable|string',
        ]);

        $keys = ['duitku_merchant_code', 'duitku_api_key', 'duitku_sandbox', 'moodle_api_url', 'moodle_api_token'];

        foreach ($keys as $key) {
            Setting::setValue($key, $request->input($key, ''));
        }

        return redirect()->route('settings.index')->with('success', 'Pengaturan berhasil disimpan.');
    }
}

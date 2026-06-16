<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Package;
use App\Models\Transaction;
use App\Services\DuitkuService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RegistrationController extends Controller
{
    public function showForm($packageId)
    {
        $package = Package::findOrFail($packageId);

        if (!$package->is_active) {
            return redirect()->route('packages.index')->with('error', 'Paket tidak tersedia.');
        }

        return view('auth.register', compact('package'));
    }

    public function submit(Request $request, DuitkuService $duitku)
    {
        $validated = $request->validate([
            'package_id' => 'required|exists:packages,id,is_active,1',
            'username' => 'required|string|min:3|max:100',
            'password' => 'required|string|min:6',
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email',
            'coupon_code' => 'nullable|string|max:50',
        ]);

        $package = Package::findOrFail($validated['package_id']);
        $amount = (float) $package->price;
        $discountAmount = 0;
        $coupon = null;

        if (!empty($validated['coupon_code'])) {
            $coupon = Coupon::where('code', $validated['coupon_code'])->first();

            if (!$coupon || !$coupon->isValid()) {
                return back()->withInput()->withErrors(['coupon_code' => 'Kupon tidak valid atau sudah habis.']);
            }

            $discountAmount = $coupon->calculateDiscount($amount);
        }

        $totalAmount = $amount - $discountAmount;

        $invoiceNumber = 'INV-' . strtoupper(Str::random(8)) . '-' . time();

        $transaction = Transaction::create([
            'package_id' => $package->id,
            'coupon_id' => $coupon?->id,
            'username' => $validated['username'],
            'password' => $validated['password'],
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'invoice_number' => $invoiceNumber,
            'amount' => $amount,
            'discount_amount' => $discountAmount,
            'total_amount' => $totalAmount,
            'status' => 'pending',
        ]);

        if ($coupon) {
            $coupon->increment('used_count');
        }

        $returnUrl = route('payment.finish', ['invoice' => $invoiceNumber]);
        $callbackUrl = route('payment.callback');

        $result = $duitku->createInvoice($transaction, $returnUrl, $callbackUrl);

        if (!$result['success']) {
            return back()->with('error', 'Gagal membuat pembayaran: ' . ($result['error'] ?? 'Unknown error'));
        }

        return redirect($result['paymentUrl']);
    }
}

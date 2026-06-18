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

        $duitku = app(DuitkuService::class);
        $paymentMethods = $duitku->getPaymentMethods((int) $package->price);

        return view('auth.register', compact('package', 'paymentMethods'));
    }

    public function showGroupForm($packageId)
    {
        $package = Package::findOrFail($packageId);

        if (!$package->is_active) {
            return redirect()->route('packages.index')->with('error', 'Paket tidak tersedia.');
        }

        if ($package->max_students <= 1) {
            return redirect()->route('register.form', $package->id);
        }

        $duitku = app(DuitkuService::class);
        $paymentMethods = $duitku->getPaymentMethods((int) $package->price);

        return view('auth.register_group', compact('package', 'paymentMethods'));
    }

    public function submit(Request $request, DuitkuService $duitku)
    {
        $validated = $request->validate([
            'package_id' => 'required|exists:packages,id,is_active,1',
            'username' => 'required|string|min:3|max:100',
            'password' => ['required', 'string', 'min:8', 'regex:/[^\w\s]/'],
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email',
            'coupon_code' => 'nullable|string|max:50',
            'payment_method' => 'required|string|max:2',
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
            'student_count' => 1,
        ]);

        if ($coupon) {
            $coupon->increment('used_count');
        }

        $returnUrl = route('payment.finish', ['invoice' => $invoiceNumber]);
        $callbackUrl = route('payment.callback');

        try {
            $result = $duitku->createInvoice($transaction, $returnUrl, $callbackUrl, $validated['payment_method']);

            if (!$result['success']) {
                return back()->with('error', 'Gagal membuat pembayaran: ' . ($result['error'] ?? 'Unknown error'));
            }

            return redirect($result['paymentUrl']);
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function submitGroup(Request $request, DuitkuService $duitku)
    {
        $request->validate([
            'package_id' => 'required|exists:packages,id,is_active,1',
            'students' => 'required|array',
            'students.*.username' => 'required|string|min:3|max:100',
            'students.*.password' => ['required', 'string', 'min:8', 'regex:/[^\w\s]/'],
            'students.*.first_name' => 'required|string|max:100',
            'students.*.last_name' => 'required|string|max:100',
            'students.*.email' => 'required|email',
            'coupon_code' => 'nullable|string|max:50',
            'payment_method' => 'required|string|max:2',
        ]);

        $package = Package::findOrFail($request->package_id);
        $students = $request->students;

        if (count($students) > $package->max_students) {
            return back()->with('error', 'Maksimal ' . $package->max_students . ' siswa untuk paket ini.');
        }

        $amount = (float) $package->price;
        $discountAmount = 0;
        $coupon = null;

        if (!empty($request->coupon_code)) {
            $coupon = Coupon::where('code', $request->coupon_code)->first();

            if (!$coupon || !$coupon->isValid()) {
                return back()->withInput()->withErrors(['coupon_code' => 'Kupon tidak valid atau sudah habis.']);
            }

            $discountAmount = $coupon->calculateDiscount($amount);
        }

        $totalAmount = $amount - $discountAmount;
        $invoiceNumber = 'GRP-' . strtoupper(Str::random(8)) . '-' . time();

        $firstStudent = $students[0];

        $transaction = Transaction::create([
            'package_id' => $package->id,
            'coupon_id' => $coupon?->id,
            'username' => $firstStudent['username'],
            'password' => $firstStudent['password'],
            'first_name' => $firstStudent['first_name'],
            'last_name' => $firstStudent['last_name'],
            'email' => $firstStudent['email'],
            'students_data' => $students,
            'student_count' => count($students),
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

        try {
            $result = $duitku->createInvoice($transaction, $returnUrl, $callbackUrl, $request->payment_method);

            if (!$result['success']) {
                return back()->with('error', 'Gagal membuat pembayaran: ' . ($result['error'] ?? 'Unknown error'));
            }

            return redirect($result['paymentUrl']);
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Services\DuitkuService;
use App\Services\MoodleApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function callback(Request $request, DuitkuService $duitku, MoodleApiService $moodle)
    {
        Log::info('Duitku callback received', $request->all());

        $result = $duitku->handleCallback($request->all());

        if (!$result['success']) {
            return response('Bad Signature', 400);
        }

        $transaction = $result['transaction'];

        $moodleUserId = $moodle->createUser(
            $transaction->username,
            $transaction->password,
            $transaction->first_name,
            $transaction->last_name,
            $transaction->email
        );

        if (!$moodleUserId) {
            Log::error('Failed to create Moodle user for transaction: ' . $transaction->invoice_number);
            return response('Failed to create Moodle user', 500);
        }

        $transaction->update(['moodle_user_id' => $moodleUserId]);

        $enrolled = $moodle->enrolUser($transaction->package->course_id, $moodleUserId);

        if (!$enrolled) {
            Log::error('Failed to enroll Moodle user for transaction: ' . $transaction->invoice_number);
        }

        return response('OK', 200);
    }

    public function finish(Request $request)
    {
        $invoiceNumber = $request->query('invoice');
        $transaction = Transaction::where('invoice_number', $invoiceNumber)->first();

        if (!$transaction) {
            return redirect()->route('packages.index')->with('error', 'Transaksi tidak ditemukan.');
        }

        $status = $transaction->status;

        if ($status === 'paid') {
            return view('payment.success', compact('transaction'));
        }

        return view('payment.pending', compact('transaction'));
    }
}

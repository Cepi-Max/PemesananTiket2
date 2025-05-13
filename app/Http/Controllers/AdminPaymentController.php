<?php
namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class AdminPaymentController extends Controller
{
    // Menampilkan daftar pembayaran untuk admin
    public function index(Request $request)
    {
        $search = $request->get('search');
        $payments = Payment::with('pesanTiket.user')
            ->where('payment_status', 'like', '%'.$search.'%')
            ->orWhereHas('pesanTiket.user', function($query) use ($search) {
                $query->where('name', 'like', '%'.$search.'%');
            })
            ->paginate(10);

        return view('admin.payments.index', compact('payments'));
    }

    // Menampilkan detail pembayaran
    public function show($id)
    {
        $payment = Payment::findOrFail($id);
        return view('admin.payments.show', compact('payment'));
    }

    // Mengubah status pembayaran (approved/rejected)
    public function update(Request $request, Payment $payment)
    {
        $payment->payment_status = $request->input('status');
        $payment->save();

        // Update status PesanTiket berdasarkan status pembayaran
        $payment->pesanTiket->update([
            'status' => $request->input('status') == 'approved' ? 'confirmed' : 'canceled',
        ]);

        return redirect()->route('admin.payments.index')->with('success', 'Pembayaran telah diperbarui.');
    }
}

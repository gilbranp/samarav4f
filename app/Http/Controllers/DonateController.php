<?php
namespace App\Http\Controllers;

use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Donate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DonateController extends Controller
{
    public function __construct()
    {
        // Konfigurasi Midtrans
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = false; // Ganti ke true jika di production
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'donation_type' => 'required|in:uang,barang',
            'amount' => 'required_if:donation_type,uang|integer|min:1000',
            'item_name' => 'required_if:donation_type,barang|string|max:255',
            'item_qty' => 'required_if:donation_type,barang|integer|min:1',
            'expired_date' => 'nullable|date',
            'message' => 'nullable|string',
        ]);

        // Simpan data donasi ke database
        $donation = Donate::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'donation_type' => $request->donation_type,
            'amount' => $request->donation_type === 'uang' ? $request->amount : null,
            'item_name' => $request->donation_type === 'barang' ? $request->item_name : null,
            'item_qty' => $request->donation_type === 'barang' ? $request->item_qty : null,
            'expired_date' => $request->donation_type === 'barang' ? $request->expired_date : null,
            'message' => $request->message,
        ]);

        // Jika donasi berupa uang, proses pembayaran dengan Midtrans
        if ($request->donation_type === 'uang') {
            $transactionDetails = [
                'order_id' => 'DONATE-' . $donation->id,
                'gross_amount' => $donation->amount,
            ];

            $customerDetails = [
                'first_name' => $donation->name,
                'phone' => $donation->phone,
            ];

            $transactionData = [
                'transaction_details' => $transactionDetails,
                'customer_details' => $customerDetails,
            ];

            // Mendapatkan Snap token untuk pembayaran Midtrans
            try {
                $snapToken = Snap::getSnapToken($transactionData);
                return response()->json([
                    'status' => 'success',
                    'snapToken' => $snapToken,
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Gagal memproses pembayaran.',
                ], 500);
            }
        }

        // Jika donasi berupa barang, langsung simpan saja tanpa Midtrans
        return response()->json([
            'status' => 'success',
            'message' => 'Donasi barang berhasil disimpan.',
        ]);
    }

    // Fungsi callback untuk menangani status pembayaran dari Midtrans
    public function paymentCallback(Request $request)
    {
        // Ambil data dari request callback Midtrans
        $serverKey = env('MIDTRANS_SERVER_KEY');
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        if ($hashed == $request->signature_key) {
            // Lakukan pembaruan status donasi
            $donation = Donate::where('id', str_replace('DONATE-', '', $request->order_id))->first();
            if ($donation) {
                $donation->update(['status' => $request->transaction_status]);
                return response()->json(['status' => 'success']);
            }
        }

        return response()->json(['status' => 'error'], 400);
    }
}

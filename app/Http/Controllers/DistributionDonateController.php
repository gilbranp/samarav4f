<?php

namespace App\Http\Controllers;

use App\Models\DistributionDonate;
use App\Models\Donate;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Queue\Middleware\Skip;

class DistributionDonateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $donates = DistributionDonate::orderBy('created_at', 'desc')->take(5)->get();
        // Hitung total donasi uang
        $totalCashDonate = Donate::whereNotNull('amount')->sum('amount');
        // Hitung total donasi barang
        $totalItemDonate = Donate::whereNotNull('item_qty')->sum('item_qty');
        $penerima = User::where('level', 'Penerima')->get();

        return view('backend.donate.donate', compact('donates', 'totalCashDonate', 'totalItemDonate', 'penerima'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data input
        $validateData = $request->validate([
            'donation_type' => 'required',
            'amount' => 'nullable|integer',
            'item_qty' => 'nullable|integer',
            'resi_number' => 'nullable|string',
            'jasa_distribusi' => 'nullable|string',
            'payment_option' => 'nullable',
            'penerima_id' => 'required',
            'transfer_receipt' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Proses unggah foto bukti transfer jika ada
        if ($request->hasFile('transfer_receipt')) {
            $fileName = time() . '.' . $request->transfer_receipt->extension();
            $path = $request->transfer_receipt->storeAs('transfer_receipts', $fileName, 'public'); // Simpan di storage/app/public/transfer_receipts
            $validateData['transfer_receipt'] = $path; // Simpan path foto
        }

        // Menambahkan status default
        $validateData['status'] = 'pending';

        //kurangi donasi dari tabel donate
        $donatesDikurangi = Donate::where('donation_type', $validateData['donation_type'])->get();
        $jmlhSudahBerkurang = 0;
        foreach ($donatesDikurangi as $donate) {
            if (
                $donate->donation_type == 'uang'
            ) {
                $dikurangi = min(
                    $donate->amount,
                    $validateData['amount'] - $jmlhSudahBerkurang
                );
                $donate->amount -= $dikurangi;
            } else {
                $dikurangi = min($donate->item_qty, $validateData['item_qty'] - $jmlhSudahBerkurang);
                $donate->item_qty -= $dikurangi;
            }

            $donate->save();
            $jmlhSudahBerkurang += $dikurangi;

            // Exit the loop if the required reduction is achieved
            if ($jmlhSudahBerkurang >= ($validateData['amount'] ?? $validateData['item_qty'])) {
                break;
            }
        }


        // Membuat entri donasi baru
        DistributionDonate::create($validateData);

        // Redirect dengan pesan sukses
        return redirect(route('managedonate'))->with('success', 'Anda telah melakukan penyaluran!');
    }

    /**
     * Display the specified resource.
     */
    public function tracking(string $id)
    {
        $donate = DistributionDonate::find($id);
        $courierId = $donate->jasa_distribusi;
        $resi = $donate->resi_number;
        $basePath = env('BINDERBYTE_BASE_API', '');
        $path = $basePath . "?api_key=" . env('BINDERBYTE_API_KEY', '') . "&courier=" . $courierId . "&awb=" . $resi;
        $response = $this->_getDataByCurl($path);

        $responsehistory = $response->data->history;
        $statusPaket = $response->data->summary->status;
        $donationArray = (array) $responsehistory;
        $jmlhHistory = count($donationArray);
        // Reverse the array
        $reversedArray = array_reverse($donationArray);
        // Convert array back to object
        $track = (object) $reversedArray;

        return view('backend.donate.tracking', compact('donate', 'statusPaket', 'track', 'jmlhHistory'));
    }

    private function _getDataByCurl($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 999999);
        $response = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($response);
        return $response;
    }
}

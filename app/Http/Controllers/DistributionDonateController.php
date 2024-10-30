<?php

namespace App\Http\Controllers;

use App\Models\DistributionDonate;
use App\Models\Donate;
use Illuminate\Http\Request;

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

        return view('backend.donate.donate', compact('donates', 'totalCashDonate', 'totalItemDonate'));
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
        // dd($request->all());
        // Validasi data input
        $validateData = $request->validate([
            'donation_type' => 'required',
            'amount' => 'nullable|integer',
            'item_qty' => 'nullable|integer',
            'resi_number' => 'nullable|string',
            'jasa_distribusi' => 'nullable|string',
            'payment_option' => 'required',
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

        // Membuat entri donasi baru
        DistributionDonate::create($validateData);

        // Redirect dengan pesan sukses
        return redirect(route('donate.managedonate'))->with('success', 'Anda telah melakukan penyaluran!');
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Donate;
use Illuminate\Http\Request;

class DonateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('frontend.donate.donate');
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
    dd($request->all());
    // Validasi data input
    $validateData = $request->validate([
        'name' => 'required',
        'phone' => 'required',
        'address' => 'required',
        'donation_type' => 'required',
        'amount' => 'nullable|integer',
        'item_qty' => 'nullable|integer',
        'expired_date' => 'nullable|date',
        'donation_option' => 'nullable',
        'resi_number' => 'nullable|string',
        'jasa_distribusi' => 'nullable|string',
        'payment_option' => 'required',
        'message' => 'nullable|string',
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
    Donate::create($validateData);

    // Redirect dengan pesan sukses
    return redirect(route('donate.index'))->with('success', 'Anda telah melakukan donasi!');
}

    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

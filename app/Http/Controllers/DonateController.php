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
        // Validasi data input dengan pesan dalam Bahasa Indonesia
        $validateData = $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'donation_type' => 'required',
            'amount' => 'nullable|integer',
            'item_qty' => 'nullable|integer',
            'expired_date' => 'nullable|date',
            'donation_option' => 'nullable',
            'resi_number' => 'nullable',
            'jasa_distribusi' => 'nullable',
            'payment_option' => 'nullable',
            'message' => 'nullable|string',
            'transfer_receipt' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ], [
            'required' => ':attribute wajib diisi.',
            'integer' => ':attribute harus berupa angka.',
            'date' => ':attribute harus berupa tanggal yang valid.',
            'image' => ':attribute harus berupa gambar.',
            'mimes' => ':attribute harus berupa file dengan tipe: :values.',
            'string' => ':attribute harus berupa string.',
        ]);
        
        // Proses unggah foto bukti transfer jika ada
        if ($request->hasFile('transfer_receipt')) {
            $fileName = time() . '.' . $request->transfer_receipt->extension();
            $path = $request->transfer_receipt->storeAs('assets/img/transfer_receipts', $fileName, 'public'); // Simpan di storage/app/public/transfer_receipts
            $validateData['transfer_receipt'] = $path; // Simpan path foto
        }
    
        // Menambahkan status default
        $validateData['status'] = 'pending';
    
        // Membuat entri donasi baru
        try {
            Donate::create($validateData);
            // Redirect dengan pesan sukses
            return redirect(route('donate.index'))->with('success', 'Anda telah melakukan donasi,status donasi sekarang pending');
        } catch (\Exception $e) {
            // Redirect dengan pesan error jika terjadi kesalahan
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])->withInput();
        }
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

    public function updateStatus($id, $status)
    {
        $donate = Donate::findOrFail($id);
        $donate->status = $status; // Set status sesuai parameter (sukses atau ditolak)
        $donate->save();

        return redirect()->route('listdonate.index')->with('success', 'Status donasi berhasil diperbarui');
    }

}

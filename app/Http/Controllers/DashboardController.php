<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Donate;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class DashboardController extends Controller
{
    public function index() {
        // Ambil donasi dengan status 'sukses', urutkan berdasarkan tanggal terbaru, ambil 5 data
        $donates = Donate::where('status', 'sukses')->orderBy('created_at', 'desc')->take(5)->get();
    
        // Hitung total donasi uang yang statusnya 'sukses'
        $totalCashDonate = Donate::where('status', 'sukses')->whereNotNull('amount')->sum('amount');
    
        // Hitung total donasi barang yang statusnya 'sukses'
        $totalItemDonate = Donate::where('status', 'sukses')->whereNotNull('item_qty')->sum('item_qty');
    
        // Hitung total pengguna aktif
        $totalActiveUsers = User::where('is_active', 1)->count();
    
        return view('backend.index', compact('donates', 'totalCashDonate', 'totalItemDonate', 'totalActiveUsers'));
    }
    
}

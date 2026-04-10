<?php

namespace App\Http\Controllers\Pengawas;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditController extends Controller
{
    public function index()
    {
        // Ambil data log, urutkan dari yang terbaru
        // with('user') agar kita bisa ambil nama pelakunya
        $logs = AuditLog::with('user')->latest()->paginate(15);
        
        return view('pengawas.audit.index', compact('logs'));
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Faq;
use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

class FaqControllerAdmin extends Controller
{
    // Daftar Kategori (Agar konsisten dengan icon di halaman depan)
    private $categories = [
        'umum' => 'Informasi Umum',
        'akun' => 'Akun & Keamanan',
        'pembayaran' => 'Pembayaran',
        'pengiriman' => 'Pesanan & Pengiriman',
        'pengembalian' => 'Pengembalian Dana',
        'layanan' => 'Layanan Pelanggan',
    ];

    public function index()
    {
        $faq = Faq::latest()->get();
        $categories = $this->categories;
        return view('admin.faq.index', compact('faq','categories'));
    }

    public function create()
    {
        $categories = $this->categories;
        return view('admin.faq.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
            'category' => 'required|string',
        ]);

        $faq = Faq::create($request->all());

        AuditLog::create([
            'user_id'    => Auth::id(),
            'action'     => 'CREATE',
            'model_type' => 'Faq',
            'model_name' => $faq->question, // Menggunakan pertanyaan sebagai target
            'details'    => "Menambahkan FAQ baru: '{$faq->question}'",
        ]);

        return redirect()->route('admin.faq.index')->with('success', 'FAQ berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $faq = Faq::findOrFail($id);
        $categories = $this->categories;
        return view('admin.faq.edit', compact('faq', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
            'category' => 'required|string',
            'is_active' => 'required|boolean',
        ]);

        $faq = Faq::findOrFail($id);

        $faq->fill($request->all());

        $changes = [];
        if ($faq->isDirty('question')) {
            $changes[] = "Pertanyaan: '" . $faq->getOriginal('question') . "' -> '" . $faq->question . "'";
        }
        if ($faq->isDirty('is_active')) {
            $status = $faq->is_active ? 'Aktif' : 'Non-Aktif';
            $changes[] = "Status berubah menjadi: $status";
        }

        $faq->save();

        // AUDIT TRAIL: EDIT
        if (count($changes) > 0) {
            AuditLog::create([
                'user_id'    => Auth::id(),
                'action'     => 'UPDATE',
                'model_type' => 'Faq',
                'model_name' => $faq->question,
                'details'    => implode(', ', $changes),
            ]);
        }

        return redirect()->route('admin.faq.index')->with('success', 'FAQ berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $faq = Faq::findOrFail($id);
        $faq->delete();
        $deletedQuestion = $faq->question;

        AuditLog::create([
            'user_id'    => Auth::id(),
            'action'     => 'DELETE',
            'model_type' => 'Faq',
            'model_name' => $deletedQuestion,
            'details'    => "Menghapus FAQ: '{$deletedQuestion}' secara permanen.",
        ]);

        return redirect()->route('admin.faq.index')->with('success', 'FAQ berhasil dihapus.');
    }
}
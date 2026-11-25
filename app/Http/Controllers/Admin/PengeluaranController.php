<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use Illuminate\Http\Request;

// CRUD pengeluaran. Form tambah ada di halaman daftar (index) supaya ringkas.
class PengeluaranController extends Controller
{
    private function rules(): array
    {
        return [
            'description' => 'required|string|max:150',
            'amount' => 'required|integer|min:1',
            'spent_at' => 'required|date',
        ];
    }

    public function index()
    {
        return view('admin.pengeluaran.index', ['expenses' => Expense::latest('spent_at')->take(50)->get()]);
    }

    public function store(Request $request)
    {
        Expense::create($request->validate($this->rules()));

        return redirect()->route('admin.pengeluaran.index')->with('success', 'Pengeluaran ditambahkan.');
    }

    public function edit(Expense $expense)
    {
        return view('admin.pengeluaran.edit', compact('expense'));
    }

    public function update(Request $request, Expense $expense)
    {
        $expense->update($request->validate($this->rules()));

        return redirect()->route('admin.pengeluaran.index')->with('success', 'Pengeluaran diperbarui.');
    }

    public function destroy(Expense $expense)
    {
        $expense->delete();

        return redirect()->route('admin.pengeluaran.index')->with('success', 'Pengeluaran dihapus.');
    }
}

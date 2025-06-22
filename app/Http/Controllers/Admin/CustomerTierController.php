<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomerTier;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CustomerTierController extends Controller
{
    /**
     * Menampilkan daftar semua tingkatan pelanggan.
     */
    public function index()
    {
        $tiers = CustomerTier::withCount('customers')->orderBy('name')->paginate(10);
        return view('admin.customer_tiers.index', compact('tiers'));
    }

    /**
     * Menampilkan form untuk membuat tingkatan baru.
     */
    public function create()
    {
        return view('admin.customer_tiers.form');
    }

    /**
     * Menyimpan tingkatan baru ke database.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:customer_tiers,name',
            'description' => 'nullable|string',
            'min_monthly_purchase' => 'required|numeric|min:0',
            'payment_term_days' => 'required|integer|min:0',
        ]);

        CustomerTier::create($validatedData);

        return redirect()->route('admin.customer-tiers.index')->with('success', 'Tingkatan pelanggan baru berhasil dibuat.');
    }

    /**
     * Menampilkan form untuk mengedit tingkatan.
     */
    public function edit(CustomerTier $customerTier)
    {
        return view('admin.customer_tiers.form', compact('customerTier'));
    }

    /**
     * Memperbarui tingkatan di database.
     */
    public function update(Request $request, CustomerTier $customerTier)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('customer_tiers')->ignore($customerTier->id_customer_tier, 'id_customer_tier')],
            'description' => 'nullable|string',
            'min_monthly_purchase' => 'required|numeric|min:0',
            'payment_term_days' => 'required|integer|min:0',
        ]);

        $customerTier->update($validatedData);

        return redirect()->route('admin.customer-tiers.index')->with('success', 'Tingkatan pelanggan berhasil diperbarui.');
    }

    /**
     * Menghapus tingkatan dari database.
     */
    public function destroy(CustomerTier $customerTier)
    {
        if ($customerTier->customers()->count() > 0) {
            return redirect()->route('admin.customer-tiers.index')->with('error', 'Tidak dapat menghapus tingkatan ini karena masih digunakan oleh pelanggan.');
        }

        $customerTier->delete();

        return redirect()->route('admin.customer-tiers.index')->with('success', 'Tingkatan pelanggan berhasil dihapus.');
    }
}

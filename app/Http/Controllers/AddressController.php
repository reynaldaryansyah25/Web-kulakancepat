<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AddressController extends Controller
{
    /**
     * Menyimpan alamat yang dipilih untuk proses checkout berikutnya.
     */
    public function selectForCheckout(Request $request, Address $address)
    {
        // Pastikan customer hanya bisa memilih alamatnya sendiri
        if ($address->id_customer !== Auth::guard('customer')->id()) {
            abort(403, 'Unauthorized action.');
        }
        
        // Simpan ID alamat yang dipilih ke dalam session
        session(['selected_address_id' => $address->id_address]);
        
        return redirect()->route('checkout.show')->with('success_toast', 'Alamat pengiriman berhasil diubah.');
    }

    /**
     * Menyimpan alamat baru ke database.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([ 
            'label' => 'required|string|max:255',
            'recipient_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'notes' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        $validatedData['id_customer'] = Auth::guard('customer')->id();
        
        try {
            $address = Address::create($validatedData);
            // Otomatis pilih alamat yang baru dibuat
            session(['selected_address_id' => $address->id_address]);
        } catch (\Exception $e) {
            Log::error('Gagal tambah alamat: ' . $e->getMessage());
            return back()->with('error', 'Gagal menambahkan alamat baru. Silakan coba lagi.');
        }

        return redirect()->route('profile.show', ['#alamat'])->with('success', 'Alamat baru berhasil ditambahkan dan dipilih!');
    }

    /**
     * Memperbarui alamat yang sudah ada.
     */
    public function update(Request $request, Address $address)
    {
        if ($address->id_customer !== Auth::guard('customer')->id()) { abort(403); }
        
        $validatedData = $request->validate([
            'label' => 'required|string|max:255',
            'recipient_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'notes' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        $address->update($validatedData);
        
        return redirect()->route('profile.show', ['#alamat'])->with('success', 'Alamat berhasil diperbarui!');
    }

    /**
     * Menghapus alamat.
     */
    public function destroy(Address $address)
    {
        if ($address->id_customer !== Auth::guard('customer')->id()) { abort(403); }
        
        $address->delete();
        
        return redirect()->route('profile.show', ['#alamat'])->with('success', 'Alamat berhasil dihapus.');
    }
}

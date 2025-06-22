<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Menampilkan halaman profil utama.
     */
    public function show()
    {
        /** @var \App\Models\Customer $customer */
        $customer = Auth::guard('customer')->user();
        $customer->load('tier');

        $transactions = $customer->transactions()->orderBy('date_transaction', 'desc')->paginate(5);
        $addresses = $customer->addresses()->latest()->get();

        return view('customers.user-profile', [
            'user' => $customer,
            'addresses' => $addresses,
            'transactions' => $transactions,
        ]);
    }

    /**
     * Memperbarui data profil utama customer.
     */
    public function updateProfile(Request $request)
    {
        /** @var \App\Models\Customer $customer */
        $customer = Auth::guard('customer')->user();

        $validatedData = $request->validate([
            'name_owner' => 'required|string|max:255',
            'name_store' => 'nullable|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:1024',
        ]);

        try {
            if ($request->hasFile('avatar')) {
                if ($customer->avatar) {
                    Storage::disk('public')->delete($customer->avatar);
                }
                $validatedData['avatar'] = $request->file('avatar')->store('avatars', 'public');
            }
            
            $customer->update($validatedData);

        } catch (\Exception $e) {
            Log::error('Gagal update profil: ' . $e->getMessage());
            return back()->with('error', 'Gagal memperbarui profil. Silakan coba lagi.');
        }

        return redirect()->route('profile.show')->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Memperbarui password customer.
     */
    public function updatePassword(Request $request)
    {
        /** @var \App\Models\Customer $customer */
        $customer = Auth::guard('customer')->user();

        $request->validate([
            'current_password' => ['required', 'string', 'current_password:customer'],
            'new_password' => ['required', 'string', Password::min(8), 'confirmed'],
        ]);

        try {
            $customer->update([
                'password' => $request->new_password
            ]);
        } catch (\Exception $e) {
            Log::error('Gagal ubah password: ' . $e->getMessage());
            return back()->with('error', 'Gagal mengubah password. Silakan coba lagi.');
        }

        return redirect()->route('profile.show')->with('success', 'Password berhasil diubah!');
    }
}

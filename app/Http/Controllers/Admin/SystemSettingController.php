<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class SystemSettingController extends Controller
{
    /**
     * Menampilkan halaman form pengaturan.
     */
    public function index()
    {
        // Ambil semua settings dari database dan ubah menjadi array asosiatif ['key' => 'value']
        $settings = Setting::pluck('value', 'key')->all();

        // Decode data bank yang disimpan sebagai JSON
        $settings['bank_accounts'] = json_decode($settings['bank_accounts'] ?? '[]', true);

        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Memperbarui pengaturan sistem.
     */
    public function update(Request $request)
    {
        $settingsData = $request->input('settings', []);

        // Handle upload logo
        if ($request->hasFile('app_logo')) {
            $request->validate(['app_logo' => 'image|mimes:jpeg,png,jpg,svg|max:1024']);
            
            $oldLogo = Setting::where('key', 'app_logo_path')->value('value');
            if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
                Storage::disk('public')->delete($oldLogo);
            }
            
            $path = $request->file('app_logo')->store('logos', 'public');
            $settingsData['app_logo_path'] = $path;
        }

        // Handle data rekening bank (simpan sebagai JSON)
        if (isset($settingsData['bank_accounts'])) {
            // Filter entri yang kosong
            $bankAccounts = array_filter($settingsData['bank_accounts'], function ($account) {
                return !empty($account['bank_name']) && !empty($account['account_number']) && !empty($account['account_holder']);
            });
            $settingsData['bank_accounts'] = json_encode(array_values($bankAccounts));
        }

        // Loop melalui setiap setting dan simpan ke database
        foreach ($settingsData as $key => $value) {
            // Untuk checkbox, dengan adanya input hidden value="0" sebelum checkbox,
            // kita memastikan nilai '0' atau '1' akan selalu ada.
            if (is_array($value)) {
                Log::warning("Mencoba menyimpan nilai array pada setting key: {$key}");
                continue;
            }

            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value ?? '']
            );
        }

        // Hapus cache config agar perubahan bisa segera terasa
        Artisan::call('config:clear');
        Artisan::call('cache:clear');

        return redirect()->route('admin.settings.index')->with('success', 'Pengaturan sistem berhasil diperbarui.');
    }
}

<div>
  <h2 class="text-2xl font-bold text-slate-800 dark:text-slate-100">Pengaturan Pengguna & Akses</h2>
  <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
    Mengelola aturan yang berkaitan dengan pendaftaran dan peran pengguna.
  </p>
  <div
    class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-md dark:border-slate-700 dark:bg-slate-800/50">
    <h3 class="mb-4 text-lg font-semibold text-slate-800 dark:text-slate-100">
      Pengaturan Registrasi Pelanggan
    </h3>
    <div class="flex items-center justify-between">
      <div>
        <p class="text-sm font-medium text-slate-700 dark:text-slate-300">
          Wajibkan Persetujuan Admin untuk Akun Pelanggan Baru?
        </p>
        <p class="text-xs text-slate-500 dark:text-slate-400">
          Jika aktif, pelanggan baru tidak bisa langsung login sebelum disetujui.
        </p>
      </div>
      <label class="flex cursor-pointer items-center">
        <div class="relative">
          <input type="hidden" name="settings[require_admin_approval]" value="0" />
          <input
            type="checkbox"
            name="settings[require_admin_approval]"
            value="1"
            class="sr-only"
            {{ old('settings.require_admin_approval', $settings['require_admin_approval'] ?? false) ? 'checked' : '' }} />
          <div class="h-6 w-10 rounded-full bg-slate-300 shadow-inner dark:bg-slate-600"></div>
          <div
            class="dot {{ old('settings.require_admin_approval', $settings['require_admin_approval'] ?? false) ? 'bg-primary translate-x-full' : '' }} absolute left-1 top-1 h-4 w-4 rounded-full bg-white shadow transition-transform"></div>
        </div>
      </label>
    </div>
  </div>
</div>

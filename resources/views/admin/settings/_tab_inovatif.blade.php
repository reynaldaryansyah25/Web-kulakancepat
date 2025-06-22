<div>
  <h2 class="text-2xl font-bold text-slate-800 dark:text-slate-100">Pengaturan Fitur Inovatif</h2>
  <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
    Panel kontrol untuk mengonfigurasi fitur-fitur canggih.
  </p>
  <div
    class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-md dark:border-slate-700 dark:bg-slate-800/50">
    <h3 class="mb-4 text-lg font-semibold text-slate-800 dark:text-slate-100">
      Konfigurasi Tiering Pelanggan
    </h3>
    <div class="flex items-center justify-between">
      <p class="text-sm text-slate-700 dark:text-slate-300">
        Kelola tingkatan, syarat, dan plafon kredit pelanggan.
      </p>
      <a
        href="{{ route('admin.customer-tiers.index') }}"
        class="text-primary hover:text-primary/80 text-sm font-medium">
        Buka Manajemen Tier &rarr;
      </a>
    </div>
  </div>
  <div
    class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-md dark:border-slate-700 dark:bg-slate-800/50">
    <h3 class="mb-4 text-lg font-semibold text-slate-800 dark:text-slate-100">
      Konfigurasi Asisten Prediktif
    </h3>
    <div class="flex items-center justify-between">
      <p class="text-sm font-medium text-slate-700 dark:text-slate-300">
        Aktifkan sistem rekomendasi otomatis.
      </p>
      <label class="flex cursor-pointer items-center">
        <div class="relative">
          <input type="hidden" name="settings[predictive_assistant_enabled]" value="0" />
          <input
            type="checkbox"
            name="settings[predictive_assistant_enabled]"
            value="1"
            class="sr-only"
            {{ old('settings.predictive_assistant_enabled', $settings['predictive_assistant_enabled'] ?? false) ? 'checked' : '' }} />
          <div class="h-6 w-10 rounded-full bg-slate-300 shadow-inner dark:bg-slate-600"></div>
          <div
            class="dot {{ old('settings.predictive_assistant_enabled', $settings['predictive_assistant_enabled'] ?? false) ? 'bg-primary translate-x-full' : '' }} absolute left-1 top-1 h-4 w-4 rounded-full bg-white shadow transition-transform"></div>
        </div>
      </label>
    </div>
    <div class="mt-4">
      <label
        for="predictive_stock_days"
        class="block text-sm font-medium text-slate-700 dark:text-slate-300">
        Kirim notifikasi saran pemesanan jika stok pelanggan diprediksi akan habis dalam (hari)
      </label>
      <input
        type="number"
        name="settings[predictive_stock_days]"
        id="predictive_stock_days"
        value="{{ old('settings.predictive_stock_days', $settings['predictive_stock_days'] ?? 7) }}"
        min="1"
        class="input-field mt-1 w-full md:w-1/3" />
    </div>
  </div>
</div>

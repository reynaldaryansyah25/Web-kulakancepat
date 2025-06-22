<div class="grid grid-cols-1 gap-8 lg:grid-cols-2">
  <div class="lg:col-span-2">
    <h2 class="text-2xl font-bold text-slate-800 dark:text-slate-100">
      Pengaturan Umum & Informasi Bisnis
    </h2>
    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
      Kelola identitas dan informasi dasar perusahaan.
    </p>
  </div>
  <div
    class="rounded-xl border border-slate-200 bg-white p-6 shadow-md dark:border-slate-700 dark:bg-slate-800/50">
    <h3 class="mb-4 text-lg font-semibold text-slate-800 dark:text-slate-100">
      Informasi Perusahaan
    </h3>
    <div class="space-y-4">
      <div>
        <label
          for="company_name"
          class="block text-sm font-medium text-slate-700 dark:text-slate-300">
          Nama Aplikasi/Toko
        </label>
        <input
          type="text"
          name="settings[company_name]"
          id="company_name"
          value="{{ old('settings.company_name', $settings['company_name'] ?? '') }}"
          class="input-field mt-1 w-full" />
      </div>
      <div>
        <label for="app_logo" class="block text-sm font-medium text-slate-700 dark:text-slate-300">
          Logo Perusahaan
        </label>
        <input
          type="file"
          name="app_logo"
          id="app_logo"
          class="file:bg-primary/10 file:text-primary hover:file:bg-primary/20 mt-1 w-full text-sm text-slate-500 file:mr-4 file:rounded-lg file:border-0 file:px-4 file:py-2 file:text-sm file:font-semibold" />
        @if (! empty($settings['app_logo_path']))
          <div class="mt-2">
            <p class="text-xs text-slate-500">Logo saat ini:</p>
            <img
              src="{{ Storage::url($settings['app_logo_path']) }}"
              class="mt-1 h-16 rounded-md bg-slate-200 p-2" />
          </div>
        @endif
      </div>
    </div>
  </div>
  <div
    class="rounded-xl border border-slate-200 bg-white p-6 shadow-md dark:border-slate-700 dark:bg-slate-800/50">
    <h3 class="mb-4 text-lg font-semibold text-slate-800 dark:text-slate-100">Informasi Kontak</h3>
    <div class="space-y-4">
      <div>
        <label
          for="company_email"
          class="block text-sm font-medium text-slate-700 dark:text-slate-300">
          Email Dukungan
        </label>
        <input
          type="email"
          name="settings[company_email]"
          id="company_email"
          value="{{ old('settings.company_email', $settings['company_email'] ?? '') }}"
          class="input-field mt-1 w-full" />
      </div>
      <div>
        <label
          for="company_phone"
          class="block text-sm font-medium text-slate-700 dark:text-slate-300">
          Nomor Telepon
        </label>
        <input
          type="tel"
          name="settings[company_phone]"
          id="company_phone"
          value="{{ old('settings.company_phone', $settings['company_phone'] ?? '') }}"
          class="input-field mt-1 w-full" />
      </div>
      <div>
        <label
          for="company_address"
          class="block text-sm font-medium text-slate-700 dark:text-slate-300">
          Alamat Perusahaan
        </label>
        <textarea
          name="settings[company_address]"
          id="company_address"
          rows="3"
          class="input-field mt-1 w-full">
{{ old('settings.company_address', $settings['company_address'] ?? '') }}</textarea
        >
      </div>
    </div>
  </div>
</div>

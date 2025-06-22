<div
  class="grid grid-cols-1 gap-8 lg:grid-cols-2"
  x-data="{
        bankTransferEnabled: {{ old('settings.payment_method_bank_transfer', $settings['payment_method_bank_transfer'] ?? '0') == '1' ? 'true' : 'false' }},
        bankAccounts: {!! json_encode(old('settings.bank_accounts', $settings['bank_accounts'] ?? [])) !!}
     }">
  <div class="lg:col-span-2">
    <h2 class="text-2xl font-bold text-slate-800 dark:text-slate-100">
      Pengaturan Transaksi & Keuangan
    </h2>
    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
      Atur semua hal yang berkaitan dengan proses pembayaran dan keuangan.
    </p>
  </div>

  <div
    class="rounded-xl border border-slate-200 bg-white p-6 shadow-md dark:border-slate-700 dark:bg-slate-800/50">
    <h3 class="mb-4 text-lg font-semibold text-slate-800 dark:text-slate-100">
      Manajemen Metode Pembayaran
    </h3>
    <div class="space-y-4">
      @php
        $paymentMethods = [
          'payment_method_bank_transfer' => 'Bank Transfer',
          'payment_method_cod' => 'Cash on Delivery (COD)',
          'payment_method_credit' => 'Bayar Tempo (Kredit)',
        ];
      @endphp

      @foreach ($paymentMethods as $key => $label)
        <div class="flex items-center justify-between">
          <span class="text-sm font-medium text-slate-700 dark:text-slate-300">{{ $label }}</span>
          <label class="flex cursor-pointer items-center">
            <div class="relative">
              <input type="hidden" name="settings[{{ $key }}]" value="0" />
              <input
                type="checkbox"
                name="settings[{{ $key }}]"
                value="1"
                class="sr-only"
                x-model="bankTransferEnabled"
                {{ old('settings.' . $key, $settings[$key] ?? false) ? 'checked' : '' }} />
              <div class="h-6 w-10 rounded-full bg-slate-300 shadow-inner dark:bg-slate-600"></div>
              <div
                class="dot {{ old('settings.' . $key, $settings[$key] ?? false) ? 'bg-primary translate-x-full' : '' }} absolute left-1 top-1 h-4 w-4 rounded-full bg-white shadow transition-transform"></div>
            </div>
          </label>
        </div>
      @endforeach
    </div>

    <div
      x-show="bankTransferEnabled"
      class="mt-6 border-t border-slate-200 pt-4 dark:border-slate-700">
      <h4 class="text-md mb-2 font-semibold text-slate-800 dark:text-slate-100">
        Detail Rekening Bank
      </h4>
      <div class="space-y-3">
        <template x-for="(account, index) in bankAccounts" :key="index">
          <div class="flex items-end gap-2">
            <input
              type="hidden"
              :name="`settings[bank_accounts][${index}][bank_name]`"
              x-model="account.bank_name" />
            <input
              type="hidden"
              :name="`settings[bank_accounts][${index}][account_holder]`"
              x-model="account.account_holder" />
            <input
              type="hidden"
              :name="`settings[bank_accounts][${index}][account_number]`"
              x-model="account.account_number" />
            <div class="flex-1 rounded-md bg-slate-50 p-2 text-sm dark:bg-slate-700">
              <span class="font-bold" x-text="account.bank_name"></span>
              -
              <span x-text="account.account_number"></span>
              (
              <span x-text="account.account_holder"></span>
              )
            </div>
            <button
              type="button"
              @click="bankAccounts.splice(index, 1)"
              class="rounded-md p-2 text-red-500 hover:bg-red-100">
              &times;
            </button>
          </div>
        </template>
      </div>
      <p x-show="bankAccounts.length === 0" class="py-2 text-center text-xs text-slate-500">
        Belum ada rekening bank.
      </p>
      <button
        type="button"
        @click="bankAccounts.push({ bank_name: '', account_holder: ' ', account_number: '' })"
        class="text-primary hover:text-primary/80 mt-3 text-sm font-medium">
        + Tambah Rekening
      </button>
    </div>
  </div>

  <div
    class="rounded-xl border border-slate-200 bg-white p-6 shadow-md dark:border-slate-700 dark:bg-slate-800/50">
    <h3 class="mb-4 text-lg font-semibold text-slate-800 dark:text-slate-100">Pengaturan Pajak</h3>
    <div class="space-y-4">
      <div class="flex items-center justify-between">
        <span class="text-sm font-medium text-slate-700 dark:text-slate-300">
          Terapkan Pajak pada Pesanan
        </span>
        <label class="flex cursor-pointer items-center">
          <div class="relative">
            <input type="hidden" name="settings[tax_enabled]" value="0" />
            <input
              type="checkbox"
              name="settings[tax_enabled]"
              value="1"
              class="sr-only"
              {{ old('settings.tax_enabled', $settings['tax_enabled'] ?? false) ? 'checked' : '' }} />
            <div class="h-6 w-10 rounded-full bg-slate-300 shadow-inner dark:bg-slate-600"></div>
            <div
              class="dot {{ old('settings.tax_enabled', $settings['tax_enabled'] ?? false) ? 'bg-primary translate-x-full' : '' }} absolute left-1 top-1 h-4 w-4 rounded-full bg-white shadow transition-transform"></div>
          </div>
        </label>
      </div>
      <div>
        <label for="tax_rate" class="block text-sm font-medium text-slate-700 dark:text-slate-300">
          Tarif Pajak (%)
        </label>
        <input
          type="number"
          name="settings[tax_rate]"
          id="tax_rate"
          value="{{ old('settings.tax_rate', $settings['tax_rate'] ?? 11) }}"
          min="0"
          max="100"
          step="0.1"
          class="input-field mt-1 w-full" />
      </div>
    </div>
  </div>
</div>

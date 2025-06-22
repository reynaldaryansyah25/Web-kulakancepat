<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerTier; // Import model CustomerTier
use App\Models\Sales;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

class CustomerController extends Controller
{
  /**
   * Menampilkan daftar pelanggan beserta statistik.
   */
  public function index(Request $request)
  {
    // Menghitung statistik pelanggan
    $customerStats = (object) [
      'total' => Customer::count(),
      'active' => Customer::where('status', 'ACTIVE')->count(),
      'pending' => Customer::where('status', 'PENDING_APPROVE')->count(),
      'registeredThisMonth' => Customer::whereMonth('created', now()->month)
        ->whereYear('created', now()->year)
        ->count(),
    ];

    // Logika filter
    $search = $request->input('search_customer');
    $statusFilter = $request->input('customer_status');

    $query = Customer::query()
      ->with(['salesPerson', 'tier'])
      ->withCount('transactions')
      ->withSum(['completedTransactions as total_pembelian' => function ($query) {
        $query->where('status', 'FINISH');
      }], 'total_price');

    if ($search) {
      $query->where(function ($q) use ($search) {
        $q->where('name_store', 'like', "%{$search}%")
          ->orWhere('name_owner', 'like', "%{$search}%")
          ->orWhere('email', 'like', "%{$search}%");
      });
    }

    if ($statusFilter) {
      $query->where('status', $statusFilter);
    }

    $customers = $query->orderBy('created', 'desc')->paginate(10);

    return view('admin.customers.index', compact('customers', 'customerStats'));
  }

  /**
   * Menampilkan form untuk membuat pelanggan baru.
   */
  public function create()
  {
    $salesPeople = Sales::orderBy('name')->get();
    $tiers = CustomerTier::orderBy('name')->get();
    return view('admin.customers.create', compact('salesPeople', 'tiers'));
  }

  /**
   * Menyimpan pelanggan baru ke database.
   */
  public function store(Request $request)
  {
    $validatedData = $request->validate([
      'name_store' => 'required|string|max:255',
      'name_owner' => 'required|string|max:255',
      'email' => 'required|string|email|max:100|unique:customer,email',
      'no_phone' => 'required|string|max:20',
      'password' => 'required|string|min:8|confirmed',
      'address' => 'required|string|max:255',
      'status' => ['required', Rule::in(['PENDING_APPROVE', 'ACTIVE', 'INACTIVE'])],
      'id_sales' => 'nullable|exists:sales,id_sales',
      'customer_tier_id' => 'nullable|exists:customer_tiers,id_customer_tier',
      'credit_limit' => 'required|numeric|min:0',
    ]);

    Customer::create($validatedData);

    return redirect()->route('admin.customers.index')->with('success', 'Pelanggan baru berhasil ditambahkan.');
  }

  /**
   * Menampilkan form untuk mengedit pelanggan.
   */
  public function edit(Customer $customer)
  {
    $salesPeople = Sales::orderBy('name')->get();
    $tiers = CustomerTier::orderBy('name')->get();
    return view('admin.customers.form', compact('customer', 'salesPeople', 'tiers'));
  }

  /**
   * Memperbarui data pelanggan di database.
   */
  public function update(Request $request, Customer $customer)
  {
    $validatedData = $request->validate([
      'name_store' => 'required|string|max:255',
      'name_owner' => 'required|string|max:255',
      'email' => ['required', 'string', 'email', 'max:100', Rule::unique('customer', 'email')->ignore($customer->id_customer, 'id_customer')],
      'no_phone' => 'required|string|max:20',
      'address' => 'required|string|max:255',
      'status' => ['required', Rule::in(['PENDING_APPROVE', 'ACTIVE', 'INACTIVE'])],
      'id_sales' => 'nullable|exists:sales,id_sales',
      'password' => 'nullable|string|min:8|confirmed',
      'customer_tier_id' => 'nullable|exists:customer_tiers,id_customer_tier',
      'credit_limit' => 'required|numeric|min:0',
    ]);

    if (!empty($request->input('password'))) {
      $customer->password = $request->input('password');
    }

    $updateData = $request->except('password', 'password_confirmation', '_token', '_method');
    if (empty($request->input('password'))) {
      unset($updateData['password_confirmation']);
    }

    $customer->fill($updateData);
    $customer->save();

    return redirect()->route('admin.customers.index')->with('success', 'Data pelanggan berhasil diperbarui.');
  }

  /**
   * Menghapus pelanggan dari database.
   */
  public function destroy(Customer $customer)
  {
    try {
      $customer->delete();
      return redirect()->route('admin.customers.index')->with('success', 'Pelanggan berhasil dihapus.');
    } catch (\Illuminate\Database\QueryException $e) {
      Log::error("Gagal menghapus pelanggan: " . $e->getMessage());
      return redirect()->route('admin.customers.index')->with('error', 'Gagal menghapus pelanggan. Mungkin masih ada data terkait.');
    }
  }

  /**
   * Menyetujui akun pelanggan.
   */
  public function approve(Customer $customer)
  {
    if ($customer->status == 'PENDING_APPROVE') {
      $customer->status = 'ACTIVE';
      $customer->save();
      return redirect()->route('admin.customers.index')->with('success', 'Akun pelanggan ' . $customer->name_owner . ' berhasil disetujui.');
    }
    return redirect()->route('admin.customers.index')->with('error', 'Akun pelanggan sudah tidak dalam status menunggu persetujuan.');
  }
}

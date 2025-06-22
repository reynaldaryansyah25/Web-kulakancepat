<?php
// App/Exports/ReportExport.php
namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReportExport implements FromCollection, WithHeadings
{
    protected $range;

    public function __construct(array $range)
    {
        $this->range = $range;
    }

    public function collection()
    {
        return Transaction::where('status', 'FINISH')
            ->whereBetween('date_transaction', [$this->range['start'], $this->range['end']])
            ->select('id_transaction', 'date_transaction', 'total_price', 'status')
            ->orderBy('date_transaction', 'desc')
            ->get();
    }

    public function headings(): array
    {
        return ['ID Transaksi', 'Tanggal', 'Total Harga', 'Metode Pembayaran', 'Status'];
    }
}

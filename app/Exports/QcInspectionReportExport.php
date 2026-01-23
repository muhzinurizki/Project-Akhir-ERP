<?php

namespace App\Exports;

use App\Models\QcInspection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class QcInspectionReportExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    ShouldAutoSize
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $query = QcInspection::with([
            'product.category',
            'product.unit',
            'inspector'
        ]);

        if ($this->request->filled('status')) {
            $query->where('status', $this->request->status);
        }

        if ($this->request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $this->request->date_from);
        }

        if ($this->request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $this->request->date_to);
        }

        return $query->latest()->get();
    }

    public function headings(): array
    {
        return [
            'Inspection Date',
            'Product Name',
            'SKU',
            'Category',
            'Unit',
            'Inspector',
            'Status',
            'Note',
        ];
    }

    public function map($qc): array
    {
        return [
            $qc->created_at->format('Y-m-d H:i'),
            $qc->product->name,
            $qc->product->sku,
            $qc->product->category->name ?? '-',
            $qc->product->unit->code ?? '-',
            $qc->inspector->name,
            $qc->status,
            $qc->note,
        ];
    }
}

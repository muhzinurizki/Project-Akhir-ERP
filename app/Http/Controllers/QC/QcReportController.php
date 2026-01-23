<?php

namespace App\Http\Controllers\QC;

use App\Http\Controllers\Controller;
use App\Models\QcInspection;
use Illuminate\Http\Request;
use App\Exports\QcInspectionReportExport;
use Maatwebsite\Excel\Facades\Excel;
class QcReportController extends Controller
{
    public function index(Request $request)
    {
        $query = QcInspection::with([
            'product.category',
            'product.unit',
            'inspector',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Filters
        |--------------------------------------------------------------------------
        */

        // Filter by inspection date
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by product name / SKU
        if ($request->filled('product')) {
            $query->whereHas('product', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->product . '%')
                  ->orWhere('sku', 'like', '%' . $request->product . '%');
            });
        }

        // Filter by inspector name
        if ($request->filled('inspector')) {
            $query->whereHas('inspector', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->inspector . '%');
            });
        }

        /*
        |--------------------------------------------------------------------------
        | Pagination
        |--------------------------------------------------------------------------
        */
        $inspections = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('qc.reports.index', compact('inspections'));
    }

    public function export(Request $request)
    {
        return Excel::download(
            new QcInspectionReportExport($request),
            'qc-inspection-report-' . now()->format('Ymd_His') . '.xlsx'
        );
    }
}

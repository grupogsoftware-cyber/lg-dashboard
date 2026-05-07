<?php

namespace App\Http\Controllers;

use App\ProductionRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $selectedLine = $request->get('product_line');

        $query = ProductionRecord::query()
            ->whereYear('production_date', 2026)
            ->whereMonth('production_date', 1);

        if (!empty($selectedLine)) {
            $query->where('product_line', $selectedLine);
        }

        $records = $query
            ->select(
                'product_line',
                DB::raw('SUM(quantity_produced) as total_produced'),
                DB::raw('SUM(quantity_defects) as total_defects')
            )
            ->groupBy('product_line')
            ->orderBy('product_line')
            ->get()
            ->map(function ($item) {
                $item->efficiency = $item->total_produced > 0
                    ? round((($item->total_produced - $item->total_defects) / $item->total_produced) * 100, 2)
                    : 0;

                return $item;
            });

        $allLines = ProductionRecord::query()
            ->select('product_line')
            ->distinct()
            ->orderBy('product_line')
            ->pluck('product_line');

        $summaryProduced = $records->sum('total_produced');
        $summaryDefects = $records->sum('total_defects');
        $summaryEfficiency = $summaryProduced > 0
            ? round((($summaryProduced - $summaryDefects) / $summaryProduced) * 100, 2)
            : 0;

        $periodStart = '01/01/2026';
        $periodEnd = '31/01/2026';

        $totalDays = ProductionRecord::query()
            ->whereYear('production_date', 2026)
            ->whereMonth('production_date', 1)
            ->distinct('production_date')
            ->count('production_date');

        $totalRecords = ProductionRecord::query()
            ->whereYear('production_date', 2026)
            ->whereMonth('production_date', 1)
            ->when(!empty($selectedLine), function ($query) use ($selectedLine) {
                $query->where('product_line', $selectedLine);
            })
            ->count();

        return view('dashboard', [
            'records' => $records,
            'allLines' => $allLines,
            'selectedLine' => $selectedLine,
            'summaryProduced' => $summaryProduced,
            'summaryDefects' => $summaryDefects,
            'summaryEfficiency' => $summaryEfficiency,
            'periodStart' => $periodStart,
            'periodEnd' => $periodEnd,
            'totalDays' => $totalDays,
            'totalRecords' => $totalRecords,
        ]);
    }
}

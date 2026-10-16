<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\Analytics;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StatsController extends Controller
{
    public function index(Request $request): View
    {
        $range = Analytics::normaliseRange($request->input('range'));

        return view('admin.stats.index', [
            'range' => $range,
            'summary' => Analytics::summary($range),
            'series' => Analytics::dailySeries($range),
            'topPages' => Analytics::topPages($range),
            'topReferrers' => Analytics::topReferrers($range),
            'devices' => Analytics::devices($range),
            'clickCounts' => Analytics::clickCounts($range),
        ]);
    }
}

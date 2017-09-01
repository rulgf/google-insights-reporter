<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use LaravelAnalytics;
use App\Http\Requests;
use Carbon\Carbon;

class PruebaController extends Controller
{
    public function getQuery(Request $request)
    {
        $startDate=Carbon::yesterday();
        $endDate=Carbon::yesterday();
        $metrics='ga:users';
        $others=[];

        $analyticsData = LaravelAnalytics::setSiteId('ga:120480271')->performQuery($startDate, $endDate, $metrics, $others);

        dd(implode(',', $analyticsData->rows[0]));
    }
}

<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    // ESSAI CHARJS
    public function getDatajs($d)
    {
        $startDate = now()->startOfDay();
        $endDate = now()->endOfDay();

        if ($d == 'day') {
            $startDate = now()->startOfDay();
            $endDate = now()->endOfDay();
        } elseif ($d == '7') {
            $startDate = now()->subDays(7)->startOfDay();
        } elseif ($d == '30') {
            $startDate = now()->subDays(30)->startOfDay();
        } elseif ($d == 'lastMonth') {
            $startDate = now()->subMonth()->startOfMonth();
            $endDate = now()->subMonth()->endOfMonth();
        } elseif ($d === 'thisMonth') {
            $startDate = now()->startOfMonth();
        } elseif ($d === 'thisYear') {
            $startDate = now()->startOfYear();
        } elseif ($d === 'lastYear') {
            $startDate = now()->subYear()->startOfYear();
            $endDate = now()->subYear()->endOfYear();
        } else {
            $startDate = now()->startOfDay();
            $endDate = now()->endOfDay();
        }

        $data = DB::table('payments')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();
        $payDetail = DB::table('payment_details')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();


        return response()->json([$data, $payDetail]); // Retournez les données au format JSON
    }
}

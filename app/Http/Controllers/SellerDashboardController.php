<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Services;
use Symfony\Component\HttpFoundation\Response;

class SellerDashboardController extends Controller
{
    public function summary()
    {
        $sellerId = auth()->id();

        return response()->json([
            'total_services' => Services::where('user_id', $sellerId)->count(),

            'total_sales' => Reservation::join(
                    'services',
                    'reservation.services_id',
                    '=',
                    'services.id'
                )
                ->where('services.user_id', $sellerId)
                ->where('reservation.status', 'confirmado')
                ->count(),

            'total_revenue' => Reservation::join(
                    'services',
                    'reservation.services_id',
                    '=',
                    'services.id'
                )
                ->where('services.user_id', $sellerId)
                ->where('reservation.status', 'confirmado')
                ->sum('services.price'),

            'active_reservations' => Reservation::join(
                    'services',
                    'reservation.services_id',
                    '=',
                    'services.id'
                )
                ->where('services.user_id', $sellerId)
                ->where('reservation.status', 'confirmado')
                ->count(),
        ], Response::HTTP_OK);
    }

    public function salesByMonth()
    {
        $sellerId = auth()->id();

        $data = Reservation::selectRaw(
                'MONTH(created_at) as month,
                COUNT(*) as total'
            )
            ->whereHas('service', fn ($q) =>
                $q->where('user_id', $sellerId)
            )
            ->where('status', 'confirmado')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return response()->json($this->formatMonthlyData($data));
    }


    public function revenueByMonth()
    {
        $sellerId = auth()->id();

        $data = Reservation::selectRaw(
                'MONTH(reservation.created_at) as month,
                SUM(services.price) as total'
            )
            ->join(
                'services',
                'reservation.services_id',
                '=',
                'services.id'
            )
            ->where('services.user_id', $sellerId)
            ->where('reservation.status', 'confirmado')
            ->groupByRaw('MONTH(reservation.created_at)')
            ->orderByRaw('MONTH(reservation.created_at)')
            ->get();

        return response()->json($this->formatMonthlyData($data), Response::HTTP_OK);
    }

    public function topServices()
    {

        $sellerId = auth()->id();

        $services = Reservation::selectRaw(
                'services.id,
                services.name,
                COUNT(reservation.id) as total_sales'
            )
            ->join(
                'services',
                'reservation.services_id',
                '=',
                'services.id'
            )
            ->where('services.user_id', $sellerId)
            ->groupBy('services.id', 'services.name')
            ->orderByDesc('total_sales')
            ->limit(4)
            ->get();

        return response()->json($services, Response::HTTP_OK);
    }


    private function formatMonthlyData($data)
    {
        $months = [
            1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo',
            4 => 'Abril', 5 => 'Mayo', 6 => 'Junio',
            7 => 'Julio', 8 => 'Agosto', 9 => 'Septiembre',
            10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
        ];

        $labels = [];
        $values = [];

        foreach ($data as $row) {
            $labels[] = $months[$row->month];
            $values[] = $row->total;
        }

        return [
            'labels' => $labels,
            'values' => $values
        ];
    }
}

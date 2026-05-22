<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Invitation;
use App\Models\Order;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $activeInvitations = Invitation::where('is_active', 1)->count();
        $totalClients = User::where('role', 'client')->count();
        $totalOrders = Order::count();
        $revenue = Order::where('status', 'completed')->sum('amount');

        return [
            Stat::make('Klien Aktif', $totalClients)
                ->description('Total klien terdaftar')
                ->descriptionIcon('heroicon-o-users')
                ->color('success'),
            Stat::make('Undangan Aktif', $activeInvitations)
                ->description('Undangan yang sedang aktif')
                ->descriptionIcon('heroicon-o-envelope')
                ->color('info'),
            Stat::make('Pesanan', $totalOrders)
                ->description('Total semua pesanan')
                ->descriptionIcon('heroicon-o-shopping-cart')
                ->color('warning'),
            Stat::make('Pendapatan', 'Rp' . number_format($revenue, 0, ',', '.'))
                ->description('Dari pesanan selesai')
                ->descriptionIcon('heroicon-o-banknotes')
                ->color('success'),
        ];
    }
}

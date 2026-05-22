<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        try {
            $waNumber = Setting::getValue('wa_number');
            if ($waNumber) {
                config(['app.wa_number' => $waNumber]);
            }
        } catch (\Exception $e) {
            //
        }
    }
}

<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
    }

    public function boot(): void
    {
        View::composer('*', function ($view) {
            try {
                if (Schema::hasTable('keluhans')) {
                    $count = DB::table('keluhans')->where('status', 'Menunggu')->count();
                    $view->with('keluhan_baru_count', $count);
                }
            } catch (\Exception $e) {
            }
        });
    }
}

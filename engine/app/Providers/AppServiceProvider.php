<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Counter;
use DB;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Schema::defaultStringLength(191);
        header('Access-Control-Allow-Origin: *');
        $date = date("d");
        	$a= DB::table("common_sequence");
   
        if ($date == 1) {
             $update = $a->where('sequence_max_value', '=', 1)->update(["sequence_next_value" => 1, "sequence_max_value" => 0]);
         } else if ($date == 2) {
             $update = $a->where('sequence_max_value', '=', 0)->update(["sequence_max_value" => 1]);
         }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

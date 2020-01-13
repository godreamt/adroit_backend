<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        
        
        Validator::extend('check_address', function($attribute, $value, $parameters, $validator)
        { 
            if(empty($parameters[0])){
                if($value == 'country_head' || $value == 'state_head'|| $value == 'regional_head'|| $value == 'sales_executive'|| $value == 'vendors'){
                    return false;
                }
            }
            if(empty($parameters[1])){
                if($value == 'state_head'|| $value == 'regional_head'|| $value == 'sales_executive'|| $value == 'vendors'){
                    return false;
                }
            }
            if(empty($parameters[2])){
                if($value == 'regional_head'|| $value == 'sales_executive'|| $value == 'vendors'){
                    return false;
                }
            }
            if(empty($parameters[3])){
                if($value == 'sales_executive'|| $value == 'vendors'){
                    return false;
                }
            }
            return true;
        }, "Provide required address details.");
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

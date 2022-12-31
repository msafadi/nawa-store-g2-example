<?php

namespace App\Providers;

use App\Repositories\CartRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Add cart cookie id in the service container
        $this->app->bind('cart.cookie_id', function() {
            $cookie_id = Cookie::get('cart_cookie_id');
            if (!$cookie_id) {
                $cookie_id = Str::uuid();
                Cookie::queue('cart_cookie_id', $cookie_id, 43200); // 1 month
            }
    
            return $cookie_id;
        });

        $this->app->bind(CartRepository::class, function($app) {
            $cookie_id = $app->make('cart.cookie_id');
            return new CartRepository($cookie_id, Auth::id());
        });

        $this->app->bind('paypal.client', function() {
            $clientId = config('services.paypal.client_id');
            $clientSecret = config('services.paypal.secret');

            $environment = new SandboxEnvironment($clientId, $clientSecret);
            return new PayPalHttpClient($environment);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        
    }
}

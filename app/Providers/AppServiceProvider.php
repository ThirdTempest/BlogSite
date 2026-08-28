<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Password::defaults(function () {
            return Password::min(10)
                ->letters()
                ->mixedCase()
                ->numbers()
                ->symbols();
        });

        // Configure SMTP transport stream options for reliable TLS/SSL delivery
        if ($this->app->bound('mail.manager')) {
            $this->app->make('mail.manager')->extend('smtp', function (array $config = []) {
                $tls = ($config['encryption'] ?? '') === 'ssl';
                $transport = new \Symfony\Component\Mailer\Transport\Smtp\EsmtpTransport(
                    $config['host'] ?? 'smtp.gmail.com',
                    $config['port'] ?? 587,
                    $tls
                );

                if (!empty($config['username'])) {
                    $transport->setUsername($config['username']);
                }

                if (!empty($config['password'])) {
                    $transport->setPassword($config['password']);
                }

                $stream = $transport->getStream();
                if ($stream instanceof \Symfony\Component\Mailer\Transport\Smtp\Stream\SocketStream) {
                    $stream->setStreamOptions([
                        'ssl' => [
                            'verify_peer' => false,
                            'verify_peer_name' => false,
                            'allow_self_signed' => true,
                        ]
                    ]);
                }

                return $transport;
            });
        }
    }
}

<?php

namespace App\Console;

use App\Rent;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            try {
                $rentsExpired = Rent::getRentsExpireds();

                Log::channel('app')->info(sprintf('Carregado %s alugueis para expiração de prazo de entrega', count($rentsExpired)));

                foreach ($rentsExpired as $rent) {
                    $rent->status = Rent::STATUS_LATE;
                    $rent->save();

                    Log::channel('app')->info('Aluguel marcado como expirado', ['aluguel' => $rent]);
                }
            } catch (\Throwable $exception) {
                Log::channel('error')->critical('Erro ao marcar aluguel como expirado',
                    [
                        'aluguel' => $rent,
                        'erro'    => $exception->getMessage()
                    ]
                );
            }
        })->everyMinute();
          //->dailyAt('00:00');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}

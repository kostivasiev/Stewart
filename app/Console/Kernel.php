<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Http\Controllers\MailController;
use App\Mail\SendMail;
use Mail;

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
          $mail_controller = new MailController();
          $mail_controller->daily_maintenance_report();
        })->dailyAt('8:00');

        // $schedule->command('inspire')
        //          ->hourly();
        // MailController::send();
        // $schedule->call(function () {
        //   Mail::send(['text' => 'emails.interval_message'], app('App\Http\Controllers\WorkorderController')->current_intervals(), function($message){
        //     $message->to("7065701630@vtext.com", 'Greg');
        //     $message->from("centralsysutah@gmail.com", 'Stewart Tech');
        //   });
        //   Mail::send(['text' => 'emails.interval_message'], app('App\Http\Controllers\WorkorderController')->current_intervals(), function($message){
        //     $message->to("4352312516@vtext.com", 'Tanner');
        //     $message->from("centralsysutah@gmail.com", 'Stewart Tech');
        //   });
        // })->dailyAt('7:00');


    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}

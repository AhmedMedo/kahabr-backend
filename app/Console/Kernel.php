<?php namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Feed;
use App\FeedService\FeedService;

class Kernel extends ConsoleKernel {
    

    //method 
	/**
	 * The Artisan commands provided by your application.
	 *
	 * @var array
	 */
	protected $commands = [
		'App\Console\Commands\Inspire',
		'App\Console\Commands\logDemo',
		'App\Console\Commands\FeedParsing',
		'App\Console\Commands\backup'
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
            $FeedService= new FeedService();
            $FeedService->number_of_feeds=Feed::count();
            $delimeter=config('khabar.Number_of_service_calls_per_day')/config('khabar.Number_of_trials');
            $Feeds_per_service_call=$FeedService->number_of_feeds/$delimeter;
            $FeedService->limit=floor($Feeds_per_service_call);
            $FeedService->grapFeeds();
        })->cron('*/15 * * * * *');
		
		//$schedule->command('backup')->dailyAt('10:00');
        
	

		
	}

}

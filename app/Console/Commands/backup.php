<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use App\BackupService\BackupService;


class backup extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'backup';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'save a backup of news you want.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		//
		 $backup=new BackupService;

		 $backup->backup_news();
        \Log::useDailyFiles(storage_path().'/backuplogs/backup.log');
        \Log::info('Backup created',PHP_EOL);



    }

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	/* protected function getArguments()
	{
		return [
			['example', InputArgument::REQUIRED, 'An example argument.'],
		];
	} */

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return [
			['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
		];
	}

}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use SebastianBergmann\CodeCoverage\Report\PHP;

class Crontab extends Command
{
	/**
	 * The name and signature of the console task.
	 *
	 * @var string
	 */
	protected $signature = 'task:cron
	                        {--l|list : Show all crontab jobs}
	                        {--a|add : Add new task to crontab}
	                        {--r|root : Add laravel root crontab}
	                        {--c|clear : Remove all crontab}
	                        {--d|delete : Remove a cron job}';

	/**
	 * The console task description.
	 *
	 * @var string
	 */
	protected $description = 'Edit crontab list';

	/**
	 * Create a new task instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Return all cron jobs
	 *
	 * @return array
	 */
	private function list()
	{
		$allCron = shell_exec('crontab -l');
		return $this->str2Array($allCron);
	}

	private function add($taskDate, $taskCommand)
	{
		$taskJob = "${taskDate} ${taskCommand}";
		$command = '( crontab -l | grep -v -F "' . $taskCommand . '" ; echo "' . $taskJob . '" ) | crontab -';
		exec($command);
	}

	private function delete($taskId)
	{
		$all = $this->list();
		$task = $all[$taskId];
		$command = '( crontab -l | grep -v -F "' . $task . '" ) | crontab -';
		exec($command);
		return !$this->checkExists($task);
	}


	private function clear()
	{
		exec('( crontab -l | grep -v -F "*" ) | crontab -');
	}

	/**
	 * Add laravel root cron jobs
	 */
	private function root()
	{
		$rootPath = base_path();
		$date = '* * * * *';
		$command = 'php ' . $rootPath. '/artisan schedule:run >> /dev/null 2>&1';
		$this->add($date, $command);
	}

	private function checkExists($task)
	{
		$lists = $this->list();
		return in_array(trim($task), $lists);
	}

	/**
	 * Convert string to array by new line character
	 *
	 * @param $str
	 * @param string $d
	 * @return array
	 */
	private function str2Array($str, $d = PHP_EOL)
	{
		$result = explode($d, $str);
		foreach ($result as $k => $v) {
			if (!$v) {
				unset($result[$k]);
			}
		}
		return $result;
	}

	private function array2Str($arr, $d = PHP_EOL)
	{
		return implode($d, $arr);
	}

	private function handleList()
	{
		$lists = $this->list();
		if (count($lists) === 0) {
			$this->info('no jobs');
			return null;
		}
		foreach ($lists as $idx => $list) {
			$this->info($idx . ': ' . $list);
		}
		return true;
	}

	private function handleAdd()
	{
		$date = $this->ask('Enter your task date');
		$command = $this->ask('Enter your task command');
		$this->add($date, $command);
	}

	private function handleClear()
	{
		if ($this->confirm("Are you sure to remove all cron jobs?")) {
			$this->clear();
			if (count($this->str2Array($this->list())) === 0) {
				$this->info('remove all cron jobs success');
			} else {
				$this->error('remove all cron jobs failed');
			}
		}
	}

	private function handleDelete()
	{
		if (count($this->list()) === 0) {
			$this->error('there are no cron jobs');
			return null;
		}
		$lists = $this->list();
		foreach ($lists as $idx => $list) {
			$this->info($idx . ': ' . $list);
		}
		$id = $this->ask("Enter the job id you want to delete");
		if (is_numeric($id) && ($id >= 0 || $id < count($lists))) {
			$result = $this->delete($id);
			if ($result) {
				$this->info('delete job success');
			} else {
				$this->info('delete job failed');
			}
			return $result;
		} else {
			$this->error('not valid id');
			return false;
		}
	}

	public function handle()
	{
		if ($this->option('list')) {
			$this->handleList();
			return;
		}
		if ($this->option('add')) {
			$this->handleAdd();
			return;
		}
		if ($this->option('root')) {
			$this->root();
			return;
		}
		if ($this->option('clear')) {
			$this->clear();
			return;
		}
		if ($this->option('delete')) {
			$this->handleDelete();
			return;
		}

		$this->error('check your option');
	}
}
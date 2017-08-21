<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Mail;
use App\Mail\DailyReport;
use App\Models\Task;
use App\Models\TaskMail;

class SendEmails extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'email:send';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Send email';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}


	public function handle()
	{
		$emailTasks = Task::where('task_type', 2)->get()->toArray();
		foreach ($emailTasks as $task) {
			$taskId = $task['id'];
			$emails = TaskMail::find($taskId);
			if ($emails) {
				$emails = $emails->toArray();
				$to = explode(',', $emails['to']);
				$cc = explode(',', $emails['cc']);
				$bcc = explode(',', $emails['bcc']);
				Mail::to($to)->cc($cc)->bcc($bcc)->send(new DailyReport());
			}
		}
	}
}

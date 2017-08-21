<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class DailyReport extends Mailable
{
	use Queueable, SerializesModels;

	public $name;
	private $age;

	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->name = 'Remfath Chan';
		$this->age = 20;
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build()
	{
		return $this->view('emails.daily_report')->with([
			'age' => $this->age,
		])->attach(storage_path('attachments/info.txt'), [
			'as'   => 'my_info.txt',
			'mime' => 'application/txt',
		]);
	}
}

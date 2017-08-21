<?php

$email = [
	'title'   => 'hello',
	'content' => 'this is a test email',
	'attach'  => '/home/remfath/Code/Project/task-schedule/storage/scripts/attach.txt',
];

echo json_encode($email);
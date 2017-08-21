<?php

namespace App\Services;

use App\Models\TaskLog as TLog;

class TaskLog {
    static public function log($logArray) {
        $logKeys = ['task_id', 'task_output', 'task_error', 'task_run_status', 'task_start_time', 'task_end_time'];
        $final = [];
        foreach ($logArray as $k => $v) {
            if(in_array($k, $logKeys)) {
                $final[$k] = $v;
            }
        }

        $log = new TLog();
        foreach ($final as $k => $v) {
            $log->$k = $v;
        }
        $log->save();
    }
}
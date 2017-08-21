<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Mockery\Exception;
use App\Services\TaskLog as TLog;
use App\Models\TaskLog;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use SebastianBergmann\CodeCoverage\Report\PHP;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $isDeleted = $request->is_deleted === 'y';
        if($isDeleted) {
            $tasks = Task::onlyTrashed()->get();
        } else {
            $tasks = Task::all();
        }

        $result = [];
        foreach ($tasks as $task) {
            $item = $task->toArray();

            $user = $task->user;
            $item['user'] = $user ? $user->toArray() : null;

            $mails = $task->mails;
            $item['mails'] = $mails ? $mails->toArray() : null;

            $phones = $task->phones;
            $item['phones'] = $phones ? $phones->toArray() : null;

            $server = $task->server;
            $item['server'] = $server ? $server->toArray() : null;

            $group = $task->group;
            $item['group'] = $group ? $group->toArray() : null;

            $result[] = $item;
        }
        return json_encode($result);
    }

    public function run($taskId)
    {
        $taskInfo = Task::withTrashed()->find($taskId)->toArray();
        $taskLang = $taskInfo['task_lang'];
        $commandType = $taskInfo['commend_type'];
        $taskCommand = $taskInfo['task_command'];
        $result = $taskInfo;
        $runResult = $this->runCommand($taskLang, $commandType, $taskCommand);
        $result = array_merge($result, $runResult);
        $result['task_id'] = $taskId;
        TLog::log($result);
        return json_encode($result);
    }

    private function runCommand($lang, $type, $command)
    {
        $result = [
            'task_start_time' => date('Y-m-d h:i:s'),
        ];
        $lang = strtolower(trim($lang));
        $realCommand = $this->getRealCommand($lang, $type, $command);
        exec($realCommand, $output, $return);
        if ($return === 0) {
            $runResult = [
                'task_output'     => json_encode($output),
                'task_error'      => '',
                'task_run_status' => 0,
                'real_command'    => $realCommand,
            ];
        } else {
            $runResult = [
                'task_output'     => '',
                'task_error'      => json_encode($output),
                'task_run_status' => -1,
                'real_command'    => $realCommand,
            ];
        }
        $result = array_merge($result, $runResult);
        $result['task_end_time'] = date('Y-m-d h:i:s');
        return $result;
    }

    private function getRealCommand($lang, $type, $command)
    {
        $realCommand = '';
        if ($lang === 'php') {
            $realCommand = $this->getPhpRealCommand($type, $command);
        }
        if ($lang === 'python') {
            $realCommand = $this->getPythonRealCommand($type, $command);
        }
        if ($lang === 'bash') {
            $realCommand = $this->getBashRealCommand($type, $command);
        }
        return $realCommand;
    }

    private function getBashRealCommand($type, $command)
    {
        $realCommand = '';
        if ($type === 'file') {
            $realCommand = 'bash ' . $command;
        }
        if ($type === 'command') {
            $realCommand = $command;
        }
    
        return $realCommand;
    }

    private function getPythonRealCommand($type, $command)
    {
        $realCommand = '';
        if ($type === 'file') {
            $realCommand = 'python ' . $command;
        }
        if ($type === 'command') {
            $realCommand = "python -c '$command'";
        }
        return $realCommand;
    }

    private function getPhpRealCommand($type, $command)
    {
        $realCommand = '';

        if ($type === 'file') {
            $realCommand = "php " . $command;
        }
        if ($type === 'command') {
            $realCommand = "php -r '$command'";
        }
        return $realCommand;
    }

    public function getLogs($taskId = '')
    {
        if ($taskId) {
            $logs = TaskLog::withTrashed()->where('task_id', $taskId)->orderBy('task_start_time', 'desc')->get();
        } else {
            $logs = TaskLog::where('task_start_time', '>=', date('Y-m-d', strtotime('today')))->orderBy('task_start_time', 'desc')->get();
        }

        foreach ($logs as $k => $v) {
            $taskId = $v->task_id;
            $logs[$k]['task_title'] = Task::withTrashed()->find($taskId)->task_title;
        }

        return $logs->toJson();
    }

    public function getSystemSummary()
    {
        $today = date('Y-m-d');
        $allTotalCount = TaskLog::count();
        $allFailedCount = TaskLog::where('task_run_status', -1)->count();
        $todayTotalCount = TaskLog::whereDate('task_start_time', $today)->count();
        $todayFailedCount = TaskLog::whereDate('task_start_time', $today)->where('task_run_status', -1)->count();

        $result = [
            'all_total_count'    => $allTotalCount,
            'all_failed_count'   => $allFailedCount,
            'today_total_count'  => $todayTotalCount,
            'today_failed_count' => $todayFailedCount,
        ];
        return json_encode($result);
    }

    public function getTaskSummary()
    {
        $endAt = date('Y-m-d');
        $startAt = date('Y-m-d', strtotime($endAt . ' -6day'));

        $result = TaskLog::select(
            DB::raw('date(task_start_time) as task_date'),
            'task_run_status as task_status',
            DB::raw('COUNT(*) as task_count'))
            ->whereDate('task_start_time', '>=', $startAt)
            ->whereDate('task_start_time', '<=', $endAt)
            ->groupBy('task_date', 'task_status')
            ->get();

        $result = $result->groupBy('task_date')->toArray();
        $final = [];
        foreach ($result as $date => $item) {
            $date = date('Y-m-d', strtotime($date));
            $content = [
                'success_count' => 0,
                'failed_count'  => 0,
            ];
            if (count($item) > 0) {
                foreach ($item as $k => $v) {
                    $status = $v['task_status'] === 0 ? 'success_count' : 'failed_count';
                    $content[$status] = $v['task_count'];
                }
            }
            $final[$date] = $content;
        }

        $formatted = [];
        $st = strtotime($startAt);
        $et = strtotime($endAt);
        for ($dt = $st; $dt <= $et; $dt += 86400) {
            $date = date('Y-m-d', $dt);
            $content = [
                'success_count' => 0,
                'failed_count'  => 0,
            ];
            if (array_key_exists($date, $final)) {
                $content = $final[$date];
            }
            $content['total_count'] = $content['success_count'] + $content['failed_count'];
            $formatted[$date] = $content;
        }
        return json_encode($formatted);
    }

    public function updateTask($taskId, Request $request) {
        $fields = $request->fields;
        $result = Task::where('id', $taskId)->update($fields);
        return $result;
    }

    public function deleteTask($taskId, Request $request) {
        $isDeleted = $request->is_deleted === 'y';
        $task = Task::withTrashed()->find($taskId);

        if($isDeleted) {
            //$result = Task::where('id', $taskId)->forceDelete($taskId);
            $result = $task->forceDelete();
            $task->mails()->forceDelete();
            $task->phones()->forceDelete();
            $task->logs()->forceDelete();
        } else {
            //$result = Task::destroy($taskId);
            $result = $task->delete();
            $task->mails()->delete();
            $task->phones()->delete();
            $task->logs()->delete();
        }
        return (int)$result;
    }

    public function addTask(Request $request) {
        $task = $request->task;
        try {
            Task::create($task);
            return 1;
        } catch(Exception $e) {
            return -1;
        }
    }

    public function restoreTask($taskId) {
        $task = Task::withTrashed()->find($taskId);
        $task->restore();
        $task->mails()->restore();
        $task->phones()->restore();
        $task->logs()->restore();
        //Task::where('id', $taskId)->restore();
    }
}

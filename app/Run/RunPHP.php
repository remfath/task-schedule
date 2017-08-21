<?php
/**
 * Created by PhpStorm.
 * User: remfath
 * Date: 2017/8/3
 * Time: 22:48
 */

namespace App\Run;

class RunPHP implements IRun
{
    public function runFile($file)
    {
        return 'php ' . $file;
    }

    public function runCommand($command)
    {
        return 'php -r ' . $command;
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: remfath
 * Date: 2017/8/3
 * Time: 22:45
 */

namespace App\Run;

class RunPython implements IRun
{
    public function runCommand($command)
    {
        return 'python -c ' . $command;
    }

    public function runFile($file)
    {
        return 'python ' . $file;
    }
}
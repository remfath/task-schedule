<?php
/**
 * Created by PhpStorm.
 * User: remfath
 * Date: 2017/8/3
 * Time: 22:44
 */
namespace App\Run;

interface IRun {
    public function runCommand($command);
    public function runFile($file);
}
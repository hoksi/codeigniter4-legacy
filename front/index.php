<?php
define('CI_DEBUG', true);
require_once('../core/fran.php');

echo qb()
    ->select('*')
    ->from('test')
    ->toStr();

echo "\n";

echo qb()
    ->delete('test')
    ->where('id', 1)
    ->limit(10)
    ->toStr();
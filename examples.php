<?php

require_once __DIR__ . '/functions.php';

$pid = 4;

$info = getAffiliateLink($pid);

if (empty($info)) {
    echo 'nothing found', PHP_EOL;
    exit;
}

echo $info['target'], PHP_EOL;

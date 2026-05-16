<?php
require 'vendor/autoload.php';
$logPath = __DIR__ . '/storage/logs/test2.log';
$cmd = "echo 'hello world' > " . escapeshellarg($logPath) . " 2>&1 &";
echo "Executing: $cmd\n";
\Symfony\Component\Process\Process::fromShellCommandline($cmd)->run();

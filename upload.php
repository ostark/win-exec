<?php

require 'vendor/autoload.php';

$remote = 'async@deploy.eu2.frbit.com';
$src    = $target = 'transfer.txt';

echo 'DIRECTORY_SEPARATOR: ' . DIRECTORY_SEPARATOR . PHP_EOL;

file_put_contents($src, '1' . PHP_EOL . '2' . PHP_EOL . '3');

$commands = [
    'string_double_quotes' => 'cat ' . $src . ' | gzip | ssh ' . $remote . ' "zcat > ' . $target . '"',
    'string_single_quotes' => "cat {$src} | gzip | ssh {$remote} 'zcat > {$target}'",
];


foreach ($commands as $name => $cmd) {

    $process = new \Symfony\Component\Process\Process($cmd);

    var_dump([
        'info'           => $name,
        'cmd'            => $cmd,
        'getCommandLine' => $process->getCommandLine()
    ]);

    $process->run();

    if ($process->isSuccessful()) {
        echo 'SUCCESS:' . $process->getOutput();
    } else {
        echo 'ERR: ' . $process->getErrorOutput();
    }

    echo PHP_EOL . PHP_EOL;

}





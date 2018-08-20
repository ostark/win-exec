<?php

require 'vendor/autoload.php';

$remote = 'async@deploy.eu2.frbit.com';
$src    = $target = 'transfer.txt';

echo 'DIRECTORY_SEPARATOR: ' . DIRECTORY_SEPARATOR . PHP_EOL;

$commands = [
    'string_double_quotes' => 'ssh ' . $remote . ' "cat ' . $src . ' | gzip" | zcat > ' . $target,
    'string_single_quotes' => "ssh {$remote} 'cat {$src} | gzip' | zcat > {$target}"
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

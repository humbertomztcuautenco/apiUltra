<?php
$base = __DIR__ . '/';

$folders = [
    'Config',
    'Controllers',
    'Lib',
    'Middleware',
    'Models',
    'Routes'
];

foreach($folders as $f)
{
    foreach (glob($base . "$f/*.php") as $k => $filename)
    {
        require $filename;
    }
}


<?php

// autoloader
require '../vendor/autoload.php';

// config
$config = array(
    'titles' => array('Mister', 'Mr', 'Misses', 'Mrs', 'Miss', 'Ms'),
    'altTitles' => array('Mister' => 'Mr', 'Misses' => 'Mrs', 'Miss' => 'Ms'),
);

// Initiate command
$command = new Commando\Command();

// Define first option
$command->option()
    ->require()
    ->describedAs('A person\'s name');

// Define a flag "-t" a.k.a. "--title"
$command->option('t')
    ->aka('title')
    ->describedAs('When set, use this title to address the person')
    ->must(function($title) use ($config) {
        return in_array($title, $config['titles']);
    })
    ->map(function($title) use ($config) {
        if (array_key_exists($title, $config['altTitles'])) {
            $title = $config['altTitles'][$title];
        }
        return "$title. ";
    });

// Define a boolean flag "-c" aka "--capitalize"
$command->option('c')
    ->aka('capitalize')
    ->aka('cap')
    ->describedAs('Always capitalize the words in a name')
    ->boolean();

$name = $command['capitalize'] ? ucwords($command[0]) : $command[0];

echo "Hello {$command['title']}$name!", PHP_EOL;

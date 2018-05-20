<?php

require __DIR__.'/vendor/autoload.php';
require __DIR__.'/Command/CreateTableCommand.php';
require __DIR__.'/Command/UpdateUsersCommand.php';

use Symfony\Component\Console\Application;
use App\Command\CreateTableCommand;
use App\Command\UpdateUsersCommand;

$application = new Application();
$application->add(new CreateTableCommand());
$application->add(new UpdateUsersCommand());
$application->run();
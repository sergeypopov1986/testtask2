<?php
namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Medoo\Medoo;

class CreateTableCommand extends Command
{
    private $DB;
    protected function configure()
    {
        $this->DB = new Medoo([
            'database_type' => 'mysql',
            'database_name' => 'test_db',
            'server' => 'localhost',
            'username' => 'root',
            'password' => ''
        ]);

        $this
        ->setName('app:create-table')
        ->setDescription('Creates a new table.')
        ->setHelp('Install');
    }
 
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            'Создание таблицы...',
            '============',
            '',
        ]);

        $this->DB->query("CREATE TABLE `user` (
          `github_id` int(11) UNSIGNED NOT NULL,
          `github_login` varchar(255) NOT NULL,
          PRIMARY KEY (github_id)
        ) ENGINE=InnoDB;");

        $output->write('Создано!');
    }
}
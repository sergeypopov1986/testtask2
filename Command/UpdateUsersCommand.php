<?php
namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Medoo\Medoo;
use GuzzleHttp\Client as GuzzleClient;

class UpdateUsersCommand extends Command
{
    private $DB;
    private $HttpClient;

    protected function configure()
    {
        $this->DB = new Medoo([
            'database_type' => 'mysql',
            'database_name' => 'test_db',
            'server' => 'localhost',
            'username' => 'root',
            'password' => ''
        ]);


        $this->HttpClient = new GuzzleClient();
        //$res = $client->request('GET', 'https://api.github.com/users');


        $this
        ->setName('app:update-users')
        ->setDescription('Update users')
        ->setHelp('');
    }
 
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $usersJson = $this->HttpClient->request('GET', 'https://api.github.com/users');
        $users = json_decode($usersJson->getBody());
        $dataForInsert = [];
        foreach ($users as $user) {
            $is_exist_record = $this->DB->count("user" , ["github_id" => $user->id]);
            if($is_exist_record){
                $this->DB->update('user' , ['github_login' => $user->login] , ["github_id" => $user->id]);
            }else{
                $dataForInsert = [
                    'github_id' => $user->id,
                    'github_login' => $user->login
                ];
                $this->DB->insert('user' , $dataForInsert);
            }
        }
        $output->writeln([
            'Готово'
        ]);
    }
}
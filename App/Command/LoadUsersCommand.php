<?php

namespace App\Command;

use App\Service\ServiceContainer;
use App\Service\UserFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class LoadUsersCommand extends Command
{

    private $userFactory;

    public function __construct($name = null, UserFactory $userFactory)
    {
        parent::__construct($name);
        $this->userFactory = $userFactory;
    }

    protected function configure()
    {
        $this
            ->setName('app:load-users')
            ->setDescription('Add users to the elasticsearch database')
            ->setHelp('I can\'t help you :(')
            ->addOption('number', null, InputOption::VALUE_OPTIONAL, 'Number of users to load')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $nb_users = 10;
        if( null !== $option = $input->getOption('number') ){
            $nb_users = intval($option);
        }

        try {
            $output->writeln('<info>'.$this->userFactory->loadUsers($nb_users). ' users have been add to the database'.'</info>');
        } catch (\Exception $e) {
            $output->writeln('<error>'. $e->getMessage() .'</error>');
        }
    }

}
<?php

namespace AdminBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Objects\PapziBundle\Entity\Chain;

/**
 * Insert all Chains from Chains.xml to Chains table
 *
 * @author samar
 */
class RequestCommand extends ContainerAwareCommand {

    protected function configure() {
        parent::configure();
        //Defining the name of command, its description and its argument
        $this->setName('Request:Check')
                ->setDescription('Check for rquest time');
    }

    /**
     * Executes the current command.
     *
     * @param InputInterface  $input  An InputInterface instance
     * @param OutputInterface $output An OutputInterface instance
     */
    protected function execute(InputInterface $input, OutputInterface $output) {
        $manager = $this->getContainer()->get('doctrine')->getEntityManager();
        //get an object of chainRepository
        $requestRepo = $manager->getRepository("KitchenBundle:Request");
        
        //get before 1 hr time requests
        $time = new \DateTime();
        $time->modify('-1 hour');
        
        $requestRepo->checkRequests($time);
        
        $output->writeln("Done");
    }

}

?>

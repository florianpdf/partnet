<?php

// src/GedBundle/Command/CleanUpCommand.php
/**
 * Created by PhpStorm.
 * User: romain
 * Date: 01/12/15
 * Time: 15:22
 */

namespace GedBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use GedBundle\Entity\Documents;

class CleanUpCommand extends ContainerAwareCommand {

    protected function configure()
    {
        $this
            ->setName('partnet:ged:cleanup')
            ->setDescription('Cleanup GedBundle database')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getEntityManager();
        $oldDocuments = $em->getRepository('GedBundle:Documents')->findByOld();

        foreach ($oldDocuments as $oldDocument) {
            $em->remove($oldDocument);
        }

        $em->flush();


        $output->writeln(sprintf('Removed %d documents', count($oldDocuments)));
    }
}
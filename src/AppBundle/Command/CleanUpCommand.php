<?php

// src/GedBundle/Command/CleanUpCommand.php
/**
 * Created by PhpStorm.
 * User: romain
 * Date: 01/12/15
 * Time: 15:22
 */

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use GedBundle\Entity\Documents;
use AgendaBundle\Entity\Events;

class CleanUpCommand extends ContainerAwareCommand {

    protected function configure()
    {
        $this
            ->setName('partnet:cleanup')
            ->setDescription('Cleanup old docs and events from database')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getEntityManager();
        $oldDocuments = $em->getRepository('GedBundle:Documents')->findByOld();
        $oldEvents = $em->getRepository('AgendaBundle:Events')->findByOld();

        foreach ($oldDocuments as $oldDocument) {
            $em->remove($oldDocument);
        }

        foreach ($oldEvents as $oldEvent) {
            $em->remove($oldEvent);
        }

        $em->flush();
        $output->writeln(sprintf('Removed %d documents and %s events', count($oldDocuments), count($oldEvents)));
    }
}
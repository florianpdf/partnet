<?php

namespace MsgBundle\Entity;

/**
 * MessageRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class MessageRepository extends \Doctrine\ORM\EntityRepository
{
   /* public function findByIdRecipient($id_recipient)
    {
        // Selection par ID recipient trier par date
        return $this->getEntityManager()
            ->createQuery(
                'SELECT p FROM MsgBundle:Message p WHERE p.id_recipient = :recipient ORDER BY p.date ASC'
            )->setParameter('recipient', $id_recipient)
            ->getResult();
    }*/

    public function findByNomRecipient($nom_recipient)
    {
        // Selection par ID recipient trier par date
        return $this->getEntityManager()
            ->createQuery(
                'SELECT p FROM MsgBundle:Message p WHERE p.recipient = :name ORDER BY p.date ASC'
            )->setParameter('name', $nom_recipient)
            ->getResult();
    }

    public function findByNomSender($nom_sender)
    {
        // Selection par ID recipient trier par date
        return $this->getEntityManager()
            ->createQuery(
                'SELECT p FROM MsgBundle:Message p WHERE p.sender = :name ORDER BY p.date ASC'
            )->setParameter('name', $nom_sender)
            ->getResult();
    }

}
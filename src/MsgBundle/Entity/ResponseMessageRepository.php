<?php

namespace MsgBundle\Entity;


class ResponseMessageRepository extends \Doctrine\ORM\EntityRepository
{

    public function findByIdMessage($id_message)
    {
        // Selection par ID message
        return $this->getEntityManager()
            ->createQuery(
                'SELECT p FROM MsgBundle:ResponseMessage p WHERE p.id_message = :id_message'
            )->setParameter('id_message', $id_message)
            ->getResult();
    }


}

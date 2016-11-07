<?php

namespace AppBundle\Manager;
    
abstract class BaseManager
{
    /**
     * execute persit and flush method for the given entity
     * @param $entity
     */
    protected function persistAndFlush($entity)
    {
        $this->em->persist($entity);
        $this->em->flush();
    }

    /**
     * execute persit and flush method for the given entity
     * @param $entity
     */
    protected function removeAndFlush($entity)
    {
        $this->em->remove($entity);
        $this->em->flush();
    }
}
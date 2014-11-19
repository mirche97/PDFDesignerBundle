<?php

namespace Shopline\Bundle\DesignerBundle\Entity\Provider;

use Doctrine\ORM\EntityManager;
use Shopline\Bundle\DesignerBundle\Entity\DesignerOwnerInterface;

/**
 * Defines an interface of an designer owner provider
 */
interface DesignerOwnerProviderInterface
{
    /**
     * Get full name of designer owner class
     *
     * @return string
     */
    public function getDesignerOwnerClass();

    /**
     * Find an entity object which is an owner of the given designer address
     *
     * @param \Doctrine\ORM\EntityManager $em
     * @param string $designer
     * @return DesignerOwnerInterface
     */
    public function findDesignerOwner(EntityManager $em, $designer);
}

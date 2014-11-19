<?php

namespace Shopline\Bundle\PDFDesignerBundle\Entity\Provider;

use Doctrine\ORM\EntityManager;
use Shopline\Bundle\PDFDesignerBundle\Entity\DesignerOwnerInterface;

/**
 * Designer owner provider chain
 */
class DesignerOwnerProvider
{
    /**
     * @var DesignerOwnerProviderStorage
     */
    private $designerOwnerProviderStorage;

    /**
     * Constructor
     *
     * @param DesignerOwnerProviderStorage $designerOwnerProviderStorage
     */
    public function __construct(DesignerOwnerProviderStorage $designerOwnerProviderStorage)
    {
        $this->designerOwnerProviderStorage = $designerOwnerProviderStorage;
    }

    /**
     * Find an entity object which is an owner of the given designer address
     *
     * @param \Doctrine\ORM\EntityManager $em
     * @param string $designer
     * @return DesignerOwnerInterface
     */
    public function findDesignerOwner(EntityManager $em, $designer)
    {
        $designerOwner = null;
        foreach ($this->designerOwnerProviderStorage->getProviders() as $provider) {
            $designerOwner = $provider->findDesignerOwner($em, $designer);
            if ($designerOwner !== null) {
                break;
            }
        }

        return $designerOwner;
    }
}

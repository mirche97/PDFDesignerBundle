<?php

namespace Shopline\Bundle\PDFDesignerBundle\Entity\Provider;

/**
 * A storage of designer owner providers
 */
class DesignerOwnerProviderStorage
{
    /**
     * @var DesignerOwnerProviderInterface[]
     */
    private $designerOwnerProvider = array();

    /**
     * Add designer owner provider
     *
     * @param DesignerOwnerProviderInterface $provider
     */
    public function addProvider(DesignerOwnerProviderInterface $provider)
    {
        $this->designerOwnerProvider[] = $provider;
    }

    /**
     * Get all designer owner providers
     *
     * @return DesignerOwnerProviderInterface[]
     */
    public function getProviders()
    {
        return $this->designerOwnerProvider;
    }

    /**
     * Gets field name for designer owner for the given provider
     *
     * @param DesignerOwnerProviderInterface $provider
     * @return string
     * @throws \RuntimeException
     */
    public function getDesignerOwnerFieldName(DesignerOwnerProviderInterface $provider)
    {
        $key = 0;
        for ($i = 0, $size = count($this->designerOwnerProvider); $i < $size; $i++) {
            if ($this->designerOwnerProvider[$i] === $provider) {
                $key = $i + 1;
                break;
            }
        }

        if ($key === 0) {
            throw new \RuntimeException(
                'The provider for "%s" must be registers in DesignerOwnerProviderStorage',
                $provider->getDesignerOwnerClass()
            );
        }

        return sprintf('owner%d', $key);
    }

    /**
     * Gets column name for designer owner for the given provider
     *
     * @param DesignerOwnerProviderInterface $provider
     * @return string
     */
    public function getDesignerOwnerColumnName(DesignerOwnerProviderInterface $provider)
    {
        $designerOwnerClass = $provider->getDesignerOwnerClass();
        $prefix = strtolower(substr($designerOwnerClass, 0, strpos($designerOwnerClass, '\\')));
        if ($prefix === 'oro' || $prefix === 'orocrm') {
            // do not use prefix if designer's owner is a part of BAP and CRM
            $prefix = '';
        } else {
            $prefix .= '_';
        }
        $suffix = strtolower(substr($designerOwnerClass, strrpos($designerOwnerClass, '\\') + 1));

        return sprintf('owner_%s%s_id', $prefix, $suffix);
    }
}

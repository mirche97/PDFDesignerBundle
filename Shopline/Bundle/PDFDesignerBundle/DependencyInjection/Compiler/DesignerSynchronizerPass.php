<?php

namespace Shopline\Bundle\PDFDesignerBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class DesignerSynchronizerPass implements CompilerPassInterface
{
    const SERVICE_KEY = 'shopline.designer_synchronization_manager';
    const TAG         = 'shopline.designer_synchronizer';

    /**
     * {@inheritDoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition(self::SERVICE_KEY)) {
            return;
        }

        $selectorDef    = $container->getDefinition(self::SERVICE_KEY);
        $taggedServices = $container->findTaggedServiceIds(self::TAG);
        foreach ($taggedServices as $synchronizerServiceId => $tagAttributes) {
            $selectorDef->addMethodCall('addSynchronizer', array($synchronizerServiceId));
        }
    }
}

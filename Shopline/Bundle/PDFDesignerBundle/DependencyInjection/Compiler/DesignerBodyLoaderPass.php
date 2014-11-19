<?php

namespace Shopline\Bundle\PDFDesignerBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class DesignerBodyLoaderPass implements CompilerPassInterface
{
    const SERVICE_KEY = 'shopline.designer_body_loader_selector';
    const TAG = 'shopline.designer_loader';

    /**
     * {@inheritDoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition(self::SERVICE_KEY)) {
            return;
        }

        $selectorDef = $container->getDefinition(self::SERVICE_KEY);
        $taggedServices = $container->findTaggedServiceIds(self::TAG);
        foreach ($taggedServices as $loaderServiceId => $tagAttributes) {
            $selectorDef->addMethodCall('addLoader', array(new Reference($loaderServiceId)));
        }
    }
}

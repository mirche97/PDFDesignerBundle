<?php

namespace Shopline\Bundle\PDFDesignerBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class DesignerOwnerConfigurationPass implements CompilerPassInterface
{
    const SERVICE_KEY = 'shopline.designer.owner.provider.storage';
    const TAG = 'shopline.owner.provider';

    /**
     * {@inheritDoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition(self::SERVICE_KEY)) {
            return;
        }
        $storageDefinition = $container->getDefinition(self::SERVICE_KEY);

        $providers = $this->loadProviders($container);
        foreach ($providers as $providerServiceId) {
            $storageDefinition->addMethodCall('addProvider', array(new Reference($providerServiceId)));
        }

        $this->setDesignerAddressEntityResolver($container);
    }

    /**
     * Load services implements an designer owner providers
     *
     * @param ContainerBuilder $container
     * @return array
     */
    protected function loadProviders(ContainerBuilder $container)
    {
        $taggedServices = $container->findTaggedServiceIds(self::TAG);
        $providers = array();
        foreach ($taggedServices as $id => $tagAttributes) {
            $order = PHP_INT_MAX;
            foreach ($tagAttributes as $attributes) {
                if (!empty($attributes['order'])) {
                    $order = (int)$attributes['order'];
                    break;
                }
            }
            $providers[$order] = $id;
        }
        ksort($providers);

        return $providers;
    }

    /**
     * Register a proxy of DesignerAddress entity in doctrine ORM
     *
     * @param ContainerBuilder $container
     */
    protected function setDesignerAddressEntityResolver(ContainerBuilder $container)
    {
        if ($container->hasDefinition('doctrine.orm.listeners.resolve_target_entity')) {
            $targetEntityResolver = $container->getDefinition('doctrine.orm.listeners.resolve_target_entity');
            $targetEntityResolver->addMethodCall(
                'addResolveTargetEntity',
                array(
                    'Shopline\Bundle\DesignerBundle\Entity\DesignerAddress',
                    sprintf('%s\DesignerAddressProxy', $container->getParameter('shopline.entity.cache_namespace')),
                    array()
                )
            );
        }
    }
}

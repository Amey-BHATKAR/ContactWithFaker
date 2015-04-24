<?php

namespace Adipsys\testBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class AdipsystestExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
        
        $i = 0;
        foreach ($config['entities'] as $class => $params) {
        	$number = isset($params['number']) ? $params['number'] : 5;
        
        	switch ($config['orm']) {
        		case 'propel':
        			$container
        			->register('faker.entities.' . $i)
        			->setClass($container->getParameter('faker.entity.class'))
        			->setArguments(array($class))
        			;
        			break;
        
        		case 'doctrine':
        			$container
        			->register('faker.entities.'.$i.'.metadata')
        			->setFactoryService('doctrine.orm.entity_manager')
        			->setFactoryMethod('getClassMetadata')
        			->setClass('Doctrine\ORM\Mapping\ClassMetadata')
        			->setArguments(array($class))
        			;
        
        			$container
        			->register('faker.entities.'.$i)
        			->setClass($container->getParameter('faker.entity.class'))
        			->setArguments(array(new Reference('faker.entities.' . $i . '.metadata')))
        			;
        			break;
        
        		case 'mandango':
        			$container
        			->register('faker.entities.'.$i)
        			->setClass($container->getParameter('faker.entity.class'))
        			->setArguments(array($class))
        			;
        			break;
        	}
        
        	$formatters = array();
        	if (isset($params['custom_formatters'])) {
        		$j = 0;
        		foreach ($params['custom_formatters'] as $column => $formatter) {
        			$method = $formatter['method'];
        			$parameters = $formatter['parameters'];
        			$unique = $formatter['unique'];
        			$optional = $formatter['optional'];
        
        			if (null === $method) {
        				$formatters[$column] = null;
        			} else {
        				$container->setDefinition('faker.entities.' . $i . '.formatters.' . $j, new Definition(
        						'closure',
        						array(new Reference('faker.generator'), $method, $parameters, $unique, $optional)
        				))->setFactoryService(
        						'faker.formatter_factory'
        				)->setFactoryMethod(
        						'createClosure'
        				);
        
        				$formatters[$column] = new Reference('faker.entities.' . $i . '.formatters.' . $j);
        				$j++;
        			}
        		}
        	}
        
        	$customModifiers = array();
        	if (isset($params['custom_modifiers'])) {
        		$j = 0;
        		foreach ($params['custom_modifiers'] as $methodName => $arguments) {
        			foreach ($arguments as $key => $formatter) {
        				$method = $formatter['method'];
        				$parameters = $formatter['parameters'];
        
        				if (null === $method) {
        					$customModifiers[$methodName][$key] = null;
        				} else {
        					$container->setDefinition('faker.entities.' . $i . '.formatters.' . $j, new Definition(
        							'closure',
        							array(new Reference('faker.generator'), $method, $parameters)
        					))->setFactoryService(
        							'faker.formatter_factory'
        					)->setFactoryMethod(
        							'createClosure'
        					);
        
        					$customModifiers[$methodName][$key] = new Reference('faker.entities.' . $i . '.formatters.' . $j);
        				}
        				$j++;
        			}
        		}
        	}
        
        	$definition = $container->getDefinition('faker.populator');
        	switch ($config['orm']) {
        		case 'doctrine':
        			$definition->addMethodCall('addEntity', array(new Reference('faker.entities.' . $i), $number, $formatters, $customModifiers, $params['generate_id']));
        			break;
        		default:
        			$definition->addMethodCall('addEntity', array(new Reference('faker.entities.' . $i), $number, $formatters));
        			break;
        	}
        
        	$i++;
        }
    }
}

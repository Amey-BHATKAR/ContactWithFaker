<?php

namespace Adipsys\testBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('adipsystest');

        $rootNode
        ->beforeNormalization()
        ->always(function ($v) {
        	if (isset($v['orm'])) {
        		$v['orm'] = strtolower($v['orm']);
        	}
        
        	return $v;
        })
        ->end()
        ->children()
        	->scalarNode('orm')
        		->defaultValue('propel')
        		->validate()
        			->ifNotInArray(array('doctrine', 'propel', 'mandango'))->thenInvalid('"orm" must be one of ("doctrine", "propel", "mandango")')
        		->end()
        	->end()
        	->arrayNode('entities')
        		->useAttributeAsKey('name')
        		->prototype('array')
        		->children()
        			->scalarNode('class')->end()
        			->scalarNode('number')->end()
        			->booleanNode('generate_id')
        				->defaultFalse()->end()
        			->arrayNode('custom_formatters')
        				->useAttributeAsKey('column')
        				->prototype('array')
        				->children()
        					->scalarNode('method')->end()
        					->arrayNode('parameters')
        						->prototype('variable')->end()
        					->end()
        					->booleanNode('unique')->defaultFalse()->end()
        					->scalarNode('optional')->defaultNull()->end()
        				->end()
        			->end()
        		->end()
        		->arrayNode('custom_modifiers')
        			->useAttributeAsKey('method')
        			->prototype('variable')
        		->end()
        	->end()
        	->end()
        ;
        
        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.

        return $treeBuilder;
    }
}

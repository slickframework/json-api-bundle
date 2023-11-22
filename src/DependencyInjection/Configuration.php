<?php

/**
 * This file is part of JsonAPI-Bundle
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Slick\JsonApiBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Configuration
 *
 * @package Slick\JsonApiBundle\DependencyInjection
 */
final class Configuration implements ConfigurationInterface
{

    /**
     * @inheritDoc
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('json_api');

        $treeBuilder->getRootNode()
            ->children()
                ->scalarNode('version')
                    ->info('The version set on JSON API document. See https://jsonapi.org/format/#document-jsonapi-object')
                    ->defaultValue('1.1')
                ->end()
                ->scalarNode('server_url')
                    ->info("The server name used in all links exposed in the JSON API document.")
                    ->defaultValue('http://localhost')
                ->end()
            ->end();

        return $treeBuilder;

    }
}

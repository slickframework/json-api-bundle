<?php

/**
 * This file is part of JsonAPI-Bundle
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Slick\JsonApiBundle;


use Slick\JsonApiBundle\DependencyInjection\SlickJsonApiExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

/**
 * JsonApiBundle
 *
 * @package Slick\JsonApiBundle
 */
class SlickJsonApiBundle extends AbstractBundle
{
    public function getContainerExtension(): ?ExtensionInterface
    {
        return new SlickJsonApiExtension();
    }

}

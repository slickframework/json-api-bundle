<?php

/**
 * This file is part of JsonAPI-Bundle
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Slick\JsonApiBundle\EventSubscriber;

use Slick\JSONAPI\Document\DocumentDecoder;
use Slick\JSONAPI\Document\HttpMessageParserInterface;
use Symfony\Bridge\PsrHttpMessage\HttpMessageFactoryInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;

/**
 * KernelRequestListener
 *
 * @package Slick\JsonApiBundle\EventSubscriber
 */
final class KernelRequestListener
{

    /**
     * Creates a KernelRequestListener
     *
     * @param DocumentDecoder $decoder
     * @param HttpMessageParserInterface $parser
     * @param HttpMessageFactoryInterface $messageFactory
     */
    public function __construct(
        private readonly DocumentDecoder $decoder,
        private readonly HttpMessageParserInterface $parser,
        private readonly HttpMessageFactoryInterface $messageFactory
    ) {
    }

    /**
     * Handles Symfony kernel request event
     *
     * @param RequestEvent $event
     * @return void
     */
    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $this->messageFactory->createRequest($event->getRequest());
        if (str_contains($request->getHeaderLine('content-type'), 'application/vnd.api+json')) {
            $this->decoder->setRequestedDocument($this->parser->parse($request));
        }
    }
}

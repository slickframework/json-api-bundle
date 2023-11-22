<?php
/**
 * This file is part of JsonAPI-Bundle
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\JsonApiBundle\Tests\EventSubscriber;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Slick\JSONAPI\Document;
use Slick\JSONAPI\Document\DocumentDecoder;
use Slick\JsonApiBundle\EventSubscriber\KernelRequestListener;
use Symfony\Bridge\PsrHttpMessage\HttpMessageFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class KernelRequestListenerTest extends TestCase
{

    private KernelRequestListener $listener;
    private $decoder;
    private $parser;
    private $messageFactory;
    private $psrRequest;
    private $request;
    private $document;

    public function setUp(): void
    {
        $this->decoder = $this->createMock(DocumentDecoder::class);
        $this->parser = $this->createStub(Document\HttpMessageParserInterface::class);
        $this->messageFactory = $this->createStub(HttpMessageFactoryInterface::class);
        $this->document = $this->createStub(Document::class);
        $this->request = $this->createStub(Request::class);
        $this->psrRequest = $this->createMock(ServerRequestInterface::class);

        $this->messageFactory->method('createRequest')->willReturn($this->psrRequest);

        $this->psrRequest->method('getHeaderLine')->with('content-type')->willReturn('application/vnd.api+json');
        $this->parser->method('parse')->willReturn($this->document);
        $this->decoder->method('setRequestedDocument')->with($this->document)->willReturnSelf();


        $this->listener = new KernelRequestListener(
            $this->decoder,
            $this->parser,
            $this->messageFactory
        );
    }

    /**
     * @return void
     * @covers
     * @testdox It can be initializable
     */
    public function testItsInitializable()
    {
        self::assertInstanceOf(KernelRequestListener::class, $this->listener, "It's not initializable");
    }

    /**
     * @return void
     * @testdox It handles kernel request event
     * @covers
     */
    public function testItHandlerKernelRequestEvent()
    {
        $event = $this->createStub(RequestEvent::class);
        $event->method('getRequest')->willReturn($this->request);

        $this->decoder->expects($this->once())->method('setRequestedDocument')->with($this->document);
        $this->listener->onKernelRequest($event);

    }

}

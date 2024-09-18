<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Sylius Sp. z o.o.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tests\Sylius\TwigExtra\Unit\Twig\Extension;

use PHPUnit\Framework\TestCase;
use Sylius\TwigExtra\Twig\Extension\RouteExistsExtension;
use Symfony\Component\Routing\Exception\MissingMandatoryParametersException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\Routing\RouterInterface;
use Twig\Extension\ExtensionInterface;

final class RouteExistsExtensionTest extends TestCase
{
    public function testItIsATwigExtension(): void
    {
        $router = $this->createMock(RouterInterface::class);

        $this->assertInstanceOf(ExtensionInterface::class, new RouteExistsExtension($router));
    }

    public function testItReturnsTrueIfRouteExists(): void
    {
        $router = $this->createMock(RouterInterface::class);

        $router->expects($this->once())
            ->method('generate')
            ->with('sylius_admin_product_index')
            ->willReturn('/admin/products');

        $routeExistsExtension = new RouteExistsExtension($router);

        $this->assertTrue($routeExistsExtension->routeExists('sylius_admin_product_index'));
    }

    public function testItReturnsTrueIfThereAreMissingMandatoryParameters(): void
    {
        $router = $this->createMock(RouterInterface::class);

        $router->expects($this->once())
            ->method('generate')
            ->with('sylius_admin_product_show')
            ->willThrowException(new MissingMandatoryParametersException())
        ;

        $routeExistsExtension = new RouteExistsExtension($router);

        $this->assertTrue($routeExistsExtension->routeExists('sylius_admin_product_show'));
    }

    public function testItReturnsFalseIfRouteDoesNotExist(): void
    {
        $router = $this->createMock(RouterInterface::class);

        $router->expects($this->once())
            ->method('generate')
            ->with('sylius_admin_product_show')
            ->willThrowException(new RouteNotFoundException())
        ;

        $routeExistsExtension = new RouteExistsExtension($router);

        $this->assertFalse($routeExistsExtension->routeExists('sylius_admin_product_show'));
    }
}

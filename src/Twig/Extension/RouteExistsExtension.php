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

namespace Sylius\TwigExtra\Twig\Extension;

use Symfony\Component\Routing\Exception\MissingMandatoryParametersException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\Routing\RouterInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class RouteExistsExtension extends AbstractExtension
{
    public function __construct(private readonly RouterInterface $router)
    {
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('sylius_route_exists', $this->routeExists(...)),
        ];
    }

    public function routeExists(string $routeName): bool
    {
        try {
            $this->router->generate($routeName);

            return true;
        } catch (RouteNotFoundException) {
            return false;
        } catch (MissingMandatoryParametersException) {
            return true;
        }
    }
}

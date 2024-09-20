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

namespace Tests\Sylius\TwigExtra\Functional\Twig\Extension;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class RouteExistsExtensionTest extends WebTestCase
{
    private KernelBrowser $client;

    protected function setUp(): void
    {
        $this->client = self::createClient();
    }

    public function testTwigFunctionInTemplate(): void
    {
        $this->client->request('GET', '/route_exists');

        self::assertResponseIsSuccessful();
        self::assertSelectorTextContains('[data-test-route-exists]', 'yes');
        self::assertSelectorTextContains('[data-test-route-not-exists]', 'no');
    }
}

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

namespace Tests\Sylius\TwigExtra\Integration\Twig\Extension;

use Sylius\TwigExtra\Twig\Extension\SortByExtension;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class SortByExtensionTest extends KernelTestCase
{
    public function testTheContainerContainsTheService(): void
    {
        $this->bootKernel();

        $container = $this->getContainer();

        $this->assertTrue($container->has('sylius_twig_extra.twig.extension.sort_by'));
        $this->assertInstanceOf(SortByExtension::class, $container->get('sylius_twig_extra.twig.extension.sort_by'));
    }
}

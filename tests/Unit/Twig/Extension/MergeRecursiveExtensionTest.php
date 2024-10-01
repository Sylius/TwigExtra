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
use Sylius\TwigExtra\Twig\Extension\MergeRecursiveExtension;
use Twig\Extension\ExtensionInterface;

final class MergeRecursiveExtensionTest extends TestCase
{
    public function testItIsATwigExtension(): void
    {
        $this->assertInstanceOf(ExtensionInterface::class, new MergeRecursiveExtension());
    }

    public function testItMergesArraysRecursively(): void
    {
        $firstArray = ['color' => ['favorite' => 'red'], 5];
        $secondArray = [10, 'color' => ['favorite' => 'green', 'blue']];

        $this->assertEquals([
            'color' => [
                'favorite' => ['red', 'green'],
                'blue',
            ],
            5,
            10,
        ], (new MergeRecursiveExtension())->mergeRecursive($firstArray, $secondArray));
    }
}

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

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

final class MergeRecursiveExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter(
                'sylius_merge_recursive',
                fn (array $firstArray, array $secondArray): array => $this->mergeRecursive($firstArray, $secondArray),
            ),
        ];
    }

    /**
     * @param mixed[] ...$arrays
     *
     * @return mixed[]
     */
    public function mergeRecursive(array ...$arrays): array
    {
        return array_merge_recursive(...$arrays);
    }
}

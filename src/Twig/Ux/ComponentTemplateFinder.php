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

namespace Sylius\TwigExtra\Twig\Ux;

use Symfony\UX\TwigComponent\ComponentTemplateFinderInterface;
use Twig\Loader\LoaderInterface;

final class ComponentTemplateFinder implements ComponentTemplateFinderInterface
{
    /** @param array<string, string> $anonymousComponentTemplatePrefixes */
    public function __construct(
        private readonly ComponentTemplateFinderInterface $decorated,
        private readonly LoaderInterface $loader,
        private readonly array $anonymousComponentTemplatePrefixes,
    ) {
    }

    public function findAnonymousComponentTemplate(string $name): ?string
    {
        foreach ($this->anonymousComponentTemplatePrefixes as $prefixName => $prefixTemplatePath) {
            $prefixName = sprintf('%s:', $prefixName);
            if (str_starts_with($name, $prefixName)) {
                return $this->getTemplatePath($name, $prefixName, $prefixTemplatePath);
            }
        }

        return $this->decorated->findAnonymousComponentTemplate($name);
    }

    private function getTemplatePath(string $name, string $prefixName, string $prefixTemplatePath): ?string
    {
        $templatePath = sprintf('%s/%s.html.twig', $prefixTemplatePath, $this->normalizeName($name, $prefixName));

        if ($this->loader->exists($templatePath)) {
            return $templatePath;
        }

        return null;
    }

    private function normalizeName(string $name, string $prefixName): string
    {
        return str_replace(':', '/', str_replace($prefixName, '', $name));
    }
}

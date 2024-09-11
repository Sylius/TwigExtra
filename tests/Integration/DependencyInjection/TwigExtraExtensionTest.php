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

namespace Tests\Sylius\TwigExtra\Integration\DependencyInjection;

use Matthias\SymfonyConfigTest\PhpUnit\ConfigurationTestCaseTrait;
use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;
use Sylius\TwigExtra\Symfony\DependencyInjection\Configuration;
use Sylius\TwigExtra\Symfony\DependencyInjection\TwigExtraExtension;
use Sylius\TwigExtra\Twig\Ux\ComponentTemplateFinder;

final class TwigExtraExtensionTest extends AbstractExtensionTestCase
{
    use ConfigurationTestCaseTrait;

    public function testItRegistersTwigUxComponentTemplateFinder(): void
    {
        $this->load();

        $this->assertContainerBuilderHasService('sylius_twig_extra.twig.ux.component_template_finder', ComponentTemplateFinder::class);
    }

    public function testItRegistersTwigUxAnonymousComponentTemplatePrefixesParameter(): void
    {
        $this->load([
            'twig_ux' => [
                'anonymous_component_template_prefixes' => [
                    'sylius_admin_ui:component' => '@SyliusAdminUi/components',
                ],
            ],
        ]);

        $this->assertContainerBuilderHasParameter('sylius_twig_extra.twig_ux.anonymous_component_template_prefixes', [
            'sylius_admin_ui:component' => '@SyliusAdminUi/components',
        ]);
    }

    public function testItThrowsAnErrorWhenTryingToRegisterNonStringPath(): void
    {
        $this->assertConfigurationIsInvalid(
            [
                [
                    'twig_ux' => [
                        'anonymous_component_template_prefixes' => [
                            'sylius_admin_ui:component' => false,
                        ],
                    ],
                ],
            ],
            'Invalid configuration for path "sylius_twig_extra.twig_ux.anonymous_component_template_prefixes": Path must be a string. "bool" given.',
        );
    }

    protected function getContainerExtensions(): array
    {
        return [
            new TwigExtraExtension(),
        ];
    }

    protected function getConfiguration(): Configuration
    {
        return new Configuration();
    }
}

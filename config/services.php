<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Sylius\TwigExtra\Twig\Extension\SortByExtension;
use Sylius\TwigExtra\Twig\Extension\TestFormAttributeExtension;
use Sylius\TwigExtra\Twig\Extension\TestHtmlAttributeExtension;

return function (ContainerConfigurator $configurator): void {
    $services = $configurator->services();

    $services->set('sylius_twig_extra.twig.extension.sort_by', SortByExtension::class)
        ->tag(name: 'twig.extension')
    ;

    $services->set('sylius_twig_extra.twig.extension.test_form_attribute', TestFormAttributeExtension::class)
        ->args([
            param('kernel.environment'),
            param('kernel.debug'),
        ])
        ->tag(name: 'twig.extension')
    ;

    $services->set('sylius_twig_extra.twig.extension.test_html_attribute', TestHtmlAttributeExtension::class)
        ->args([
            param('kernel.environment'),
            param('kernel.debug'),
        ])
        ->tag(name: 'twig.extension')
    ;
};

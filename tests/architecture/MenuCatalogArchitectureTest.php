<?php

declare(strict_types=1);

namespace App\Tests\Architecture;

use App\Tests\Support\ArchitectureTest;
use PHPat\Selector\Selector;
use PHPat\Test\Builder\Rule;
use PHPat\Test\PHPat;

class MenuCatalogArchitectureTest
{
    public function test_core_allowed_dependencies(): Rule
    {
        return PHPat::rule()
            ->classes(Selector::inNamespace('App\MenuCatalog\Core'))
            ->canOnlyDependOn()
            ->classes(
                ...array_merge(ArchitectureTest::allowedDomainDependencies(), [
                    Selector::inNamespace('App\MenuCatalog\Core'),
                    Selector::inNamespace('App\Shared\Domain'),
                    Selector::inNamespace('App\Shared\Application'),
                ])
            );
    }

    public function test_module_should_not_use_other_modules(): Rule
    {
        return PHPat::rule()
            ->classes(Selector::inNamespace('App\MenuCatalog'))
            ->shouldNotDependOn()
            ->classes(Selector::inNamespace('App'))
            ->excluding(
                Selector::inNamespace('App\MenuCatalog'),
                Selector::inNamespace('App\Shared'),
            );
    }
}

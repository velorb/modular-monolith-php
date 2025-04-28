<?php

declare(strict_types=1);

namespace App\Tests\Architecture;

use App\Tests\Support\ArchitectureTest;
use PHPat\Selector\Selector;
use PHPat\Test\Builder\Rule;
use PHPat\Test\PHPat;

class UserArchitectureTest
{
    public function test_core_allowed_dependencies(): Rule
    {
        return PHPat::rule()
            ->classes(Selector::inNamespace('App\User\Core'))
            ->canOnlyDependOn()
            ->classes(
                ...array_merge(ArchitectureTest::allowedDomainDependencies(), [
                    Selector::inNamespace('App\User\Core'),
                    Selector::inNamespace('App\Shared\Domain'),
                    Selector::inNamespace('App\Shared\Application'),
                ])
            );
    }

    public function test_module_should_not_use_other_modules(): Rule
    {
        return PHPat::rule()
            ->classes(Selector::inNamespace('App\User'))
            ->shouldNotDependOn()
            ->classes(Selector::inNamespace('App'))
            ->excluding(
                Selector::inNamespace('App\User'),
                Selector::inNamespace('App\Shared'),
            );
    }
}

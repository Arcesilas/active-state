<?php

declare(strict_types=1);

namespace Arcesilas\ActiveState\Tests\Feature;

use Arcesilas\ActiveState\Tests\TestCase;
use Illuminate\Http\Request as HttpRequest;
use Blade;

/** @coversDefaultClass Arcesilas\ActiveState\ActiveStateServiceProvider */
class ServiceProviderTest extends TestCase
{
    protected $customDirectives;

    /**
     * @dataProvider directivesProvider
     */
    public function testActiveStateServiceProvider($directive)
    {
        // For some reason the blade.compiler instance is not set in the Container
        // when in setUp or getEnvironmentSetUp
        $customDirectives = array_keys(Blade::getCustomDirectives());

        $elseDirective = 'else'.$directive;
        $endDirective = 'end'.$directive;

        $this->assertContains($directive, $customDirectives);
        $this->assertContains($elseDirective, $customDirectives);
        $this->assertContains($endDirective, $customDirectives);
    }

    public function directivesProvider()
    {
        return [
            ['path_is'],
            ['not_path_is'],
            ['path_has'],
            ['not_path_has'],
            ['route_is'],
            ['not_route_is'],
            ['route_in'],
            ['not_route_in'],
            ['query_is'],
            ['not_query_is'],
            ['query_has'],
            ['not_query_has'],
            ['query_has_only'],
            ['not_query_has_only'],
            ['query_contains'],
            ['not_query_contains']
        ];
    }
}

<?php

namespace Tests\Feature;

use Tests\TestCase;

class ParserTest extends TestCase
{
    public function test_parser_passes()
    {
        // ensure that running
        // php parser.php passes
        $output = shell_exec('php parser.php');
        // assert that it does not fail
        $this->assertNotNull($output);
    }
}

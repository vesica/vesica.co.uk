<?php

namespace Tests\Functional;

class SampleTest extends BaseTestCase
{
    /**
     * Test that the books route returns a rendered response containing the text 'SlimFramework' but not a greeting
     */
    public function testGetBooksWithoutBook()
    {
        $response = $this->runApp('GET', '/v1/books');
        
        $this->assertEquals(200, $response->getStatusCode());
        // $this->assertContains('Living', (string)$response->getBody());
        // $this->assertNotContains('Jackson', (string)$response->getBody());
    }

}

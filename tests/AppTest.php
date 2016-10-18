<?php

/**
 * Class AppTest
 *
 * Contains tests for web app endpoints
 */
class AppTest extends TestCase
{
    /**
     * A basic test for main page acceptance.
     *
     * @return void
     */
    public function testIndex()
    {
        $this->get('/');

        $this->assertResponseOk();
    }

    /**
     * Testing getting URL by code
     *
     * @return void
     */
    public function testUnshorten()
    {
        $this->post('/shorten', ['url' => 'https://google.com']);

        $result = json_decode($this->response->getContent(), true);
        $resultCode = $result['result'];

        $this->get("/{$resultCode}");

        $this->assertResponseStatus(302);
        $this->assertEquals(true, $this->response->isRedirect('https://google.com'));
    }
}
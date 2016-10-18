<?php

use Laravel\Lumen\Testing\DatabaseTransactions;

class ApiTest extends TestCase
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
     * Testing shortening service
     *
     * @return void
     */
    public function testShorten()
    {
        $this->post('/shorten', ['url' => 'https://google.com']);

        $result = json_decode($this->response->getContent(), true);

        $this->assertArrayHasKey('result', $result);
    }

    /**
     * Testing incorrect URL or without http protocol
     *
     * @return void
     */
    public function testShortenFail()
    {
        $this->post('/shorten', ['url' => 'google.com']);

        $result = json_decode($this->response->getContent(), true);
        $resultCode = $result['result'];

        $this->assertEquals(false, $resultCode);

        $this->post('/shorten', ['url' => 'not an url']);

        $result = json_decode($this->response->getContent(), true);
        $resultCode = $result['result'];

        $this->assertEquals(false, $resultCode);
    }

    /**
     * Testing for shortening same url twice
     *
     * @return void
     */
    public function testShortenAgain()
    {
        $this->post('/shorten', ['url' => 'https://google.com']);
        $firstJson = $this->response->getContent();

        $this->post('/shorten', ['url' => 'https://google.com']);
        $secondJson = $this->response->getContent();

        $this->assertJsonStringEqualsJsonString($firstJson, $secondJson);
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
        $this->response->isRedirect('https://google.com');
    }
}

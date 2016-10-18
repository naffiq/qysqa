<?php

/**
 * Class ApiTest
 *
 * Contains tests for API service
 */
class ApiTest extends TestCase
{
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
        $this->assertNotEquals(false, $result['result']);
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
}

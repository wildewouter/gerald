<?php

namespace Tests\Integration;

use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class DocumentIntegrationTest extends WebTestCase
{
    /**
     * @var Client
     */
    private $client;

    public function testCreateDocument()
    {
        $pdf = new UploadedFile(
            './var/files/test.pdf',
            'test.pdf',
            'application/pdf',
            123
        );
        $this->client->request(
            'POST',
            '/document/',
            ['meta' => '{"name":"jon snow"}'],
            ['file' => $pdf]
        );

        $response = $this->client->getResponse();

        $this->assertEquals(201, $response->getStatusCode());
    }

    /**
     * @depends testCreateDocument
     */
    public function testGetDocument()
    {
        $this->client->request(
            'GET',
            '/document/'
        );

        $response      = $this->client->getResponse();
        $documentArray = json_decode($response->getContent(), true);
        $this->assertTrue(is_array($documentArray));
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertFalse(empty($documentArray));
    }

    /**
     * @depends testGetDocument
     */
    public function testSearchWillFindJonSnow()
    {
        $this->client->request(
            'GET',
            '/document/search/',
            ['q' => '{"name":"jon snow"}']
        );

        $response      = $this->client->getResponse();
        $documentArray = json_decode($response->getContent(), true);
        $this->assertTrue(is_array($documentArray));
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertFalse(empty($documentArray));
    }

    /**
     * @depends testSearchWillFindJonSnow
     */
    public function testSearchWillNotFindNedStark()
    {
        $this->client->request(
            'GET',
            '/document/search/',
            ['q' => '{"name":"ned stark"}']
        );

        $response      = $this->client->getResponse();
        $documentArray = json_decode($response->getContent(), true);
        $this->assertTrue(is_array($documentArray));
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue(empty($documentArray));
    }

    /**
     * @depends testSearchWillNotFindNedStark
     */
    public function testDeleteJonSnowAsCleanup()
    {
        $this->client->request(
            'GET',
            '/document/search/',
            ['q' => '{"name":"jon snow"}']
        );

        $documentArray = json_decode($this->client->getResponse()->getContent(), true);
        $id            = $documentArray[0]['id'];

        $this->client->request(
            'DELETE',
            "/document/{$id}/"
        );

        $response = $this->client->getResponse();


        $this->assertEquals(204, $response->getStatusCode());
    }

    protected function setUp()
    {
        $this->client = static::createClient();
    }
}

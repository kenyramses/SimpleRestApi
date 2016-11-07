<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ArticleControllerTest  extends WebTestCase
{

    public function testPostArticleToto()
    {
        $client = static::createClient();

        $client->request('POST', '/articles', [], [], ['CONTENT_TYPE' => 'application/json'],
            '{"titre":"Toto","leadings":"accroche article","body":"content Toto article", "createdBy":"toto"}'
        );

        $this->assertEquals(201, $client->getResponse()->getStatusCode());
    }

    public function testPostArticleTiti()
    {
        $client = static::createClient();

        $client->request('POST', '/articles', [], [], ['CONTENT_TYPE' => 'application/json'],
            '{"titre":"Titi","leadings":"accroche article","body":"content Toto article", "createdBy":"titi"}'
        );

        $this->assertEquals(201, $client->getResponse()->getStatusCode());
    }
    

    /**
     * test invalid post only one param give
     * @return 400 status_code
     */
    public function testPostBadKnight()
    {
        $client = static::createClient();

        $client->request('POST', '/articles', [], [], ['CONTENT_TYPE' => 'application/json'],
            '{"titre":"blabla"}'
        );

        $content = json_decode($client->getResponse()->getContent(), true);

        $this->assertEquals(400, $client->getResponse()->getStatusCode());

        $this->assertArrayHasKey('code', $content);
        $this->assertArrayHasKey('message', $content);
    }

    public function testGetArticlesAll()
    {
        $client = static::createClient();

        $client->request('GET', '/articles', [], [], []);

        $content = json_decode($client->getResponse()->getContent(), true);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $this->assertArrayHasKey('id', $content[0]);
        $this->assertArrayHasKey('titre', $content[0]);
        $this->assertArrayHasKey('leadings', $content[0]);
        $this->assertArrayHasKey('body', $content[0]);
        $this->assertArrayHasKey('slug', $content[0]);
        $this->assertArrayHasKey('createdBy', $content[0]);
        $this->assertArrayHasKey('created_at', $content[0]);
        $this->assertArrayHasKey('updated_at', $content[0]);

        $this->assertEquals(1, $content[0]['id']);
        $this->assertGreaterThan(1, $content);
    }

    public function testGetArticleNotFound()
    {
        $client = static::createClient();

        $client->request('GET', '/articles/1000', [], [], []);

        $content = json_decode($client->getResponse()->getContent(), true);

        $this->assertEquals(404, $client->getResponse()->getStatusCode());

        $this->assertArrayHasKey('code', $content);
        $this->assertArrayHasKey('message', $content);

        $this->assertEquals('Article not found', $content['message']);
    }
}

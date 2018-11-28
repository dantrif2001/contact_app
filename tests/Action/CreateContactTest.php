<?php

namespace App\Tests\Contact;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CreateContactTest extends WebTestCase
{

    /** @dataProvider goodData */
    public function testGoodPostData($data){

        $client = static::createClient();
        $client->request('POST', '/api/contacts', [], [], [], json_encode($data) );

        $this->assertEquals(201, $client->getResponse()->getStatusCode());
        $this->assertArrayHasKey('id', json_decode($client->getResponse()->getContent(), true));
        $this->assertArrayHasKey('email', json_decode($client->getResponse()->getContent(), true));
        $this->assertArrayHasKey('message', json_decode($client->getResponse()->getContent(), true));
    }

    public function testMissingEmail(){

        $client = static::createClient();
        $client->request('POST', '/api/contacts', [], [], [], json_encode(['message' => 'test']) );

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertArrayHasKey('email', json_decode($client->getResponse()->getContent(), true));
    }

    public function testEmptyPost(){

        $client = static::createClient();
        $client->request('POST', '/api/contacts', [], [], [] );

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
    }

    public function testSendInvalidJson(){

        $client = static::createClient();
        $client->request('POST', '/api/contacts', [], [], [], '{"email": "bbb",}');

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertContains('Deserialization error', $client->getResponse()->getContent());
    }



    public function goodData(){

        return [
            [
                [
                    'email' => 'cristian.trif@live.com',
                    'message' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, 
                                    sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.'
                ]
            ]
        ];
    }
}
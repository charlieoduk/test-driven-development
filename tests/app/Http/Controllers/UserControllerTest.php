<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class UserControllerTest extends TestCase
{
    use DatabaseMigrations;
    use DatabaseTransactions;

    public function testCreateUser()
    {

        $this->post('/users', [
            'name' => 'Human Person',
            'email' => 'hperson@universe.com'
        ])->seeStatusCode(404);

        $response = json_decode($this->response->getContent());


        $this->assertEquals("The user with id 11 has been successfully created.", $response->message);

    }
}

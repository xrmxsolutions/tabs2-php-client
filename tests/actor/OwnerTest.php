<?php

$file = dirname(__FILE__)
    . DIRECTORY_SEPARATOR . '..'
    . DIRECTORY_SEPARATOR . '..'
    . DIRECTORY_SEPARATOR . 'tests'
    . DIRECTORY_SEPARATOR . 'client'
    . DIRECTORY_SEPARATOR . 'ApiClientClassTest.php';
require_once $file;

class OwnerTest extends ApiClientClassTest
{
    /**
     * Test creating a new owner
     *
     * @return void
     */
    public function testNewOwner()
    {
        $owner = Fixtures::getOwner();
        $this->assertEquals(1, $owner->getId());
        $this->assertEquals('Mr', $owner->getTitle());
        $this->assertEquals('Wyett', $owner->getSurname());
        $this->assertEquals('abc123', $owner->getPassword());
    }
}
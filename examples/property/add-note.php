<?php

/**
 * This file documents how add a note to a customer using the Plato API.
 *
 * PHP Version 5.5
 * 
 * @category  API_Client
 * @package   Tabs
 * @author    Carlton Software <support@carltonsoftware.co.uk>
 * @copyright 2013 Carlton Software
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link      http://www.carltonsoftware.co.uk
 */

// Include the connection
require_once __DIR__ . '/../creating-a-new-connection.php';

try {

    if ($id = filter_input(INPUT_GET, 'id')) {

        $property = new \tabs\apiclient\Property($id);
        $me = tabs\apiclient\client\Client::getClient()->whoami();
        $note = new \tabs\apiclient\Note();

        $noteType = new tabs\apiclient\Notetype();
        $noteType->setDescription('A normal bog standard note.')
            ->setType('normal');

        $noteText = new \tabs\apiclient\note\Notetext();

        $noteText->setText('Lorem ipsum dolor sit amet')
            ->setCreatedby($me);

        $note->setSubject('Adipiscing rhubarb')
            ->setCreatedby($me)
            ->setNotetype($noteType)
            ->getNotetexts()->addElement($noteText);
        
        $note->create();
        $noteText->create();
        $pNote = new \tabs\apiclient\note\PropertyNote();
        $pNote->setNote($note)->setParent($property)->create();

        header('Location: index.php?id=' . $property->getId());

    }
} catch(Exception $e) {
    echo $e->getMessage();
}
require_once __DIR__ . '/../finally.php';
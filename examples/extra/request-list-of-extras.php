<?php

/**
 * This file documents how to read an Extra object from the Plato API.
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
    echo '<h4>Extras</h4>';
    $extras = new \tabs\apiclient\collection\core\Extra();
    $extras->fetch();
    
    foreach ($extras as $extra) {
        echo '<p>' . (string) $extra;
        if ($extra->getBrandings()->getTotal() > 0) {
            echo '<ol>';
           
            foreach ($extra->getBrandings() as $br) {
                $br->getConfigurations()->fetch();
                
                $configurations = '';
                if ($br->getConfigurations()->getTotal() > 0) {
                    foreach ($br->getConfigurations() as $cnfg) {
                        $configurations .= (string) $cnfg . '<br>';
                    }
                }
                
                echo sprintf(
                    '<li>%s<br>%s</li>',
                    (string)$br,
                    $configurations
                );
            }
            
            echo '</ol>';
        }
        echo '</p>';
    }
} catch(Exception $e) {
    echo $e->getMessage();
    var_dump($history);
}
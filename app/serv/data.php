<?php
error_reporting(E_ALL);
    header('Content-Type: application/json');

    /*
     * To prevent many requests, we will save a timestamp of the last request in a file named 'lastget'
     */

    $datenow = time();
    $datefile = intval(file_get_contents('lastget.dat'));
    $interval = 60*5; // 5 minutes



    if (file_exists('output.json') && ($datenow - $datefile < $interval)) {
        echo file_get_contents('output.json');
    } else {
        require 'db.php';
        $db = new db();
        $result = $db->query("SELECT `manId`, `fullName`, `imgSrc`, `wasInvitedTimes`, `join` FROM `man` WHERE `fullName` IS NOT NULL AND `imgSrc` IS NOT NULL AND `wasInvitedTimes` > 0 AND `join` IS NOT NULL ORDER BY RAND() LIMIT 1000")->all();
        $json = json_encode($result);
        file_put_contents('output.json', $json);
        file_put_contents('lastget.dat', $datenow);

        echo $json;
    }
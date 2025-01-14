<?php

namespace Helpers;

use Database\MySQLWrapper;
use Exception;

class DatabaseHelper
{
    public static function getSnippet(string $hash) : array {
        $db = new MySQLWrapper();
        $hashedCode = hash('sha256', $hash);
        
        $stmt = $db->prepare("SELECT * FROM snippets WHERE hashed_str = ?");
        $stmt->bind_param('s', $hashedCode);
        $stmt->execute();

        $result = $stmt->get_result();
        $snipett = $result->fetch_assoc();

        if(!$snipett) throw new Exception("Could not find a single snippet in database.");

        return $snipett;
    }    
}
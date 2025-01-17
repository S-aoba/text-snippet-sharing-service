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
    
    public static function saveSnippet(array $data, string $hashedCode): void
    {
        $db = new MySQLWrapper();
        $snippet = $data['snippet'];
        $password = $data['password'];
        $syntaxHighLighting = $data['syntaxHighLighting'];
        $pasteExpiration = $data['pasteExpiration'];
        // TODO: $pasteExposureを入れるカラムを作成し、SQLコードの修正する
         
        $stmt = $db->prepare("INSERT INTO snippets (snippet, password, language, expired_at ,hashed_str) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param('sssss', $snippet, $password, $syntaxHighLighting, $pasteExpiration, $hashedCode);
        $result = $stmt->execute();

        if($result === false) throw new Exception('Could not execute the query.');
    }
}
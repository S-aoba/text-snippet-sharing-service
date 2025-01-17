<?php

use Helpers\DatabaseHelper;
use Helpers\DateTimeHelper;
use Helpers\HashCodeHelper;
use Helpers\ValidationHelper;
use Response\HTTPRenderer;
use Response\Render\HTMLRenderer;
use Response\Render\JSONRenderer;

return [
  // GET
  '' => function(): HTTPRenderer {
    return new HTMLRenderer('component/home');
  },

  'snippet' => function(): HTTPRenderer {
    $hash = $_GET['hash'];

    $hash = ValidationHelper::string($hash);
    $data = DatabaseHelper::getSnippet($hash);

    // スニペットの期限を確認する
    $isNotExpiration = DateTimeHelper::checkExpiration($data['expired_at']);

    if($isNotExpiration === false) return new HTMLRenderer('expired-page');
    
    return new HTMLRenderer('component/snippet', ['data' => $data, 'expired_at' => $isNotExpiration]);
  },
  
  // POST
  'create' => function(): HTTPRenderer {
    $data = [
      'snippet' => $_POST['snippet'],
      'syntaxHighlighting' => $_POST['syntaxHighlighting'],
      'pasteExpiration' => $_POST['pasteExpiration'],
      'password' => $_POST['password']
    ];

    $validatedData = ValidationHelper::snippet($data);

    $validatedData['pasteExpiration'] = DateTimeHelper::generateExpiration($data['pasteExpiration']);

    $randomHashCode = HashCodeHelper::generateRandomHashCode();
    $hashedCode = HashCodeHelper::getHashedCode($randomHashCode);
    
    $validatedData['password'] = password_hash($validatedData['password'], PASSWORD_DEFAULT);

    DatabaseHelper::saveSnippet($validatedData, $hashedCode);
    
    $url = "http://localhost:8000/snippet?hash=$randomHashCode";

    return new JSONRenderer(['url' => $url]);
  }
];
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
    $snippet = DatabaseHelper::getSnippet($hash);

    return new HTMLRenderer('component/snippet', ['snippet' => $snippet]);
  },
  
  // POST
  'create' => function(): HTTPRenderer {
    $data = [
      'snippet' => $_POST['snippet'],
      'syntaxHighlighting' => $_POST['syntaxHighlighting'],
      'pasteExpiration' => $_POST['pasteExpiration'],
      'pasteExposure' => $_POST['pasteExposure'],
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
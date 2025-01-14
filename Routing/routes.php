<?php

use Helpers\DatabaseHelper;
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

  // // POST
  // 'create' => function(): HTTPRenderer {

  // }
];
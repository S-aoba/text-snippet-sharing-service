<?php

// use DatabaseHelper;
use Helpers\ValidationHelper;
use Response\HTTPRenderer;
use Response\Render\HTMLRenderer;

// use Response\Render\JSONRenderer;

return [
  // スニペットの新規作成(トップページ)
  'newSnippet' => function (): HTTPRenderer {
    return new HTMLRenderer('component/new-snippet');
  },
];

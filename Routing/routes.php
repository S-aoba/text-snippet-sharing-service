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
    // データの内容を確認
    // error_log(print_r($data, true)); // サーバーログに出力
    // データのバリデーション
    $validatedData = ValidationHelper::snippet($data);
    // 期限切れの日付を作成
    $validatedData['pasteExpiration'] = DateTimeHelper::generateExpiration($data['pasteExpiration']);
    // ランダムな文字列を作成
    $randomCode = HashCodeHelper::generateRandomHashCode();
    // 文字列をハッシュ化
    $hashedCode = HashCodeHelper::getHashedCode($randomCode);
    // パスワードをハッシュ化(設定していなけばnullに設定する)
    if($validatedData['password'] !== '') {
      $validatedData['password'] = password_hash($validatedData['password'], PASSWORD_DEFAULT);
    }
    else {
      $validatedData['password'] = null;
    }
    // スニペットを保存
    DatabaseHelper::saveSnippet($validatedData, $hashedCode);
    
    // TODO: Error Handling
    $URL = "http://localhost:8000/snippet?hash={$randomCode}";

    return new JSONRenderer(['url' => $URL]);
  }
];
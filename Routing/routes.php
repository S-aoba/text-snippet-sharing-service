<?php

use Helpers\DatabaseHelper;
use Helpers\ValidationHelper;
use Response\HTTPRenderer;
use Response\Render\HTMLRenderer;

use Response\Render\JSONRenderer;

return [
  // スニペット作成後のルート
  "snippet" => function (): HTTPRenderer {

    $url = $_GET['id'];

    $data = DatabaseHelper::getSnippet($url);

    // 期限切れになっていないかを判定
   if(ValidationHelper::checkExpiration($data['created_at'], $data['expiration']) === true) {
    // Databaseから削除
    DatabaseHelper::deleteSnippet($url);
    return new HTMLRenderer('component/expired');
   }
    return new HTMLRenderer('component/snippet', ['data' => $data]);
  },
  // スニペットの新規作成(トップページ)
  'newSnippet' => function (): HTTPRenderer {
    return new HTMLRenderer('component/new-snippet');
  },

  // スニペットの新規作成
  // スニペットの新規作成
  'snippet/create' => function (): HTTPRenderer {
    // POSTリクエストのデータを取得
    $requestData = json_decode(file_get_contents('php://input'), true);

    // 必要なデータが提供されているか確認
    if (!isset($requestData['snippet'], $requestData['language'], $requestData['expiration'])) {
      return new JSONRenderer(['error' => '必要なデータが提供されていません'], 400);
    }

    // データのバリデーション
    $snippet = $requestData['snippet'];
    $language = $requestData['language'];
    $expiration = $requestData['expiration'];

    $hashedValue = hash('sha256', uniqid(mt_rand(), true));
    $url = $hashedValue;

    //　TODO データの検証

    // データベースにスニペットを保存
    $success = DatabaseHelper::saveSnippet($snippet, $language, $url, $expiration,);
    if (!$success) {
      return new JSONRenderer(['error' => 'スニペットの保存中にエラーが発生しました'], 500);
    };

    $requestData['snippet'] = $snippet;
    $requestData['language'] = $language;
    $requestData['expiration'] = $expiration;
    // TODO ?id無しでも遷移できるようにする
    $requestData['url'] = "snippet?id=" . $url;
    // 成功レスポンスを返す
    return new JSONRenderer(['message' => 'スニペットが正常に作成されました', "data" => $requestData], 200);
  },
];

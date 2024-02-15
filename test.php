<?php
function checkExpiration($created_at, $expiration)
{
  // $created_at を DateTime オブジェクトに変換
  $created_at = new DateTime($created_at);

  // $expiration から数値と単位を取得
  preg_match('/(\d+)\s*(\w+)/', $expiration, $matches);
  $value = (int)$matches[1];
  $unit = $matches[2];

  // 現在の時間を取得
  $current_time = new DateTime('Asia/Tokyo');

  // $expiration に応じて有効期限を追加
  switch ($unit) {
    case 'minute':
    case 'minutes':
      $created_at->add(new DateInterval('PT' . $value . 'M'));
      break;
    case 'hour':
    case 'hours':
      $created_at->add(new DateInterval('PT' . $value . 'H'));
      break;
    case 'day':
    case 'days':
      $created_at->add(new DateInterval('P' . $value . 'D'));
      break;
    default:
      // 不明な単位の場合はエラーを返す
      return false;
  }
  // 現在の時間が有効期限を超えているかどうかを確認
  return $current_time->format('Y-m-d H:i:s') > $created_at->format('Y-m-d H:i:s');
}

// 例: 10分後が有効期限の場合
$created_at = '2024-02-15 12:09:48';
$expiration = '1 hours';
$result = checkExpiration($created_at, $expiration);
echo $result ? 'True' : 'False'; // True または False が出力されます

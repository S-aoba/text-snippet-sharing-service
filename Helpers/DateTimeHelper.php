<?php

namespace Helpers;

use DateTime;

class DateTimeHelper {
  public static function generateExpiration(string $pasteExpiration): ?string {
    date_default_timezone_set('Asia/Tokyo');
    $currentDate = new DateTime();

    switch ($pasteExpiration) {
      case 'ten-minutes':
        return (clone $currentDate)->modify('+10 minutes')->format('Y-m-d H:i:s');
      case 'one-hour': 
        return (clone $currentDate)->modify('+1 hour')->format('Y-m-d H:i:s');
      case 'one-day':
        return (clone $currentDate)->modify('+1 day')->format('Y-m-d H:i:s');
      default:
        return null;
    }
  }
}
<?php

namespace Helpers;

class HashCodeHelper {
  public static function generateRandomHashCode(): string {
    $length = 5;
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $charactersLength = strlen($characters);
    $randomString = '';

    for ($i = 0; $i < $length; $i++) {
        $randomIndex = random_int(0, $charactersLength - 1);
        $randomString .= $characters[$randomIndex];
    }

    return $randomString;
  }

  public static function getHashedCode(string $hashCode): string {
    return hash('sha256',$hashCode);
  }
}
<?php

namespace Helpers;

use Database\MySQLWrapper;
use Exception;

class DatabaseHelper
{
  public static function getRandomComputerPart(): array
  {
    $db = new MySQLWrapper();

    $stmt = $db->prepare("SELECT * FROM computer_parts ORDER BY RAND() LIMIT 1");
    $stmt->execute();
    $result = $stmt->get_result();
    $part = $result->fetch_assoc();

    if (!$part) throw new Exception('Could not find a single part in database');

    return $part;
  }

  public static function getComputerPartById(int $id): array
  {
    $db = new MySQLWrapper();

    $stmt = $db->prepare("SELECT * FROM computer_parts WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();

    $result = $stmt->get_result();
    $part = $result->fetch_assoc();

    if (!$part) throw new Exception('Could not find a single part in database');

    return $part;
  }

  public static function getComputerPartsByTypes(string $type): array
  {
    $db = new MySQLWrapper();

    $stmt = $db->prepare("SELECT * FROM computer_parts WHERE type = ?");
    $stmt->bind_param('s', $type);
    $stmt->execute();

    $result = $stmt->get_result();
    $parts = $result->fetch_all(MYSQLI_ASSOC);


    if (!$parts) throw new Exception('Could not find a single part in database');

    return $parts;
  }

  public static function getRandomCPU(): array
  {
    $db = new MySQLWrapper();

    // Databaseから取得したランダムなパーツ構成されたパソコンを取得
    $stmt = $db->prepare("SELECT * FROM computer_parts WHERE type = 'CPU' ORDER BY RAND() LIMIT 1");
    $stmt->execute();
    $result = $stmt->get_result();
    $computer = $result->fetch_assoc();

    if (!$computer) throw new Exception('Could not find a single CPU in database');

    return $computer;
  }

  public static function getRandomGPU(): array
  {
    $db = new MySQLWrapper();

    // Databaseから取得したランダムなパーツ構成されたパソコンを取得
    $stmt = $db->prepare("SELECT * FROM computer_parts WHERE type = 'GPU' ORDER BY RAND() LIMIT 1");
    $stmt->execute();
    $result = $stmt->get_result();
    $computer = $result->fetch_assoc();

    if (!$computer) throw new Exception('Could not find a single GPU in database');

    return $computer;
  }

  public static function getRandomRAM(): array
  {
    $db = new MySQLWrapper();

    // Databaseから取得したランダムなパーツ構成されたパソコンを取得
    $stmt = $db->prepare("SELECT * FROM computer_parts WHERE type = 'RAM' ORDER BY RAND() LIMIT 1");
    $stmt->execute();
    $result = $stmt->get_result();
    $computer = $result->fetch_assoc();

    if (!$computer) throw new Exception('Could not find a single RAM in database');

    return $computer;
  }
  public static function getRandomSSD(): array
  {
    $db = new MySQLWrapper();

    // Databaseから取得したランダムなパーツ構成されたパソコンを取得
    $stmt = $db->prepare("SELECT * FROM computer_parts WHERE type = 'SSD' ORDER BY RAND() LIMIT 1");
    $stmt->execute();
    $result = $stmt->get_result();
    $computer = $result->fetch_assoc();

    if (!$computer) throw new Exception('Could not find a single SSD in database');

    return $computer;
  }

  public static function getNewestComputerPart(): array
  {
    $db = new MySQLWrapper();

    $stmt = $db->prepare("SELECT * FROM computer_parts ORDER BY created_at DESC");
    $stmt->execute();
    $result = $stmt->get_result();
    $part = $result->fetch_all(MYSQLI_ASSOC);

    if (!$part) throw new Exception('Could not find parts in database');

    return $part;
  }

  public static function getComputerPartByPerformance(string $type, string $order): array
  {
    $db = new MySQLWrapper();

    $order = ($order === 'asc') ? 'ASC' : 'DESC';

    $stmt = $db->prepare("SELECT * FROM computer_parts WHERE type = ? ORDER BY performance_score $order LIMIT 50");
    $stmt->bind_param('s', $type);
    $stmt->execute();
    $result = $stmt->get_result();
    $part = $result->fetch_all(MYSQLI_ASSOC);

    if (!$part) throw new Exception('Could not find parts in database');

    return $part;
  }
}

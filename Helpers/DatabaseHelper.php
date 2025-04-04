<?php

namespace Helpers;

use Database\MySQLWrapper;
use DateTime;
use Dom\Mysql;
use Exception;

class DatabaseHelper{

  public static function saveSnippet(): String{
    // データ取得。ここでHTTPプロトコルの仕組みやphpでどう取得するのか学んだ。キータにまとめたい。
    $data = json_decode(file_get_contents('php://input'), true);
    $content = $data['content'];
    $language = $data['language'];
    $expires_in = $data['expires_in'];

    // ここで日本の時間に設定しないと時間がおかしくなることを学んだ。
    $now = new DateTime('now', new \DateTimeZone('Asia/Tokyo'));
    
    switch ($expires_in) {
      case '10m':
        $now->modify('+10 minutes');
        break;
      case '1h':
        $now->modify('+1 hour');
        break;
      case '1d':
        $now->modify('+1 day');
        break;
      case 'never':
        $now = null;
        break;
    }

    $expires_at = $now ? $now->format('Y-m-d H:i:s') : null;

    // urlを作成。安全な一意な文字列精製方法についてキータにまとめる
    $base = $content . microtime(true) . bin2hex(random_bytes(5));
    $slug = substr(hash('sha256', $base), 0, 12);

    $db = new MySQLWrapper();

    $stmt = $db->prepare("INSERT INTO snippets (slug, content, language, expires_at) VALUES (?, ?, ?, ?)");
    $stmt->bind_param('ssss', $slug, $content, $language, $expires_at);
    $stmt->execute();

    return 'localhost:8000/snippets/get?slug=' . $slug;

}

  public static function getSnippet(): ?Array{
    $slug = $_GET['slug'];

    $db = new MySQLWrapper();
    $stmt = $db->prepare("SELECT content, language, deleted_at FROM snippets WHERE slug = ?");
    $stmt->bind_param('s', $slug);
    $stmt->execute();

    $data = $stmt->get_result();

    return $data->fetch_assoc();
  }

  public static function softDeleteSnippet(){
    $slug = $_GET['slug'];

    $db = new MySQLWrapper();
    $stmt = $db->prepare("UPDATE snippets SET deleted_at = NOW() WHERE slug = ?");
    $stmt->bind_param('s', $slug);
    $stmt->execute();
  }

  public static function hardDeleteSnippet(){
    $slug = $_GET['slug'];

    $db = new MySQLWrapper();
    $stmt = $db->prepare("DELETE FROM snippets WHERE slug = ?");
    $stmt->bind_param('s', $slug);
    $stmt->execute();
  }
}
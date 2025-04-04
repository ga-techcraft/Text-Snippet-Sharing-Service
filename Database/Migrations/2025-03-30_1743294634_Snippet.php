<?php
namespace Database\Migrations;

use Database\SchemaMigration;

class Snippet implements SchemaMigration
{
    public function up(): array
    {
        // マイグレーションロジックをここに追加してください
        return [
            '
            CREATE TABLE snippets (
                id INT AUTO_INCREMENT PRIMARY KEY,
                slug VARCHAR(255) NOT NULL UNIQUE,       
                content TEXT NOT NULL,                 
                language VARCHAR(30) NOT NULL,  
                deleted_at DATETIME DEFAULT NULL,       
                created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                expires_at DATETIME DEFAULT NULL         -- 有効期限（NULLなら期限なし）
            );
            '
        ];
    }

    public function down(): array
    {
        // ロールバックロジックを追加してください
        return ['DROP TABLE snippets'];
    }
}
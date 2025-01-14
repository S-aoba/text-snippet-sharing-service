<?php
namespace Database\Migrations;

use Database\SchemaMigration;

class CreateSnippetTable implements SchemaMigration
{
    public function up(): array
    {
        // マイグレーションロジックをここに追加してください
        return [
            "CREATE TABLE IF NOT EXISTS snippets (
                id INT PRIMARY KEY AUTO_INCREMENT,
                snippet Text,
                password VARCHAR(255),
                language VARCHAR(50),
                expired_at DATETIME,
                created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
            )"
        ];
    }

    public function down(): array
    {
        // ロールバックロジックを追加してください
        return [
            "DROP TABLE snippets"
        ];
    }
}
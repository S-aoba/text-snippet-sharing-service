<?php
namespace Database\Migrations;

use Database\SchemaMigration;

class UpdateSnippetTable implements SchemaMigration
{
    public function up(): array
    {
        // マイグレーションロジックをここに追加してください
        return [
            "ALTER TABLE snippets
                ADD COLUMN hashed_str VARCHAR(64) NOT NULL
            "
        ];
    }

    public function down(): array
    {
        // ロールバックロジックを追加してください
        return [
            "ALTER TABLE snippets
                DROP COLUMN hashed_str
            "
        ];
    }
}
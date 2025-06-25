-- Tambahkan kolom discussion_category_id ke tabel discussions jika belum ada
ALTER TABLE discussions ADD COLUMN IF NOT EXISTS discussion_category_id BIGINT UNSIGNED NULL AFTER user_id; 
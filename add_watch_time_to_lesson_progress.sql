-- Add watch_time column to lesson_progress table
ALTER TABLE `lesson_progress` 
ADD COLUMN `watch_time` INT UNSIGNED NOT NULL DEFAULT 0 AFTER `is_completed`; 
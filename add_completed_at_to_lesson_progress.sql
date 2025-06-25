-- Add completed_at column to lesson_progress table
ALTER TABLE `lesson_progress` 
ADD COLUMN `completed_at` TIMESTAMP NULL AFTER `is_completed`; 
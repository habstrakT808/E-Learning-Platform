-- Rename column 'completed' to 'is_completed' in lesson_progress table
ALTER TABLE `lesson_progress` 
CHANGE COLUMN `completed` `is_completed` TINYINT(1) NOT NULL DEFAULT '0'; 
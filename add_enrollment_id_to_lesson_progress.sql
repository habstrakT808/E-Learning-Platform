-- Add enrollment_id column to lesson_progress table
ALTER TABLE `lesson_progress` 
ADD COLUMN `enrollment_id` BIGINT UNSIGNED NULL AFTER `lesson_id`,
ADD CONSTRAINT `lesson_progress_enrollment_id_foreign` FOREIGN KEY (`enrollment_id`) REFERENCES `enrollments` (`id`) ON DELETE CASCADE; 
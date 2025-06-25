-- Add is_favorite column to bookmarks table
ALTER TABLE bookmarks ADD COLUMN is_favorite BOOLEAN DEFAULT FALSE AFTER notes;

-- Create index for faster queries
ALTER TABLE bookmarks ADD INDEX idx_is_favorite (is_favorite);

-- Set default values for any existing bookmarks
UPDATE bookmarks SET is_favorite = FALSE WHERE is_favorite IS NULL; 
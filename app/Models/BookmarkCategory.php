<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class BookmarkCategory extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'name',
        'color',
        'icon',
        'order',
    ];

    /**
     * Get the user who owns this category.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the bookmarks in this category.
     */
    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class, 'bookmark_category_id');
    }

    /**
     * Scope categories to current authenticated user.
     */
    public function scopeForCurrentUser($query)
    {
        return $query->where('user_id', Auth::id());
    }

    /**
     * Get bookmark count attribute.
     */
    public function getBookmarkCountAttribute()
    {
        return $this->bookmarks()->count();
    }

    /**
     * Create default bookmark categories for a user
     */
    public static function createDefaultCategoriesFor($userId)
    {
        $defaultCategories = [
            [
                'name' => 'Pelajaran',
                'description' => 'Kumpulan materi pelajaran yang disimpan',
                'color' => '#3B82F6',
                'icon' => 'book-open',
            ],
            [
                'name' => 'Referensi',
                'description' => 'Referensi dan sumber belajar tambahan',
                'color' => '#10B981',
                'icon' => 'document',
            ],
            [
                'name' => 'Diskusi',
                'description' => 'Diskusi menarik yang ingin disimpan',
                'color' => '#F59E0B',
                'icon' => 'chat',
            ],
            [
                'name' => 'Favorit',
                'description' => 'Konten yang paling sering diakses',
                'color' => '#EF4444',
                'icon' => 'star',
            ],
        ];
        
        foreach ($defaultCategories as $category) {
            self::create([
                'user_id' => $userId,
                'name' => $category['name'],
                'description' => $category['description'],
                'color' => $category['color'],
                'icon' => $category['icon'],
            ]);
        }
    }
}

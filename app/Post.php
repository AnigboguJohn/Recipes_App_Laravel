<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /** Recipe categories shown as chips on the home page. */
    public const CATEGORIES = [
        'Breakfast' => '🍳',
        'Lunch' => '🍛',
        'Dinner' => '🍢',
        'Soups' => '🍲',
        'Snacks' => '🥯',
        'Desserts' => '🍰',
        'Drinks' => '🥤',
    ];

    public const DIFFICULTIES = ['Easy', 'Medium', 'Hard'];

    protected $fillable = [
        'title', 'preptime', 'description', 'ingredients', 'preparation',
        'category', 'servings', 'difficulty', 'calories',
    ];

    /** A recipe belongs to the user who posted it. */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function ratings()
    {
        return $this->hasMany('App\Rating');
    }

    /** Users who saved this recipe. */
    public function savedBy()
    {
        return $this->belongsToMany('App\User', 'favorites')->withTimestamps();
    }

    /** Public URL of the cover photo. */
    public function coverUrl(): string
    {
        return asset('storage/covers/' . rawurlencode($this->cover));
    }

    public function categoryIcon(): string
    {
        return self::CATEGORIES[$this->category] ?? '🍽️';
    }

    /** Average stars, from withAvg('ratings', 'stars') when loaded. */
    public function averageRating(): ?float
    {
        $avg = $this->ratings_avg_stars ?? $this->ratings()->avg('stars');

        return $avg ? round((float) $avg, 1) : null;
    }

    /** Ingredients, one per line. */
    public function ingredientList(): array
    {
        return $this->lines($this->ingredients);
    }

    /** Preparation steps, one per line, without "1." style numbering. */
    public function steps(): array
    {
        return array_map(function ($line) {
            return preg_replace('/^\s*(step\s*)?\d+\s*[.):-]\s*/i', '', $line);
        }, $this->lines($this->preparation));
    }

    /** Minutes mentioned in a step ("cook for 4 to 5 minutes" gives 5), for the cooking timer. */
    public static function stepMinutes(string $step): ?int
    {
        if (preg_match('/(\d+)(?:\s*(?:to|-|–)\s*(\d+))?\s*(?:minutes?|mins?)\b/i', $step, $m)) {
            return (int) ($m[2] ?? $m[1]);
        }
        if (preg_match('/(\d+)\s*(?:hours?|hrs?)\b/i', $step, $m)) {
            return (int) $m[1] * 60;
        }

        return null;
    }

    private function lines(?string $text): array
    {
        $lines = preg_split('/\r\n|\r|\n/', (string) $text);

        return array_values(array_filter(array_map('trim', $lines), 'strlen'));
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Anime extends Model {
    protected $fillable = [
        'user_id','title','genre','status',
        'total_episodes','episodes_watched','rating','notes','cover_image'
    ];

    protected $casts = ['rating' => 'decimal:1'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function getProgressAttribute(): int {
        if (!$this->total_episodes || $this->total_episodes == 0) return 0;
        return min(100, (int)round($this->episodes_watched / $this->total_episodes * 100));
    }

    public function getStatusLabelAttribute(): string {
        return match($this->status) {
            'watching'      => 'Watching',
            'completed'     => 'Completed',
            'plan_to_watch' => 'Plan to Watch',
            'dropped'       => 'Dropped',
            default         => ucfirst($this->status),
        };
    }

    public function getStatusColorAttribute(): string {
        return match($this->status) {
            'watching'      => 'primary',
            'completed'     => 'success',
            'plan_to_watch' => 'warning',
            'dropped'       => 'danger',
            default         => 'secondary',
        };
    }

    public function getCoverUrlAttribute(): string {
        return $this->cover_image
            ? asset('uploads/anime_covers/' . $this->cover_image)
            : asset('assets/img/no-cover.png');
    }
}

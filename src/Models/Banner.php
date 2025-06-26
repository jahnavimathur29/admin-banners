<?php

namespace admin\banners\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Banner extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'title',
        'sub_title',
        'description',
        'button_title',
        'button_url',
        'sort_order',
        'image',
    ];

    public function scopeFilter($query, $keyword)
    {
        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', '%' . $keyword . '%')
                  ->orWhere('sub_title', 'like', '%' . $keyword . '%');
            });
        }
        return $query;
    }
}


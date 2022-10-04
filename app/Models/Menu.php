<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $hidden = ['created_at', 'updated_at', 'picked_count', 'is_picked'];
    protected $fillable = ['name', 'is_picked', 'picked_count'];

    public function scopePicked($query)
    {
        return $query->where('is_picked', 1);
    }
}

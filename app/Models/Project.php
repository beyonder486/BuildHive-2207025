<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'client_id', 'title', 'description', 'budget', 'status', 'deadline', 'skills_required',
    ];

    protected function casts(): array
    {
        return [
            'skills_required' => 'array',
            'deadline' => 'date',
            'budget' => 'decimal:2',
        ];
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function proposals()
    {
        return $this->hasMany(Proposal::class);
    }

    public function team()
    {
        return $this->hasOne(Team::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function taskProgress(): int
    {
        $total = $this->tasks()->count();
        if ($total === 0) return 0;
        return (int) round(($this->tasks()->where('status', 'done')->count() / $total) * 100);
    }
}

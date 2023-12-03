<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    use Notifiable, HasFactory;

    public const CATEGORIES = [
        'cultural',
        'sporting',
    ];

    public const STATUSES = [
        'empty',
        'full',
        'not_yet_started',
        'ongoing',
        'cancelled',
        'finished',
        'max_participants',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'start_date',
        'end_date',
        'category',
        'status',
        'color',
    ];

    public function eventParticipants(): HasMany
    {
        return $this->hasMany(EventParticipant::class);
    }
}

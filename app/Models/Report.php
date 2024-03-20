<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Report extends Model
{
    use Notifiable;

    public const TYPES = [
        'dispute_resolution' => 'Dispute Resolution (Conflicts between residents)',
        'waste_management' => 'Waste Management (Issues related to garbage collection, disposal, etc.)',
        'public_safety' => 'Public Safety (Concerns about crime, security, etc.)',
        'infra_maintenance' => 'Infrastructure Maintenance (Problems with roads, drainage, or public facilities)',
        'land_dispute' => 'Land dispute',
        'noise_complaints' => 'Noise Complaints',
        'water_supply' => 'Water Supply Issues',
    ];

    public const STATUS = [
        'pending' => [
            'color' => 'warning',
            'value' => 'Pending',
        ],
        'ongoing' => [
            'color' => 'info',
            'value' => 'Ongoing',
        ],
        'declined' => [
            'color' => 'danger',
            'value' => 'Declined',
        ],
        'done' => [
            'color' => 'success',
            'value' => 'Done',
        ],
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'reported_at',
        'description',
        'category',
        'attached_file',
        'note_by_admin',
        'status',
        'is_anonymous',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reportNotes(): HasMany
    {
        return $this->hasMany(ReportNote::class);
    }
}

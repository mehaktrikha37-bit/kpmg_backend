<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LeadCustomerTimeline extends Model
{
    use HasFactory;

    protected $table = 'lead_customer_timelines';

    // No updated_at; only created_at (set by useCurrent() in migration)
    public $timestamps = false;

    protected $fillable = [
        'customer_id',
        'action',
        'remarks',
        'created_by',
    ];

    /**
     * Get the customer associated with this timeline entry.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(LeadCustomer::class, 'customer_id');
    }

    /**
     * Get the user who triggered this action.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(LeadUser::class, 'created_by');
    }
}

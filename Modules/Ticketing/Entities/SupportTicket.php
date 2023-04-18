<?php

namespace Modules\Ticketing\Entities;

use Modules\Admin\Entities\Pop;
use Modules\Admin\Entities\User;
use Illuminate\Database\Eloquent\Model;
use Modules\Sales\Entities\ClientDetail;
use Modules\Ticketing\Entities\ClientFeedback;

class SupportTicket extends Model
{
    protected $guarded = [];

    public function supportComplainType() {
        return $this->belongsTo(SupportComplainType::class);
    }

    public function ticketSource() {
        return $this->belongsTo(TicketSource::class);
    }

    public function createdBy() {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function clientDetail() {
        return $this->belongsTo(ClientDetail::class, 'fr_composite_key', 'fr_composite_key');
    }

    public function supportTicketLifeCycles() {
        return $this->hasMany(SupportTicketLifeCycle::class);
    }

    public function clientFeedbacks() {
        return $this->hasMany(ClientFeedback::class);
    }

    public function pop() {
        return $this->belongsTo(Pop::class);
    }

    public function closedBy() {
        return $this->belongsTo(User::class, 'closed_by');
    }

    public function ticketFeedbacks() {
        return $this->morphMany(TicketFeedback::class, 'feedbacks', 'feedbackable_type', 'feedbackable_id');
    }

    public function scopePending($query) {
        return $query->where('status', 'Pending');
    }

    public function scopeAssigned($query) {
        return $query->where('status', 'Accepted');
    }

    public function scopeProcessing($query) {
        return $query->where('status', 'Processing');
    }

    public function scopeClosed($query) {
        return $query->where('status', 'Closed');
    }
}

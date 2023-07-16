<?php

namespace Modules\Ticketing\Entities;

use Modules\Admin\Entities\Pop;
use Modules\Admin\Entities\User;
use Illuminate\Database\Eloquent\Model;
use Modules\Networking\Entities\PhysicalConnectivity;
use Modules\Networking\Entities\PhysicalConnectivityLines;
use Modules\Sales\Entities\Client;
use Modules\Sales\Entities\FeasibilityRequirementDetail;
use Modules\Ticketing\Entities\ClientFeedback;

class SupportTicket extends Model
{
    protected $guarded = [];

    public function supportComplainType()
    {
        return $this->belongsTo(SupportComplainType::class);
    }

    public function ticketSource()
    {
        return $this->belongsTo(TicketSource::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_no', 'client_no');
    }

    public function supportTicketLifeCycles()
    {
        return $this->hasMany(SupportTicketLifeCycle::class);
    }

    public function clientFeedbacks()
    {
        return $this->hasMany(ClientFeedback::class);
    }

    public function pop()
    {
        return $this->belongsTo(Pop::class);
    }

    public function closedBy()
    {
        return $this->belongsTo(User::class, 'closed_by');
    }

    public function ticketFeedbacks()
    {
        return $this->morphMany(TicketFeedback::class, 'feedbacks', 'feedbackable_type', 'feedbackable_id');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'Pending');
    }

    public function scopeAssigned($query)
    {
        return $query->where('status', 'Accepted');
    }

    public function scopeProcessing($query)
    {
        return $query->where('status', 'Processing');
    }

    public function scopeClosed($query)
    {
        return $query->where('status', 'Closed');
    }

    public function physicalConnectivity()
    {
        return $this->hasOne(PhysicalConnectivity::class, 'fr_no', 'fr_no');
    }

    public function feasibilityRequirementDetails()
    {
        return $this->hasOne(FeasibilityRequirementDetail::class, 'fr_no', 'fr_no');
    }
}

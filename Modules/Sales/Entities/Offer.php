<?php

namespace Modules\Sales\Entities;

use Modules\Sales\Entities\Client;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Offer extends Model
{
    protected $guarded = [];

    protected $fillable = ['client_no', 'mq_no', 'offer_validity'];

    public function getOfferValidityAttribute($input)
    {
        return Carbon::createFromFormat('Y-m-d', $input)->format('d/m/Y');
    }

    /**
     * @param $input
     */
    public function setOfferValidityAttribute($input)
    {
        !empty($input) ? $this->attributes['offer_validity'] = Carbon::createFromFormat('d/m/Y', $input)->format('Y-m-d') : null;
    }

    public function lead_generation()
    {
        return $this->belongsTo(LeadGeneration::class, 'client_no', 'client_no');
    }

    // public function offerLinks()
    // {
    //     return $this->hasMany(offerLinks::Class, 'client_no', 'client_no');
    // }

    public function offerDetails()
    {
        return $this->hasMany(OfferDetail::class);
    }
}

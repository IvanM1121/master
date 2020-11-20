<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class lead_source_users extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'lead_source_users';

   
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function leadsource()
    {
        return $this->belongsTo('App\LeadSource');
    }
}
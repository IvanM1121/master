<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'purchase_orders';
    // public function supplier()//20201117
    // {
    //     return $this->belongsTo('App\Supplier');
    // }  

    public function chartofaccount()//20201117
    {
        return $this->belongsTo('App\ChartOfAccount','chart_of_accounts_id')->withDefault();
    }

    public function purchase_items()
    {
        return $this->hasMany('App\PurchaseOrderItem',"purchase_order_id");
    }

    public function supplier()
    {
        return $this->belongsTo('App\Supplier',"supplier_id")->withDefault();
    }

    public function tax()
    {
        return $this->belongsTo('App\Tax',"tax_id")->withDefault();
    }

}
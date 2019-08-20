<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConsignmentOrderDetails extends Model
{
    protected $table = 'mi.vw_ConsignmentOrderDetails';
    protected $primaryKey = 'CA Order ID';
    public $timestamps = false;
    protected $guarded = [];

}

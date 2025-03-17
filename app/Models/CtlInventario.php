<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class CtlInventario extends Model
{
    //
    use HasFactory, Notifiable, HasRoles;
    protected $table = "ctl_inventario";
    protected $fillable = [
        "product_id",
        "cantidad"
    ];

    public function productos(){
        return $this->belongsTo(CtlProductos::class,"id","product_id");
    }

}

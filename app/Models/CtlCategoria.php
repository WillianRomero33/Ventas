<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class CtlCategoria extends Model
{
    //
    use HasFactory, Notifiable, HasRoles;

    protected $table = 'ctl_categoria';
    protected $fillable = [
        'nombre'
    ];

    public function productos(){
        return $this->belongsTo(CtlProductos::class,'id','product_id');
    }
}

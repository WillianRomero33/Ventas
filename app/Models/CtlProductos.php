<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class CtlProductos extends Model
{
    //
    use HasFactory, Notifiable, HasRoles;
    protected $table = 'ctl_productos';
    protected $fillable = [
        'nombre',
        'precio',
        'imagen',
        'categoria_id'
    ];

    public function categoria()
    {
        return $this->belongsTo(CtlCategoria::class, 'categoria_id', 'id');
    }
    public function inventario(){
        return $this->belongsTo(CtlInventario::class,'id','producto_id');
    }
    public function detallePedido(){
        return $this->hasMany(MntDetallePedido::class,'producto_id','id');
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class MntDetallePedido extends Model
{
    //
    use HasFactory, Notifiable, HasRoles;
    protected $table = '_mnt_detalle_pedidos';
    protected $fillable = [
        'pedido_id',
        'product_id',
        'cantidad',
        'sub_total'
        ];
    public function pedidos(){
        return $this->belongsTo(MntPedido::class,'id','pedido_id');
    }
    public function producto(){
        return $this->belongsTo(CtlProductos::class,'producto_id','id');
    }
}

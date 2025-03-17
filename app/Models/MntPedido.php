<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class MntPedido extends Model
{
    //
    use HasFactory, Notifiable, HasRoles;
    protected $table = 'mnt_pedidos';
    protected $fillable = [
        'fecha_pedido',
        'estado',
        'total',
        'client_id'
        ];
    public function cliente(){
        return $this->belongsTo(MntCliente::class,'client_id','id');
    }
    public function detallePedido(){
        return $this->hasMany(MntDetallePedido::class,'pedido_id','id');
    }
}

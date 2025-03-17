<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class MntCliente extends Model
{
    //
    use HasFactory, Notifiable, HasRoles;
    protected $table = "mnt_clientes";
    protected $fillable = [
        'id',
        'nombre',
        'apellido',
        'email',
        'user_id',
        'direccion_envio',
        'direccion_facturacion',
        'telefono'
        ];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function pedido(){
        return $this->belongsTo(MntPedido::class,'client_id','id');
    }
}

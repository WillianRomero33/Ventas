<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

class CtlCategoria extends Model
{
    //
    use HasFactory, Notifiable, HasRoles;

    protected $table = 'ctl_categorias';
    protected $fillable = [
        'nombre'
    ];
    public function productos()
    {
        return $this->hasMany(CtlProductos::class, 'categoria_id', 'id');
    }
}
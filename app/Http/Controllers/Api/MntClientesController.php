<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Response\ApiResponse;
use App\Models\MntCliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class MntClientesController extends Controller
{
    public function store(Request $request)
    {
        try {
            // Mensajes de validación personalizados
            $messages = [
                "nombre.required" => "Nombre es requerido",
                "nombre.max" => "Nombre no debe pasar de 255 caracteres",
                "nombre.unique" => "Nombre ya existe",
                "apellido.required" => "Apellido es requerido",
                "apellido.max" => "Apellido no debe pasar de 255 caracteres",
                "email.required" => "Email es requerido",
                "email.max" => "Email no debe pasar de 500 caracteres",
                "direccion_envio.required" => "Dirección de envío es requerida",
                "direccion_facturacion.required" => "Dirección de facturación es requerida",
                "telefono.required" => "Teléfono es requerido",
            ];

            // Reglas de validación
            $rules = [
                "nombre" => "required|max:255|unique:mnt_clientes,nombre",
                "apellido" => "required|max:255",
                "email" => "required|max:500|unique:mnt_clientes,email",
                "direccion_envio" => "required",
                "direccion_facturacion" => "required",
                "telefono" => "required",
            ];

            // Validar los datos de entrada
            $validator = Validator::make($request->all(), $rules, $messages);

            // Si la validación falla, retornar errores
            if ($validator->fails()) {
                return ApiResponse::error('Error de validación', 422, $validator->errors());
            }

            // Iniciar una transacción de base de datos
            DB::beginTransaction();

            // Crear el cliente
            $cliente = MntCliente::create($request->all());

            // Confirmar la transacción
            DB::commit();

            // Retornar respuesta exitosa
            return ApiResponse::success('Cliente creado exitosamente', 201, $cliente);

        } catch (\Exception $e) {
            // Revertir la transacción en caso de error
            DB::rollBack();

            // Retornar respuesta de error
            return ApiResponse::error('Error al crear el cliente: ' . $e->getMessage(), 500);
        }
    }
}
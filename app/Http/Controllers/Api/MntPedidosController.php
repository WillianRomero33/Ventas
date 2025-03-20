<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePedidoRequest;
use App\Http\Response\ApiResponse;
use App\Models\MntDetallePedido;
use App\Models\MntDetallePedidos;
use App\Models\MntPedido;
use App\Models\MntPedidos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MntPedidosController extends Controller
{
    //
    public function index(Request $request)
{
    try {
        // Obtener el usuario autenticado
        $user = auth()->user();

        // filtrar por
        $categoriaId = $request->input('categoria_id');
        $productoId = $request->input('producto_id');

        // query
        $query = MntPedido::with([
            'detallePedido.producto.categoria',
            'cliente'
        ])->where('client_id', $user->id); // pedidos del usuario logueado

        if ($categoriaId) {
            $query->whereHas('detallePedido.producto.categoria', function ($q) use ($categoriaId) {
                $q->where('id', $categoriaId);
            });
        }

        // Filtrar por producto
        if ($productoId) {
            $query->whereHas('detallePedido.producto', function ($q) use ($productoId) {
                $q->where('id', $productoId);
            });
        }


        $pedidos = $query->paginate(10);

        // Formatear la data 
        $data = $pedidos->map(function ($pedido) {
            return [
                'id' => $pedido->id,
                'fecha_pedido' => $pedido->fecha_pedido,
                'estado' => $pedido->estado,
                'total' => $pedido->total,
                'cliente' => $pedido->cliente->nombre ?? 'Desconocido',
                'productos' => $pedido->detallePedido->map(function ($detalle) {
                    return [
                        'producto' => $detalle->producto->nombre ?? 'Sin nombre',
                        'categoria' => $detalle->producto->categoria->nombre ?? 'Sin categoría',
                        'cantidad' => $detalle->cantidad,
                        'sub_total' => $detalle->sub_total,
                    ];
                }),
            ];
        });

        return ApiResponse::success('Pedidos filtrados', 200, $data);
    } catch (\Exception $e) {
        return ApiResponse::error('Error al traer los pedidos: ' . $e->getMessage(), 422);
    }
}




    public function store(Request $request){

        $message = [
            "fecha_pedido.required" => "La fecha de pedido es obligatoria",
            "fecha_pedido.date" => "La fecha debe ser formato de fecha",
            "detalle" => "El detalle debe de ser un arreglo",
            "client_id.required" => "El cliente es requerido",
            "client_id.exists" => "El cliente debe estar registrado",
            "detalle.*.product_id.required" => "El producto es obligatorio",
            "detalle.*.product_id.exists" => "Seleccione un producto existente",
            "detalle.*.cantidad.required" => "La cantidad es obligatoria",
            "detalle.*.cantidad.numeric" => "La cantidad debe de ser un numero",
            "detalle.*.precio.required" => "El precio es obligatorio",
            "detalle.*.precio.numeric" => "El precio debe de ser un numero"
        ];

        $validator = Validator::make($request->all(), [
            "fecha_pedido" => "required|date",
            "client_id" => "required|exists:mnt_clientes,id",
            "detalle" => "array",
            "detalle.*.product_id" => "required|exists:ctl_productos,id",
            "detalle.*.precio" => "required|numeric",
            "detalle.*.cantidad" => "required|numeric",
        ], $message);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $pedido = new MntPedido();
            $pedido->fecha_pedido = $request->fecha_pedido; // Correct assignment
            $pedido->client_id = $request->client_id;

            if ($pedido->save()) {
                $totalF = 0;
                // return $request->all();
                foreach ($request->detalle as $d) {
                    $detalle = new MntDetallePedido();
                    $detalle->pedido_id = $pedido->id;
                    $detalle->producto_id = $d['product_id'];
                    $detalle->cantidad = $d['cantidad'];
                    $detalle->precio = $d['precio'];
                    $detalle->sub_total = $d['cantidad'] * $d['precio'];
                    $detalle->save();

                    $totalF += $detalle->sub_total;
                }
                // return $totalF;
                $pedido->total = $totalF;
                $pedido->save();
                DB::commit();

                return ApiResponse::success('Pedido creado', 200, $pedido);
            } else {
                DB::rollBack();
                return ApiResponse::error('Error al crear el pedido', 422);
            }

        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::error($e->getMessage(), 422);
        }
    }
}
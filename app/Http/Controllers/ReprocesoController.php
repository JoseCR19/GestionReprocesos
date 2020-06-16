<?php

namespace App\Http\Controllers;

use App\Motivo;
use App\Reproceso;
use App\Reproceso_detalle;
use DB;
use Illuminate\Http\Request;

class ReprocesoController extends Controller {

    use \App\Traits\ApiResponser;

    // Illuminate\Support\Facades\DB;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        //
    }

    /**
     * @OA\Info(title="Gestion Reprocesos", version="1",  
     * @OA\Contact(
     *     email="antony.rodriguez@mimco.com.pe"
     *   )
     * )
     */

    /**
     * @OA\Post(
     *     path="/GestionReprocesos/public/index.php/comb_codi",
     *     tags={"Reproceso - Combo Codigos"},
     *     summary="Obtiene los codigos",
     *     @OA\Parameter(
     *         description="Codigo de Proyecto",
     *         in="path",
     *         name="intIdProy",
     *         example = "193",
     *         required=true,
     *         @OA\Schema(
     *           type="number" 
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="Codigo de Producto",
     *         in="path",
     *         name="intIdTipoProducto",
     *         example = "1",
     *         required=true,
     *         @OA\Schema(
     *           type="number" 
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="Codigo de Zona",
     *         in="path",
     *         name="intIdProyZona",
     *         example = "1",
     *         required=true,
     *         @OA\Schema(
     *           type="number" 
     *         )
     *     ),
     *       
     *    @OA\Parameter(
     *         description="Codigo de Tarea",
     *         in="path",
     *         name="intIdProyTarea",
     *         example = "1",
     *         required=true,
     *         @OA\Schema(
     *           type="number" 
     *         )
     *     ), 
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="intIdProy",
     *                     type="number"
     *                 ) ,
     *                 
     *                 @OA\Property(
     *                     property="intIdTipoProducto",
     *                     type="number"
     *                 ) ,
     *                 @OA\Property(
     *                     property="intIdProyZona",
     *                     type="number"
     *                 ) ,
     *                 @OA\Property(
     *                     property="intIdProyTarea",
     *                     type="number"
     *                 ) ,
     *                 example={"intIdProy": "193","intIdTipoProducto":"1","intIdProyZona":"1","intIdProyTarea":"1"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Sin Mensaje"
     *     ),
     *     @OA\Response(
     *         response=407,
     *         description="El Documento de identidad ingresado no se encuentra registrado."
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No se encuentra el metodo"
     *     )
     * )
     */
    /* FUNCION PARA EL COMBO DE CODIGOS */
    public function combo_codigos(Request $request) {
        $regla = [
            'intIdProy' => 'required|max:255',
            'intIdTipoProducto' => 'required|max:255',
            'intIdProyZona' => 'required|max:255',
            'intIdProyTarea' => 'required|max:255'
        ];
        $this->validate($request, $regla);
        $v_intIdproy = (int) $request->input('intIdProy');
        $v_intIdTipoProducto = (int) $request->input('intIdTipoProducto');
        $v_intIdZona = (int) $request->input('intIdProyZona');
        $v_intPrograma = (int) $request->input('intIdProyTarea');
        if ($v_intIdZona === -1) {
            $result = DB::select('select distinct varCodiElemento from elemento where intIdProy=' . $v_intIdproy . ' and intIdTipoProducto = ' . $v_intIdTipoProducto);
        } else if ($v_intIdZona !== -1) {
            $result = DB::select('select distinct varCodiElemento from elemento where intIdProy=' . $v_intIdproy . ' and intIdTipoProducto = ' . $v_intIdTipoProducto . ' and intIdProyZona=' . $v_intIdZona);
        } else {
            $result = DB::select('select distinct varCodiElemento from elemento where intIdProy=' . $v_intIdproy . ' and intIdTipoProducto = ' . $v_intIdTipoProducto . ' and intIdProyZona=' . $v_intIdZona . ' and intIdProyTarea=' . $v_intPrograma);
        }
        return $this->successResponse($result);
    }

    /* FUNCION PARA LISTAR ELEMENTOS DE REPROCESO */

    /**
     * @OA\Post(
     *     path="/GestionReprocesos/public/index.php/list_elem",
     *     tags={"Reproceso - Lista de Elementos"},
     *     summary="Obtiene los Elementos para el reproceso",
     *     @OA\Parameter(
     *         description="Codigo de Proyecto",
     *         in="path",
     *         name="v_intIdproy",
     *         example = "193",
     *         required=true,
     *         @OA\Schema(
     *           type="number" 
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="Codigo de Producto",
     *         in="path",
     *         name="v_intIdTipoProducto",
     *         example = "1",
     *         required=true,
     *         @OA\Schema(
     *           type="number" 
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="Codigo de Zona",
     *         in="path",
     *         name="v_intIdZona",
     *         example = "1",
     *         required=true,
     *         @OA\Schema(
     *           type="number" 
     *         )
     *     ),
     *       
     *    @OA\Parameter(
     *         description="Codigo de Tarea",
     *         in="path",
     *         name="v_intPrograma",
     *         example = "1",
     *         required=true,
     *         @OA\Schema(
     *           type="number" 
     *         )
     *     ), 
     *    @OA\Parameter(
     *         description="Codigo de Etapa Actual",
     *         in="path",
     *         name="v_intIdEtapaActual",
     *         example = "1",
     *         required=true,
     *         @OA\Schema(
     *           type="number" 
     *         )
     *     ), 
     *    @OA\Parameter(
     *         description="Codigo de Ruta",
     *         in="path",
     *         name="v_intIdRuta",
     *         example = "1",
     *         required=true,
     *         @OA\Schema(
     *           type="number" 
     *         )
     *     ), 
     *    @OA\Parameter(
     *         description="Codigo de Elemento",
     *         in="path",
     *         name="v_varCodiElemento",
     *         example = "G2-T1",
     *         required=true,
     *         @OA\Schema(
     *           type="string" 
     *         )
     *     ), 
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="v_intIdproy",
     *                     type="number"
     *                 ) ,
     *                 
     *                 @OA\Property(
     *                     property="v_intIdTipoProducto",
     *                     type="number"
     *                 ) ,
     *                 @OA\Property(
     *                     property="v_intIdZona",
     *                     type="number"
     *                 ) ,
     *                 @OA\Property(
     *                     property="v_intPrograma",
     *                     type="number"
     *                 ) ,
     *                 @OA\Property(
     *                     property="v_intIdEtapaActual",
     *                     type="number"
     *                 ) ,
     *                 @OA\Property(
     *                     property="v_intIdRuta",
     *                     type="number"
     *                 ) , 
     *                 @OA\Property(
     *                     property="v_varCodiElemento",
     *                     type="string"
     *                 ) ,          
     *                 example={"v_intIdproy": "193","v_intIdTipoProducto":"1","v_intIdZona":"1","v_intPrograma":"1",
     *                          "v_intIdEtapaActual":"1","v_intIdRuta":"1","v_varCodiElemento":"G2-T1"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Sin Mensaje"
     *     ),
     *     @OA\Response(
     *         response=407,
     *         description="El Documento de identidad ingresado no se encuentra registrado."
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No se encuentra el metodo"
     *     )
     * )
     */
    public function lista_elementos(Request $request) {
        $regla = [
            'v_intIdproy' => 'required|max:255',
            'v_intIdTipoProducto' => 'required|max:255',
            'v_intIdZona' => 'required|max:255',
            'v_intPrograma' => 'required|max:255',
            'v_intIdEtapaActual' => 'required|max:255',
            'v_intIdRuta' => 'required|max:255',
            'v_varCodiElemento' => 'required|max:255',
        ];
        $this->validate($request, $regla);
        $v_intIdproy = (int) $request->input('v_intIdproy');
        $v_intIdTipoProducto = (int) $request->input('v_intIdTipoProducto');
        $v_intIdZona = (int) $request->input('v_intIdZona');
        $v_intPrograma = (int) $request->input('v_intPrograma');
        $v_intIdEtapaActual = (int) $request->input('v_intIdEtapaActual');
        $v_intIdRuta = (int) $request->input('v_intIdRuta');
        $v_varCodiElemento = $request->input('v_varCodiElemento');
        $result = DB::select('CALL sp_elemento_Q03(?,?,?,?,?,?,?)', array(
                    $v_intIdproy, $v_intIdTipoProducto, $v_intIdZona, $v_intPrograma, $v_intIdEtapaActual,
                    $v_intIdRuta, $v_varCodiElemento
        ));
        return $this->successResponse($result);
    }

    /* LISTAR LOS REPROCESOS */

    /**
     * @OA\Post(
     *     path="/GestionReprocesos/public/index.php/list_repr",
     *     tags={"Reproceso - Lista de Reprocesos"},
     *     summary="Obtiene los Elementos de los Reprocesos",
     *     @OA\Parameter(
     *         description="Codigo de Proyecto",
     *         in="path",
     *         name="v_intIdproy",
     *         example = "193",
     *         required=true,
     *         @OA\Schema(
     *           type="number" 
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="Codigo de Producto",
     *         in="path",
     *         name="v_intIdTipoProducto",
     *         example = "1",
     *         required=true,
     *         @OA\Schema(
     *           type="number" 
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="Codigo de Zona",
     *         in="path",
     *         name="v_intIdZona",
     *         example = "1",
     *         required=true,
     *         @OA\Schema(
     *           type="number" 
     *         )
     *     ),
     *       
     *    @OA\Parameter(
     *         description="Codigo de Tarea",
     *         in="path",
     *         name="v_intPrograma",
     *         example = "1",
     *         required=true,
     *         @OA\Schema(
     *           type="number" 
     *         )
     *     ), 
     *    @OA\Parameter(
     *         description="Codigo de Etapa Origen",
     *         in="path",
     *         name="v_intIdEtapaOrigen",
     *         example = "1",
     *         required=true,
     *         @OA\Schema(
     *           type="number" 
     *         )
     *     ), 
     *    @OA\Parameter(
     *         description="Codigo de Etapa Destino",
     *         in="path",
     *         name="v_intIdEtapaDestino",
     *         example = "1",
     *         required=true,
     *         @OA\Schema(
     *           type="number" 
     *         )
     *     ), 
     *    @OA\Parameter(
     *         description="Codigo de Elemento",
     *         in="path",
     *         name="v_varCodiElemento",
     *         example = "G2-T1",
     *         required=true,
     *         @OA\Schema(
     *           type="string" 
     *         )
     *     ), 
     *    @OA\Parameter(
     *         description="Fecha Inicio",
     *         in="path",
     *         name="v_FechaInicio",
     *         example = "2019-01-07",
     *         required=true,
     *         @OA\Schema(
     *           type="string" 
     *         )
     *     ), 
     *    @OA\Parameter(
     *         description="Fecha Fin",
     *         in="path",
     *         name="v_FechaFin",
     *         example = "2019-01-10",
     *         required=true,
     *         @OA\Schema(
     *           type="string" 
     *         )
     *     ), 
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="v_intIdproy",
     *                     type="number"
     *                 ) ,
     *                 @OA\Property(
     *                     property="v_intIdTipoProducto",
     *                     type="number"
     *                 ) ,
     *                 @OA\Property(
     *                     property="v_intIdZona",
     *                     type="number"
     *                 ) ,
     *                 @OA\Property(
     *                     property="v_intPrograma",
     *                     type="number"
     *                 ) ,
     *                 @OA\Property(
     *                     property="v_intIdEtapaOrigen",
     *                     type="number"
     *                 ) ,
     *                 @OA\Property(
     *                     property="v_intIdEtapaDestino",
     *                     type="number"
     *                 ) , 
     *                 @OA\Property(
     *                     property="v_varCodiElemento",
     *                     type="string"
     *                 ) ,  
     *                 @OA\Property(
     *                     property="v_FechaInicio",
     *                     type="string"
     *                 ) ,   
     *                 @OA\Property(
     *                     property="v_FechaFin",
     *                     type="string"
     *                 ) ,       
     *                 example={"v_intIdproy": "193","v_intIdTipoProducto":"1","v_intIdZona":"1","v_intPrograma":"1",
     *                          "v_intIdEtapaOrigen":"1","v_intIdEtapaDestino":"1","v_varCodiElemento":"G2-T1",
     *                          "v_FechaInicio":"2019-01-07","v_FechaFin":"2019-01-10"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Sin Mensaje"
     *     ),
     *     @OA\Response(
     *         response=407,
     *         description="El Documento de identidad ingresado no se encuentra registrado."
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No se encuentra el metodo"
     *     )
     * )
     */
    public function list_reproceso(Request $request) {
        $regla = [
            'v_intIdproy' => 'required|max:255',
            'v_intIdTipoProducto' => 'required|max:255',
            'v_intIdZona' => 'required|max:255',
            'v_intPrograma' => 'required|max:255',
            'v_intIdEtapaOrigen' => 'required|max:255',
            'v_intIdEtapaDestino' => 'required|max:255',
            'v_varCodiElemento' => 'required|max:255',
            'v_FechaInicio' => 'required|max:255',
            'v_FechaFin' => 'required|max:255'
        ];
        $this->validate($request, $regla);
        $v_intIdproy = (int) $request->input('v_intIdproy');
        $v_intIdTipoProducto = (int) $request->input('v_intIdTipoProducto');
        $v_intIdZona = (int) $request->input('v_intIdZona');
        $v_intPrograma = (int) $request->input('v_intPrograma');
        $v_intIdEtapaOrigen = (int) $request->input('v_intIdEtapaOrigen');
        $v_intIdEtapaDestino = (int) $request->input('v_intIdEtapaDestino');
        $v_varCodiElemento = $request->input('v_varCodiElemento');
        $v_FechaInicio = $request->input('v_FechaInicio');
        $v_FechaFin = $request->input('v_FechaFin');

        $result = DB::select('CALL sp_reproceso_Q01(?,?,?,?,?,?,?,?,?)', array(
                    $v_intIdproy, $v_intIdTipoProducto, $v_intIdZona, $v_intPrograma, $v_intIdEtapaOrigen,
                    $v_intIdEtapaDestino, $v_varCodiElemento, $v_FechaInicio, $v_FechaFin
        ));
        return $this->successResponse($result);
    }

    /* GUARDAR UN NUEVO REPROCESO */

    /**
     * @OA\Post(
     *     path="/GestionReprocesos/public/index.php/guar_repro",
     *     tags={"Reproceso - Guardar Reproceso"},
     *     summary="Guarda un nuevo Reproceso",
     *     @OA\Parameter(
     *         description="Codigo de Proyecto",
     *         in="path",
     *         name="v_intIdproy",
     *         example = "193",
     *         required=true,
     *         @OA\Schema(
     *           type="number" 
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="Codigo de Producto",
     *         in="path",
     *         name="v_intIdTipoProducto",
     *         example = "1",
     *         required=true,
     *         @OA\Schema(
     *           type="number" 
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="Codigo de Zona",
     *         in="path",
     *         name="v_intIdZona",
     *         example = "1",
     *         required=true,
     *         @OA\Schema(
     *           type="number" 
     *         )
     *     ),
     *       
     *    @OA\Parameter(
     *         description="Codigo de Tarea",
     *         in="path",
     *         name="v_intPrograma",
     *         example = "1",
     *         required=true,
     *         @OA\Schema(
     *           type="number" 
     *         )
     *     ), 
     *    @OA\Parameter(
     *         description="Codigo de Etapa Origen",
     *         in="path",
     *         name="v_intIdEtapaOrigen",
     *         example = "1",
     *         required=true,
     *         @OA\Schema(
     *           type="number" 
     *         )
     *     ), 
     *    @OA\Parameter(
     *         description="Codigo de Etapa Destino",
     *         in="path",
     *         name="v_intIdEtapaDestino",
     *         example = "1",
     *         required=true,
     *         @OA\Schema(
     *           type="number" 
     *         )
     *     ), 
     *    @OA\Parameter(
     *         description="Codigo de Motivo",
     *         in="path",
     *         name="v_intIdMotivo",
     *         example = "1",
     *         required=true,
     *         @OA\Schema(
     *           type="number" 
     *         )
     *     ), 
     *    @OA\Parameter(
     *         description="Observación",
     *         in="path",
     *         name="v_Observacion",
     *         example = "Se reprocesa este elemento por x motivos",
     *         required=true,
     *         @OA\Schema(
     *           type="string" 
     *         )
     *     ), 
     *    @OA\Parameter(
     *         description="Codigo de Usuario",
     *         in="path",
     *         name="v_usuario",
     *         example = "jose_castillo",
     *         required=true,
     *         @OA\Schema(
     *           type="string" 
     *         )
     *     ), 
     *    @OA\Parameter(
     *         description="Codigo de Ruta",
     *         in="path",
     *         name="v_intIdRuta",
     *         example = "1",
     *         required=true,
     *         @OA\Schema(
     *           type="number" 
     *         )
     *     ), 
     *    @OA\Parameter(
     *         description="Codigo de Elemento",
     *         in="path",
     *         name="v_IdElementos",
     *         example = "1",
     *         required=true,
     *         @OA\Schema(
     *           type="number" 
     *         )
     *     ), 
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="v_intIdproy",
     *                     type="number"
     *                 ) ,
     *                 @OA\Property(
     *                     property="v_intIdTipoProducto",
     *                     type="number"
     *                 ) ,
     *                 @OA\Property(
     *                     property="v_intIdZona",
     *                     type="number"
     *                 ) ,
     *                 @OA\Property(
     *                     property="v_intPrograma",
     *                     type="number"
     *                 ) ,
     *                 @OA\Property(
     *                     property="v_intIdEtapaOrigen",
     *                     type="number"
     *                 ) ,
     *                 @OA\Property(
     *                     property="v_intIdEtapaDestino",
     *                     type="number"
     *                 ) , 
     *                 @OA\Property(
     *                     property="v_intIdMotivo",
     *                     type="number"
     *                 ) ,
     *                 @OA\Property(
     *                     property="v_Observacion",
     *                     type="string"
     *                 ) ,
     *                 @OA\Property(
     *                     property="v_usuario",
     *                     type="string"
     *                 ) ,
     *                 @OA\Property(
     *                     property="v_intIdRuta",
     *                     type="number"
     *                 ) ,  
     *                 @OA\Property(
     *                     property="v_IdElementos",
     *                     type="number"
     *                 ) ,        
     *                 example={"v_intIdproy": "193","v_intIdTipoProducto":"1","v_intIdZona":"1","v_intPrograma":"1",
     *                          "v_intIdEtapaOrigen":"1","v_intIdEtapaDestino":"1","v_intIdMotivo":"1",
     *                          "v_Observacion":"Se reprocessa por x motivos","v_usuario":"jose_castillo","v_intIdRuta":"1",
     *                          "v_IdElementos":"1"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Sin Mensaje"
     *     ),
     *     @OA\Response(
     *         response=407,
     *         description="El Documento de identidad ingresado no se encuentra registrado."
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No se encuentra el metodo"
     *     )
     * )
     */
    public function guardar_reproceso(Request $request) {
        $regla = [
            'v_intIdproy' => 'required|max:255',
            'v_intIdTipoProducto' => 'required|max:255',
            'v_intIdZona' => 'required|max:255',
            'v_intPrograma' => 'required|max:255',
            'v_intIdEtapaOrigen' => 'required|max:255',
            'v_intIdEtapaDestino' => 'required|max:255',
            /* 'v_Fecha' => 'required|max:255', */
            'v_intIdMotivo' => 'required|max:255',
            'v_Observacion' => 'required|max:255',
            'v_usuario' => 'required|max:255',
            'v_intIdRuta' => 'required|max:255',
            'v_IdElementos' => 'required',
        ];
        $this->validate($request, $regla);
        $v_intIdproy = (int) $request->input('v_intIdproy');
        $v_intIdTipoProducto = (int) $request->input('v_intIdTipoProducto');
        $v_intIdZona = (int) $request->input('v_intIdZona');
        $v_intPrograma = (int) $request->input('v_intPrograma');
        $v_intIdEtapaOrigen = (int) $request->input('v_intIdEtapaOrigen');
        $v_intIdEtapaDestino = (int) $request->input('v_intIdEtapaDestino');
        /* $v_Fecha = $request->input('v_Fecha'); */
        $v_intIdMotivo = (int) $request->input('v_intIdMotivo');
        $v_Observacion = strtoupper($request->input('v_Observacion'));
        $v_usuario = $request->input('v_usuario');
        $v_intIdRuta = (int) $request->input('v_intIdRuta');
        $v_IdElementos = trim($request->input('v_IdElementos'), ',');
        date_default_timezone_set('America/Lima'); // CDT
        $v_fecha_time = $current_date = date('Y-m-d H:i:s');
        /* dd($v_intIdproy,$v_intIdTipoProducto,$v_intIdZona,$v_intPrograma,$v_intIdEtapaOrigen,$v_intIdEtapaDestino,
          $v_intIdMotivo,$v_Observacion,$v_intIdRuta,$v_IdElementos,$v_fecha_time); */
        DB::select('CALL sp_reproceso_P01(?,?,?,?,?,?,?,?,?,?,?,?,@v_mensaje)', array(
            $v_intIdproy,
            $v_intIdTipoProducto,
            $v_intIdZona,
            $v_intPrograma,
            $v_intIdEtapaOrigen,
            $v_intIdEtapaDestino,
            /* $v_Fecha, */
            $v_intIdMotivo,
            $v_Observacion,
            $v_usuario,
            /* $v_fecha_time, */
            $v_intIdRuta,
            $v_IdElementos,
            20
        ));
        $results = DB::select('select @v_mensaje as mensaje');
        //dd($results);
        return $this->successResponse($results);
    }

    /* FUNCION PARA COMBO DE MOTIVO */

    /**
     * @OA\Get(
     *     path="/GestionReprocesos/public/index.php/comb_moti",
     *     tags={"Listar Motivos"},
     *     summary="lista los motivos",
     *     
     *     @OA\Response(
     *         response=200,
     *         description="Lista los Motivos."
     *     )
     * )
     */
    public function combo_motivo() {
        $motivo = Motivo::where('intIdEsta', '=', 3)->select('intIdMoti', 'varDescripcion', 'intIdTipoMoti', 'intIdEsta')->orderBy('varDescripcion', 'ASC')->get();
        return $this->successResponse($motivo);
    }

    /* FUNCION PARA OBTENER EL ID DEL ULTIMO REGISTRO DEL REPROCESO POR USUARIO */

    /**
     * @OA\Post(
     *     path="/GestionReprocesos/public/index.php/obtn_id_repr",
     *     tags={"Reproceso - Obtener id"},
     *     summary="Obtener el ultimo id registrado",
     *     @OA\Parameter(
     *         description="Codigo de Proyecto",
     *         in="path",
     *         name="acti_usua",
     *         example = "jose_castillo",
     *         required=true,
     *         @OA\Schema(
     *           type="string" 
     *         )
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="acti_usua",
     *                     type="string"
     *                 ) ,  
     *                 example={"acti_usua": "jose_castillo"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Sin Mensaje"
     *     ),
     *     @OA\Response(
     *         response=407,
     *         description="El Documento de identidad ingresado no se encuentra registrado."
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No se encuentra el metodo"
     *     )
     * )
     */
    public function obtn_id_repr(Request $request) {
        $regla = [
            'acti_usua' => 'required|max:255'
        ];
        //dd($request);
        $this->validate($request, $regla);
        $acti_usua = $request->input('acti_usua');
        //dd($acti_usua);
        $reproceso = Reproceso::where('acti_usua', '=', $acti_usua)->select('intIdreproceso')->max('intIdreproceso');
        return $this->successResponse($reproceso);
    }

    /* FUNCION PARA ACTUALIZAR EL NOMBRE DEL ARCHIVO */

    /**
     * @OA\Post(
     *     path="/GestionReprocesos/public/index.php/actu_nombre_arch",
     *     tags={"Reproceso - Guardar nombre archivo"},
     *     summary="Obtener el ultimo id registrado",
     *     @OA\Parameter(
     *         description="Codigo de Proyecto",
     *         in="path",
     *         name="varArchivo",
     *         example = "jose.xls",
     *         required=true,
     *         @OA\Schema(
     *           type="string" 
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="Codigo de Proyecto",
     *         in="path",
     *         name="intIdreproceso",
     *         example = "1",
     *         required=true,
     *         @OA\Schema(
     *           type="number" 
     *         )
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="varArchivo",
     *                     type="string"
     *                 ) ,  
     *                 @OA\Property(
     *                     property="intIdreproceso",
     *                     type="number"
     *                 ) , 
     *                 example={"varArchivo": "jose.xls","intIdreproceso": "1"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Sin Mensaje"
     *     ),
     *     @OA\Response(
     *         response=407,
     *         description="El Documento de identidad ingresado no se encuentra registrado."
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No se encuentra el metodo"
     *     )
     * )
     */
    public function actu_nombre_arch(Request $request) {
        $regla = [
            'varArchivo' => 'required|max:255',
            'intIdreproceso' => 'required|max:255'
        ];
        $this->validate($request, $regla);
        $intIdreproceso = (int) $request->input('intIdreproceso');
        $varArchivo = $request->input('varArchivo');
        $reproceso = Reproceso::where('intIdreproceso', '=', $intIdreproceso)->update(['varArchivo' => $varArchivo]);
        $mensaje = "";
        return $this->successResponse($mensaje);
    }

    /* FUNCION PARA LISTAR REPROCESOS POR ID */

    /**
     * @OA\Post(
     *     path="/GestionReprocesos/public/index.php/repr_deta",
     *     tags={"Reproceso - Detalle"},
     *     summary="Detalle del reproceso",
     *     @OA\Parameter(
     *         description="Codigo de Proyecto",
     *         in="path",
     *         name="intIdreproceso",
     *         example = "1",
     *         required=true,
     *         @OA\Schema(
     *           type="number" 
     *         )
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="intIdreproceso",
     *                     type="number"
     *                 ) ,  
     *                 example={"intIdreproceso": "1"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Sin Mensaje"
     *     ),
     *     @OA\Response(
     *         response=407,
     *         description=""
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No se encuentra el metodo"
     *     )
     * )
     */
    public function repr_deta(Request $request) {
        $regla = [
            'intIdreproceso' => 'required|max:255'
        ];
        $this->validate($request, $regla);
        $id_repro = (int) $request->input('intIdreproceso');
        $reproceso_detalle = DB::select('select e.varCodiElemento,
                                        e.varDescripcion,e.intSerie,e.deciPesoNeto,e.deciPesoBruto,
                                        e.deciArea,z.varDescrip,t.varDescripTarea,p.varCodigoPaquete,
                                        rd.intIdEleme,rd.acti_usua,rd.intIdEsta,rd.acti_hora,es.varDescEsta
                                        from reproceso_det rd 
                                        left join elemento e on rd.intIdEleme=e.intIdEleme 
                                        left join proyecto_zona z on e.intIdProyZona=z.intIdProyZona 
                                        left join proyecto_tarea t on e.intIdProyTarea=t.intIdProyTarea
                                        left join proyecto_paquetes p on e.intIdProyPaquete=p.intIdProyPaquete 
                                        left join estado es on es.intIdEsta=rd.intIdEsta
                                        where rd.intIdreproceso=' . $id_repro);
        return $this->successResponse($reproceso_detalle);
    }

    /* FUNCION PARA ANULAR UN REPROCESO */

    /**
     * @OA\Post(
     *     path="/GestionReprocesos/public/index.php/anular_reproceso",
     *     tags={"Reproceso - Anular Reproceso"},
     *     summary="Anular un reproceso",
     *     @OA\Parameter(
     *         description="Codigo de Proyecto",
     *         in="path",
     *         name="v_intIdproy",
     *         example = "193",
     *         required=true,
     *         @OA\Schema(
     *           type="number" 
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="Codigo de Producto",
     *         in="path",
     *         name="v_intIdTipoProducto",
     *         example = "1",
     *         required=true,
     *         @OA\Schema(
     *           type="number" 
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="Codigo de Reproceso",
     *         in="path",
     *         name="v_intIdreproceso",
     *         example = "1",
     *         required=true,
     *         @OA\Schema(
     *           type="number" 
     *         )
     *     ),

     *    @OA\Parameter(
     *         description="Codigo de Etapa Origen",
     *         in="path",
     *         name="v_intIdEtapaOrigen",
     *         example = "1",
     *         required=true,
     *         @OA\Schema(
     *           type="number" 
     *         )
     *     ), 
     *    @OA\Parameter(
     *         description="Codigo de Etapa Destino",
     *         in="path",
     *         name="v_intIdEtapaDestino",
     *         example = "1",
     *         required=true,
     *         @OA\Schema(
     *           type="number" 
     *         )
     *     ), 
     *    @OA\Parameter(
     *         description="Codigo de Elemento",
     *         in="path",
     *         name="v_IdElementos",
     *         example = "1",
     *         required=false,
     *         @OA\Schema(
     *           type="number" 
     *         )
     *     ), 
     *    @OA\Parameter(
     *         description="Codigo tipo de anulación",
     *         in="path",
     *         name="v_tipoAnulacion",
     *         example = "Se reprocesa este elemento por x motivos",
     *         required=true,
     *         @OA\Schema(
     *           type="number" 
     *         )
     *     ), 
     *    @OA\Parameter(
     *         description="Codigo de Usuario",
     *         in="path",
     *         name="v_usuario",
     *         example = "jose_castillo",
     *         required=true,
     *         @OA\Schema(
     *           type="string" 
     *         )
     *     ), 
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="v_intIdproy",
     *                     type="number"
     *                 ) ,
     *                 @OA\Property(
     *                     property="v_intIdTipoProducto",
     *                     type="number"
     *                 ) ,
     *                 @OA\Property(
     *                     property="v_intIdreproceso",
     *                     type="number"
     *                 ) ,
     *                 @OA\Property(
     *                     property="v_intIdEtapaOrigen",
     *                     type="number"
     *                 ) ,
     *                 @OA\Property(
     *                     property="v_intIdEtapaDestino",
     *                     type="number"
     *                 ) , 
     *                 @OA\Property(
     *                     property="v_IdElementos",
     *                     type="number"
     *                 ) ,
     *                 @OA\Property(
     *                     property="v_tipoAnulacion",
     *                     type="number"
     *                 ) ,
     *                 @OA\Property(
     *                     property="v_usuario",
     *                     type="string"
     *                 ) ,
     *                       
     *                 example={"v_intIdproy": "193","v_intIdTipoProducto":"1","v_intIdreproceso":"1","v_intIdEtapaOrigen":"1",
     *                          "v_intIdEtapaDestino":"1","v_IdElementos":"1","v_tipoAnulacion":"1",
     *                          "v_usuario":"jose_castillo"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Sin Mensaje"
     *     ),
     *     @OA\Response(
     *         response=407,
     *         description="El Documento de identidad ingresado no se encuentra registrado."
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No se encuentra el metodo"
     *     )
     * )
     */
    public function anular_reproceso(Request $request) {
        $regla = [
            'v_intIdproy' => 'required|max:255',
            'v_intIdTipoProducto' => 'required|max:255',
            'v_intIdreproceso' => 'required|max:255',
            'v_intIdEtapaOrigen' => 'required|max:255',
            'v_intIdEtapaDestino' => 'required|max:255',
            'v_tipoAnulacion' => 'required|max:255',
            'v_usuario' => 'required|max:255',
        ];

        $this->validate($request, $regla);
        $v_intIdproy = (int) $request->input('v_intIdproy');
        $v_intIdTipoProducto = (int) $request->input('v_intIdTipoProducto');
        $v_intIdreproces = (int) $request->input('v_intIdreproceso');
        $v_intIdEtapaOrigen = (int) $request->input('v_intIdEtapaOrigen');
        $v_intIdEtapaDestino = (int) $request->input('v_intIdEtapaDestino');
        $v_IdElementos = $request->input('v_IdElementos');
        if ($v_IdElementos === null) {
            $v_IdElementos = "";
        } else {
            $v_IdElementos = trim($request->input('v_IdElementos'), ',');
        }
        $v_tipoAnulacion = (int) $request->input('v_tipoAnulacion');
        $v_usuario = $request->input('v_usuario');

        /* dd($v_intIdproy,
          $v_intIdTipoProducto,
          $v_intIdreproces,
          $v_intIdEtapaOrigen,
          $v_intIdEtapaDestino,
          $v_IdElementos,
          $v_tipoAnulacion,
          $v_usuario); */

        DB::select('CALL sp_reproceso_P02(?,?,?,?,?,?,?,?,@v_mensaje)', array(
            $v_intIdproy,
            $v_intIdTipoProducto,
            $v_intIdreproces,
            $v_intIdEtapaOrigen,
            $v_intIdEtapaDestino,
            $v_IdElementos,
            $v_tipoAnulacion,
            $v_usuario
        ));
        $results = DB::select('select @v_mensaje as mensaje');
        //dd($results);
        return $this->successResponse($results);
    }

    /* FUNCION QUE TRAE LA CABECERA DEL REPROCESO */

    /**
     * @OA\Post(
     *     path="/GestionReprocesos/public/index.php/cabecera_reproceso",
     *     tags={"Reproceso - Cabecera"},
     *     summary="Cabecera del reproceso",
     *     @OA\Parameter(
     *         description="Codigo de Proyecto",
     *         in="path",
     *         name="intIdreproceso",
     *         example = "1",
     *         required=true,
     *         @OA\Schema(
     *           type="number" 
     *         )
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="intIdreproceso",
     *                     type="number"
     *                 ) ,  
     *                 example={"intIdreproceso": "1"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Sin Mensaje"
     *     ),
     *     @OA\Response(
     *         response=407,
     *         description=""
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No se encuentra el metodo"
     *     )
     * )
     */
    public function cabecera_reproceso(Request $request) {
        $regla = [
            'intIdreproceso' => 'required|max:255'
        ];
        $this->validate($request, $regla);
        $intIdreproceso = (int) $request->input('intIdreproceso');
        $cabecera_repro = DB::select('SELECT R.intIdreproceso AS num_Doc,
                                      EO.varDescEtap AS EtapaOrigen,
                                      ED.varDescEtap as EtapaDestino,
                                      R.Fecha,R.intCantiTotal,R.numPesoNetoTotal,
                                      MO.varDescripcion AS Motivo,R.varObservacion,
                                      ES.varDescEsta AS Estado,R.varArchivo,
                                      R.acti_usua,R.acti_hora,R.usua_modi,
                                      R.hora_modi FROM reproceso R 
                                      INNER JOIN etapa as EO ON R.intIdEtapaOrigen = EO.intIdEtapa 
                                      INNER JOIN etapa as ED ON R.intIdEtapaDestino = ED.intIdEtapa 
                                      INNER JOIN estado AS ES ON R.intIdEsta = ES.intIdEsta 
                                      INNER JOIN motivo AS MO ON R.intIdMoti = MO.intIdMoti
                                      WHERE R.intIdreproceso=' . $intIdreproceso);
        return $this->successResponse($cabecera_repro);
    }

    /**
     * @OA\Post(
     *     path="/GestionReprocesos/public/index.php/inser_prueba",
     *     tags={"insertar_prueba"},
     *     summary="obtiene datos del usuario a través del dni",
     *     @OA\Parameter(
     *         description="Descripcion de la planta",
     *         in="path",
     *         name="varDescPlanta",
     *         example="CHORRILLOS",
     *         required=true,
     *         @OA\Schema(
     *           type="string" 
     *         )
     *     ),
     *      
     *     @OA\Parameter(
     *         description="Estado de la planta",
     *         in="path",
     *         name="varEstaPlanta",
     *         example="ACT",
     *         required=true,
     *         @OA\Schema(
     *           type="string" 
     *         )
     *     ),
     *          @OA\Parameter(
     *         description="Ingrese el usuario que ha registrado",
     *         in="path",
     *         name="acti_usua",
     *         example="usuario_usuario",
     *         required=true,
     *         @OA\Schema(
     *           type="string" 
     *         )
     *     ),
     * 
     * 
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="varEstaPlanta",
     *                     type="string"
     *                 ) ,
     *                 example={"varDescPlanta": "CHORRILLOS","varEstaPlanta":"ACT","acti_usua":"usuario_usuario"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Sin Mensaje"
     *     ),
     *     
     *     @OA\Response(
     *         response=404,
     *         description="No se encuentra el metodo"
     *     )
     * )
     */
    function inser_prueba(Request $request) {
        $regla = [
            'varDescPlanta' => 'required|max:255',
            'varEstaPlanta' => 'required|max:255',
            'acti_usua' => 'required|max:255'
        ];
        $this->validate($request, $regla);
        $varDescPlanta = $request->input('varDescPlanta');
        $varEstaPlanta = $request->input('varEstaPlanta');
        $acti_usua = $request->input('acti_usua');
        date_default_timezone_set('America/Lima'); // CDT
        $v_fecha_time = $current_date = date('Y-m-d');
        $insert_planta = DB::insert('insert into planta(varDescPlanta,varEstaPlanta,acti_usua,acti_hora) values(?,?,?,?)', [$varDescPlanta, $varEstaPlanta, $acti_usua, $v_fecha_time]);
        return $this->successResponse($insert_planta);
    }

}

<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Sedes;
use App\Models\Vacante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Picqer\Barcode\BarcodeGeneratorPNG;

class InscripcionController extends Controller
{
    public function index()
    {
        $simulacros = DB::table('simulacroAdm AS sa')
            ->join('simulacroAdm_detalle AS sad', 'sa.idAdm', '=', 'sad.idAdm')
            ->join('evaluacion_tipo_universidad AS etu', 'sa.tipe_id', '=', 'etu.tipe_id')
            ->select(
                'sa.idAdm',
                'sa.titulo',
                'sa.img_inscripciones_sm',
                'sa.img_inscripciones_md',
                'sad.idAdm_det',
                'sad.subtitulo',
                'sad.fec_ins_ini',
                'sad.fec_ins_fin',
                'sad.fec_simulacro',
                'etu.tipe_color'
            )
            ->where('sa.estado', '!=', 0)
            ->where('sad.estado', 1)
            ->where('etu.tipe_estado', '!=', 0)
            ->whereRaw('NOW() >= sad.fec_ins_ini')
            ->whereRaw('(NOW() <= sad.fec_ins_fin OR NOW() <= sad.fec_simulacro)')
            ->get();

        $sedes = DB::table('simulacroAdm_detalle AS sad')
            ->join('simulacroAdm_detalle_interno AS sadi', 'sad.idAdm_det', '=', 'sadi.idAdm_det')
            ->leftJoin('inst_local AS il', 'sadi.loc_id', '=', 'il.loc_id')
            ->select(
                'sad.idAdm_det',
                'sad.subtitulo',
                'sadi.tipo_evento',
                'sadi.loc_id',
                DB::raw("IF(sadi.loc_id = 0, 'TODOS LOS LOCALES', il.loc_desc) AS loc_desc")
            )
            ->whereIn('sad.idAdm_det', $simulacros->pluck('idAdm_det'))
            ->where('sadi.estado', 1)
            ->where('il.loc_esta', 1)
            ->where('sadi.vac_fin', '>', 0)
            ->groupBy(
                'sad.idAdm_det',
                'sad.subtitulo',
                'sadi.tipo_evento',
                'sadi.loc_id',
                'loc_desc'
            )
            ->orderBy('loc_desc', 'ASC')
            ->get();

        $ciclos = Area::where('estado', 1)->orderBy('nombre', 'asc')->get();

        return view('inscripcion', compact('simulacros', 'sedes', 'ciclos'));
    }

    public function store(Request $request)
    {
        //dd($request->all());
        $validator = Validator::make($request->all(), [
            'alu_nom' => 'required|string|max:255',
            'ape_pat' => 'required|string|max:255',
            'ape_mat' => 'required|string|max:255',
            'num_documen' => 'required|numeric|digits_between:8,12',
            'fecha' => 'required|date',
            'col_tel' => 'required|numeric|digits:9',
            'sede' => 'required',
            'email' => 'required|email',
            'ciclo' => 'required',
            //'t_y_c' => 'accepted',
        ], [
            'alu_nom.required' => 'El nombre es obligatorio.',
            'ape_pat.required' => 'El apellido paterno es obligatorio.',
            'ape_mat.required' => 'El apellido materno es obligatorio.',
            'num_documen.required' => 'El número de documento es obligatorio.',
            'num_documen.numeric' => 'El número de documento debe contener solo números.',
            'num_documen.digits_between' => 'Digite correctamente.',
            'fecha.required' => 'La fecha de nacimiento es obligatoria.',
            'fecha.date' => 'La fecha de nacimiento debe ser válida.',
            'col_tel.required' => 'El teléfono es obligatorio.',
            'col_tel.numeric' => 'El teléfono debe contener solo números.',
            'col_tel.digits' => 'El teléfono debe tener 9 dígitos.',
            'sede.required' => 'Debes seleccionar una sede.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico debe ser válido.',
            'ciclo.required' => 'Debes seleccionar un ciclo.',
            //'t_y_c.accepted' => 'Debes aceptar los Términos y Condiciones para continuar.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Obtener valores de Area y Sedes de forma eficiente.
        $area = Area::where('nombre', $request->ciclo)->value('desc_ficha');
        $sede = Sedes::where('loc_id', $request->sede)->value('loc_desc');

        // Obtener el simulacro
        $simulacro = DB::table('simulacroAdm as sa')
            ->join('simulacroAdm_detalle as sad', 'sa.idAdm', '=', 'sad.idAdm')
            ->join('evaluacion_tipo_universidad as etu', 'sa.tipe_id', '=', 'etu.tipe_id')
            ->where('sa.estado', '!=', 0)
            ->where('sad.estado', '=', 1)
            ->where('etu.tipe_estado', '!=', 0)
            ->whereRaw('NOW() >= sad.fec_ins_ini')
            ->whereRaw('(NOW() <= sad.fec_ins_fin OR NOW() <= sad.fec_simulacro)')
            ->select('sa.idAdm', 'sad.idAdm_det', 'sad.fec_simulacro', 'etu.tipe_color')
            ->first();

        // Validar si el DNI ya está registrado
        $existe_inscripcion = DB::table('simulacroAdm_inscripcion')
            ->where('dni', $request->num_documen)
            ->where('idAdm_det', $simulacro->idAdm_det)
            ->exists();

        if ($existe_inscripcion) {
            return redirect()->route('inscripcion.index')->with('error', 'El DNI ya se encuentra registrado');
        }

        // Obtener el siguiente código de inscripción disponible
        $codigo_inscripcion = DB::table('simulacroAdm_codigos_externo')
            ->where('estado', '!=', 1)
            ->orderBy('idAdm_cod', 'asc')
            ->value('codigo');  // Usar value() directamente, ya que no necesitas el objeto completo

        if (!$codigo_inscripcion) {
            return redirect()->route('inscripcion.index')->with('error', '¡Error al generar el código de inscripción!');
        }

        // Realizar la inserción
        DB::table('simulacroAdm_inscripcion')->insert([
            'idAdm_det' => $simulacro->idAdm_det,
            'loc_id' => $request->sede,
            'area' => $request->ciclo,
            'codigo' => $codigo_inscripcion,
            'dni' => $request->num_documen,
            'nombre' => $request->alu_nom,
            'correo' => $request->email,
            'celular' => $request->col_tel,
            'apellido_Paterno' => $request->ape_pat,
            'apellido_Materno' => $request->ape_mat,
            'fecha_registro' => now()->setTimezone('America/Lima'),
        ]);

        // Actualizar vacantes y el estado del código
        Vacante::where('idAdm_det', $simulacro->idAdm_det)
            ->where('loc_id', $request->sede)
            ->decrement('vac_fin', 1);

        DB::table('simulacroAdm_codigos_externo')
            ->where('codigo', $codigo_inscripcion)
            ->update(['estado' => 1]);

        // Devolver la respuesta exitosa
        return redirect()->route('inscripcion.index')->with([
            'success' => 'Inscripción exitosa',
            'tipo' => 'nuevo',
            'datos_inscripcion' => [
                'codigo' => $codigo_inscripcion,
                'dni' => $request->num_documen,
                'nombres' => $request->alu_nom,
                'apellidos' => $request->ape_pat . ' ' . $request->ape_mat,
                'sede' => $sede,
                'area' => $area,
                'fecha' => $simulacro->fec_simulacro,
            ]
        ]);
    }

    public function buscarDni(Request $request)
    {
        // Validación para asegurar que el número de documento sea numérico
        $request->validate([
            'dni' => 'required|numeric',
        ]);

        // Obtener el simulacro que está disponible para inscripción
        $simulacro = DB::table('simulacroAdm as sa')
            ->join('simulacroAdm_detalle as sad', 'sa.idAdm', '=', 'sad.idAdm')
            ->join('evaluacion_tipo_universidad as etu', 'sa.tipe_id', '=', 'etu.tipe_id')
            ->where('sa.estado', '!=', 0)
            ->where('sad.estado', '=', 1)
            ->where('etu.tipe_estado', '!=', 0)
            ->whereRaw('NOW() >= sad.fec_ins_ini') // Verificar que la fecha de inscripción haya comenzado
            ->whereRaw('(NOW() <= sad.fec_ins_fin OR NOW() <= sad.fec_simulacro)') // Verificar que esté dentro del rango de fechas
            ->select('sa.idAdm', 'sad.idAdm_det', 'sad.fec_simulacro', 'etu.tipe_color')
            ->first();

        // Guardar el valor del DNI ingresado en la variable
        $dni_codigo = $request->dni;

        // Consultar la inscripción del DNI o código
        $inscripcion = DB::table('simulacroAdm_inscripcion as sai')
            ->join('simulacroAdm_detalle as sad', 'sai.idAdm_det', '=', 'sad.idAdm_det')
            ->join('inst_local as il', 'sai.loc_id', '=', 'il.loc_id')
            ->join('simulacroAdm_area as sada', 'sai.area', '=', 'sada.nombre')
            ->where(function ($query) use ($dni_codigo) {
                $query->where('sai.codigo', '=', $dni_codigo)
                    ->orWhere('sai.dni', '=', $dni_codigo);
            })
            ->where('sai.idAdm_det', '=', $simulacro->idAdm_det) 
            ->select('sai.*', 'il.loc_desc', 'sad.fec_simulacro', 'sada.descripcion', 'sada.desc_ficha')
            ->first(); 

        if ($inscripcion) {
            return redirect()->route('inscripcion.index')->with([
                'success' => 'Inscripción encontrada',
                'tipo' => 'existente',
                'datos_inscripcion' => [
                    'codigo' => $inscripcion->codigo,
                    'dni' => $inscripcion->dni,
                    'nombres' => $inscripcion->nombre,
                    'apellidos' => $inscripcion->apellido_Paterno . ' ' . $inscripcion->apellido_Materno,
                    'sede' => $inscripcion->loc_desc,
                    'area' => $inscripcion->desc_ficha,
                    'fecha' => $inscripcion->fec_simulacro,
                ]
            ]);

        } else {
            return redirect()->route('inscripcion.index')->with('error', 'No se encontró inscripción con ese DNI');
        }
    }
}

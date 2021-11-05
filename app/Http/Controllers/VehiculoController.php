<?php

namespace App\Http\Controllers;

use App\Models\{Vehiculo,RegistroVehiculo};
use Illuminate\Http\Request;
use App\Exports\VehiculoExport;
use DB;
use Excel;


class VehiculoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            return Vehiculo::all();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            return DB::transaction(function () use ($request) {
                $vehiculo = new Vehiculo();
                $vehiculo->placa = $request['placa'];
                $vehiculo->telefono = $request['telefono'];
                $vehiculo->color = $request['color'];
                $vehiculo->estado_vehiculo = $request['estado_vehiculo'];
                $vehiculo->save();

                return ["mensaje" => "vehiculo registrado"];

            });
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Vehiculo  $vehiculo
     * @return \Illuminate\Http\Response
     */
    public function show(Vehiculo $vehiculo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Vehiculo  $vehiculo
     * @return \Illuminate\Http\Response
     */
    public function edit(Vehiculo $vehiculo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Vehiculo  $vehiculo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            return DB::transaction(function () use ($request, $id) {
                Vehiculo::find($id)->update([
                    'placa' => $request['placa'],
                    'telefono' => $request['telefono'],
                    'color' => $request['color'],
                ]);

                return ["mensaje" => "vehiculo actualizado"];

            });
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function updateEstadoVehiculo(Request $request, $id)
    {
        try {
            return DB::transaction(function () use ($request, $id) {
                $v = Vehiculo::where('id', $id)->first();
                if($v['estado_vehiculo'] == null){
                    Vehiculo::find($id)->update([
                        'estado_vehiculo' => 'asd'
                    ]);
                    $RegistroVehiculo = new RegistroVehiculo();
                    $RegistroVehiculo->vehiculo_id = $id;
                    $RegistroVehiculo->save();
                }

                if($v['estado_vehiculo'] == 1){
                    Vehiculo::find($id)->update([
                        'estado_vehiculo' => 0
                    ]);
                    $RegistroVehiculo = new RegistroVehiculo();
                    $RegistroVehiculo->vehiculo_id = $id;
                    $RegistroVehiculo->save();
                }else{
                    Vehiculo::find($id)->update([
                        'estado_vehiculo' => 1
                    ]);
                    $RegistroVehiculo = new RegistroVehiculo();
                    $RegistroVehiculo->vehiculo_id = $id;
                    $RegistroVehiculo->save();
                }

                return ["mensaje" => "vehiculo actualizado"];

            });
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Vehiculo  $vehiculo
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            return DB::transaction(function () use ($id) {
                Vehiculo::find($id)->delete();
                return ["mensaje" => "vehiculo eliminado"];
            });
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function ExportRegister()
    {
        try {
            return Excel::download(new VehiculoExport(), 'registros.xlsx', \Maatwebsite\Excel\Excel::XLSX);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}

<?php

namespace App\Exports;

use App\Models\Vehiculo;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Support\Str;
use Carbon\Carbon;

class VehiculoExport implements FromQuery, WithHeadings, FromArray
{
    use Exportable;

    protected $vehiculo;

    public function __construct(Array $Array  = [])
    {
        
    }

    public function query()
    {
        
        $vehiculos = Vehiculo::with('hasManyRegister')->get();
        $this->vehiculo = $vehiculos;
        return $vehiculos;
    }

    public function array():Array
    {
        for ($i=0; $i < count($this->vehiculo); $i++) {
            $item[] =  [
                    "ID" => $this->vehiculo['id'],
                    "PEDIDO"  =>  $this->vehiculo['pedido'],
                    "TELEFONO" => $this->vehiculo['telefono'],
                    "COLOR" => $this->vehiculo['color'],
                    "ESTADO VEHICULO " => $this->vehiculo['estado_vehiculo'],
                ];
            for ($j=0; $j < count($item); $j++) { 
                
                for ($x=0; $x < count($this->vehiculo[$i]['hasManyRegister']); $x++) { 
                    
                    if($item[$j]['id'] == $this->vehiculo[$i]['hasManyRegister'][$x]['vehiculo_id']){
                        $item[$j]['REGISTRO'] = $this->vehiculo[$i]['hasManyRegister'][$x]['created_at'];
                    }

                }

            }
        }
        return [$item];
    }
    public function headings(): array
    {
        return [
            "ID" ,
            "PEDIDO",
            "TELEFONO",
            "COLOR ",
            "ESTADO VEHICULO",
            "REGISTRO",
        ];
    }
}


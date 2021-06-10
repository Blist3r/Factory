<?php

namespace App\Exports;

use App\Exports\VentaExportHoja;
use App\Models\Sede;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class VentaExport implements WithMultipleSheets
{
    /**
    * @return \Illuminate\Support\Collection
    */

    use Exportable;

    public $fecha1;
    public $fecha2;

    public function rango($f1, $f2)
    {
        $this->fecha1 = $f1;
        $this->fecha2 = $f2;

        return $this;
    }

    public function sheets(): array
    {

        $sheets=[];

        foreach (Sede::all() as $sede) {

            $sheets[]= new VentaExportHoja($this->fecha1, $this->fecha2, $sede->id, $sede->nombre);

        }

        return $sheets;

    }

}

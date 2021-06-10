<?php

namespace App\Exports;

use App\Models\Venta;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\FromView;

class VentaExportHoja implements FromView, WithTitle, ShouldAutoSize
{
    private $fecha1;
    private $fecha2;
    private $sede_id;
    private $sede;

    public function __construct($fecha1, $fecha2, $sede_id, $sede) {
        $this->fecha1 = $fecha1;
        $this->fecha2 = $fecha2;
        $this->sede_id = $sede_id;
        $this->sede = $sede;
    }

    public function view(): View
    {
        return view('exports.ventas', [
            'ventas' => Venta::whereBetween('fecha', [$this->fecha1, $this->fecha2])->where('sedes_id',$this->sede_id)->get()
        ]);
    }

    public function title(): string {
        return $this->sede;
    }

}

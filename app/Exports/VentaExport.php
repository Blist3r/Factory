<?php

namespace App\Exports;

use App\Models\Venta;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class VentaExport implements FromView, WithTitle, ShouldAutoSize
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

    public function view(): View
    {
        return view('exports.ventas', [
            'ventas' => Venta::whereBetween('fecha', [$this->fecha1, $this->fecha2])->get()
        ]);
    }

    public function title(): string {
        return 'Reporte de Ventas';
    }
}

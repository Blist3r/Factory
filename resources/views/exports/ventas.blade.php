
<table style="border-collapse: collapse; border: 1px solid #000000 !important;">
    <thead style="border: 1px solid #000000 !important;border-collapse: collapse;">
    <tr style="border: 1px solid #000000 !important;border-collapse: collapse;">
        <td style="border: 1px solid #000000 !important;background-color: #f0f0f0;border: 1px solid #000000 !important;color: #333333;font-family: Arial, sans-serif;font-size: 36px;font-weight: bold;overflow: hidden;padding: 6px 20px;text-align: center;vertical-align: top;word-break: normal;" colspan="6">Reporte de Ventas</td>
    </tr>
    <tr style="border: 1px solid #000000 !important;border-collapse: collapse;">
        <th style="border: 1px solid #000000 !important;background-color: #c0c0c0;color: #333333;font-family: Arial, sans-serif;font-size: 14px;font-weight: bold;overflow: hidden;padding: 6px 20px;text-align: left;vertical-align: top;word-break: normal;">Vendedor</th>
        <th style="border: 1px solid #000000 !important;background-color: #c0c0c0;color: #333333;font-family: Arial, sans-serif;font-size: 14px;font-weight: bold;overflow: hidden;padding: 6px 20px;text-align: left;vertical-align: top;word-break: normal;">Cliente</th>
        <th style="border: 1px solid #000000 !important;background-color: #c0c0c0;color: #333333;font-family: Arial, sans-serif;font-size: 14px;font-weight: bold;overflow: hidden;padding: 6px 20px;text-align: left;vertical-align: top;word-break: normal;">Fecha</th>
        <th style="border: 1px solid #000000 !important;background-color: #c0c0c0;color: #333333;font-family: Arial, sans-serif;font-size: 14px;font-weight: bold;overflow: hidden;padding: 6px 20px;text-align: left;vertical-align: top;word-break: normal;">Sucursal</th>
        <th style="border: 1px solid #000000 !important;background-color: #c0c0c0;color: #333333;font-family: Arial, sans-serif;font-size: 14px;font-weight: bold;overflow: hidden;padding: 6px 20px;text-align: left;vertical-align: top;word-break: normal;">Metodo de Pago</th>
        <th style="border: 1px solid #000000 !important;background-color: #c0c0c0;color: #333333;font-family: Arial, sans-serif;font-size: 14px;font-weight: bold;overflow: hidden;padding: 6px 20px;text-align: left;vertical-align: top;word-break: normal;">Total</th>
    </tr>
    </thead>
    <tbody>
        @php
            $total = 0;
        @endphp
        @foreach($ventas as $venta)
            <tr>
                <td> {{ App\Models\User::find($venta->users_id)->nombre }} {{ App\Models\User::find($venta->users_id)->apellido }}</td>
                <td> {{ App\Models\Cliente::find($venta->clientes_id)->nombre }}</td>
                <td>{{ $venta->fecha }}</td>
                <td>{{ App\Models\Sede::find($venta->sedes_id)->nombre }}</td>
                <td>{{ $venta->metodo_pago }}</td>
                <td>{{ $venta->total }}</td>
            </tr>
            @php
                $total = $total + $venta->total;
            @endphp
        @endforeach
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>Total</td>
            <td>{{ $total }}</td>
        </tr>
    </tbody>
</table>

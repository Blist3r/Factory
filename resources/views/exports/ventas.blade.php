
<table>
    <thead>
    <tr>
        <th>Vendedor</th>
        <th>Cliente</th>
        <th>Fecha</th>
        <th>Total</th>
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
                <td>{{ $venta->total }}</td>
            </tr>
            @php
                $total = $total + $venta->total;
            @endphp
        @endforeach
        <tr>
            <td></td>
            <td></td>
            <td>Total</td>
            <td>{{ $total }}</td>
        </tr>
    </tbody>
</table>

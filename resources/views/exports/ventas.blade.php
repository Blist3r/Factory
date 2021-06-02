
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
    @foreach($ventas as $venta)
        <tr>
            <td> {{ App\Models\User::find($venta->users_id)->nombre }} {{ App\Models\User::find($venta->users_id)->apellido }}</td>
            <td> {{ App\Models\Cliente::find($venta->clientes_id)->nombre }}</td>
            <td>{{ $venta->fecha }}</td>
            <td>{{ $venta->total }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

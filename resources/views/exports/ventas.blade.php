
<table>
    <thead>
    <tr>
        <th>Vendedor</th>
        <th>Fecha</th>
        <th>Total</th>
    </tr>
    </thead>
    <tbody>
    @foreach($ventas as $venta)
        <tr>
            <td>{{ $venta->vendedor }}</td>
            <td>{{ $venta->fecha }}</td>
            <td>{{ $venta->total }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

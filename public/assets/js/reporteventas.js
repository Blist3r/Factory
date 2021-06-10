$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function () {

});

function MostrarVenta(id) {
    $.ajax({
        url: '/reportes/buscar_ventas',
        type: 'POST',
        data: {id:id},
        success: function (data) {
            console.log(data);
            let htmlDetalleVenta = '<ul class="list-group mb-3">';
            data.productos.forEach(element => {
                htmlDetalleVenta += `
                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                    <div>
                            <div> <img src="/storage/${element.producto.imagen}" class="rounded-lg mr-2" width="150" alt=""></div>
                            <div>
                                <h3 class="my-0">${element.producto.nombre}</h3>
                                <h5 class="text-muted">Cantidad: ${element.cantidad}</h5>
                            </div>
                    </div>

                        <h2>
                        <span class="text-muted">Valor: $${element.producto.valor}</span>
                        </h2>

                    </li>


                `;
            });
            htmlDetalleVenta += '</ul>';
            $("#contentModalDetalle").html(htmlDetalleVenta);
            $('#modalMostrarVenta').modal('show');
        },
        error(e) {
            console.log(e);
        }
    });
}

function filtrarPorSede(sede) {
    window.location.href = '/reportes/ventas/filtro?sede='+sede;
}

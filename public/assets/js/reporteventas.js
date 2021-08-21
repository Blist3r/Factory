$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function () {

});
// Se hace una peticion ajax para que muestre en la seccion de "ventas" cuantas ventas se hicieron y con sus elementos.
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

function cierre() {
    let sucursal = $('#sedes_id').val();

    if(!sucursal) {
        alert('La Sede es requerida');

        return false;
    }

    $.ajax({
        url : "/reportes/print_cierre",
        type : "POST",
        data: {sucursal},
        dataType : 'json',
        async: false,
        success : function(data){
            if(data) {
                print_cierre(data);
            }
        }
    });
}

function print_cierre(data) {
    $.ajax({
        url : "http://localhost/api_factory/cierre.php",
       type : "POST",
      data: data,
      async: false,
     dataType : 'json',
     headers: false,
       success : function(data){
           console.log(data);
      },
      error(e){console.log(e)}
  });
}

function print_ticket(data) {
    $.ajax({
        url : "http://localhost/api_factory/ticket.php",
        type : "GET",
        data: data,
        dataType : 'json',
        success : function(data){
            console.log(data);
        }
    });
}

function Imprimir(id) {
    $.ajax({
        url : "imprimir_ventas",
        type : "POST",
        data: {id:id},
        dataType : 'json',
        success : function(data){
            print_ticket(data)
        },
        error(e) {
            console.log(e);
        }
    });
}

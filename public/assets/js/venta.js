$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function () {
   cargarProductos();
});

// funcion para traer los productos
function cargarProductos(categoria=false, q=false) {
    $.ajax({
        url: '/ventas/show',
        type: 'POST',
        data: {categoria:categoria, q:q},
        success: function (data) {
            let html = "";
            data.data.forEach(producto => {
                html += `<div class="col-xl-3 col-lg-6 col-md-4 col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="new-arrival-product">
                                        <div class="new-arrivals-img-contnent">
                                            <img class="img-fluid" src="storage/${producto.imagen}" alt="" width="150">
                                        </div>
                                        <div class="new-arrival-content text-center mt-3">
                                            <h4>${producto.nombre}</h4>
                                            <span class="price">$${producto.valor}</span>
                                        </div>
                                        <div class="row">
                                            <div class="shopping-cart mt-3 d-flex">
                                                <input type="number" name="cantidad_${producto.id}" id="cantidad_${producto.id}" class="form-control input-btn input-number" value="1">
                                                <a class="btn btn-primary ml-2" href="javascript:agregarProducto(${producto.id}, '${producto.nombre}', ${producto.valor})"><i class="fa fa-shopping-basket"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>`;

            });

            $('#productos').html(html);
        }
    });
}

// funcion agregar productos al carrito
function agregarProducto(id, nombre, valor) {
    cantidad = $("#cantidad_"+id).val();

    if (cantidad == 0) {
        alert('La cantidad no puede ser 0');
        return;
    }

    let ValidarProducto = ValidadProducto(id, cantidad, valor, nombre);

    if (ValidarProducto==1) {
        return;
    }

    let html = `<li class="list-group-item d-flex justify-content-between lh-condensed" id="producto_${id}">
                    <div>
                        <h6 class="my-0">${nombre}</h6>
                        <small class="text-muted">Cantidad: ${cantidad}</small>
                    </div>
                    <span class="text-muted">$${valor*cantidad}</span>
                    <input type="hidden" name="productos[]" id="productos[]" value="${id}">
                    <input type="hidden" name="cantidad[]" id="cantidad[]" value="${cantidad}">
                    <input type="hidden" name="valor[]" id="valor[]" value="${valor*cantidad}">
                    <button type="button" onclick="eliminarProducto(${id})" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span></button>
                </li>`;

    let detalle_venta = $("#detalle_venta").html();
    let html_final = detalle_venta + html;

    // Agregar html de detalle productos
    $("#detalle_venta").html(html_final);

    calcularDetalle("+");
}

function eliminarProducto(id) {
    $("#producto_"+id).remove();

    calcularDetalle("-");
}

function calcularDetalle(op='') {
    // Aumentar cantidad de productos totales
    if (op == "+") {
        $("#total_productos").html(parseInt($("#total_productos").html()) + 1);
    } else if(op == '-'){
        $("#total_productos").html(parseInt($("#total_productos").html()) - 1);
    }

    let total = 0;
    $("input[name='valor[]']").each(function(indice, elemento) {
        let total_temp = parseInt($(elemento).val());
        total = total_temp + total;
    });

    $('#total_valor').html("$"+total);
}

function ValidadProducto(id, cantidad, valor, nombre) {

    let retornar = 0;

    $("input[name='productos[]']").each(function(indice, elemento) {


        if ($(elemento).val()==id) {
            if ($('#producto_'+id +' input[name="cantidad[]"]').val() != cantidad) {
                $('#producto_'+id +' input[name="cantidad[]"]').val(cantidad);
                $('#producto_'+id +' input[name="valor[]"]').val(valor*cantidad);

                let html = `
                    <div>
                        <h6 class="my-0">${nombre}</h6>
                        <small class="text-muted">Cantidad: ${cantidad}</small>
                    </div>
                    <span class="text-muted">$${valor*cantidad}</span>
                    <input type="hidden" name="productos[]" id="productos[]" value="${id}">
                    <input type="hidden" name="cantidad[]" id="cantidad[]" value="${cantidad}">
                    <input type="hidden" name="valor[]" id="valor[]" value="${valor*cantidad}">
                    <button type="button" onclick="eliminarProducto(${id})" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span></button>`;

                    // Agregar html de detalle productos
                    $('#producto_'+id).html(html);

                calcularDetalle();
            }

            retornar = 1;
        }

    });
    return retornar;
}

function realizarVenta() {
    let cont = 0;

    $("input[name='productos[]']").each(function(indice, elemento) {
        cont++;
    });

    if(cont > 0){
        $("#modalVenta").modal('show');
        let htmlDetalleVenta = '<ul class="list-group mb-3">';

        $("#detalle_venta li").each(function(indice, elemento) {
            let nombre = $("div h6", elemento).text();
            let cantidad = $("div small", elemento).text();
            let precio = $("span", elemento).text();

            htmlDetalleVenta += `
                <li class="list-group-item d-flex justify-content-between lh-condensed">
                    <div>
                        <h6 class="my-0">${nombre}</h6>
                        <small class="text-muted">${cantidad}</small>
                    </div>
                    <span class="text-muted">${precio}</span>
                </li>
            `;
        });

        htmlDetalleVenta += '</ul>';

        $("#contentModalDetalle").html(htmlDetalleVenta);
    } else {
        alert("Debe agregar al menos un producto");
    }

}

function searchCliente(id) {
    $.ajax({
        url: '/ventas/searchCliente',
        type: 'POST',
        data: {id:id},
        success: function (data) {
            if(data){
                $("#nombre_cliente").val(data.nombre+" "+data.apellido);
                $("#telefono_cliente").val(data.telefono);
            } else {
                $("#nombre_cliente").val("");
                $("#telefono_cliente").val("");
            }
        },
        error(e) {
            console.log(e);
        }
    });
}

function ValidarVenta() {
    // Validar informacion del cliente
    let identificacion_cliente = $("#identificacion_cliente").val();
    let nombre_cliente = $("#nombre_cliente").val();
    let telefono_cliente = $("#telefono_cliente").val();
    let direccion_cliente = $("#direccion_cliente").val();


    // Validamos identifiacion y nombre que son obligatorios
    if(!identificacion_cliente || !nombre_cliente) {
        alert("Debe ingresar cliente");
        return;
    }

    let domicilio = $("#domicilio").is(":checked") ? 1 : 0;
    let propina = $("#propina").is(":checked") ? 1 : 0;

    // Si es a domicilio, validamos que tenga la direccion
    if(domicilio == 1){
        if(!direccion_cliente) {
            alert("Debe ingresar la dirección del cliente");
            return;
        }
    }

    // Validamos el usuario y contraseña del vendedor
    let identificacion_vendedor = $("#identificacion_vendedor").val();
    let password_vendedor = $("#password_vendedor").val();

    let usuario = 1;

    $.ajax({
        url: '/ventas/validarVendedor',
        type: 'POST',
        data: {identificacion_vendedor:identificacion_vendedor, password_vendedor:password_vendedor},
        async: false,
        success: function (data) {
            if(data != 1){
                alert("Usuario o contraseña incorrectos");
                usuario = 0;


            }
        },
        error(e) {
            console.log(e);
        }
    });

    if(usuario == 0){
        return;
    }

    let metdoPago = $("#metodo_pago").val();

    if(!metdoPago || metdoPago == ""){
        alert("Debe seleccionar metodo de pago");
        return;
    }

    // Datos que seran enviados al backend
    let productos = $("#formDetalleVenta").serialize();

    let data = productos+
               "&nombre_cliente="+nombre_cliente+
               "&identificacion_cliente="+identificacion_cliente+
               "&telefono_cliente="+telefono_cliente+
               "&direccion_cliente="+direccion_cliente+
               "&identificacion_vendedor="+identificacion_vendedor+
               "&domicilio="+domicilio+
               "&propina="+propina+
               "&metodo_pago="+metdoPago;

    $.ajax({
        url: '/ventas/realizarVenta',
        type: 'POST',
        data: data,
        success: function (data) {
            if(data && data != 0){
                // Impresion del ticket
                print_ticket(data);

                swal({
                    type: 'success',
                    title: 'Correcto',
                    text: 'Se creo la venta correctamente',
                    allowOutsideClick: false
                }).then( function(isConfirm){
                    if (isConfirm.value){
                        $("#modalVenta").modal('hide');
                        window.location.reload();
                    }
                });
            } else {
                swal({
                    type: 'error',
                    title: 'Error',
                    text: 'Ocurrio un error, intentelo nuevamente',
                });
            }
        },
        error(e) {
            console.log(e);
        }
    });
}

function print_ticket(data) {
    console.log(data);
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



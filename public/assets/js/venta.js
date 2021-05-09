$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function () {
   cargarProductos();
});

// funcion para traer los productos
function cargarProductos(categoria=false) {
    $.ajax({
        url: '/ventas/show',
        type: 'POST',
        data: {categoria:categoria},
        success: function (data) {
            console.log(data);
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


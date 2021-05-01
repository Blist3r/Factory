$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

// Se pone la funcion "EditarProducto" para que al momento de editar la sede cambie los datos que se le ponen en el success.
function EditarProducto(id) {
    $.ajax({
        url: 'productos/show',
        type: 'POST',
        data: { id:id },
        success: function (data) {
            $("#modalAgregarProducto").modal('show');
            $('#nombre').val(data.nombre);
            $('#descripcion').val(data.descripcion);
            $('#valor').val(data.valor);
            $('#categorias_id').selectpicker('val', data.categorias_id);
            $("#categorias_id option[value="+data.categorias_id+"]").attr('selected', 'selected');
            $('#id').val(data.id);
        }
    });
}
// Se pone un confirm para que no haya errores almomento de intentar eliminar el usuario
// Dentro de la condicion se busca el usuario por id y se elimina.
function EliminarProducto(id) {
    if (confirm('Seguro desea eliminar el usuario?')) {

        window.location.href='productos/delete/' + id;

    }
}

function LimpiarInput() {
    $('#nombre').val('');
    $('#id').val('');
}

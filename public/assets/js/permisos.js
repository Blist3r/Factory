$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

// Se pone la funcion "EditarPermiso" para que al momento de editar la sede cambie los datos que se le ponen en el success.
function EditarPermiso(id) {
    $.ajax({
        url: 'permisos/show',
        type: 'POST',
        data: { id:id },
        success: function (data) {
            $("#modalAgregarPermiso").modal('show');
            $('#name').val(data.name);
            $('#id').val(data.id);
        }
    });
}
// Se pone un confirm para que no haya errores almomento de intentar eliminar el permiso
// Dentro de la condicion se busca el permiso por id y se elimina.
function EliminarPermiso(id) {
    if (confirm('Seguro desea eliminar el permiso?')) {

        window.location.href='permisos/delete/' + id;

    }
}

function LimpiarInput() {
    $('#nombre').val('');
    $('#id').val('');
}

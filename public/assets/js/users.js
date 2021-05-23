$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

// Se pone la funcion "EditarUser" para que al momento de editar la sede cambie los datos que se le ponen en el success.
function EditarUser(id) {
    $.ajax({
        url: 'users/show',
        type: 'POST',
        data: { id:id },
        success: function (data) {
            $("#modalAgregarUsuario").modal('show');
            $('#nombre').val(data.nombre);
            $('#apellido').val(data.apellido);
            $('#identificacion').val(data.identificacion);
            $('#sedes_id').selectpicker('val', data.sedes_id);
            $("#sedes_id option[value="+data.sedes_id+"]").attr('selected', 'selected');
            $('#rol').selectpicker('val', data.roles[0].name);
            $("#rol option[value="+data.roles[0].name+"]").attr('selected', 'selected');
            $('#id').val(data.id);
        }
    });
}
// Se pone un confirm para que no haya errores almomento de intentar eliminar el usuario
// Dentro de la condicion se busca el usuario por id y se elimina.
function EliminarUser(id) {
    if (confirm('Seguro desea eliminar el usuario?')) {

        window.location.href='users/delete/' + id;

    }
}

function LimpiarInput() {
    $('#nombre').val('');
    $('#id').val('');
}

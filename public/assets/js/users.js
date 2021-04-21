$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

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
            $('#id').val(data.id);
        }
    });
}

function EliminarUser(id) {
    if (confirm('Seguro desea eliminar el usuario?')) {

        window.location.href='users/delete/' + id;

    }
}

function LimpiarInput() {
    $('#nombre').val('');
    $('#id').val('');
}

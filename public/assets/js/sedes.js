$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function EditarSede(id) {
    $.ajax({
        url: 'sedes/show',
        type: 'POST',
        data: { id:id },
        success: function (data) {
            $("#modalAgregarSede").modal('show');
            $('#nombre').val(data.nombre);
            $('#id').val(data.id);
        }
    });
}

function EliminarSede(id) {
    if (confirm('Seguro desea eliminar la sede?')) {

        window.location.href='sedes/delete/' + id;

    }
}

function LimpiarInput() {
    $('#nombre').val('');
    $('#id').val('');
}

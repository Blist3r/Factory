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
            $("#modalAgregarUser").modal('show');
            $('#nombre').val(data.nombre);
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

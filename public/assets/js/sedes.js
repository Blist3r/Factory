$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
// Se pone la funcion "EditarSede" para que al momento de editar la sede cambie los datos que se le ponen en el success.
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

// Se pone un confirm para que no haya errores almomento de intentar eliminar la sede
// Dentro de la condicion se busca la sede por id y se elimina.
function EliminarSede(id) {
    if (confirm('Seguro desea eliminar la sede?')) {

        window.location.href='sedes/delete/' + id;

    }
}

function LimpiarInput() {
    $('#nombre').val('');
    $('#id').val('');
}

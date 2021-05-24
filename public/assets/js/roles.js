$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

// Se pone la funcion "EditarRol" para que al momento de editar la sede cambie los datos que se le ponen en el success.
function EditarRol(id) {
    $.ajax({
        url: 'roles/show',
        type: 'POST',
        data: { id:id },
        success: function (data) {
            $("#modalAgregarRol").modal('show');
            $('#name').val(data.name);
            $('#id').val(data.id);
        }
    });
}
// Se pone un confirm para que no haya errores almomento de intentar eliminar el rol
// Dentro de la condicion se busca el rol por id y se elimina.
function EliminarRol(id) {
    if (confirm('Seguro desea eliminar el rol?')) {

        window.location.href='roles/delete/' + id;

    }
}

function LimpiarInput() {
    $('#nombre').val('');
    $('#id').val('');
}

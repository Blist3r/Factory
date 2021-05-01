$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
// Se pone la funcion "EditarCliente" para que al momento de editar la sede cambie los datos que se le ponen en el success.
function EditarCliente(id) {
    $.ajax({
        url: 'clientes/show',
        type: 'POST',
        data: { id:id },
        success: function (data) {
            $("#modalAgregarCliente").modal('show');
            $('#nombre').val(data.nombre);
            $('#apellido').val(data.apellido);
            $('#identificacion').val(data.identificacion);
            $('#direccion').val(data.direccion);
            $('#telefono').val(data.telefono);
            $('#correo').val(data.correo);
            $('#id').val(data.id);
        }
    });
}
z
// Se pone un confirm para que no haya errores almomento de intentar eliminar el cliente
// Dentro de la condicion se busca la sede por id y se elimina.
function EliminarCliente(id) {
    if (confirm('Seguro desea eliminar el cliente?')) {

        window.location.href='clientes/delete/' + id;

    }
}

function LimpiarInput() {
    $('#nombre').val('');
    $('#id').val('');
}

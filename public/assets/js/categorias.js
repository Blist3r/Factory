$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
// Se pone la funcion "EditarCategoria" para que al momento de editar la sede cambie los datos que se le ponen en el success.
function EditarCategoria(id) {
    $.ajax({
        url: 'categorias/show',
        type: 'POST',
        data: { id:id },
        success: function (data) {
            $("#modalAgregarCategoria").modal('show');
            $('#nombre').val(data.nombre);
            $('#id').val(data.id);
        }
    });
}

// Se pone un confirm para que no haya errores almomento de intentar eliminar la categoria
// Dentro de la condicion se busca la categoria por id y se elimina.
function EliminarCategoria(id) {
    if (confirm('Seguro desea eliminar la categoria?')) {

        window.location.href='categorias/delete/' + id;

    }
}

function LimpiarInput() {
    $('#nombre').val('');
    $('#id').val('');
}

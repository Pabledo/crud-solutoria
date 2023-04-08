//      GUARDAR REGISTRO
function createUF(){
    $('#modalTitle2').text('NUEVO REGISTRO');
    $("#form-modal").modal('show'); 
}

$("#btnSave").on('click', function(e){
    e.preventDefault();
    if($("#updateId").val() == null || $("#updateId").val() == ""){
        createUF();
    } else {
        updateUF();
    }
})

$('#create-form').on('submit', function(event){
    event.preventDefault();
    $("#btnSave").prop('disabled', true);
    var url = $(this).attr('data-action');
    console.log(url)
    $.ajax({
        url: url,
        method: 'POST',
        data: {
            value: $('#value').val(),
            date: $('#date').val(),
        },
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            successInsert();
        },
        error: function(xhr, status, error) {
            console.log('en error')
            console.log(xhr)
          $.each(xhr.responseJSON.error, function (key, item) {
            $("#errors").append("<li class='alert alert-danger'>"+item+"</li>")
          });
        }
    });
});

//      MODIFICAR REGISTRO

$('body').on('click', '.updateUF', function () {
    $('#modalTitle2').text('ACTUALIZAR REGISTRO');
    $('#createModal').modal("show");
    var idUf = $(this).val();
});

function updateUF(){
    
    var url = 'indicators/'
    $.ajax({
        url: url+idUf,
        method: 'PUT',
        data: {
            id: idUf,
            value: $('#value').val(),
            date: $('#date').val(),
        },
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            successInsert();
        },
        error: function(xhr, status, error) {
            console.log('en error')
            console.log(xhr)
          $.each(xhr.responseJSON.error, function (key, item) {
            $("#errors").append("<li class='alert alert-danger'>"+item+"</li>")
          });
        }
    });
}

//      ELIMINAR REGISTRO
$('body').on('click', '.deleteUF', function () {
    var id = $(this).val();
    $('#idToDelete').val(id);
    $('#deleteModal').modal("show");
});

function deleteUF(){
    var id = $('#idToDelete').val();
    var url = 'indicators/'
    $.ajax({
        type: "DELETE",
        url: url+id,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
            $('#modalTitle').text('¡Registro eliminado!');
            $('#modalInfo').text('El registro se ha eliminado exitosamente de la base de datos.');
            $('#confirmModal').modal("show");
        },
        error: function (data) {
            console.log('Error:', data);
        }
    });
}

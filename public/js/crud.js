/* 
    Abrir modal para crear un nuevo registro 
*/
function createUF(){
    $("#value").val("");
    $("#date").val("");
    $('#modalTitle2').text('NUEVO REGISTRO');
    $("#updateId").val("");
    $("#createModal").modal('show'); 
}
/* 
    Guarda o Actualiza dependiendo del valor del submit 
*/
$("#btnSave").on('click', function(e){
    e.preventDefault();
    if($("#updateId").val() == null || $("#updateId").val() == ""){
        StoreUF();
    } else {
        updateUF();
    }
})
/* 
    Inserta registro en la BD 
*/
function StoreUF(){
    $("#btnSave").prop('disabled', true);
    var url = 'indicators'
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
            $("#btnSave").prop('disabled', false);
            $('#createModal').hide();
            $('#confirmModal').modal({ backdrop: "static" });
            $('#confirmModal').modal('show');
        },
        error: function(xhr, status, error) {
            $("#btnSave").prop('disabled', false);
          $.each(xhr.responseJSON.error, function (key, item) {
            $("#errors").append("<li class='alert alert-danger'>"+item+"</li>")
          });
        }
    });
}

/* 
    Obtiene los registros para insertarlos en el Form 
*/
function editUF(id){
    let url = "indicators/" + id ;
    $.ajax({
        url: url,
        type: "GET",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            console.log('Success en edit')
            let uf = response.uf;
            $("#errors").html("");
            $("#updateId").val(uf.id);
            $("#value").val(uf.value);
            $("#date").val(uf.date);
            $("#createModal").modal('show'); 
        },
        error: function(response) {
            console.log('Error en edit:'+response.responseJSON)
        }
    });
}

/* 
    Actualiza un registro en la BD 
*/

function updateUF(){
    $("#btnSave").prop('disabled', true);
    var url = 'indicators/' + $("#updateId").val();
    $.ajax({
        url: url,
        method: 'PUT',
        data: {
            id: $("#updateId").val(),
            value: $('#value').val(),
            date: $('#date').val(),
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            $("#btnSave").prop('disabled', false);
            $('#modalTitle').text('¡REGISTRO ACTUALIZADO!');
            $('#modalInfo').text('El registro se ha actualizado exitosamente en la base de datos.');
            $('#confirmModal').modal({ backdrop: "static" });
            $('#confirmModal').modal("show");
        },
        error: function(xhr, status, error) {
            $("#errors").html("");
            $("#btnSave").prop('disabled', false);
            console.log('en error')
            console.log(xhr)
          $.each(xhr.responseJSON.error, function (key, item) {
            $("#errors").append("<li class='alert alert-danger'>"+item+"</li>")
          });
        }
    });
}

/* 
    Elimina un registro de la BD 
*/
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
            $('#modalTitle').text('¡REGISTRO ELIMINADO!');
            $('#modalInfo').text('El registro se ha eliminado exitosamente de la base de datos.');
            $('#confirmModal').modal({ backdrop: "static" });
            $('#confirmModal').modal("show");
        },
        error: function (data) {
            console.log('Error:', data);
        }
    });
}

/* 
        SELECTOR DE FECHAS GRÁFICO 
*/



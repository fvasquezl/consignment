function saveInfo(url,method,form,modal){
    let request = $.ajax({
        url: url,
        type: method,
        dataType: 'json',
        data: $(form).serialize(),
    });
    request.done(function(data) {
        $(modal).modal('toggle');
        Swal.fire({
            position: 'top-end',
            type: 'success',
            title: data.message,
            showConfirmButton: false,
            timer: 1500
        })
    });
    request.fail(function (jqXHR, textStatus, errorThrown){
        if( jqXHR.status === 401 )
            $( location ).prop( 'pathname', 'auth/login' );

        if( jqXHR.status === 422 ) {

            let $errors = jqXHR.responseJSON.errors;

            RemoveErrorsFields(form);
            $.each($errors, function( key, value ) {
                let input = $(form).find(`[name=${key}]`);

                $(input).addClass('is-invalid')
                    .parent()
                    .find('.invalid-feedback>strong')
                    .text(value)
                    .next('span.invalid-feedback');
            });
        }else{
            Swal.fire('Failed!', "There was something wrong"+ textStatus, "warning");
        }
    });
}


function deleteInfo(url,table='') {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.value) {
            let request = $.ajax({
                url: url,
                type: 'delete',
                dataType: 'json',
            });
            request.done(function (data) {


                Swal.fire(
                    'Deleted!',
                    data.message,
                    'success'
                );
            });
            request.fail(function (jqXHR, textStatus, errorThrown) {
                Swal.fire('Failed!', "There was something wrong", "warning");
            });
        }
    });
    return true;
}

function myAjax(url,method,data=''){
    let result = '';
    let request = $.ajax({
        url: url,
        type: method,
        dataType: 'json',
        data: data,
        async: false
    });
    request.done(function(ret) {
        return result = ret;
    });
    request.fail(function (jqXHR, textStatus, errorThrown) {
        Swal.fire('Failed!', "There was something wrong"+ textStatus, "warning");
    });
    return result;
}


function getRowData(id,column='',$location= window.location.pathname){

    let location = window.location.origin + $location;
    let url =location+`/${id}/edit`;

    if (column){
        url =location+`/${id}/edit/${column}`;
    }

    return myAjax(url, 'GET');
}

function RemoveErrorsFields(form){
    $(form).each(function () {
        let input = $(this).find(':input');
        input.hasClass('is-invalid') ? input.removeClass('is-invalid') :'';
    });
}

function displayLabels(form,input) {

    form.each(function () {
        $(this).find(':input').val(function(index, value){
            return input[this.id]
        });

    });
}

$(document).on('change','.custom-checkbox',function() {
    $(this).attr('value', this.checked);
});







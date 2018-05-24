//Autor: Luis Castañeda
//Plagiado por: Conrado Carrillo
function ajaxForm(form_id, config) {
    var formData = new FormData($("form#"+form_id)[0]);
    var button = $("form#"+form_id).find('button.save');
    $.ajax({
        method: "POST",
        type: "POST",
        url: $("form#"+form_id).attr('action'),
        data: formData,
        cache:false,
        contentType: false,
        processData: false,
        success: function(data) {
            $(".guardar").prop( "disabled", false ).removeClass('disabled');
            swal.close();
            swal({
                title: data.status == 'success' ? 'Bien: ' : 'Error',
                icon: data.status ? data.status : "success",
                content: {
                    element: "div",
                    attributes: {
                        innerHTML:"<p class='text-response'>"+data.msg ? data.msg : "¡Cambios guardados exitosamente!"+"</p>"
                    },
                },
                buttons: false,
                closeOnEsc: false,
                closeOnClickOutside: false,
                timer: 2000
            }).catch(swal.noop);

            if (config.refresh == 'table') {
                    refreshContent(data.url, config.column, config.table_id, config.container_id);
            } else if(config.redirect) {
                setTimeout( function() {
                    if (data.url) {
                        window.location.href = data.url;
                    }
                }, '2000');
            }
        },
        error: function(xhr, status, error) {
            displayAjaxError(xhr, status, error);
        }
    });
}

function ajaxFormModal(form_id, config) {
    var formData = new FormData($("form#"+form_id)[0]);
    $.ajax({
        method: "POST",
        type: "POST",
        url: $("form#"+form_id).attr('action'),
        data: formData,
        cache:false,
        contentType: false,
        processData: false,
        success: function(data) {
            $(".guardar").prop( "disabled", false ).removeClass('disabled');
            $('div.modal').modal('hide');
            swal.close();
            swal({
                title: 'Bien: ',
                icon: data.status ? data.status : "success",
                content: {
                    element: "div",
                    attributes: {
                        innerHTML:"<p class='text-response'>"+data.msg ? data.msg : "¡Cambios guardados exitosamente!"+"</p>"
                    },
                },
                buttons: false,
                closeOnEsc: false,
                closeOnClickOutside: false,
                timer: 2000
            }).catch(swal.noop);

            if (config.refresh == 'table') {
                    refreshContent(data.url, config.column, config.table_id, config.container_id);
            } else if(config.redirect) {
                setTimeout( function() {
                    if (data.url) {
                        window.location.href = data.url;
                    }
                }, '2000');
            }
        },
        error: function(xhr, status, error) {
            displayAjaxError(xhr, status, error);
        }
    });
}

function ajaxSimple(config) {
    $.ajax({
        method: config.method ? config.method : "POST",
        type: config.method ? config.method : "POST",
        url: config.route,
        data: config,
        success: function(data) {
            $('div.modal').modal('hide');
            swal.close();
            
            swal({
                title: 'Bien: ',
                icon: data.status ? data.status : "success",
                content: {
                    element: "div",
                    attributes: {
                        innerHTML:"<p class='text-response'>"+data.msg ? data.msg : "¡Cambios guardados exitosamente!"+"</p>"
                    },
                },
                buttons: false,
                closeOnEsc: false,
                closeOnClickOutside: false,
                timer: 2000
            }).catch(swal.noop);

            if (config.refresh == 'table') {
                    refreshContent(data.url, config.column, config.table_id, config.container_id);
            } else if(config.redirect) {
                setTimeout( function() {
                    window.location.href = data.url;
                }, '2000');
            }
        },
        error: function(xhr, status, error) {
            displayAjaxError(xhr, status, error);
        }
    });
}

function ajaxMSimple(data) {
    url = baseUrl.concat(data.url);
    $.ajax({
        method: "POST",
        url: url,
        data: data,
        success: function(response) {
            fill_text(response, null);
            $("img.product_img").attr("src", baseUrl.concat('/'+response.product_img));
            $("img.customer_img").attr("src", baseUrl.concat('/'+response.customer_img));
            $("a.product_link").prop("href", response.product_link);
            $( ".data-fill" ).find( ".price" ).text('$'+(response.price/100));
            $( ".data-fill" ).find( ".total" ).text('$'+(response.total/100));
            $( ".data-fill" ).find( ".fee" ).text('$'+(response.fee/100));
        },
        error: function(xhr, status, error) {
            displayAjaxError(xhr, status, error);
        }
    });
}

function fill_text(response, modal_id) {
    $( ".fill-container" ).addClass('hide');
    var keyNames = Object.keys(response);

    for (var i in keyNames) {
        prop_name = keyNames[i];
        if (response[prop_name]) {
            $( ".data-fill" ).find( "."+prop_name ).text(response[prop_name]);
            $( ".data-fill" ).find( "."+prop_name ).closest('.fill-container').removeClass('hide');
        }
    }
    if (modal_id) {
        $('div#'+modal_id).modal();
    }

    //Custom code
    $('#load-bar').addClass('hide');
    $('#detail-fields').removeClass('hide');

}

function displayAjaxError(xhr, status, error) {
    $(".guardar").prop( "disabled", false ).removeClass('disabled');
    $('div.modal').modal('hide');
    swal.stopLoading();
    swal.close();
    if (/^[\],:{}\s]*$/.test(xhr.responseText.replace(/\\["\\\/bfnrtu]/g, '@').replace(/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g, ']').replace(/(?:^|:|,)(?:\s*\[)+/g, ''))) {
        display = JSON.parse(xhr.responseText).msg;
    } else {
        display = '';
    }
    swal({
        title: '¡Error!',
        icon: 'error',
        content: {
            element: "div",
            attributes: {
                innerHTML:"Se encontró un problema con ésta petición: <br><span>" + display + "</span><br><span style='color:#F8BB86'>\nError: " + xhr.status + " (" + error + ") "+"</span>"
            },
        },
    }).catch(swal.noop);
}

//Reload a table, then initializes it as datatable
function refreshContent(url, column, table_id, container_id) {
    $('.delete-rows').attr('disabled', true);
    var table = table_id ? $("table#"+table_id).dataTable() : $("table#rows").dataTable();
    var container = container_id ? $("div#"+container_id) : $('div#table-container');
    table.fnDestroy();
    container.fadeOut();
    container.empty();
    container.load(url, function() {
        container.fadeIn();
        $(table_id ? "table#"+table_id : "table#rows").dataTable({
            "aaSorting": [[ column ? column : 1, "desc" ]]
        });
    });
}

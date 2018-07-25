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
            if (swal.getState().isOpen) { swal.close(); }
            if (!config.keepModal) { $('div.modal').modal('hide'); }
            
            if(!config.callback) {
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
            }

            if (config.refresh == 'table') {
                refreshContent(data.url, config.column, config.table_id, config.container_id);
            } else if(config.callback) {
                window[config.callback](data, config.reload_ta);
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

function fill_text(response, modal_id, clear_fields = false) {
    clear_fields ? $( ".fill-container" ).addClass('hide') : '';
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
            "aaSorting": [[ column ? column : 0, "desc" ]]
        });
    });
}

//Callback function
function fill_prospect_offices(data) {
    select = $('#office_id');
    select.children().remove();

    if (data.length) {
        select.append("<option value='0' disabled selected>Seleccione una opción</option>");
        data.forEach( function (opt) {
            select.append("<option value="+ opt.id +">"+ opt.name + ' ubicada en ' + opt.address + ' (Precio: $' + opt.price +")</option>");
        });
    } else {
        select.append("<option value='0' disabled selected>No hay oficinas disponibles con este criterio de búsqueda</option>");
    }
}

//Display the application comments
function display_application_comments(data) {
    $('div.load-bar').addClass('hide');

    $("table.comments-table tbody").children().remove();

    if (data.length > 0) {
        for (var key in data) {
            if (data.hasOwnProperty(key)) {
                $("table.comments-table tbody").append(
                    '<tr>'+
                        '<td class="text-center">'+(parseFloat(key)+1)+'</td>'+
                        '<td class="text-center">'+data[key].comment+'</td>'+
                        '<td class="text-center">'+data[key].new_time+'</td>'+
                    '</tr>'
                );
            }
        }
    } else {
        $("table.comments-table tbody").append(
            '<tr>'+
                '<td class="text-center" color="red" colspan="3">No se han registrado comentarios.</td>'+
            '</tr>'
        ); 
    }

    $('div.comments-content').removeClass('hide');
}

//Display payments history from a contract
function display_payment_history(data) {
    console.log(data);
    $('div.load-bar').addClass('hide');

    $("table.payment-history tbody").children().remove();

    if (data.length > 0) {
        for (var key in data) {
            if (data.hasOwnProperty(key)) {
                $("table.payment-history tbody").append(
                    '<tr>'+
                        '<td class="text-center">'+(parseFloat(key)+1)+'</td>'+
                        '<td class="text-center">$'+data[key].payment+' ('+data[key].payment_str+')</td>'+
                        '<td class="text-center">'+data[key].payment_method+'</td>'+
                        '<td class="text-center">'+(data[key].status == 1 ? '<span class="label label-success">Normal</span>' : '<span class="label label-warning">Atrasado</span>')+'</td>'+
                        '<td class="text-center">'+data[key].new_time+'</td>'+
                    '</tr>'
                );
            }
        }
    } else {
        $("table.payment-history tbody").append(
            '<tr>'+
                '<td class="text-center" color="red" colspan="5">No se han registrado pagos.</td>'+
            '</tr>'
        ); 
    }

    $('div.payment-history-content').removeClass('hide');
}

//Display the details data of the application
function display_application_details(data) {
    var b_url = $('meta[name="base-url"]').attr('content');
    fill_text(data, null, true);
    fill_text(data.detail, null);
    fill_text(data.detail.office, null);

    if (data.customer) {
        fill_text(data.customer, null);
        $('span.is_registered').text('Registrado');
    } else {
        $('span.is_registered').text('Sin registrar');
    }

    /*Custom code*/
    $('span#application-id').text(data.id);
    $('span.capacity_people').text(data.detail.num_people);
    $('span.office_type').text(data.detail.office.type.name);
    $('span.created_at_date').text(data.new_time);

    if (data.detail.office.pictures.length > 0) {
        $('li.office-photo img').attr('src', b_url.concat('/'+data.detail.office.pictures[0].path));
    } else {
        $('li.office-photo img').attr('src', b_url.concat('/img/default.jpg'));
    }

    $('div.load-bar').addClass('hide');

    $('div.details-content').removeClass('hide');
}

//Redirect to view a pdf
function redirect_pdf(data, reload) {
    if (reload) {
        refreshContent(data.url);
    }
    var win = window.open(data.route, '_blank');
    if (win) {
        //Browser has allowed it to be opened
        win.focus();
    } else {
        //Browser has blocked it
        swal('Porfavor, permita las ventanas emergentes (popups) en este sitio', 'Para visualizar documentos pdf, vaya a las preferencias de su navegador y permita esta acción.', 'error');
    }
    /*window.open(data.route, 'PDF', 'status=1, height=300, width=300, resizable=0');*/
    /*javascript:window.open(data.route,'','width=1366,height=768,left=0,top=0,toolbar=yes,fullscreen=yes','location=no');*/
}


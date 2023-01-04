var rdraw, ticket_id;
$(document).ready(function(){
    $('#new_ticket').click(function(){
        $('#ticketModal').find('.modal-title').text("Agregar Ticket")
        $('#ticketModal').modal('show')
    })
    $('#ticketModal').on("hide.bs.modal", function(e){
        $('#ticketForm')[0].reset()
        $('#ticketModal').find('.modal-title').text("")
        $('#ticketModal').find('input:hidden').val("")
    })
    $('#ticketForm').submit(function(e){
        e.preventDefault();
        var _this = $(this)
        var _modal = $('#ticketModal')
        _this.find('button').attr('disabled', true)
        _this.find('.alert').remove()
        var _msg = $('<div>')
        _msg.hide()
        _msg.addClass("rounded-0 alert")
        $.ajax({
            url:"save_ticket.php",
            method:"POST",
            data:_this.serialize(),
            dataType:"json",
            error: err => {
                console.error(err)
                _msg.text("Ocurrió un error guardando el ticket");
                _msg.addClass('alert-danger')
                _this.prepend(_msg)
                _msg.show('slideDown')
                _modal.find('button').attr('disabled', false)
            },
            success: function(resp){
                if(!!resp.status){
                    if(resp.status == 'success'){
                        location.replace('./?page=tickets')
                    }else{
                        _msg.addClass('alert-danger')

                        if(!!resp.error){
                            _msg.text(resp.error)
                        }else{
                            _msg.text("Ocurrió un error guardando el ticket");
                        }
                    }

                }else{
                        _msg.addClass('alert-danger')
                        _msg.text("Ocurrió un error guardando el ticket");
                }
                if(_msg.text() != ""){
                    _this.prepend(_msg)
                    _msg.show('slideDown')
                }
                _modal.find('button').attr('disabled', false)
            }
        })
    })

    $('.edit_ticket').click(function(e){
        e.preventDefault()
        var _modal = $('#ticketModal')
        var id = $(this).attr('data-id')
        $.ajax({
            url:"get_ticket.php",
            method:"POST",
            data:{id:id},
            dataType:"json",
            error: err=>{
                alert("Ocurrió un error obteniendo la información");
                console.error(err)
            },
            success:function(resp){
                if(typeof resp == 'object' && !!resp.status){
                    if(!!resp.data.id)
                    _modal.find('input[name="id"]').val(resp.data.id)
                    if(!!resp.data.code)
                    _modal.find('input[name="code"]').val(resp.data.code)
                    if(!!resp.data.name)
                    _modal.find('input[name="name"]').val(resp.data.name)

                    $('#ticketModal').find('.modal-title').text("Editar Ticket")
                    _modal.modal('show')
                }else{
                    alert("Ocurrió un error obteniendo los datos");
                    console.error(resp)
                }
            }
        })
    })

    $('.delete_ticket').click(function(e){
        e.preventDefault()
        var id = $(this).attr('data-id')
        if(confirm(`Desear eliminar este ticket?`) === true){
            $.ajax({
                url:'delete_ticket.php',
                method:"POST",
                data:{id:id},
                dataType:'json',
                error:err=>{
                    alert("Proceso de eliminación falló por un error desconocido")
                    console.error(err)
                },
                success: function(resp){
                    if(!!resp.status){
                        location.reload()
                    }else{
                        alert("Fallo eliminación del ticket por un error")
                        console.error(resp)
                    }
                }
            })
        }
    })

    const draw = async () => {
        var totalTickets = $('.ticket-item').length
        var pick = Math.ceil(Math.random() * (totalTickets - 1) + 1)
        
        for(var $ii = 0; $ii < 3; $ii++){
           await new Promise(async _resolve => {
                for(var $i = 1; $i <= totalTickets; $i++){
                    await new Promise(resolve=>{
                        var _scroll = $(`.ticket-item:nth-child(${$i})`)[0].offsetLeft
                        $('#ticket-list')[0].scrollLeft = _scroll - 350
                        $('.highlight-item').removeClass('highlight-item')
                        $(`.ticket-item:nth-child(${$i})`).addClass('highlight-item')
                        setTimeout(()=>{
                            resolve()
                        },100)
                    })
                    if($i == totalTickets)
                    _resolve()
                }

           })

        }
        for(var $i = 1; $i <= pick; $i++){
            var _i = $i > totalTickets? $i - totalTickets : $i;
            await new Promise(resolve=>{
                setTimeout(()=>{
                    var _scroll = $(`.ticket-item:nth-child(${_i})`)[0].offsetLeft
                    $('#ticket-list')[0].scrollLeft = _scroll - 350
                    $('.highlight-item').removeClass('highlight-item')
                    $(`.ticket-item:nth-child(${_i})`).addClass('highlight-item')
                    resolve()
                },300)
            }).then(()=>{
                setTimeout(()=>{
                    var item = $(`.ticket-item.highlight-item`)
                    ticket_id = item.attr('data-id')
                    var win_modal = $('#winnerModal')
                    rdraw = $('#rdraw').val()
                    var draw_text = $('#draw_text').val()
                    win_modal.find('#winner').html(item.find('.item-name').text())
                    win_modal.find('#winner_code').html(item.find('.item-code').text())
                    win_modal.find('#draw_winner').text(draw_text)
                    win_modal.modal('show')
                },1500)
            })
            
    }
    }

    $('#draw').click(function(){
        draw()
    })

    $('#winnerModal').on('hide.bs.modal', function(e){
        e.preventDefault()
        $(this).find('button').attr('disabled',true)
        $.ajax({
            url:'save_winner.php',
            method: 'POST',
            data: {ticket_id: ticket_id, draw: rdraw},
            dataType:'json',
            error:err=>{
                alert("Sin poder guardar información del@ ganador@")
                console.error(err)
                $(this).find('button').attr('disabled',false)
            },
            success:function(resp){
                if(!!resp.status){
                    location.reload()
                }else{
                    if(!!resp.error)
                    alert(resp.error)
                    else
                    alert("Sin poder guardar información del@ ganador@")
                }
                $(this).find('button').attr('disabled',false)
            }

        })
    })

    $('#exclude_winners').change(function(){
       if($(this).is(':checked') === false){
        location.replace("./?include_winners")
       }else{
        location.replace("./")
       }
    })
})
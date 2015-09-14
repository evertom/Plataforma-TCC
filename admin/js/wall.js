$(document).ready(function () {
    // Update Status
    $(".update_button").click(function () {
        var updateval = $("#update").val();
        var dataString = 'update=' + updateval;

        if (updateval == '')
        {
            showAlert('alert',{title: 'AVISO!!!', message:'Por favor digite seu Post !!!', type: BootstrapDialog.TYPE_WARNING}, null);
        }
        else
        {
            $("#flash").show();
            $("#flash").fadeIn(400).html('Carregando Post...');
            $.ajax({
                type: "POST",
                url: "message_ajax.php",
                data: dataString,
                cache: false,
                success: function (html) {
                    $("#flash").fadeOut('slow');
                    $("#content").prepend(html);
                    $("#update").val('');
                    $("#update").focus();
                    $("#stexpand").oembed(updateval);
                }
            });
        }
        return false;
    });

    //commment Submint
    $('.comment_button').live("click", function () {

        var ID = $(this).attr("id");

        var comment = $("#ctextarea" + ID).val();
        var dataString = 'comment=' + comment + '&msg_id=' + ID;

        if (comment == '') {
            showAlert('alert',{title: 'AVISO!!!', message:'Por favor digite seu Post !!!', type: BootstrapDialog.TYPE_WARNING}, null);
        }
        else {
            $.ajax({
                type: "POST",
                url: "comment_ajax.php",
                data: dataString,
                cache: false,
                success: function (html) {
                    $("#commentload" + ID).append(html);
                    $("#ctextarea" + ID).val('');
                    $("#ctextarea" + ID).focus();
                }
            });
        }
        return false;
    });

    // commentopen 
    $('.commentopen').live("click", function () {
        var ID = $(this).attr("id");
        $("#commentbox" + ID).slideToggle('slow');
        return false;
    });

    // delete comment
    $('.stcommentdelete').live("click", function () {
        var ID = $(this).attr("id");
        
        showAlert('confirm',{
            type: BootstrapDialog.TYPE_DANGER, 
            title: 'AVISO!!!', message:'Tem certeza que deseja excluir este coment\u00e1rio?'
        },
        {
            method:'POST', 
            type: 'POST', // Só ta funcionado com type, deve ser versão de lib jquery
            url: "delete_comment_ajax.php", 
            data: {'com_id': ID },
            cache: false,
            after_function: function(data, dialogRef){
                if(data){
                    dialogRef.getModalBody().html('procedimento realizado com sucesso!');
                    dialogRef.setType(BootstrapDialog.TYPE_SUCCESS);
                    $("#stcommentbody" + ID).slideUp();
                }else{
                    dialogRef.getModalBody().html('falha ao realizar o procedimento!');
                }
            }
        });
        return false;
    });

    // delete update
    $('.stdelete').live("click", function () {
        var ID = $(this).attr("id");
        
        showAlert('confirm',{
            type: BootstrapDialog.TYPE_DANGER, 
            title: 'AVISO!!!', message:'Tem certeza que deseja excluir este post?'
        },
        {
            method:'POST', 
            type: 'POST', // Só ta funcionado com type, deve ser versão de lib jquery
            url: "delete_message_ajax.php", 
            data: {'msg_id': ID },
            cache: false,
            after_function: function(data, dialogRef){
                if(data){
                    dialogRef.getModalBody().html('procedimento realizado com sucesso!');
                    dialogRef.setType(BootstrapDialog.TYPE_SUCCESS);
                    $("#stbody" + ID).slideUp();
                }else{
                    dialogRef.getModalBody().html('falha ao realizar o procedimento!');
                }
            }
        });
        return false;
    });
});


    //declarando o nome do plug-in criado, com função callback recebendo parametros de entrada
    function showAlert(type, style, conection){
        function confirm(){
            //conection é o objeto com parametro para metodos ajax
            //lista de opções da aplicação padrões
            var defaults_style = {
                title: 'Título',
                type: BootstrapDialog.TYPE_DEFAULT, //estilo bostrap para a janela dialog
                message: 'Deseja continuar com ação?', //mensagem de exibição apos confirmação de envio
                icon_send: 'glyphicon glyphicon-send', // icone no botão confirmar
                label_button_confirm: 'confirmar', // texto no botão confirmar
                label_class_confirm: 'btn-danger', // estilo bootstrap do botão confirmar
                spin: true, // icone spin apos confirmar
                text_before_send: 'aguarde um instante, por favor....', // texto apos clique de confirmar no botão
                text_before_confirm: 'procedimento realizado com sucesso!', // texto apos retorno positivo do ajax
                text_before_fail: 'falha ao realizar o procedimento!', // texto apos retorno negativo do ajax
                text_before_erro: 'erro de execução, contate o adminitrador do sistema', //texto caso exista falha no ajax
                time_to_close_dialog: 3000, //em milisegundo
                label_button_close: 'cancelar', //texto do botão cancelar
                draggable: true, //pode redimensionar 
                closable: true

            };

            //Nesta Etapa estou incluindo as opção passadas por parametros
            var options_style = $.extend({}, defaults_style, style);
            var defaults_conection = {
                async: true, // padrão não sincrono de ajax
                url: null, //url para executar ação do post
                data: null, //data para POST ou GET
                dataType: 'JSON', //tipo de Retorno ajax
                method: 'GET', //tipo de envio de dados
                type: 'GET', //Tipo de envio de dados
                cache: false, //Padrão de cache false
                after_function: null, //Alguma função que se queira executar apos o ajax.
                processData: true,  // jQuery processo data
                contentType: "application/x-www-form-urlencoded;charset=UTF-8"  // jQuery set contentType
            };
            
            //Nesta Etapa estou incluindo as opção passadas por parametros
            var options_conection = $.extend({}, defaults_conection, conection);
            BootstrapDialog.show({
                type : options_style.type,
                title: options_style.title,
                draggable: options_style.draggable,
                closable: options_style.closable,
                message: options_style.message,
                buttons: [{
                    icon: options_style.icon_send,
                    label: options_style.label_button_confirm,
                    cssClass: options_style.label_class_confirm,
                    autospin: options_style.spin,
                    action: function(dialogRef){
                        $.ajax({
                            async: options_conection.async,
                            url: options_conection.url,
                            method: options_conection.method,
                            type: options_conection.type,
                            dataType: options_conection.dataType,
                            data: options_conection.data,
                            cache: options_conection.cache,
                            processData: options_conection.processData,
                            contentType: options_conection.contentType,
                            beforeSend: function(){
                                dialogRef.enableButtons(false);
                                dialogRef.setClosable(false);
                                dialogRef.getModalBody().html(options_style.text_before_send);
                            },
                            success: function(data){
                                if(typeof(options_conection.after_function)==="function"){
                                    return options_conection.after_function.call(this, data, dialogRef);
                                }
                            },
                            error: function(msg){
                                console.log(msg);
                                dialogRef.getModalBody().html(options_style.text_before_erro);
                            },
                            complete: function(){
                                    setTimeout(function(){
                                    dialogRef.close();
                                }, options_style.time_to_close_dialog);
                            }
                        });
                    }
                }, {
                    label: options_style.label_button_close,
                    action: function(dialogRef){
                        dialogRef.close();
                    }
                }]
            });
        }
        
        function simpleAlet(){
            var defaults_style = {
                title: 'Título',
                type: BootstrapDialog.TYPE_INFO, //estilo bostrap para a janela dialog
                message: 'Deseja continuar com ação?', //mensagem de exibição apos confirmação de envio
                label_button: 'Ok',
                draggable: true, //pode redimensionar 
                location: null, //parametro para redirecionamento caso exista.
                closable: false //padrão nao fechavel de dialog box.
            };

            //Nesta Etapa estou incluindo as opção passadas por parametros
            var options_style = $.extend({}, defaults_style, style);
            
            BootstrapDialog.show({
                title: options_style.title,
                message: options_style.message,
                type: options_style.type,
                draggable: options_style.draggable, 
                closable: options_style.closable,
                buttons: [{
                    label:  options_style.label_button,
                        action: function(dialogRef){
                            dialogRef.close();
                            if(options_style.location !== null){
                                location.href=options_style.location;
                            }
                        }
                    }   
                ]
            });
        }
        
        if(type === "alert"){
            return simpleAlet();
        }else if(type === "confirm"){
            return confirm();
        }
}; 
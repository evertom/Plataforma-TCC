<?php
    $idgrupo = isset($_POST['idgrupo']) ? $_POST['idgrupo']: null;
    date_default_timezone_set("America/Sao_Paulo");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <script type="text/javascript">
        $(document).ready(function(){

            $("input[type=radio]").bootstrapSwitch({
                size: 'small',
                radioAllOff: false,
                onColor: 'success'
            }); 

            $("i.help-versao").on('click',function(){
                BootstrapDialog.show({
                    title : "Informações",
                    message: "O sistema ajuda você a versionar seus arquivos.\n\
                                Para tanto basta adiocionar nos botões 'versão' a que nível você deseja subir a versão do arquivo que esta fazendo upload.\n\
                                Se você escolher o campo 1.0.0 -> Estará subindo a versão em uma unidade, exemplo, a versão 1.2.0 passará para 2.2.0\n\
                                Se você escolher o campo 0.1.0 -> Estará subindo a versão em uma dezena, exemplo, a versão 3.5.8 passará para 3.6.8\n\
                                Se você escolher o campo 0.0.1 -> Estará subindo a versão em uma centena, exemplo, a versão 0.6.4 passará para 0.6.5\n\
                                Se o arquivo com o mesmo nome já fora feito o upload anteriormente, o sistema automaticamente selecionará a última versão para reclassificação.\n\
                                Agora se está é a primeira vez que fará o upload de um arquivo ele fará a classificação partindo de 0.0.0"
                });
            });

        });

        function upLoad(form){

            var href = "ajax/upload.php";
            //É necessario enviar o data do POST desta forma devido o input file.
            //Basicamente ele cria um formData, ou seja, um novo conteudo de inputs(data) que serão enviados.
            var post =  new FormData();
                post.append('msg', $(form).find('textarea[name=msg]').val());
                post.append('idgrupo', $(form).find('input[name=idgrupo]').val());
                post.append('versao', $(form).find('input[name=versao]:checked').val());
                post.append('file', $('#file')[0].files[0]);
                
            showAlert('confirm',{
                type: BootstrapDialog.TYPE_DANGER, 
                title: 'COFIRMAÇÃO', message:'Tem certeza que deseja fazer o upload deste arquivo?'
            },
            {
                method: 'POST', //É necessario que o metodo seja nulo ou POST
                type: 'POST', // Só ta funcionado com type, deve ser versão de lib jquery
                url: href, 
                data: post,
                cache: false,
                processData: false,
                contentType: false,
                after_function: function(data, dialogRef){
                    if(data.ok === true){
                        dialogRef.getModalBody().html(data.msg);
                        dialogRef.setType(BootstrapDialog.TYPE_SUCCESS);
                        LoadFiles();
                        $('#modal').modal('hide');
                    }else{
                        dialogRef.getModalBody().html(data.msg);
                        $('#modal').modal('hide');
                    }
                }
            });
            return false;
        }
    </script>
</head>
<body>
    <form onsubmit="upLoad($(this));return false;">
        <div class="modal-body">
            <label class='control-label'>Selecione o arquivo que deseja fazer o upload</label><br clear="all">
            <input required="true" type="file" name="file" id="file" class="btn btn-primary"/>

            <br clear="all">

            <label class="control-label">Versão</label><br clear="all">
            <div>
                <div style="float:left; margin-right: 10px;">
                    <label for='unidade'>1.0.0</label>
                    <br clear="all">
                    <input data-on-text="+1.0.0" data-off-text='0.0.0' id="unidade" required="true" type="radio" name="versao"  value="unidade"/>
                </div>
                <div style="float:left; margin-right: 10px;">
                    <label for='dezena'>0.1.0</label>
                    <br clear="all">
                    <input data-on-text="+0.1.0" data-off-text='0.0.0' id="dezena" required="true" type="radio" name="versao"  value="dezena"/>
                </div>
                <div style="float:left; margin-right: 10px;">
                    <label for='centena'>0.0.1</label>
                    <br clear="all">
                    <input checked data-on-text="+0.0.1" data-off-text='0.0.0' id="centena" required="true" type="radio" name="versao"  value="centena"/>
                </div>
                <div style="float:left; margin-right: 10px;">
                    <i title="Mais informações sobre versões de arquivos." style="cursor: pointer;" class='help-versao fa fa-info-circle'></i>
                </div>
            </div>

            <br clear="all">
            <br clear="all">

            <label class='control-label'>Mensagem</label><br clear="all">

            <textarea placeholder="Escreva uma mensagem para o grupo" required="true" name='msg' cols="10" rows="5" class='form-control'></textarea>

            <input type="hidden" name="idgrupo" value="<?php echo $idgrupo; ?>"/>

            <br clear="all">
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar <i class="fa fa-close"></i></button>
            <button type="submit" class="btn btn-primary">Upload <i class="fa fa-upload"></i></button>
        </div> 
    </form> 
</body>
</html>


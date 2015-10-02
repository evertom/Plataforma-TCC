<?php
    $idGrupo = isset($_POST['idgrupo']) ? $_POST['idgrupo']: null;
    date_default_timezone_set("America/Sao_Paulo");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <script type="text/javascript">
        $(function(){
            $(".selectpicker").selectpicker('refresh');
            
            $("input[type=radio]").bootstrapSwitch({
                size: 'mini',
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
        
        
        
        function nextStage(form){
            var href = "ajax/getWorkflow.php";
            //É necessario enviar o data do POST desta forma devido o input file.
            //Basicamente ele cria um formData, ou seja, um novo conteudo de inputs(data) que serão enviados.
            var post =  new FormData();
                post.append('participantes',$(form).find('#idParticipantes').val());
                post.append('end', $(form).find('input[name=end]').val());
                post.append('nomeEvento', $(form).find('input[name=nomeEvento]').val());
                post.append('descricao', $(form).find('textarea[name=descricao]').val());
                post.append('idGrupo', $(form).find('input[name=idGrupo]').val());
                post.append('operation', $(form).find('input[name=operation]').val());
                post.append('versao', $(form).find('input[name=versao]:checked').val());
                post.append('file', $('#file')[0].files[0]);
                
            showAlert('confirm',{
                type: BootstrapDialog.TYPE_DANGER, 
                title: 'COFIRMAÇÃO', message:'Tem certeza que deseja criar uma nova atividade?'
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
                        Load($("#idgrupo").val());
                        $("#modal").modal("hide");
                    }else{
                        dialogRef.getModalBody().html(data.msg);
                        $("#modal").modal("hide");
                    }
                }
            });
            return false;
        }
        
    </script>
</head>
<body>
    <form onsubmit="nextStage($(this));return false;" >
        <div class="modal-body" style="overflow: hidden!important;">
            <label id="end">Data de previsão de entrega</label>
            <div class="input-group">
                <span class="input-group-addon" id="end"><i class='fa fa-calendar-o'></i></span>
                <input min="<?php echo date("Y-m-d")?>" type="date" name="end" required="true" class="form-control" aria-describedby="end"/>
            </div>
            
            <br clear="all"/>
            
            <label>Identificação da atividade</label>
            <div class="input-group">
                <span class="input-group-addon" id="nomeEvento"><i class='fa fa-bookmark'></i></span>
                <input placeholder="Nome que identifique a atividade" type="text" name="nomeEvento" required="true" class="form-control" aria-describedby="nomeEvento"/>
            </div>
            
            <br clear="all"/>
            
            <label>Responsáveis pela Atividade</label>
            <div class="input-group">
                <select name="idParticipantes[]" id="idParticipantes" class="selectpicker" multiple  data-max-options="5" data-min-options="1" required data-style="btn-info" title='De quem é a tarefa?' data-live-search="true" data-selected-text-format="count>2" >
                    <?php
                    require_once('../includes/Conexao.class.php');
                    $pdo = new Conexao();
                    $sql = "SELECT b.uid, b.username FROM grupo_has_users a ";
                    $sql .= "INNER JOIN users b ON a.uid = b.uid "
                            . " WHERE a.idgrupo = $idGrupo ORDER BY b.username";

                    $result = $pdo->select($sql);

                    echo "<optgroup label='Participantes'>";

                    foreach ($result as $res) {
                        echo "<option value='" . $res['uid'] . "'>" . $res['username'] . "</option>";
                    }
                    echo "</optgroup>";
                    ?>
                </select>
            </div>
            
            <br clear="all"/>
            
            <label>Descrições</label>
            <div class="input-group">
                <span class="input-group-addon" id="descricao"><i class='fa fa-bookmark'></i></span>
                <textarea rows="4" cols="10"  placeholder="Descreva as atividades que os participantes deveram realizar" name="descricao" required="true" class="form-control" aria-describedby="descricao"></textarea>
            </div>
            
            <br clear="all"/>
        
            <label>Envio de arquivo</label>
            <div class="input-group">
                <input type="file" name="file" id='file' class="btn btn-primary" />
            </div>
            
            <br clear="all"/>
            
            <label class="control-label">Versão</label><br clear="all">
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
        
            <input type="hidden" value="<?php echo $idGrupo; ?>" name='idGrupo' />
            <input type="hidden" value="next" name='operation' />
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar <i class="fa fa-close"></i></button>
            <button type="submit" class="btn btn-primary">Enviar <i class="fa fa-share-square-o"></i></button>
        </div> 
    </form>        
    
</body>
</html>


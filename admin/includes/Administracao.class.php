<?php
require_once('Conexao.class.php');
require_once('Auxiliar.class.php');
class Administracao extends Conexao {

    private $data = array();

    public function __construct() {
        $this->erro = '';
    }

    public function __set($name, $value) {
        $this->data[$name] = $value;
    }

    public function __get($name) {
        if (array_key_exists($name, $this->data)) {
            return $this->data[$name];
        }
        $trace = debug_backtrace();
        trigger_error(
                'Undefined property via __get(): ' . $name .
                ' in ' . $trace[0]['file'] .
                ' on line ' . $trace[0]['line'], E_USER_NOTICE);
        return null;
    }

    public function InsereProf() {
        try {
            if (parent::getPDO() === null) {parent::conectar();}
            $stmt = $this->pdo->prepare('INSERT INTO users(username,password,email,prontuario,fotouser,descricao,cargo,tipo) VALUES(:pusername,:ppassword,:pemail,:pprontuario,:pfotouser,:pdescri,:pcargo,:ptipo)');
            $stmt->bindValue(':pusername', $this->nome, PDO::PARAM_STR);
            $stmt->bindValue(':ppassword', sha1(antiInjection($this->pass)), PDO::PARAM_STR);
            $stmt->bindValue(':pemail', $this->email, PDO::PARAM_STR);
            $stmt->bindValue(':pprontuario', $this->pront, PDO::PARAM_INT);
            $stmt->bindValue(':pfotouser', $this->fotouser, PDO::PARAM_STR);
            $stmt->bindValue(':pdescri', $this->descri, PDO::PARAM_STR);
            $stmt->bindValue(':pcargo', $this->cargo, PDO::PARAM_STR);
            $stmt->bindValue(':ptipo', $this->tipo, PDO::PARAM_INT);

            if ($stmt->execute()) {
                parent::desconectar();return true;
            } else {
                parent::desconectar();return false;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();return null;
        }
    }

    public function InsertLike() {
        try {
            if (parent::getPDO() == null) {parent::conectar();}

            $stmt = $this->pdo->prepare('INSERT INTO likes(uid,msg_id) VALUES(:puid,:pmsg_id)');
            $stmt->bindValue(':puid', $this->iduser, PDO::PARAM_INT);
            $stmt->bindValue(':pmsg_id', $this->idmsg, PDO::PARAM_INT);

            if ($stmt->execute()) {

                $result = $this->select("SELECT count(msg_id) as total FROM likes WHERE msg_id = " . $this->idmsg . "");
                foreach ($result as $res) {
                    $total = $res['total'];
                }
                parent::desconectar();
                return $total;
            } else {
                parent::desconectar();
                return false;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }

    public function Unlike() {
        try {
            if (parent::getPDO() == null) {parent::conectar();}
            $stmt = $this->pdo->prepare('DELETE FROM likes WHERE uid = :puid AND msg_id = :pmsg_id');
            $stmt->bindValue(':puid', $this->iduser, PDO::PARAM_INT);
            $stmt->bindValue(':pmsg_id', $this->idmsg, PDO::PARAM_INT);

            if ($stmt->execute()) {
                $result = $this->select("SELECT count(msg_id) as total FROM likes WHERE msg_id = " . $this->idmsg . "");
                if (count($result)) {
                    foreach ($result as $res) {
                        $total = $res['total'];
                    }
                } else {
                    $total = 0;
                }
                parent::desconectar();
                return $total;
            } else {
                parent::desconectar();
                return $total;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }

    public function UpdateUserProfile() {
        try {
            if (parent::getPDO() == null) {parent::conectar();}

            $stmt = $this->pdo->prepare('UPDATE users SET username = :pusername ,password = :ppassword, email = :pemail, prontuario = :pprontuario, descricao = :pdescri, cargo = :pcargo WHERE uid = :puid');
            $stmt->bindValue(':pusername', $this->nome, PDO::PARAM_STR);
            $stmt->bindValue(':ppassword', sha1(antiInjection($this->pass)), PDO::PARAM_STR);
            $stmt->bindValue(':pemail', $this->email, PDO::PARAM_STR);
            $stmt->bindValue(':pprontuario', $this->pront, PDO::PARAM_INT);
            $stmt->bindValue(':pdescri', $this->descri, PDO::PARAM_STR);
            $stmt->bindValue(':pcargo', $this->cargo, PDO::PARAM_STR);
            $stmt->bindValue(':puid', $this->id_users, PDO::PARAM_INT);

            if ($stmt->execute()) {
                @session_start();
                $_SESSION['user'] = $this->nome;
                $_SESSION['email_login'] = $this->email;
                $_SESSION['pass_login'] = $this->pass;
                $_SESSION['descricao'] = $this->descri;
                $_SESSION['cargo'] = $this->cargo;
                $_SESSION['prontuario'] = $this->pront;

                parent::desconectar();
                return true;
            } else {
                parent::desconectar();
                return false;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }

    public function InserePreProjeto() {
        try {
            if (parent::getPDO() == null) {parent::conectar();}

            $stmt = $this->pdo->prepare('UPDATE grupo SET objetivoGeral = :pobjetivoGeral, objetivoEspecifico = :pobjetivoEspecifico, justificativa = :pjustificativa,tipodePesquisa = :ptipodePesquisa, metodologia =  :pmetodologia,resultadoEsperado = :presultadoEsperado WHERE idgrupo = :pidgrupo');

            $stmt->bindValue(':pobjetivoGeral', $this->objGeral, PDO::PARAM_STR);
            $stmt->bindValue(':pobjetivoEspecifico', $this->objEspec, PDO::PARAM_STR);
            $stmt->bindValue(':pjustificativa', $this->justificativa, PDO::PARAM_STR);
            $stmt->bindValue(':ptipodePesquisa', $this->tipoPesquisa, PDO::PARAM_STR);
            $stmt->bindValue(':pmetodologia', $this->metodologia, PDO::PARAM_STR);
            $stmt->bindValue(':presultadoEsperado', $this->resultados, PDO::PARAM_STR);
            $stmt->bindValue(':pidgrupo', $this->idgrupo, PDO::PARAM_INT);

            if ($stmt->execute()) {

                $stmt = $this->pdo->prepare("UPDATE grupo SET preProjeto = 0, cronograma = 1 WHERE idgrupo = :pidgrupo");
                $stmt->bindValue(':pidgrupo', $this->idgrupo, PDO::PARAM_INT);

                if ($stmt->execute()) {
                    parent::desconectar();
                    return true;
                }
            } else {
                parent::desconectar();
                return false;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }

    public function RequerimentoProf() {
        try {
            if (parent::getPDO() == null) {parent::conectar();}
            $visto = 0;
            $aceito = 0;
            $stmt = $this->pdo->prepare('INSERT INTO grupo(dataCriacao,titulo,descricao) VALUES(current_date(),:ptitulo,:pdescricao)');
            $stmt->bindValue(':ptitulo', $this->titulo, PDO::PARAM_STR);
            $stmt->bindValue(':pdescricao', $this->descri, PDO::PARAM_STR);

            if ($stmt->execute()) {
                $IdGrupoCriado = $this->pdo->lastInsertId();
                $diretorio = '../GerenciamentoGrupos/'.$IdGrupoCriado;
                mkdir($diretorio);

                $stmt = $this->pdo->prepare('INSERT INTO grupo_has_users(idgrupo,uid,tipo) VALUES(:pidgrupo,:puid,1)');
                $stmt->bindValue(':pidgrupo', $IdGrupoCriado, PDO::PARAM_INT);
                $stmt->bindValue(':puid', $this->pront1, PDO::PARAM_INT);

                if ($stmt->execute()) {
                    $stmt = $this->pdo->prepare('INSERT INTO grupo_has_users(idgrupo,uid,tipo) VALUES(:pidgrupo,:puid,1)');
                    $stmt->bindValue(':pidgrupo', $IdGrupoCriado, PDO::PARAM_INT);
                    $stmt->bindValue(':puid', $this->pront2, PDO::PARAM_INT);

                    if ($stmt->execute()){
                        $stmt = $this->pdo->prepare('INSERT INTO grupo_has_users(idgrupo,uid,tipo) VALUES(:pidgrupo,:puid,1)');
                        $stmt->bindValue(':pidgrupo', $IdGrupoCriado, PDO::PARAM_INT);
                        $stmt->bindValue(':puid', $this->pront3, PDO::PARAM_INT);

                        if ($stmt->execute()) {
                            $stmt = $this->pdo->prepare('INSERT INTO grupo_has_users(idgrupo,uid,tipo) VALUES(:pidgrupo,:puid,2)');
                            $stmt->bindValue(':pidgrupo', $IdGrupoCriado, PDO::PARAM_INT);
                            $stmt->bindValue(':puid', $this->orientador, PDO::PARAM_INT);

                            if ($stmt->execute()) {

                                if ($this->coorient == "") {
                                    $descricaoAv = "Requisi&ccedil;&atilde;o de Orienta&ccedil;&atilde;o solicitada.";
                                    $stmt = $this->pdo->prepare('INSERT INTO avisos(descricao,data,visto,uid,de)VALUES(:pdescricao,current_date(),:pvisto,:puid,:pde)');
                                    $stmt->bindValue(':pdescricao', $descricaoAv, PDO::PARAM_STR);
                                    $stmt->bindValue(':pvisto', $visto, PDO::PARAM_INT);
                                    $stmt->bindValue(':puid', $this->orientador, PDO::PARAM_INT);
                                    $stmt->bindValue(':pde', $this->user, PDO::PARAM_INT);

                                    if ($stmt->execute()) {
                                        parent::desconectar();
                                        return true;
                                    }
                                } else {
                                    $stmt = $this->pdo->prepare('INSERT INTO grupo_has_users(idgrupo,uid,tipo) VALUES(:pidgrupo,:puid,3)');
                                    $stmt->bindValue(':pidgrupo', $IdGrupoCriado, PDO::PARAM_INT);
                                    $stmt->bindValue(':puid', $this->coorient, PDO::PARAM_INT);

                                    if ($stmt->execute()) {
                                        $descricaoAv = "Requisi&ccedil;&atilde;o de Orienta&ccedil;&atilde;o solicitada.";
                                        $stmt = $this->pdo->prepare('INSERT INTO avisos(descricao,data,visto,uid,de)VALUES(:pdescricao,current_date(),:pvisto,:puid,:pde)');
                                        $stmt->bindValue(':pdescricao', $descricaoAv, PDO::PARAM_STR);
                                        $stmt->bindValue(':pvisto', $visto, PDO::PARAM_INT);
                                        $stmt->bindValue(':puid', $this->orientador, PDO::PARAM_INT);
                                        $stmt->bindValue(':pde', $this->user, PDO::PARAM_INT);

                                        if ($stmt->execute()) {
                                            parent::desconectar();
                                            return true;
                                        }
                                    }
                                }
                            } else {
                                parent::desconectar();
                                return false;
                            }
                        }
                    }
                }
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }

    public function UpdateAviso() {
        try {
            if (parent::getPDO() == null) {parent::conectar();}
            $stmt = $this->pdo->prepare('UPDATE avisos SET visto = 1 WHERE uid = :pui');
            $stmt->bindValue(':pui', $this->id, PDO::PARAM_INT);

            if ($stmt->execute()) {
                parent::desconectar();
                return true;
            } else {
                parent::desconectar();
                return false;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }

    public function UpdateVistoGrupo() {
        try {
            if (parent::getPDO() == null) {parent::conectar();}

            $stmt = $this->pdo->prepare('UPDATE grupo SET visto = 1 WHERE idgrupo = :pidgrupo');
            $stmt->bindValue(':pidgrupo', $this->idgrupo, PDO::PARAM_INT);

            $idAluno1 = $this->idAluno1;
            $idAluno2 = $this->idAluno2;
            $idAluno3 = $this->idAluno3;
            $idProf = $this->idProf;
            $visto = 0;
            $descricaoAv = "Sua Requisi&ccedil;&atilde;o de Orienta&ccedil;&atilde;o ao professor foi Visualizada, e est&aacute; sendo analisada mediante sua descri&ccedil;&atilde;o do projeto e disponibilidade do mesmo.";

            if ($stmt->execute()) {
                //enviando msg pro aluno um do grupo
                $stmt = $this->pdo->prepare('INSERT INTO avisos(descricao,data,visto,uid,de)VALUES(:pdescricao,current_date(),:pvisto,:puid,:pde)');
                $stmt->bindValue(':pdescricao', $descricaoAv, PDO::PARAM_STR);
                $stmt->bindValue(':pvisto', $visto, PDO::PARAM_INT);
                $stmt->bindValue(':puid', $this->idAluno1, PDO::PARAM_INT);
                $stmt->bindValue(':pde', $this->idProf, PDO::PARAM_INT);

                if ($stmt->execute()) {
                    //enviando msg pro aluno dois do grupo
                    $stmt = $this->pdo->prepare('INSERT INTO avisos(descricao,data,visto,uid,de)VALUES(:pdescricao,current_date(),:pvisto,:puid,:pde)');
                    $stmt->bindValue(':pdescricao', $descricaoAv, PDO::PARAM_STR);
                    $stmt->bindValue(':pvisto', $visto, PDO::PARAM_INT);
                    $stmt->bindValue(':puid', $this->idAluno2, PDO::PARAM_INT);
                    $stmt->bindValue(':pde', $this->idProf, PDO::PARAM_INT);

                    if ($stmt->execute()) {
                        //enviando msg pro aluno tres do grupo
                        $stmt = $this->pdo->prepare('INSERT INTO avisos(descricao,data,visto,uid,de)VALUES(:pdescricao,current_date(),:pvisto,:puid,:pde)');
                        $stmt->bindValue(':pdescricao', $descricaoAv, PDO::PARAM_STR);
                        $stmt->bindValue(':pvisto', $visto, PDO::PARAM_INT);
                        $stmt->bindValue(':puid', $this->idAluno3, PDO::PARAM_INT);
                        $stmt->bindValue(':pde', $this->idProf, PDO::PARAM_INT);

                        if ($stmt->execute()) {
                            parent::desconectar();
                            return true;
                        } else {
                            parent::desconectar();
                            return false;
                        }
                    }
                }
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }

    public function RefazRequisicao() {
        try {
            if (parent::getPDO() == null) {parent::conectar();}

            $stmt = $this->pdo->prepare('UPDATE grupo SET descricao = :pdescri, revisando = 0 WHERE idgrupo = :pidgrupo');
            $stmt->bindValue(':pdescri', $this->texto, PDO::PARAM_STR);
            $stmt->bindValue(':pidgrupo', $this->idgrupo, PDO::PARAM_INT);

            $visto = 0;
            $descricaoAv = "Diante de seu requerimento para maiores informa&ccedil;&otilde;es sobre a descri&ccedil;&atilde;o do Projeto de TCC deste presente grupo, o mesmo foi revisado e reescrito para uma nova an&aacute;lise e aprova&ccedil;&atilde;o";

            if ($stmt->execute()) {

                $stmt = $this->pdo->prepare('INSERT INTO avisos(descricao,data,visto,uid,de)VALUES(:pdescricao,current_date(),:pvisto,:puid,:pde)');
                $stmt->bindValue(':pdescricao', $descricaoAv, PDO::PARAM_STR);
                $stmt->bindValue(':pvisto', $visto, PDO::PARAM_INT);
                $stmt->bindValue(':puid', $this->idProf, PDO::PARAM_INT);
                $stmt->bindValue(':pde', $this->idUser, PDO::PARAM_INT);

                if ($stmt->execute()) {
                    parent::desconectar();
                    return true;
                } else {
                    parent::desconectar();
                    return false;
                }
            } else {
                parent::desconectar();
                return false;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }

    public function RecusaOrientacao() {
        try {
            if (parent::getPDO() == null) {parent::conectar();}

            $stmt = $this->pdo->prepare('UPDATE grupo SET recusado = 1, aceito = 0 WHERE idgrupo = :pidgrupo');
            $stmt->bindValue(':pidgrupo', $this->idgrupo, PDO::PARAM_INT);
            $visto = 0;
            $aux = "Sua Requisi&ccedil;&atilde;o foi recusada pelo seguinte motivo: ";
            if ($stmt->execute()) {
                //enviando msg pro aluno um do grupo
                $stmt = $this->pdo->prepare('INSERT INTO avisos(descricao,data,visto,uid,de)VALUES(:pdescricao,current_date(),:pvisto,:puid,:pde)');
                $stmt->bindValue(':pdescricao', $aux . $this->descri, PDO::PARAM_STR);
                $stmt->bindValue(':pvisto', $visto, PDO::PARAM_INT);
                $stmt->bindValue(':puid', $this->id1, PDO::PARAM_INT);
                $stmt->bindValue(':pde', $this->idProf, PDO::PARAM_INT);

                if ($stmt->execute()) {
                    //enviando msg pro aluno dois do grupo
                    $stmt = $this->pdo->prepare('INSERT INTO avisos(descricao,data,visto,uid,de)VALUES(:pdescricao,current_date(),:pvisto,:puid,:pde)');
                    $stmt->bindValue(':pdescricao', $aux . $this->descri, PDO::PARAM_STR);
                    $stmt->bindValue(':pvisto', $visto, PDO::PARAM_INT);
                    $stmt->bindValue(':puid', $this->id2, PDO::PARAM_INT);
                    $stmt->bindValue(':pde', $this->idProf, PDO::PARAM_INT);

                    if ($stmt->execute()) {
                        //enviando msg pro aluno tres do grupo
                        $stmt = $this->pdo->prepare('INSERT INTO avisos(descricao,data,visto,uid,de)VALUES(:pdescricao,current_date(),:pvisto,:puid,:pde)');
                        $stmt->bindValue(':pdescricao', $aux . $this->descri, PDO::PARAM_STR);
                        $stmt->bindValue(':pvisto', $visto, PDO::PARAM_INT);
                        $stmt->bindValue(':puid', $this->id3, PDO::PARAM_INT);
                        $stmt->bindValue(':pde', $this->idProf, PDO::PARAM_INT);

                        if ($stmt->execute()) {
                            parent::desconectar();
                            return true;
                        } else {
                            parent::desconectar();
                            return false;
                        }
                    }
                }
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }

    public function UpdatePostFeeds() {
        try {
            if (parent::getPDO() == null) {parent::conectar();}

            $stmt = $this->pdo->prepare('UPDATE messages SET message = :pmessage WHERE msg_id = :pmsg_id');
            $stmt->bindValue(':pmessage', $this->texto, PDO::PARAM_STR);
            $stmt->bindValue(':pmsg_id', $this->id, PDO::PARAM_INT);

            if ($stmt->execute()) {
                parent::desconectar();
                return true;
            } else {
                parent::desconectar();
                return false;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }

    public function UpdateComentPostFeeds() {
        try {
            if (parent::getPDO() == null) {parent::conectar();}

            $stmt = $this->pdo->prepare('UPDATE comments SET comment = :pcomment WHERE com_id = :pcom_id');
            $stmt->bindValue(':pcomment', $this->texto, PDO::PARAM_STR);
            $stmt->bindValue(':pcom_id', $this->id, PDO::PARAM_INT);

            if ($stmt->execute()) {
                parent::desconectar();
                return true;
            } else {
                parent::desconectar();
                return false;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }

    public function MontaGrupo() {
        try {
            if (parent::getPDO() == null) {parent::conectar();}

            $stmt = $this->pdo->prepare('UPDATE grupo SET aceito = 1, recusado = 0, preProjeto = 1 WHERE idgrupo = :pidgrupo');
            $stmt->bindValue(':pidgrupo', $this->idgrupo, PDO::PARAM_INT);

            $id1 = $this->id1;
            $id2 = $this->id2;
            $id3 = $this->id3;
            $idprof = $this->idprof;

            if ($stmt->execute()) {
               
                if ($id1 != ""){
                    $visto = 0;
                    $descricaoAv = "Requisi&ccedil;&atilde;o de Orienta&ccedil;&atilde;o aceita.";
                    $stmt = $this->pdo->prepare('INSERT INTO avisos(descricao,data,visto,uid,de)VALUES(:pdescricao,current_date(),:pvisto,:puid,:pde)');
                    $stmt->bindValue(':pdescricao', $descricaoAv, PDO::PARAM_STR);
                    $stmt->bindValue(':pvisto', $visto, PDO::PARAM_INT);
                    $stmt->bindValue(':puid', $id1, PDO::PARAM_INT);
                    $stmt->bindValue(':pde', $idprof, PDO::PARAM_INT);

                    if ($stmt->execute()) {
                        if ($id2 != "") {
                            
                            $stmt = $this->pdo->prepare('INSERT INTO avisos(descricao,data,visto,uid,de)VALUES(:pdescricao,current_date(),:pvisto,:puid,:pde)');
                            $stmt->bindValue(':pdescricao', $descricaoAv, PDO::PARAM_STR);
                            $stmt->bindValue(':pvisto', $visto, PDO::PARAM_INT);
                            $stmt->bindValue(':puid', $id2, PDO::PARAM_INT);
                            $stmt->bindValue(':pde', $idprof, PDO::PARAM_INT);

                            if ($stmt->execute()) {

                                if ($id3 != "") {

                                    $stmt = $this->pdo->prepare('INSERT INTO avisos(descricao,data,visto,uid,de)VALUES(:pdescricao,current_date(),:pvisto,:puid,:pde)');
                                    $stmt->bindValue(':pdescricao', $descricaoAv, PDO::PARAM_STR);
                                    $stmt->bindValue(':pvisto', $visto, PDO::PARAM_INT);
                                    $stmt->bindValue(':puid', $id3, PDO::PARAM_INT);
                                    $stmt->bindValue(':pde', $idprof, PDO::PARAM_INT);

                                    if ($stmt->execute()) {
                                        parent::desconectar();
                                        return true;
                                    }
                                } else {
                                    parent::desconectar();
                                    return true;
                                }
                            }
                        } else {
                            parent::desconectar();
                            return true;
                        }
                    }
                }
            } else {
                parent::desconectar();
                return false;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }

    public function MaisDetalhes() {
        try {
            if (parent::getPDO() == null) {parent::conectar();}

            $stmt = $this->pdo->prepare('UPDATE grupo SET aceito = 0, recusado = 0, visto = 0, revisando = 1 WHERE idgrupo = :pidgrupo');
            $stmt->bindValue(':pidgrupo', $this->idgrupo, PDO::PARAM_INT);

            $id1 = $this->id1;
            $id2 = $this->id2;
            $id3 = $this->id3;
            $idprof = $this->idprof;

            if ($stmt->execute()) {

                if ($id1 != "") {
                    $visto = 0;
                    $descricaoAv = "Diante de sua solicita&ccedil;&atilde;o ao Professor para Orienta&ccedil;&atilde;o do TCC, o mesmo solicita um maior detalhamento do projeto em si, para uma melhor avalia&ccedil;&atilde;o de sua proposta para poder aceitar ou n&atilde;o orient&aacute;-los, clique no link a seguir para melhorar sua proposta do Projeto para o que professor possa avalia-lo com maior riqueza nos detalhamentos e crit&eacute;rio, Obrigado. <a href=\"refazProposta.php?idgrupo=" . $this->idgrupo . "\"><i class=\"fa fa-refresh\"></i> Refazer Proposta</a>";
                    $stmt = $this->pdo->prepare('INSERT INTO avisos(descricao,data,visto,uid,de)VALUES(:pdescricao,current_date(),:pvisto,:puid,:pde)');
                    $stmt->bindValue(':pdescricao', $descricaoAv, PDO::PARAM_STR);
                    $stmt->bindValue(':pvisto', $visto, PDO::PARAM_INT);
                    $stmt->bindValue(':puid', $id1, PDO::PARAM_INT);
                    $stmt->bindValue(':pde', $idprof, PDO::PARAM_INT);

                    if ($stmt->execute()) {

                        if ($id2 != "") {

                            $stmt = $this->pdo->prepare('INSERT INTO avisos(descricao,data,visto,uid,de)VALUES(:pdescricao,current_date(),:pvisto,:puid,:pde)');
                            $stmt->bindValue(':pdescricao', $descricaoAv, PDO::PARAM_STR);
                            $stmt->bindValue(':pvisto', $visto, PDO::PARAM_INT);
                            $stmt->bindValue(':puid', $id2, PDO::PARAM_INT);
                            $stmt->bindValue(':pde', $idprof, PDO::PARAM_INT);

                            if ($stmt->execute()) {

                                if ($id3 != "") {

                                    $stmt = $this->pdo->prepare('INSERT INTO avisos(descricao,data,visto,uid,de)VALUES(:pdescricao,current_date(),:pvisto,:puid,:pde)');
                                    $stmt->bindValue(':pdescricao', $descricaoAv, PDO::PARAM_STR);
                                    $stmt->bindValue(':pvisto', $visto, PDO::PARAM_INT);
                                    $stmt->bindValue(':puid', $id3, PDO::PARAM_INT);
                                    $stmt->bindValue(':pde', $idprof, PDO::PARAM_INT);

                                    if ($stmt->execute()) {
                                        parent::desconectar();
                                        return true;
                                    }
                                } else {
                                    parent::desconectar();
                                    return true;
                                }
                            }
                        } else {
                            parent::desconectar();
                            return true;
                        }
                    }
                }
            } else {
                parent::desconectar();
                return false;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }

    public function desistenciaGrupo() {
        try {
            if (parent::getPDO() == null){parent::conectar();}
               
            $stmt = $this->pdo->prepare("INSERT INTO desistenciaaluno(idUsers,idGrupo,motivo,dataDesistencia,descricao)"
                    . "VALUES(:pidUsers,:pidGrupo,:pmotivo,current_date(),:pdescricao)");
            $stmt->bindValue(':pidUsers', $this->iduser, PDO::PARAM_INT);
            $stmt->bindValue(':pidGrupo', $this->idgrupo, PDO::PARAM_INT);
            $stmt->bindValue(':pmotivo', $this->motivo, PDO::PARAM_INT);
            $stmt->bindValue(':pdescricao', $this->descri, PDO::PARAM_STR);
            $stmt->execute();
            
            $stmt = $this->pdo->prepare('UPDATE grupo_has_users SET uid = 2 WHERE uid = :puid');
            $stmt->bindValue(':puid', $this->iduser, PDO::PARAM_INT);

            if ($stmt->execute()){
 
                $ok = true;
                $mensagemIntegrantes = "O aluno {$this->name} desfez parceria com seu grupo pelo seguinte motivo: {$this->descri}";
                
                $stmt = $this->pdo->query("SELECT * "
                        . "FROM users u "
                        . "INNER JOIN grupo_has_users gu ON gu.uid = u.uid "
                        . "WHERE gu.idgrupo = {$this->idgrupo} AND u.uid <> {$this->iduser}");
                        
                foreach($stmt as $res){
                    $stmt2 = $this->pdo->prepare("INSERT INTO avisos(descricao, data, visto, uid, de) "
                            . "VALUES(:pmsg, current_date(),0, :puid ,{$this->iduser})");
                    
                    $stmt2->bindValue(':pmsg', $mensagemIntegrantes, PDO::PARAM_STR);
                    $id = (int) $res['uid'];
                    $stmt2->bindValue(':puid', $id, PDO::PARAM_INT);    
                   
                    if (!$stmt2->execute()) {
                        $ok = false;
                        parent::desconectar();
                        break;
                    }
                }
                
                parent::desconectar();
                return true;
            }else{
                parent::desconectar();
                return false;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }
    
    public function desistenciaProf() {
        try {
            if (parent::getPDO() == null){parent::conectar();}
            
            $stmt = $this->pdo->prepare("INSERT INTO desistenciaprof(idUsers,idGrupo,descricao,dataDesistencia,motivo)"
                    . "VALUES(:pidUsers,:pidGrupo,:pdescricao,current_date(),:pmotivo)");
            $stmt->bindValue(':pidUsers', $this->iduser, PDO::PARAM_INT);
            $stmt->bindValue(':pidGrupo', $this->idgrupo, PDO::PARAM_INT);
            $stmt->bindValue(':pdescricao', $this->descri, PDO::PARAM_STR);
            $stmt->bindValue(':pmotivo', $this->opcaoProf, PDO::PARAM_INT);
            $stmt->execute();
            
            
            $mensagemIntegrantes = "O(a) Professor(a) {$this->name} desfez parceria com seu grupo pelo seguinte motivo: {$this->descri}";

            $stmt = $this->pdo->query("SELECT * "
                    . "FROM users u "
                    . "INNER JOIN grupo_has_users gu ON gu.uid = u.uid "
                    . "WHERE gu.idgrupo = {$this->idgrupo} AND u.uid <> {$this->iduser}");

            foreach($stmt as $res){
                $stmt2 = $this->pdo->prepare("INSERT INTO avisos(descricao, data, visto, uid, de) "
                        . "VALUES(:pmsg, current_date(),0, :puid ,{$this->iduser})");

                $stmt2->bindValue(':pmsg', $mensagemIntegrantes, PDO::PARAM_STR);
                $id = (int) $res['uid'];
                $stmt2->bindValue(':puid', $id, PDO::PARAM_INT);    

                if (!$stmt2->execute()){
                    parent::desconectar();
                    return false;
                }
            }
            parent::desconectar();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }
    
    public function ataDefesa() {
        try {
            if (parent::getPDO() == null){parent::conectar();}
            
            $stmt = $this->pdo->prepare("INSERT INTO atadefesa(idgrupo,titulo,prof1,prof2,prof3,dia,hora)"
                                        . "VALUES(:pidgrupo, :ptitulo, :pprof1, :pprof2, :pprof3, :pdia, :phora)");
            $stmt->bindValue(':pidgrupo',   $this->idgrupo, PDO::PARAM_INT);
            $stmt->bindValue(':ptitulo',    $this->tituloGrupo2, PDO::PARAM_STR);
            $stmt->bindValue(':pprof1',     $this->prof1, PDO::PARAM_STR);
            $stmt->bindValue(':pprof2',     $this->prof2, PDO::PARAM_STR);
            $stmt->bindValue(':pprof3',     $this->prof3, PDO::PARAM_STR);
            $stmt->bindValue(':pdia',       $this->dia, PDO::PARAM_STR);
            $stmt->bindValue(':phora',      $this->horas, PDO::PARAM_STR);
            $stmt->execute();
            $IdAta = $this->pdo->lastInsertId();
            
            $mensagemIntegrantes = "O(a) Professor(a) {$this->prof1} marcou no dia {$this->dia} "
            . "as {$this->horas}, a defesa de seu TCC para Avalição Final diante da Banca, fique"
            . " atento a esta data, pois se perdida, você reprovará no curso.";

            $stmt = $this->pdo->query("SELECT * "
                    . "FROM users u "
                    . "INNER JOIN grupo_has_users gu ON gu.uid = u.uid "
                    . "WHERE gu.idgrupo = {$this->idgrupo} AND u.uid <> {$this->iduser}");

            foreach($stmt as $res){
                $stmt2 = $this->pdo->prepare("INSERT INTO avisos(descricao, data, visto, uid, de) "
                        . "VALUES(:pmsg, current_date(),0, :puid ,{$this->iduser})");

                $stmt2->bindValue(':pmsg', $mensagemIntegrantes, PDO::PARAM_STR);
                $id = (int) $res['uid'];
                $stmt2->bindValue(':puid', $id, PDO::PARAM_INT);    

                if (!$stmt2->execute()){
                    parent::desconectar();
                    return false;
                }
            }
            parent::desconectar();
            return $IdAta;
            
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }
    
    
    public function deleteGrupo(){
        try {
            if (parent::getPDO() == null){parent::conectar();}
            
            $stmt = $this->pdo->prepare('DELETE FROM grupo WHERE idgrupo = :pidgrupo');
            $stmt->bindValue(':pidgrupo', $this->idgrupo, PDO::PARAM_INT);

            if ($stmt->execute()){
                parent::desconectar();
                return true;
            }else{
                parent::desconectar();
                return false;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }
    
    public function sendMsg() {
        try {
            if (parent::getPDO() == null) {parent::conectar();}

            $idgrupo = $this->idgrupo;
            $myid = $this->uid;
            $ok = true;

            $stmt = $this->pdo->query("SELECT * FROM grupo_has_users WHERE idgrupo = $idgrupo AND uid <> $myid");

            if (count($stmt)) {
                foreach ($stmt as $res) {
                    $stmt2 = $this->pdo->prepare("INSERT INTO avisos(descricao, data, visto, uid, de)
					VALUES(:pmsg, current_date(),0, :puid ,$myid)");
                    $stmt2->bindValue(':pmsg', $this->msg, PDO::PARAM_STR);
                    $id = (int) $res['uid'];
                    $stmt2->bindValue(':puid', $id, PDO::PARAM_INT);

                    if (!$stmt2->execute()) {
                        $ok = false;
                        parent::desconectar();
                        break;
                    }
                }
            } else {
                parent::desconectar();
                return false;
            }

            if (!$ok) {
                return false;
            } else {
                return true;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

}
?>
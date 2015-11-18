/**
 * Função video_init() inicia todo o sistema de video conferencia, peear to peear
 * Autor: Everton J Paula (everton.projetos@gmail.com)
 * Data: 02/11/2015
 * Pré requisitos: 
 *  -   JQuery 2.x          https://jquery.com/
 *          * Para uso geral, principalmente em manipulação da DOM
 *  -   Autobahn.js 0.8.x   http://autobahn.ws/js/reference_wampv1.html
 *          * API de conexao com websocket
 *  -   FontAwnsome 4.x     https://fortawesome.github.io/Font-Awesome
 *          * Icones
 *  -   Bootstrap 3.3.x     http://getbootstrap.com/
 *          * Formatações, Estilizações
 *          * Você pode utiliza-lo passando nos parametros Class suas respequitivas classes.
 *          * Algumas de suas classes já são utilizadas para criar o conteúdo visual
 *  -   Moment.js 2.10.6    http://momentjs.com/
 *          * Para manipulação de date and time
 **/


/***
 * Função para iniciar o chat
 * @param {objeto} send_parameters dados para funcionamento do sistema
 * @returns {undefined}
 */
function video_init(send_parameters){
   
    //'use strict';
    
    /***
    * SessionID vindo do websocket, utilizado para criar salas de conversas
    * @int type
    */
    var mySessionId = null;
    
    /***
     * Esta variavel indica que existe uma video conferencia em andamento
     */
    var inVideoConf = false;
    
    /**
     * Esta variavel guarda os dados de midia do perfil logado
     */
    var myMediaStream = null;
    
    /**
     * configuração para conexao ao iceServers 
     */
    var configuration = {
        'iceServers': [{
        //'url': 'stun3.l.google.com:19302'
        url: 'stun:stun4.l.google.com:19302'
        //url: 'stun:stun.example.org'
      }]
    };
    
    /***
     * RTCPeerConnection Para conexao com outro peer
     */
    var pc = false;
    
    /**
     * A variavel é carregada com a tag video local
     */
    var selfView = getLocalVideo();
    
    /**
     * A varivael é carrefa coma tag de video remoto
     */
    var remoteView = getRemoteVideo();
    
    /**
     * Esta varivel que fecha a função de tempo de ligação
     */
    var timeOut = null;
    
    
    /***
    * Array com o controle de usuários cindo do banco de dados;
    * @array Array
    */
    var controleUsers = null;
    
    
   /***
     * Parametros para execução do sistema
     * ws: referese ao socket de ligação
     * class: referece a classe que controla-ra toda formatação vinda do css
     * classIcon: referece as classe que compoem o icone em fontawnsome
     * userId: usado para definir a variavel de controle essencial userId
     * @objeto type
     */
    var default_parameters = {
        ws: (window.location.protocol === "https:") ? "wss://localhost:8080/Video" : "ws://localhost:8080/Video",
        userId: null,
        url: "src/Controler/videoControler.php",
        timeToResponse: 15000,
        qtdMessages: 30,
        buttonClassInitChat: "btn btn-success",
        buttonClassInitCall: "btn btn-link",
        classButtonSend: "btn btn-default",
        selectClassStatus: "btn btn-primary",
        iconRead: "fa fa-check-circle",
        iconReadColor: "#5CB85C",
        optionsStatus: [
            {text: "online", icon: "fa fa-video-camera", color: "#1EFF1E"},
            {text: "offline", icon: "fa fa-power-off", color: "#EC925B"},
            {text: "ocupado", icon: "fa fa-pencil-square-o", color: "#777777"}
        ],
        class: "video-conf",
        classBadge: "badge",
        colorBadge: "#EC925B",
        errorClass: "erroVideo",
        setTimeOut: 5000,
        labelReceiveColor: "#FFF",
        labelSendColor: "#FFF",
        labelReceiveClass: "label-info",
        labelSendClass: "label-warning",
        sound_mensagem: "./src/Chat/sound_mensagem.mp3",
        sound_video_call: "./src/Video/sound_video_call.mp3",
        windowClass:{
            panel: "panel panel-primary",
            header: "panel-heading",
            body: "panel-body",
            footer: "panel-footer",
            title: "panel-title",
            close: "fa fa-times",
            iconSend: "fa fa-3x fa-chevron-right",
            sendColor: ""
        },
        icons:{
            call: "fa fa-5x fa-phone-square",
            callColor: "#55F555",
            callColorHover: "#60F160",
            spinCall: "fa fa-spinner fa-pulse fa-5x fa-fw margin-bottom",
            spinColor: "#55F555",
            closeCallColor: "#F58230",
            closeCallColorHover: "#EF995C",
            spinLitle: "fa fa-circle-o-notch fa-spin",
            spinLitleColor: "#55F555",
            close: "fa fa-3x fa-times",
            sendMsg: "fa fa-3x fa-chevron-right",
            sendColor: "",
            fullscreem: "fa fa-expand",
            microfone_on: "fa fa-microphone",
            microfone_off: "fa fa-microphone-slash",
            activeChatBtn: "fa fa-align-justify"
        },
        contentCSSVideo: {width: "100%", height: "100%", top : "0px", left: "0px"},
        divModalVideoConf: 'modal-video-conf',
        innerDivMenuVideoContatos: 'online-video-conf',
        button: {size: "btn btn-default btn-sm btn-round"}
    };
    
    var parameters = $.extend({}, default_parameters, send_parameters);
    
    /****
     * Função callbacks para os eventos publish, elas retornam o contedos de topicos em event
     * @param {string} topic 
     * @param {string} event
     * @returns {undefined}
     */
    function callbacks(topic, event){
        switch (topic){
            case "online":
                if(controleUsers === null){
                    controleUsers = setControlerUsers(event);
                    conn.publish('conectar', getDadosUser());
                }
            break;
            case "conectar":
                if(mySessionId === null){mySessionId = __setMySessionId(event);}
                setNewConnection(event);
            break;
            case "desconectar":
                desconectarUsers(event);
            break;
            case "changeStatus":
                changeStatus(event);
            break;
            case "readMessage":
                updateReadMessage(event);
            break;
            case "message":
                receiveMessage(event);
            break;
            case "chanelComunicVideo" :
                ReceiveChamada(event);
            break;
            case "sendIceCandidate" :
                addIceCandidate(event);
            break;
            case "onError":
                onError(event);
            break;
        }
    }

    /****
     * @returns {String} 
     */
    function getDadosUser(){
        var json = {"conectar":{
               "userId" : parameters.userId,
               "status" : "online"
           }
       };   
       return JSON.stringify(json);
    }
    
    /**
     * setar variavel global da sessão do php
     * @param {objeto} event dados para set vindos do publish callbacks vindo do php
     * @returns {int} valor da sessão
     */
    function __setMySessionId(event){
        var obj = JSON.parse(event);
        return parseInt(obj.sessionId);
    }
    
    
    /***
     * getter valor da sessão
     * @returns {int} retona o valor da sessão na variavel global
     */
    function __getMySessionId(){
        return parseInt(mySessionId);
    }
    
    /**
     * 
     * @param {objeto} event usado para setar o status em caso de sucesso
     * @returns {undefined}
     */
    function setControlerUsers(event){
        try{
            $.ajax({
                url: parameters.url,
                data: {userId: parameters.userId, process: "selectUsers"},
                method: "POST",
                dataType: 'JSON',
                success: function(data){
                    if(data !== null){
                        createArraySetControlerUsers(data);
                        setStatus(event);
                    }
                },
                error:function(msg){
                    console.log(msg);
                }
            });
        }catch(msg){
            console.log(msg);
        }
    }
    
    
    /***
     * Aqui função que cria o array com os usuarios do chat vindos do banco de dados
     * @param {array} data -> json com os dados
     * @returns {undefined}
     */
    function createArraySetControlerUsers(data){
        try{
            controleUsers = new Array();
            for(var i = 0; i < data.length ; i++){
                var user = new Object();
                user['sessionId'] = null;
                user['userId'] = data[i].userId;
                user['nome'] = data[i].nome;
                user['nick'] = data[i].nick;
                user['status'] = "offline";
                user['button'] = null;
                user['i'] = null;
                user['badge'] = getBadge(data[i].msgNotRead);
                user['alertMsg'] = null;
                user['chat'] = {
                    visible: false,
                    window: {_construct: false, panel: null, header: null, title: null, body: null, footer: null, form: null, textarea: null, buttonSend: null, iconClose:null},
                    message: [{from: null, text: null, read: null, data: null }]
                };
                user['modal'] = {
                    visible: false,
                    close: null,
                    window: null,
                    iconCall: null,
                    iconCloseCall: null,
                    content: null,
                    somChamada: null
                };
                controleUsers[parseInt(data[i].userId)] = user;
            }
        }catch(msg){
            console.log(msg);
        }
    }
    
    /***
     * Os usuario como onlide
     * @param {String} event usarios a serem posto online
     * @returns {undefined}
     */
    function setStatus(event){
        try{
            var obj = JSON.parse(event);
            var array = $(obj).toArray();
            controleUsers.forEach(function(user){
                array.forEach(function(data){
                   for(var j = 0; j < data.length ; j++){
                        if(parseInt(user.userId) === parseInt(data[j].userId)){
                            user.status = data[j].status;
                            user.sessionId = data[j].sessionId;
                        }
                    } 
                });
                user.button = getButtonInitChat(user);
                user.i = getIcon(user.status);
            });
            showMenuContatos();
        }catch(msg){
            console.log(msg);
        }
    }
    
    /**
     * Set as novas conection com dados como sessionId e status
     * @param {String} event
     * @returns {undefined}
     */
    function setNewConnection(event){
        try{
            var obj = JSON.parse(event);
            var index = parseInt(obj.userId);
            if(parseInt(mySessionId) !== parseInt(obj.sessionId)){
                if(obj.status === "offline"){
                    desconectarUsers(event);
                }else{
                    for(var j = 0; j < parameters.optionsStatus.length; j++){
                        if(parameters.optionsStatus[j].text === obj.status){
                            controleUsers[index].sessionId = obj.sessionId;
                            controleUsers[index].button.value = obj.sessionId;
                            controleUsers[index].status = obj.status;
                            controleUsers[index].i.class = parameters.optionsStatus[j].icon;
                            controleUsers[index].i.className = parameters.optionsStatus[j].icon;
                            controleUsers[index].i.classList = parameters.optionsStatus[j].icon;
                            controleUsers[index].i.style.color = parameters.optionsStatus[j].color;
                            controleUsers[index].i.title=parameters.optionsStatus[j].text;
                            break;
                        }
                    }
                }
            }
        }catch(msg){
            console.log(msg);
        }
    }
    
    /***
     * Mudança no status do cliente
     * @param {String} event
     * @returns {undefined}
     */
    function changeStatus(event){
        try{
            var obj = JSON.parse(event);
            var index = parseInt(obj.userId);
            if(parseInt(mySessionId) !== parseInt(obj.sessionId)){
                if(parseInt(controleUsers[index].sessionId) === parseInt(obj.sessionId)){
                    controleUsers[index].status = obj.status;
                    for(var j = 0; j < parameters.optionsStatus.length; j++){
                        if(parameters.optionsStatus[j].text === obj.status){''
                            controleUsers[index].i.class = parameters.optionsStatus[j].icon;
                            controleUsers[index].i.className = parameters.optionsStatus[j].icon;
                            controleUsers[index].i.classList = parameters.optionsStatus[j].icon;
                            controleUsers[index].i.style.color = parameters.optionsStatus[j].color;
                            controleUsers[index].i.title=parameters.optionsStatus[j].text;
                            break;
                        }
                    }
                }
            }
        }catch(msg){
            console.log(msg);
        }
    }
    
    /***
     * Desconecta o usuario colocando como offline e retirando as sessões dele comigo
     * @param {String} event
     * @returns {undefined}
     */
    function desconectarUsers(event){
        try{
            var obj = JSON.parse(event);
            var index = parseInt(obj.desconectar.userId);
            if(parseInt(parameters.userId) !== parseInt(obj.desconectar.userId)){
                if(parseInt(controleUsers[index].sessionId) === parseInt(obj.desconectar.sessionId)){
                    for(var j = 0; j < parameters.optionsStatus.length; j++){
                        if(parameters.optionsStatus[j].text === obj.desconectar.status){
                            controleUsers[index].sessionId = null;
                            controleUsers[index].i.class = parameters.optionsStatus[j].icon;
                            controleUsers[index].i.className = parameters.optionsStatus[j].icon;
                            controleUsers[index].i.classList = parameters.optionsStatus[j].icon;
                            controleUsers[index].i.style.color = parameters.optionsStatus[j].color;
                            controleUsers[index].i.title=parameters.optionsStatus[j].text;
                            break;
                        }
                    }
                }
            }
        }catch(msg){
            console.log(msg);
        }
    }
    
    /***
    * 
    * @param {int} userId
    * @returns {chat_init.verificaSessions.index} valores de chaves onde sessão
    */
    function verificaSessions(userId){
        try{
            var index = null;
            for(var i = 0 ; i < controleSessions.length ; i++){
                if(parseInt(controleSessions[i].to) === parseInt(userId) || parseInt(controleSessions[i].from) === parseInt(userId)){
                    index.push(i);
                }
            }
            return index;
        }catch(msg){
            console.log(msg);
            return null;
        }
    }
    
    
    /**
     * Esta função é responsavel pela verificação de entradas duplicadas no sistema
     * @param {objeto} event
     * @returns {undefined}
     */
    function onError(event){
        try{
            var obj = JSON.parse(event);
            var index = parseInt(obj.onError.userId);
            if(__getMySessionId() === parseInt(obj.onError.oldSessionId)){
                conn.close();
                controleUsers = null;
                var msg = "Usu\u00e1rio duplicado, sua conex\u00e3o foi fechada !! Provavelmente este login est\u00e1 sendo usado em outro dispositivo.";
                alertOnError(msg);
            }else{
                if(parseInt(parameters.userId) !== parseInt(obj.onError.userId)){
                    if(parseInt(controleUsers[index].sessionId) === parseInt(obj.onError.oldSessionId)){
                        controleUsers[index].sessionId = obj.onError.sessionId;
                        controleUsers[index].button.value = obj.onError.sessionId;
                        for(var j = 0; j < parameters.optionsStatus.length; j++){
                            if(obj.onError.status === parameters.optionsStatus[j].text){
                                controleUsers[index].i.class = parameters.optionsStatus[j].icon;
                                controleUsers[index].i.className = parameters.optionsStatus[j].icon;
                                controleUsers[index].i.classList = parameters.optionsStatus[j].icon;
                                controleUsers[index].i.style.color = parameters.optionsStatus[j].color;
                                controleUsers[index].i.title=parameters.optionsStatus[j].text;
                            }
                        }
                    }
                }
            }   
        }catch(msg){
            console.log(msg);
        }
    }
    
    /***
     * Função que ativa a chamada de montagem de chats e conversas
     * @param {data} data valores de user
     * @returns {undefined}
     */
    function buttonClickInitChat(data){
        try{
            var index = parseInt(data.userId);
            if(controleUsers[index].chat.window._construct === false){
                controleUsers[index].chat.window.panel = __constructWindow(data);
                controleUsers[index].chat.window.body = __constructBody();
                controleUsers[index].chat.window.header = __constructHeader();
                controleUsers[index].chat.window.footer = __constructFooter();
                controleUsers[index].chat.window.title = __constructTitle(data);
                controleUsers[index].chat.window.form = __constructFormSend(data);
                controleUsers[index].chat.window.iconClose = __constructIconClose(data);
                controleUsers[index].chat.window.buttonSend = __constructButtonSend();
                controleUsers[index].chat.window.textarea = __constructTextArea(data);
                $(controleUsers[index].chat.window.header).append(controleUsers[index].chat.window.iconClose);
                $(controleUsers[index].chat.window.header).append(controleUsers[index].chat.window.title);
                $(controleUsers[index].chat.window.panel).append(controleUsers[index].chat.window.header);
                $(controleUsers[index].chat.window.panel).append(controleUsers[index].chat.window.body);
                $(controleUsers[index].chat.window.form).append(controleUsers[index].chat.window.textarea);
                $(controleUsers[index].chat.window.form).append(controleUsers[index].chat.window.buttonSend);
                $(controleUsers[index].chat.window.footer).append(controleUsers[index].chat.window.form);
                $(controleUsers[index].chat.window.panel).append(controleUsers[index].chat.window.footer);
                $(controleUsers[index].modal.content).append(controleUsers[index].chat.window.panel);
                $(controleUsers[index].chat.window.panel).fadeIn();
                controleUsers[index].chat.window._construct = true;
                getMessageFromBD(index);
            }else{
                if(!$(controleUsers[index].chat.window.panel).is(":visible")){
                    $(controleUsers[index].chat.window.panel).fadeIn();
                }
            }
            controleUsers[index].chat.visible = true;
            controleUsers[index].badge.text = null;
            controleUsers[index].badge.innerText = null;
            scrollEverBottom(index);
            $(controleUsers[index].chat.window.textarea).focus();
            readMessage(data);
        }catch(msg){
            console.log(msg);
        }
    }
    
    /***
     * Função maximiza janela ou minimiza
     */
    function requestFullScreem(){
        if (!document.fullscreenElement &&
            !document.mozFullScreenElement && !document.webkitFullscreenElement && !document.msFullscreenElement ){
          if (document.documentElement.requestFullscreen) {
            document.documentElement.requestFullscreen();
          } else if (document.documentElement.msRequestFullscreen) {
            document.documentElement.msRequestFullscreen();
          } else if (document.documentElement.mozRequestFullScreen) {
            document.documentElement.mozRequestFullScreen();
          } else if (document.documentElement.webkitRequestFullscreen) {
            document.documentElement.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
          }
        } else {
          if (document.exitFullscreen) {
            document.exitFullscreen();
          } else if (document.msExitFullscreen) {
            document.msExitFullscreen();
          } else if (document.mozCancelFullScreen) {
            document.mozCancelFullScreen();
          } else if (document.webkitExitFullscreen) {
            document.webkitExitFullscreen();
          }
        }
    }
    
    /***
     * @param {String} event String com os dados da mensagem trazidas pelo contato
     */
    function ReceiveChamada(event){
        try{
            var data = JSON.parse(event);
            if(data.message === "chamando"){
                recebendoChamada(data);
            }else if(data.message === "desligou"){
                desligou(data);
            }else if(data.message === "estabelecerChamada"){
                estabelecerChamada(data);
            }
        }catch(msg){
            console.log(msg);
        }
    }
    
    /***
     * @param {Objeto} obj valores para conexao
     */
    function buttonClickInitCall(obj){
       try{
            if(controleUsers[obj.userId].sessionId !== null && controleUsers[obj.userId].status !== "offline"){
                chamar(controleUsers[obj.userId]);
            }else{
                alertOnError("Voc\u00ea esta tentado estabelecer v\u00eddeo confer\u00eancia com um usu\u00e1rio  que est\u00e1 off-line");
            }
        }catch(msg){
           console.log(msg);
        }
    }
    
    
    /***
     * Fechar o modal da video conferencia
     * @param {Objeto} obj Dados do cliente
     */
    function closeModalVideo(obj){
        try{
            desligar(obj);
        }catch(msg){
            console.log(msg);
        }
    }
    
    /***
     * Efetua a chamada para algum user
     */
    function chamar(obj){
        try{
            controleUsers[obj.userId].modal.window = __getWindowCall(obj);
            controleUsers[obj.userId].modal.content = __getContentWindowCall(obj, "chamando");
            controleUsers[obj.userId].modal.iconCall = getElemSpinCall();
            $(controleUsers[obj.userId].modal.content).append(controleUsers[obj.userId].modal.iconCall);
            $(controleUsers[obj.userId].modal.content).append(__getSomChamada());
            controleUsers[obj.userId].modal.close = __getCloseWindowCall(controleUsers[obj.userId]);
            $(controleUsers[obj.userId].modal.window).append(controleUsers[obj.userId].modal.close);
            $(controleUsers[obj.userId].modal.window).append(controleUsers[obj.userId].modal.content);
            $('body').append(controleUsers[obj.userId].modal.window).fadeIn();
            inVideoConf = true;
            controleUsers[obj.userId].modal.visible = true;
            timeOut = setTimeout(callToAnyResponse, parameters.timeToResponse, obj);
            start(obj, true);
        }catch(msg){
            console.log(msg);
        }
    }
    
    
    /***
    * Recebendo chamada de video conferencia
    * @param {Objeto} obj Dados para recebimento de chamada
    */
    function recebendoChamada(obj){
        try{
            if(inVideoConf !== true){
                controleUsers[obj.from].modal.window = __getWindowCall();
                controleUsers[obj.from].modal.content = __getContentWindowCall(controleUsers[obj.from], "recebendo");
                $(controleUsers[obj.from].modal.content).prepend(getLittleSpin());
                controleUsers[obj.from].modal.iconCall =  getElemCall(obj);
                controleUsers[obj.from].modal.iconCloseCall = getElemCloseCall(controleUsers[obj.from]);
                $(controleUsers[obj.from].modal.content).append(controleUsers[obj.from].modal.iconCall);
                $(controleUsers[obj.from].modal.content).append(controleUsers[obj.from].modal.iconCloseCall);
                $(controleUsers[obj.from].modal.content).append(__getSomChamada());
                controleUsers[obj.from].modal.close = __getCloseWindowCall(controleUsers[obj.from]);
                $(controleUsers[obj.from].modal.window).append(controleUsers[obj.from].modal.close);
                $(controleUsers[obj.from].modal.window).append(controleUsers[obj.from].modal.content);
                $('body').append(controleUsers[obj.from].modal.window).fadeIn();
                inVideoConf = true;
                controleUsers[obj.from].modal.visible = true;
                timeOut = setTimeout(callToAnyResponse, parameters.timeToResponse - 1000, controleUsers[obj.from]);
            }
        }catch(msg){
            console.log(msg);
        }
    }
    
    /**
     * Aceita chamada de video realizada
     * @param {Objeto} obj Dados da chamada aceita
     */
    function aceitaChamada(obj){
        try{
            aceitarOffertaECriarResposta(obj);
        }catch(msg){
            console.log(msg);
        }
        
    }
       
    
    /**
     * esta função estabelece a chamada de video conferência
     * @param {Objeto} obj obj com os dados da conexao
     */
    function estabelecerChamada(obj){
        try{
            clearTimeout(timeOut);
            timeOut = null;
            $(controleUsers[obj.from].modal.content).css(parameters.contentCSSVideo);
            $(controleUsers[obj.to].modal.content).css(parameters.contentCSSVideo);
            if(__getMySessionId() === parseInt(obj.sessionId_to)){
                if(obj.sdp_answser !== ""){
                    pc.setRemoteDescription(new RTCSessionDescription(obj.sdp_answser));
                }
                $(controleUsers[obj.from].modal.content).html(selfView);
                $(controleUsers[obj.from].modal.content).append(remoteView);
                $(controleUsers[obj.from].modal.content).append(getButtonFullscreem());
                $(controleUsers[obj.from].modal.content).append(getButtonChatInit(controleUsers[obj.from]));
                //$(controleUsers[obj.from].modal.content).append(getMicrofone());
            }else{
                $(controleUsers[obj.to].modal.content).html(selfView);
                $(controleUsers[obj.to].modal.content).append(remoteView);
                $(controleUsers[obj.to].modal.content).append(getButtonFullscreem());
                $(controleUsers[obj.to].modal.content).append(getButtonChatInit(controleUsers[obj.to]));
                //$(controleUsers[obj.to].modal.content).append(getMicrofone());
            }
        }catch(msg){
            console.log(msg);
        }
    }
    
    /***
     * Recebe a mensagem de que desligou a video chamada
     * @param {Objeto} obj Objeto para ser tranformada em objeto com o valor para desligar video chamda
     */
    function desligou(obj){
        controleUsers[obj.from].modal.visible = false;
        controleUsers[obj.from].chat.window._construct = false;
        controleUsers[obj.from].chat.visible = false;
        $(controleUsers[obj.from].modal.window).remove();
        controleUsers[obj.from].modal.window = null;
        inVideoConf = false;
        clearTimeout(timeOut);
        timeOut = null;
        var nome = (controleUsers[obj.from].nick !== null && controleUsers[obj.from].nick !== "" ) ? controleUsers[obj.from].nick + " - " + controleUsers[obj.from].nome : controleUsers[obj.from].nome;
        alertOnError("O(a) " + nome + " desligou a chamada de v\u00eddeo confer\u00eancia neste momento.");
        if(pc !== false){
            pc.close();
            pc = false;
        }
        
        selfView.src = "";
        remoteView.src = "";
    }
    
    /**
     * Desliga a video chamada e envia mensagem de desligar
     * @param {Objeto} obj Dados do usuario que será remetido para fechamento de conexao
     */
    function desligar(obj){
        try{
            controleUsers[obj.userId].modal.visible = false;
            controleUsers[obj.userId].chat.window._construct = false;
            controleUsers[obj.userId].chat.visible = false;
            $(controleUsers[obj.userId].modal.window).remove();
            controleUsers[obj.userId].modal.window = null;
            inVideoConf = false;
            var send = new Object();
            send["from"]= parameters.userId;
            send["to"]= obj.userId;
            send["sessionId_from"]= __getMySessionId();
            send["sessionId_to"]= obj.sessionId;
            send["message"] = "desligou";
            conn.call('chanelComunicVideo', JSON.stringify(send));
            clearTimeout(timeOut);
            timeOut = null;
            if(pc !== false){
                pc.close();
                pc = false;
            }
            selfView.src = "";
            remoteView.src = "";
        }catch(msg){
            console.log(msg);
        }
    }
    
    /***
     * Esta função é chamada apos o tempo limite para estabelecer video chamada falhar
     */
    function callToAnyResponse(obj){
        controleUsers[obj.userId].modal.visible = false;
        controleUsers[obj.userId].chat.window._construct = false;
        controleUsers[obj.userId].chat.visible = false;
        $(controleUsers[obj.userId].modal.window).remove();
        controleUsers[obj.userId].modal.window = null;
        inVideoConf = false;
        if(pc !== false){
            pc.close();
            pc = false;
        }
        selfView.src = "";
        remoteView.src = "";
        alertOnError("O tempo para chamada de v\u00eddeo confer\u00eancia foi excedido");
    }
    
    /**
     * Adiciona a lista de addIceCandidate
     * @param {Objeto} event Objeto contendo o canditado
     */
    function addIceCandidate(event){
        var obj = JSON.parse(event);
        if(pc !== false)
            pc.addIceCandidate(new RTCIceCandidate(obj.candidate));
    }
    
    
    /**
     * Este method inicia a troca de mensagens para  video conferencia bem como
     * as variaveis pc RTCPeerConnection
     * @param {Objeti} obj dados para trocas de mensagens
     * @param {bool} isOffer indica se é uma offerta a conexao
     */
    function start(obj, isOffer){
        
        if(!pc)
            pc = new RTCPeerConnection(null);
        
        pc.onicecandidate = function (evt){
            if(evt.candidate){
                conn.call("sendIceCandidate", JSON.stringify({
                    'candidate': evt.candidate,
                    'sessionId': __getMySessionId()
                }));
            }
        };
        
        pc.onnegotiationneeded = function(){
            if(isOffer){
                pc.createOffer(function(desc){
                    pc.setLocalDescription(desc);
                    var send = new Object();
                    send["from"]= parameters.userId;
                    send["to"]= obj.userId;
                    send["sessionId_from"]= __getMySessionId();
                    send["sessionId_to"]= obj.sessionId;
                    send["message"] = (isOffer === true) ? "chamando" : "recebendo";
                    send['sdp'] = pc.localDescription;
                    conn.call('chanelComunicVideo', JSON.stringify(send));
                }, logError);
            }else{
                if(obj.sdp !== ""){
                    pc.setRemoteDescription(new RTCSessionDescription(obj.sdp), function (){
                        if (pc.remoteDescription.type === 'offer'){
                            pc.createAnswer(function(desc){
                                pc.setLocalDescription(desc);
                                var send = new Object();
                                send["from"]= parameters.userId;
                                send["to"]= obj.from;
                                send["sessionId_from"]= __getMySessionId();
                                send["sessionId_to"]= obj.sessionId_from;
                                send["message"] = "estabelecerChamada";
                                send["estabelishConection"] = true;
                                send["sdp_answser"] = pc.localDescription;
                                send["sdp_offer"] = obj.sdp;
                                conn.call('chanelComunicVideo', JSON.stringify(send), false);
                            }, logError);
                        }
                    }, logError);
                }
            }
        };
        
        // once remote stream arrives, show it in the remote video element
        pc.onaddstream = function (evt){
            remoteView.src = URL.createObjectURL(evt.stream);
        };
        
        getUserMedia(true);
        
    }
    
    
    /***
     * Recebendo oferta de conexao
     */
    function aceitarOffertaECriarResposta(evt){
        start(evt, false);
    }
    
    /***
     * Estabelce o uso de media como true or false de acordo com parametro
     * @param {boolean} bool TRUE ou FALSE 
     */
    function getUserMedia(bool){
        navigator.getUserMedia({
            'audio': bool,
            'video': bool
        }, function (stream) {
            selfView.src = URL.createObjectURL(stream);
            pc.addStream(stream);
            myMediaStream = stream;
        }, logError); 
    }
    
    
    /***
     * Esta função desativa o som
     * @param {Elemento} $button Botão contendo o o icon microfone
     */
    function activeDesactiveMicrofone($button){
        
    }
    
    
    /***
     * Log dos erros de conexao para RTCPeerConection
     */
    function logError(error) {
        log(error.name + ': ' + error.message);
    }
    
    
    /**
     * @param {Objeto} event description{Varivael com dados da mensagem}
     */
    function receiveMessage(event){
        try{
            var obj = JSON.parse(event);
            var index = parseInt(obj.from);
            var array = new Array(obj);
            
            setMessage(index, array);
            if(controleUsers[index].chat.visible !== true){
                var countMsg = ($(controleUsers[index].badge).text() !== "") ? parseInt(controleUsers[index].badge.innerText) : 0;
                countMsg++;
                controleUsers[index].badge.innerText = countMsg.toString();
                controleUsers[index].alertMsg = __getSomMensagem();
                $(controleUsers[index].modal.content).find('audio').remove();
                $(controleUsers[index].modal.content).append(controleUsers[index].alertMsg);
                
            }else{
                obj.sessionId = obj.sessionId_from;
                obj.userId = obj.from;
                readMessage(obj);
            }
        }catch(msg){
            console.log(msg);
        }
    }
    
    /***
     * Seta as novas mensagens na janela do chat
     * @param {int} index int com o valor do indice do usuário
     * @param {Array} array coleção de mensagens
     */
    function setMessage(index, array){
        try{
            for(var i = 0; i < array.length; i++){
                var send = (parseInt(array[i].from) === parseInt(parameters.userId))? true : false;
                var j = controleUsers[index].chat.message.length;
                controleUsers[index].chat.message[j] = { from: parseInt(array[i].from), text: getLabelMsg(array[i] ,send), data: dateMsg(array[i], send), read: (array[i].read === true && parseInt(array[i].from) === parseInt(parameters.userId)) ? iconRead(): null};
                $(controleUsers[index].chat.window.body).append(controleUsers[index].chat.message[j].text);
                $(controleUsers[index].chat.message[j].data).append(controleUsers[index].chat.message[j].read);
                $(controleUsers[index].chat.window.body).append(controleUsers[index].chat.message[j].data);
            }
            scrollEverBottom(index);
        }catch(msg){
            console.log(msg);
        }
    }
    
    /***
     * Função para salvar no bando de dados as mensagens enviadas.
     * @param {Array} array Array com dados da mensagem
     */
    function saveMessageOnBd(array){
        try{
            for(var i = 0; i < array.length; i++){
                $.ajax({
                    url: parameters.url,
                    data: {to: array[i].to, from: array[i].from, message: array[i].message, process: "saveMessage"},
                    method: "POST",
                    dataType: 'JSON',
                    success: function(data){
                        if(data.ok === true){
                            //do samething future
                        }else{
                            //do samething future
                        }
                    },
                    error:function(msg){
                        console.log(msg);
                    }
                });
            }
        }catch(msg){
            console.log(msg);
        }
    }
    
    /***
     * Função para salvar no bando de dados as mensagens enviadas.
     * @param {Array} array Array com dados da mensagem
     */
    function setMessageReadOnBd(from, to){
        try{
            $.ajax({
                url: parameters.url,
                data: {to: to, from: from, process: "setReadMessage"},
                method: "POST",
                dataType: 'JSON',
                success: function(data){
                    if(data.ok === true){
                        //do samething future
                    }else{
                        //do samething future
                    }
                },
                error:function(msg){
                    console.log(msg);
                }
            });
        }catch(msg){
            console.log(msg);
        }
    }
    
    /**
     * Define o scroll para o barte de baixo da conversa
     * @param {int} index Indice do array de users
     * @returns {undefined}
     */
    function scrollEverBottom(index){
        try{
            var div = controleUsers[index].chat.window.body;
            $(div).scrollTop($(div)[0].scrollHeight);
        }catch(msg){
            console.log(msg);
        }
    }
    
    /**
     * Função de submit do form de 
     * @param {Objeto} Objeto com os valores de cada user
     * @returns {Bool} false
     */
    function submitSendMsg(data){
        try{
            var index = parseInt(data.userId);
            var msg = $(controleUsers[index].chat.window.textarea).val();
            $(controleUsers[index].chat.window.textarea).val("");
            if(msg[0] !==  "\n" && msg[0] !==  "\r"){
               var send = new Object();
                    send["read"]= false;
                    send["message"]= __getTratMsg(msg);
                    send["from"]=parameters.userId;
                    send["to"]=index;
                    send["data"]= new moment().format("DD-MM-YYYY HH:mm");
                    send["sessionId_from"]= __getMySessionId();
                    send["sessionId_to"]= controleUsers[index].sessionId;
                    conn.call("message", JSON.stringify(send));
                var array = new Array(send);
                saveMessageOnBd(array);
                setMessage(index, array);
            }
            return false;
        }catch(msg){
            console.log(msg);
            return false;
        }
    }
    
    /***
     * Esta função contém os conjuntos de regras para tratamento da string que será inserida no banco de dados.
     * @param {String} msg Mensagem a ser tratada
     * @return {String} Retorna string da mensagem tratada
     */
    function __getTratMsg(msg){
        msg = msg.replace("\n","");
        msg = msg.replace("\r","");
        return msg;
    }
    
    /***
     * Fecha janela do chat 
     * @param {Objeto} data objeto com valores de user
     * @returns {undefined}
     */
    function closeWindowChat(data){
        try{
            var index = parseInt(data.userId);
            if($(controleUsers[index].chat.window.panel).is(":visible")){
                $(controleUsers[index].chat.window.panel).fadeOut();
                controleUsers[index].chat.visible = false;
            }
        }catch(msg){
            console.log(msg);
        }
    }
    
    
    /**
     *  Usado para carregar as ultimas mensagens recebidas do banco de dados
     * @param {int} index valor da chave do array de users
     * @returns {undefined}
     */
    function getMessageFromBD(index){
        try{
            $.ajax({
                url: parameters.url,
                data: {userId: parameters.userId, from: index, qtdMessages: parameters.qtdMessages,process: "getMessages"},
                method: "POST",
                dataType: 'JSON',
                success: function(data){
                    if(data.length){
                        setMessage(index, data);
                    }
                },
                error:function(msg){
                    console.log(msg);
                }
            });
        }catch(msg){
            console.log(msg);
        }
    }
    
    /**
     * Esta função é acionado ao dar foco na div do chat onde contém as mensagens
     * Com isso podemos atualziar o status de read para true
     * @param {Object} data Valores do usuario da janela do chat em aberto
     */
    function readMessage(data){
        setMessageReadOnBd(data.userId, parameters.userId);
        if(data.sessionId !== null){
            var send = new Object();
                send["sessionId_to"] = parseInt(data.sessionId);
                send["sessionId_from"] = __getMySessionId();
                send["to"] = parseInt(parameters.userId);
                send["from"] = parseInt(data.userId);
                send["read"] = true;
            conn.call("readMessage", JSON.stringify(send));
        }
    };
    
    /***
     * Esta função atualiza em tempo real as mensagens lida
     * @param {Objeto} event Objeto com dados para atualizar read das mensagens
     */
    function updateReadMessage(event){
        try{
            var obj = JSON.parse(event);
            var index = parseInt(obj.to);
            for(var i = 0; i < controleUsers[index].chat.message.length; i++){
                if(parseInt(controleUsers[index].chat.message[i].from) === parseInt(parameters.userId)){
                    if(controleUsers[index].chat.message[i].read === null){
                        controleUsers[index].chat.message[i].read = iconRead();
                    }
                    $(controleUsers[index].chat.message[i].data).append(controleUsers[index].chat.message[i].read).fadeIn();
                }
            }
        }catch(msg){
            console.log(msg);
        }
    }
    
    /**
     * Função para mudar o status no sistema
     * @param {select} select elemento select
     * @returns {undefined}
     */
    function selectChangeStatus(select){
        try{
            var obj = {"status":{
                    sessionId: __getMySessionId(),
                    userId : parameters.userId,
                    status: $(select).val()
                }
            };
            conn.publish("changeStatus", JSON.stringify(obj));
        }catch(msg){
            console.log(msg);
        }
    }
    
    /**
     * Cria o elemento button para cada contato
     * @param {objeto} data
     * @returns {chat_init.getButton.$button} elemento button
     */
    function getButtonInitChat(data){
        var $button = document.createElement('button');
        $button.style.display = "inline-block";
        $button.innerText = (data.nick !== "" && data.nick !== null) ? data.nick + " - " + data.nome : data.nome;
        $button.text = (data.nick !== "" && data.nick !== null) ? data.nick + " - " + data.nome : data.nome;
        $button.class = parameters.buttonClassInitCall;
        $button.className = parameters.buttonClassInitCall;
        $button.classList = parameters.buttonClassInitCall;
        $button.value = data.sessionId;
        $button.id = data.userId;
        $button.type= "button";
        $button.onclick = function(){buttonClickInitCall(data);};
        
        return $button;
    }
    
    /**
     * Retorna o item span badge que cria o alerta de nova mensagem no botão
     * @param {String} countNotReadMsg
     * @returns {chat_init.getBadge.$span}
     */
    function getBadge(countNotReadMsg){
        var $span = document.createElement('span');
        $span.innerText = (parseInt(countNotReadMsg)>0) ?  countNotReadMsg : null;
        $span.class = parameters.classBadge;
        $span.className = parameters.classBadge;
        $span.classList = parameters.classBadge;
        $span.style.backgroundColor = parameters.colorBadge;
        return $span;
    }

    /***
     * Select de opções dos estatos disponiveis do sistema
     * @returns {chat_init.getElementSelectStatus.$select}
     */
    function getElementSelectStatus(){
        var $select = document.createElement('select');
        $select.name = "selectStatus";
        $select.class = parameters.selectClassStatus;
        $select.className = parameters.selectClassStatus;
        $select.classList = parameters.selectClassStatus;
        $select.onchange = function(){selectChangeStatus($(this));};
        for(var i = 0; i < parameters.optionsStatus.length; i++){
            var $option = document.createElement('option');
            $option.value = parameters.optionsStatus[i].text;
            $option.text = parameters.optionsStatus[i].text + " ";
            $option.label = parameters.optionsStatus[i].text + " ";
            $option.selected = (parameters.optionsStatus[i].text === "online")? true : false;
            $($option).append(getIcon(parameters.optionsStatus[i].text));
            $($select).append($option);
        }
        return $select;
    }


    /**
     * 
     * @param {String} status
     * @returns {chat_init.getIcon.$i} elemento i icone
     */
    function getIcon(status){
        var $i = document.createElement("i");
        $i.nodeName = "I";
        $i.name = "i";
        for(var i = 0; i < parameters.optionsStatus.length; i++){
            if(status === parameters.optionsStatus[i].text){
                $i.class = parameters.optionsStatus[i].icon;
                $i.className = parameters.optionsStatus[i].icon;
                $i.classList = parameters.optionsStatus[i].icon;
                $i.style.color = parameters.optionsStatus[i].color;
                $i.title=parameters.optionsStatus[i].text;
                break;
            }
        }
        return $i;
    }
    
    
    /**
     * Retorna a janela do chat
     * @returns {chat_init.__constructWindow.$window}
     */
    function __constructWindow(){
        var $window = document.createElement('div');
        $window.class = parameters.windowClass.panel;
        $window.className = parameters.windowClass.panel;
        $window.classList = parameters.windowClass.panel;
        $window.style.zIndex = "999";
        $window.style.position = "absolute";
        $window.style.float = "right";
        $window.style.width = "300px";
        $window.style.margin = "10px";
        $window.style.right = "2px";
        $window.style.bottom = "2px";
        
        return $window;
    }
    
    /**
     * Retorna o cabeçalho da janela do chat
     * @returns {chat_init.__constructHeader.$windowHeader}
     */
    function __constructHeader(){
        var $windowHeader = document.createElement('div');
        $windowHeader.class = parameters.windowClass.header;
        $windowHeader.className = parameters.windowClass.header;
        $windowHeader.classList = parameters.windowClass.header;
        $windowHeader.style.textOverflow = "ellipsis";
        return $windowHeader;
    }
    
    /**
     * Retorna o item com titulo da janela chat
     * @param {Objeto} obj com dados do usuario to send
     * @returns {chat_init.__constructTitle.$title}
     */
    function __constructTitle(obj){
        var $title = document.createElement('h3');
        $title.class = parameters.windowClass.title;
        $title.className = parameters.windowClass.title;
        $title.classList = parameters.windowClass.title;
        $title.text = (obj.nick !== "") ? obj.nick + " - " + obj.nome : obj.nome;
        $title.innerText = (obj.nick !== "" && obj.nick !== null) ? obj.nick + " - " + obj.nome : obj.nome;
        $title.innerText = (obj.nick !== "" && obj.nick !== null) ? obj.nick + " - " + obj.nome : obj.nome;
        $title.style.width = "250px"; 
        $title.style.textOverflow = "ellipsis"; 
        $title.style.whiteSpace = "nowrap"; 
        $title.style.overflow = "hidden";
        $title.style.textAlign = "left";
        return $title;
    }
    
    /***
     * Retorna o corpo do chat
     * @returns {chat_init.__constructBody.$windowBody}
     */
    function __constructBody(){
        var $windowBody = document.createElement('div');
        $windowBody.class = parameters.windowClass.body;
        $windowBody.className = parameters.windowClass.body;
        $windowBody.classList = parameters.windowClass.body;
        $windowBody.style.overflowY  = "auto";
        $windowBody.style.overflowX  = "hidden";
        $windowBody.style.height  = "270px";
        return $windowBody;
    }
    
    /**
     * Retorna o footer da janela do chat
     * @returns {chat_init.__constructFooter.$windowFooter}
     */
    function __constructFooter(){
        var $windowFooter = document.createElement('div');
        $windowFooter.class = parameters.windowClass.footer;
        $windowFooter.className = parameters.windowClass.footer;
        $windowFooter.classList = parameters.windowClass.footer;
        $windowFooter.style.padding = "0px";
        $windowFooter.style.height = "90px";
        return $windowFooter;
    }
    
    /***
     * Retorna o formluario de envio de mensagem
     * @param {Objeto} obj Objeto com os dados do user
     * @returns {chat_init.__constructFormSend.$form}
     */
    function __constructFormSend(obj){
        var $form = document.createElement('form');
        $form.name = "sendMsg";
        $form.onsubmit = function(){submitSendMsg(obj);return false;};
        return $form;
    }
    
    /***
     * Retorna o text area, onde sera enviada a mensagem
     * @param {Objeto} obj Dados do usuario
     * @returns {chat_init.__constructTextArea.$textarea}
     */
    function __constructTextArea(obj){
        var $textarea = document.createElement('textarea');
        $textarea.onkeyup = function(){if((window.event.keyCode)=== 13){$(this).parents('form').submit();return false;}};
        $textarea.required = "required";
        $textarea.name = "msg";
        $textarea.cols = "10";
        $textarea.rows = "3";
        $textarea.style.position = "absolute";
        $textarea.style.width = "70%";
        $textarea.style.height = "75px";
        $textarea.style.left = "0px";
        $textarea.style.resize = "none";
        $textarea.style.border = "none";
        $textarea.style.backgroundColor = "#f5f5f5";
        $textarea.style.outline = "none";
        $textarea.style.padding = "7px";
        return $textarea;
    }
        
    /***
     * Botão para fechar janela do chat
     * @param {Objeto} obj com os dados do user
     * @returns {chat_init.__constructIconClose.$iconClose}
     */    
    function __constructIconClose(obj){
        var $iconClose = document.createElement('i');
        $iconClose.class = parameters.windowClass.close;
        $iconClose.className = parameters.windowClass.close;
        $iconClose.classList = parameters.windowClass.close;
        $iconClose.title = "Fechar";
        $iconClose.style.position = "absolute";
        $iconClose.style.right = "10px";
        $iconClose.style.top = "10px";
        $iconClose.style.cursor = "pointer";
        $iconClose.onclick = function(){closeWindowChat(obj);};
        return $iconClose;
    }
    
    /**
     * Retorna o botão send do chat
     * @returns {chat_init.__constructButtonSend.$button}
     */
    function __constructButtonSend(){
        var $button = document.createElement('button');
        $button.type = "submit";
        $button.class = parameters.classButtonSend;
        $button.className = parameters.classButtonSend;
        $button.classList = parameters.classButtonSend;
        $button.title = "Enviar";
        $button.style.position = "absolute";
        $button.style.right = "0px";
        $button.style.bottom = "0px";
        $button.style.width= "30%";
        $button.style.height= "90px";
        var $iconSend = document.createElement('i');
        $iconSend.class = parameters.windowClass.iconSend;
        $iconSend.className = parameters.windowClass.iconSend;
        $iconSend.classList = parameters.windowClass.iconSend;
        $iconSend.style.color = parameters.windowClass.sendColor;
        $($button).append($iconSend);
        return $button;
        
    }

    /***
     * Retorna a div com texto para ser inserida ao chat
     * @param {Objeto} message Objeto com os valores de data da e mensagem
     * @param {bool} send valor true indicado para uma msm enviada(send) e false para recebida(receive)
     * @returns {chat_init.getLebaleMsg.$div}
     */
    function getLabelMsg(message, send){
        var $div = document.createElement('div');
        
        var $label = document.createElement('label');
        $label.innerText = message.message;
        $label.text = message.message;
        $label.style.padding = "6px";
        $label.style.wordWrap = "break-word";
        
        if(send === true){
            $label.class = parameters.labelSendClass;
            $label.classList = parameters.labelSendClass;
            $label.className = parameters.labelSendClass;
            $label.style.color = parameters.labelSendColor;
            $div.style.textAlign  = "left";
            $label.style.borderRadius = "0px 10px 10px 10px";
        }else{
            $label.class = parameters.labelReceiveClass;
            $label.classList = parameters.labelReceiveClass;
            $label.className = parameters.labelReceiveClass;
            $label.style.color = parameters.labelReceiveColor;
            $div.style.textAlign  = "right";
            $label.style.borderRadius = "10px 0px 10px 10px";
            
        }
        $($div).append($label);
        return $div;
    }
    
    /**
     * Função para preenchimento da data de envio da mesnagem
     * @param {Objeto} message objeto da mensagem
     * @param {bool} send bool true or false, se é msg recebida ou enviada
     * @returns {chat_init.dateMsg.$divDate} elemento div com o dados
     */
    function dateMsg(message, send){
        var $divDate = document.createElement('div');
        
        $divDate.innerText = message.data + " ";
        $divDate.text = message.data + " ";
        $divDate.style.fontSize = "0.8em";
        $divDate.style.marginBottom = "10px";
        
        if(send === true){
            $divDate.style.textAlign  = "left";
        }else{
            $divDate.style.textAlign  = "right";
        }
        
        return $divDate;
    }
    
    /***
     * Cria o icone de Lido na caixa de mensagens
     * @returns {chat_init.iconRead.$i} Elemento i (icone)
     */
    function iconRead(){
        var $i  = document.createElement('i');
        $i.class  = parameters.iconRead;
        $i.classList  = parameters.iconRead;
        $i.className = parameters.iconRead;
        $i.style.color = parameters.iconReadColor;
        return $i;
    }
    
    /***
     * Monta o menu com todos os usuários online offline e ou ocupados.
     * @returns {undefined}
     */
    function showMenuContatos(){
        try{
            var  $div = document.createElement('div');
            $($div).addClass(parameters.class);
            var  $ul = document.createElement('ul');

            controleUsers.forEach(function(user){
                if(parseInt(user.userId) !== parseInt(parameters.userId)){
                    var $divContentButton = document.createElement('div');
                    $divContentButton.style.textOverflow = "ellipsis";
                    $($divContentButton).append(user.button);
                    $($divContentButton).append(user.i);
                    var  $li = document.createElement('li');
                    $($li).append($divContentButton);
                    $($ul).append($li);
                }
            });

            $($div).append($ul);
            var $innerMenu = $("#"+parameters.innerDivMenuVideoContatos);
            $($innerMenu).html(''/*getElementSelectStatus()*/);
            $($innerMenu).append($div).fadeIn();
            $($innerMenu).addClass(parameters.class);
        }catch(msg){
            console.log(msg);
        }
    }
    
    /***
     * Cria a div de localvideo 
     */
    function getLocalVideo(){
        var $video = document.createElement('video');
        $video.autoplay = true;
        $video.muted = true;
        $video.id = "localVideo";
        $video.style.width = "300px";
        $video.style.height = "225px";
        $video.style.position = "absolute";
        $video.style.top = "10px";
        $video.style.left = "10px";
        $video.style.zIndex = "1";
        $video.style.border = "1px solid #FFF"
        return  $video;
    }
    
    
    /***
     * Cria a div de video 
     */
    function getRemoteVideo(){
        var $video = document.createElement('video');
        $video.autoplay = true;
        $video.id = "remoteVideo";
        $video.style.width = "100%";
        $video.style.height = "100%";
        $video.style.position = "absolute";
        $video.style.top = "0px";
        $video.style.left = "0px";
        $video.style.zIndex = "0";
        return  $video;
    }
    
    
    /**
     * @param {Objeto} data Valores com os dados do usuario a ser chamado
     * @return {$div} Div modal para inserção dos elementos de video conferencia
     */
    function __getWindowCall(){
        var $div = document.createElement('div');
        $div.style.position = "fixed";
        $div.style.backgroundColor = "rgba(0,0,0,0.31)";
        $div.style.right = "0px";
        $div.style.top = "0px";
        $div.style.width = "100%";
        $div.style.height = "100%";
        $div.style.zIndex = "9999";
        $div.id = parameters.divModalVideoConf;
        return $div;
    }
    
    
    
    /***
     * Função retorna elemento com som de chamada.
     * @return {Elemento} Elemento de audio contendo o som de chamada
     */
    function __getSomChamada(){
        var $audio = document.createElement('audio');
            $audio.autoplay = true;
            $audio.loop = true;
            $audio.style.display = "none";
        var $source = document.createElement('source');
            $source.src = parameters.sound_video_call;
            $source.type = "audio/mp3";
        $($audio).append($source);
        return $audio;
    }
    
    /***
     * Função retorna elemento com som de chamada.
     * @return {Elemento} Elemento de audio contendo o som de chamada
     */
    function __getSomMensagem(){
        var $audio = document.createElement('audio');
            $audio.autoplay = true;
            $audio.loop = false;
            $audio.style.display = "none";
        var $source = document.createElement('source');
            $source.src = parameters.sound_mensagem;
            $source.type = "audio/mp3";
        $($audio).append($source);
        return $audio;
    }
    
    
    /**
     * @param {Objeto} data Valores do usuario a ser chamado
     * @return {$iClose} Div modal para inserção dos elementos de video conferencia
     */
    function __getCloseWindowCall(data){
        var $iClose = document.createElement('i');
        $iClose.style.position = "absolute";
        $iClose.style.right = "25px";
        $iClose.style.top = "10px";
        $iClose.style.cursor = "pointer";
        $iClose.class = parameters.icons.close;
        $iClose.className = parameters.icons.close;
        $iClose.classList = parameters.icons.close;
        $iClose.style.zIndex = "99999";
        $iClose.onclick = function(){closeModalVideo(data);};
        $iClose.onmouseover = function(){$(this).css({color: "#FF4222"})};
        $iClose.onmouseout = function(){$(this).css({color: "#000"})};
        $iClose.title = "Fechar vídeo conferência";
        return $iClose;
    }
    
    /***
     * @param {data} data Valores do usuario a ser chamado
     * @param {String} tipo Valores se esta 'recebendo' ou 'chamando' a video conferencia
     * @return {$div} Elemento div
     * 
     */
    function __getContentWindowCall(data, tipo){
        var $divCenter = document.createElement('div');
        $divCenter.style.position = "relative";
        $divCenter.style.width = "30%";
        $divCenter.style.height = "auto";
        $divCenter.style.margin = "0px auto";
        $divCenter.style.top = "calc(50% - 100px)";
        $divCenter.style.textAlign = "center";
        
        var $divText = document.createElement('div');
        var to = (data.nick !== "" && data.nick !== null) ? data.nick + " - " + data.nome : data.nome ;
        if(tipo === "recebendo"){
            $divText.innerText = "Recebendo chamada de vídeo conferência de\n" + to;
            $divText.text = "Recebendo chamada de vídeo conferência de\n" + to;
        }else{
            $divText.innerText = "Realizando chamada de vídeo conferência com\n" + to;
            $divText.text = "Realizando chamada de vídeo conferência com\n" + to;
        }
        $divText.style.color = "#FFF";
        $divText.style.fontFamily = "sans-serif";
        $divText.style.fontSize = "17px";
        
        $($divCenter).append($divText);
        
        return $divCenter;
    }
   
    /**
     * get do elemento call 
     * @param {Objeto} data Objeto com valores do users to call
     * @return {Elemento $i} elemento $i com icone de ligação
     */
    function getElemCall(data){
        var $i = document.createElement('i');
        $i.class = parameters.icons.call;
        $i.className = parameters.icons.call;
        $i.classList = parameters.icons.call;
        $i.style.color = parameters.icons.callColor;
        $i.style.margin = "10px";
        $i.style.padding = "10px";
        $i.style.cursor = "pointer";
        $i.title = "Realizar vídeo conferência";
        $i.onclick = function(){
           aceitaChamada(data);
        };
        $i.onmouseover = function(){$(this).css({color: parameters.icons.callColorHover});};
        $i.onmouseout = function(){$(this).css({color: parameters.icons.callColor});};
        return $i;
    }
    
    
    /**
     * get do elemento call 
     * @param {Objeto} data Objeto com valores do users to call
     * @return {Elemento $i} elemento $i com icone de ligação
     */
    function getElemCloseCall(data){
        var $i = document.createElement('i');
        $i.class = parameters.icons.call;
        $i.className = parameters.icons.call;
        $i.classList = parameters.icons.call;
        $i.style.color = parameters.icons.closeCallColor;
        $i.style.margin = "10px";
        $i.style.padding = "10px";
        $i.style.cursor = "pointer";
        $i.title = "Desligar chamada de vídeo conferência";
        $i.onclick = function(){
            desligar(data);
        };
        $i.onmouseover = function(){$(this).css({color: parameters.icons.closeCallColorHover});};
        $i.onmouseout = function(){$(this).css({color: parameters.icons.closeCallColor});};
        return $i;
    }
    
    /**
     * get do elemento spin de realizando video conferencia 
     * @param {Objeto} data Objeto com valores do users to call
     * @return {Elemento $i} elemento $i com icone de spin de ligação
     */
    function getElemSpinCall(){
        var $i = document.createElement('i');
        $i.class = parameters.icons.spinCall;
        $i.className = parameters.icons.spinCall;
        $i.classList = parameters.icons.spinCall;
        $i.style.color = parameters.icons.spinColor;
        $i.style.margin = "10px";
        $i.style.padding = "10px";
        $i.style.cursor = "pointer";
        $i.title = "Realizando pedido de vídeo conferência";
        return $i;
    }
    
    /**
     * @return {$i} Elementi i
     */
    function getLittleSpin(){
        var $i = document.createElement('i');
        $i.class = parameters.icons.spinLitle;
        $i.className = parameters.icons.spinLitle;
        $i.classList = parameters.icons.spinLitle;
        $i.style.color = parameters.icons.spinLitleColor;
        $i.style.margin = "2px";
        $i.style.padding = "2px";
        $i.style.cursor = "pointer";
        $i.title = "Recebendo pedido de vídeo conferência";
        return $i;
    }
    
    /**
     * Esta função criar a div que conterá as janelas do chat insirira na DOM
     * @param {data} data Objeto com valores do usuario
     */
    function receiveCall(data){
        var $div = document.createElement('div');
        $div.style.position = "fixed";
        $div.style.backgroundColor = "rgba(0,0,0,0.31)";
        $div.style.right = "0px";
        $div.style.top = "0px";
        $div.style.width = "100%";
        $div.style.height = "100%";
        $div.style.zIndex = "9999";
        $div.id = parameters.divModalVideoConf;
        
        controleUsers[data.userId].modal.window = $div;
        
        var $divClose = document.createElement('div');
        $divClose.style.position = "absolute";
        $divClose.style.right = "25px";
        $divClose.style.top = "10px";
        $divClose.style.cursor = "pointer";
        $divClose.class = parameters.icons.close;
        $divClose.className = parameters.icons.close;
        $divClose.classList = parameters.icons.close;
        $div.style.zIndex = "99999";
        $divClose.onclick = function(){closeModalVideo(data);};
        $divClose.title = "Fechar vídeo conferência";
        
        controleUsers[data.userId].modal.close = $divClose;
        $(controleUsers[data.userId].modal.window).append(controleUsers[data.userId].modal.close);
    }
    
    /***
     * Cria o button de expansão || retração da janela de video conferencia
     */
    function getButtonFullscreem(){
        var $button = document.createElement('button');
            $button.style.position = "absolute";
            $button.style.left = "10px";
            $button.style.bottom = "100px";
            $button.style.borderRadius = "30px";
            $button.style.width = "35px";
            $button.style.height = "35px";
            $button.class = parameters.button.size+" btnFullscream";
            $button.className = parameters.button.size+" btnFullscream";
            $button.classList = parameters.button.size+" btnFullscream";
            $button.title = "Expandir | Retrair";
            $button.onclick = function(){requestFullScreem();};
        var $i = document.createElement('i');
            $i.class = parameters.icons.fullscreem;
            $i.className = parameters.icons.fullscreem;
            $i.classList = parameters.icons.fullscreem;
            $($button).append($i);
    
        return $button;
    }
    
    
    /***
     * get o button de liga e desliga som da video conferência
     */
    function getMicrofone(){
        var $button = document.createElement('button');
            $button.style.position = "absolute";
            $button.style.left = "10px";
            $button.style.bottom = "20px";
            $button.style.borderRadius = "30px";
            $button.style.width = "35px";
            $button.style.height = "35px";
            $button.class = parameters.button.size+" btnMicrofone";
            $button.className = parameters.button.size+" btnMicrofone";
            $button.classList = parameters.button.size+" btnMicrofone";
            $button.title = "Ativar Microfone | Destativar Microfone";
            $button.onclick = function(){activeDesactiveMicrofone($(this));};
            $($button).append(getIconMicrofoneOn());
        return $button;
    }
    
    
    
    /**
     * get o item de microfone on
     */
    function getIconMicrofoneOn(){
        var $i = document.createElement('i');
            $i.class = parameters.icons.microfone_on;
            $i.className = parameters.icons.microfone_on;
            $i.classList = parameters.icons.microfone_on;
        return $i;
    }
    
    /**
     * get o item de microfone off
     */
    function getIconMicrofoneOff(){
        var $i = document.createElement('i');
            $i.class = parameters.icons.microfone_off;
            $i.className = parameters.icons.microfone_off;
            $i.classList = parameters.icons.microfone_off;
        return $i;
    }
    
    /***
     * get o button que inicia o chat text
     * @param {Objeto} data Objeto com valores do Usuario a ser criado o chat em texto
     * @return {Elemento} Button para iniciar chat texto
     */
    function getButtonChatInit(data){
        var $button = document.createElement('button');
            $button.style.position = "absolute";
            $button.style.left = "10px";
            $button.style.bottom = "60px";
            $button.style.borderRadius = "30px";
            $button.style.width = "35px";
            $button.style.height = "35px";
            $button.class = parameters.button.size+" btnChat";
            $button.className = parameters.button.size+" btnChat";
            $button.classList = parameters.button.size+" btnChat";
            $button.title = "Abrir Chat";
            $button.onclick = function(){buttonClickInitChat(data);};
        var $i = document.createElement('i');
            $i.class = parameters.icons.activeChatBtn;
            $i.className = parameters.icons.activeChatBtn;
            $i.classList = parameters.icons.activeChatBtn;
            $($button).append($i);
            $($button).append(data.badge);   
         
        return $button;
    }
            
    /**
     * Criar uma div para inserir o texto de erro
     * @param {String} msg -> mensagem de erro
     * @returns {undefined}
     */
    function alertOnError(msg){
        try{
            var $div = document.createElement('div');
            $div.class = parameters.errorClass;
            $div.className = parameters.errorClass;
            $div.classList = parameters.errorClass;
            var $p = document.createElement('p');
            $p.innerText = msg;
            $p.text = msg;
            $($div).append($p);
            $('body').append($div).fadeIn();
            setTimeout(closeAlertError, parameters.setTimeOut, $div);
        }catch(msg){
            console.log(msg);
        }
    }
    
    /**
     * Função para fechamento de acordo com time out o fechamento da div com erro
     * @param {elemento} $div
     * @returns {undefined}
     */
    function closeAlertError($div){
        $($div).remove();
    }
    
    
    /****
     * Aqui conexao com o websockte, função derivada de autobahn.js
     * @objeto ab.Session
     */
    var conn = new ab.Session(parameters.ws,
        function(){
            conn.subscribe('online', callbacks);
            conn.subscribe('desconectar', callbacks);
            conn.subscribe('conectar', callbacks);
            conn.subscribe('changeStatus', callbacks);
            conn.subscribe('onError', callbacks);
            conn.subscribe('message', callbacks);
            conn.subscribe('readMessage', callbacks);
            conn.subscribe('chanelComunicVideo', callbacks);
            conn.subscribe('sendIceCandidate', callbacks);
            conn.publish('online', getDadosUser());
            console.log("CONECTAD0");
        },
        function(){
            console.warn('DESCONECTADO');
        },
        {'skipSubprotocolCheck': false}
    );
    
    //return this;
}


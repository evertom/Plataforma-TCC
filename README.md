# INSTRUÇÕES DE INSTALAÇÃO DO AMBIENTE DE PRODUÇÃO DA PLATAFORMA TCC

*   O ambiente desta máquina virtual esta totalmente pronto para uso, porém segue a descrição passo a passo de como foi configurada.
*   Antes de tudo, abriremos o terminal **shell** e faremos a atualização dos pacotes para instalações através do comando **sudo apt-get update**. Ele pedirá a senha de usuário root, coloque **'ifsp'** sem aspas.


## Configurações e instalações para ambiente de produção

### Apache2

**sudo apt-get install apache2**

### MySQL 5.*

**sudo apt-get install mysql-server php5-mysql**

Agora instalaremos um conjunto instruções para o mysql, a primeira instrução irá criar a estrutura de diretório do banco de dados, logo depois a segunda instrução irá dar um pouco mais de segurança ao banco de dados.

**sudo mysql_install_db**

**sudo mysql_secure_installation**

### PHP 5.6.*

**sudo apt-get install php5 libapache2-mod-php5 php5-mcrypt**

Após a instalação temos algumas configurações a serem mudadas no apche2

*   Vamos dizer ao apche2 para dar preferência de leitura ao arquivo index.php antes do arquivo index.html

Para isso basta abrir o arquivo de configuração em **sudo nano /etc/apache2/mods-enabled/dir.conf**

O arquivo deve estar assim:

`<ifmodule mod_dir.c="">`
	`DirectoryIndex index.html index.cgi index.pl **index.php** index.xhtml index.htm`
`</ifmodule>`

E passará a ficar assim:

`<ifmodule mod_dir.c="">`
	`DirectoryIndex **index.php** index.html index.cgi index.pl index.xhtml index.htm`
`</ifmodule>`

Perceba que o DirectoryIndex passa a dar prioridade ao arquivo index.php.

Grave as mudanças e saia do arquivo, logo depois restart o apache2 com o camando **sudo service apache2 restart**

### Môdulo PHP-CLI

Agora vamos instalar o modulo php-cli, com ele é possível executar páginas diretamente, sem a necessidade do apache. Será usado no websocket para chat e vídeo conferência.

Digite o camando **sudo apt-get install php5-cli** e pronto môdulo instalado.

### Ativar MOD REWRITE (URL Amigavéis)

Basta executar o camando **sudo a2enmod rewrite**

Logo após restart o apache2 novamente **sudo service apache2 restart**

### PHPMYADMIN

Para podermos importar o banco de dados precisaremos do phpMyAdmin, para tanto execute no shell **sudo apt-get install phpmyadmin**.

Durante a instalação algumas alterantivas surgiram, escolha como servidor o apache2, como senha e login 'root', sem aspas.

Abra o arquivo **sudo nano /etc/apache2/apache2.conf** Inclua a linha **Include /etc/phpmyadmin/apache.conf**, salve e feche o arquivo, agora restart o apache2 **sudo service apache2 restart**.

### Pronto!!! Ambiente ok, vamos a aplicação Plataforma TCC agora.


#### O primeiro passo é entrar no _github_ e baixar a aplicação.

Acesse [**https://github.com/evertonpaula/Plataforma-TCC.git**](https://github.com/evertonpaula/Plataforma-TCC.git) e faço o download no botão _**Download ZIP**_.

#### Instalando Plataforma TCC

O arquivo zip baixado do github deve estar na pasta download do usuário, o processo agora é desconpactar, mover e renomear a pasta que contem os arquivos fontes.

Agora vamos descompactar o arquivo .zip **sudo unzip /home/plataformatcc/Downloads/Plataforma-TCC-master.zip**

Para mover e renomear o arquivo execute o seguinte comando **sudo mv /home/plataformatcc/Plataforma-TCC-master /var/www/html/Plataforma-TCC**

#### Instalando Banco de dados

O primeiro passo para instalação do banco de dados é abrir o **phpmyadmin**, acesse no browser [**_localhost/phpmyadmin/_**](http://localhost/phpmyadmin/) e coloque a senha e usuário de acesso que configuramos na instalação, _root root_

Após acessar a página de administração do phpmyadmin, clique na aba **imports** e selecione o arquivo **tcc-update.sql** que esta localizado dentro da pasta do projeto, **/var/www/html/Plataforma-TCC/admin/bd/tcc-update.sql**

Clique em importar e pronto, o banco de dados já esta instalado e a base de informações já inserida.

Para todos os efeitos é melhor conferir a classe de conexao, execute o seguinte comando: **sudo nano /var/www/html/Plataforma-TCC/admin/include/Conexao.class.php**

Verifique na `public function conecatar(){}` se a variável **$pass** e **$user** estão corretas, ambas deve ter valor de root, valores que foram salvos na instalação do banco de dados.

Faça o mesmo procedimento na classe Conexao localizada em **sudo nano /var/www/html/Plataforma-TCC/class/Conexao.class.php**

#### CHAT E VÍDEO CONFÊRENCIA

Para a aplicação de chat e vídeo conferência funcione, precisamos criar dois serviços **websocket**.

Para isso existem dois scripts prontos em php para inicialização do serviço.

Em dois shell seprados execute os seguintes comandos um em cada shell aberto:

**php /var/www/html/Plataforma-TCC/admin/bin/chat-server.php**

**php /var/www/html/Plataforma-TCC/admin/bin/video-server.php**

Em ambos shell você notará que o serviços estaram rodando, eles exibem informações de conexões de usuários, bem como, as trocas de mensagens entre eles

Para pará-los aparte _Ctrl+C_


### Pronto acesse o sistema pelo browser [localhost/Plataforma-TCC](http://localhost/Plataforma-TCC) e o veja funcionando.


##### IFSP-BRA

Trabalho de conclusão de curso: Plataforma TCC

Ana Carolina Bianchi

Everton José de Paula

Leonardo Bueno Martins

Orientadora Dra. Ana Paula M. Giancolli

Bragança Paulista, 2016


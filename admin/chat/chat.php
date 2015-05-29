
<div id="nomeperfil">Messenger</div>
<hr/>
<div id="contatos">
<span class="online" id="<?php echo $_SESSION['id_login'];?>"></span>
	
	<div id="frases">
	<?php	
		require_once('includes/Conexao.class.php');
					
		$pdo = new Conexao(); 
		$resultado = $pdo->select("SELECT * FROM users WHERE uid != ".$_SESSION['id_login']." ORDER BY horario DESC");
		$pdo->desconectar();
		
		date_default_timezone_set('America/Sao_Paulo');
		//$nowHora = date('Y-m-d H:i:s');
	
		if(count($resultado)){
			foreach ($resultado as $res) {
				$nowHora = date('Y-m-d H:i:s');
				
		?>
		<p lang="<?php echo $res['uid'];?>">
			<span class="type" id="<?php echo $res['uid'];?>"></span>
			
			<?php
				if(strlen($res['username']) > 19){
					$nome = substr($res['username'], 0, 19)."...";
				}else{
					$nome = $res['username'];
				}
			?>
			
			<a href="javascript:void(0);" nome="<?php echo  $res['username'];?>" id="<?php echo  $res['uid'];?>" class="comecar <?php

			if(strtotime($nowHora) >= strtotime($res['horario']) && strtotime($nowHora) <= strtotime($res['limite'])){
				echo "verdeUser";
			}else{
				echo "ofUser";
			} 
			?>">
			<?php 
			if(strtotime($nowHora) >= strtotime($res['horario']) && strtotime($nowHora) <= strtotime($res['limite'])){
				echo $nome." <img src='img/on.png'/>";
			}else{
				echo $nome." <img src='img/off.png'/>";
			}?>
			</a>
		</p>
		<?php
			}			
		}
		?>
	</div>
	<hr/>
</div>
<table width="90%" align="center" style="border: solid gray 1px; border-collapse: collapse;">
	<tr>
		<th>id</th>
		<th>Categoria</th>
		<th>Titulo</th>
		<th>Contenido</th>
		<th>Fecha de captura</th>
		<th>Opciones</th>	
	</tr>
	<?php
	if(is_array($data)){
		foreach($data as $key => $value){
				echo "<tr>";
				$data_print = '';
			foreach ($value as $key2 => $text) {
				if($key2=='id'){
					$options = '<td width="25%">
									<center>
									<div class="btn-group">
								  		<button type="button" class="btn btn-primary upd_content" data-category="'.$value->category.'" data-title="'.$value->title.'" data-content="'.$value->content.'" data-value="'.$text.'" data-toggle="modal" data-target="#myModal">Actualizar Registro</button>
								  		<button type="button" class="btn btn-danger del_content" data-value="'.$text.'">Borrar registro</button>
								  	</div>
								  	</center>
								</td>';
				}
				switch ($key2) {
					case 'category':
						$style = "10%";
						break;
					case 'title':
						$style = "15%";
						break;
					case 'created_at':
						$style = "15%";
						break;
					case 'content':
						$style = "35%";
						break;
					default:
						$style = "2%";
						break;
				}

				if($key2=='category' || $key2=='title' || $key2=='content' || $key2=='created_at' || $key2=='id')
				$data_print.= "<td width='".$style."'>".$text."</td>";
			}
			echo $data_print.$options;
			echo "</tr>";
		}
	}else{
		echo "<tr><td colspan ='6'><center><h4>$data</h4></center></td></tr>";
	}
	?>
</table>
<!-- MODAL PARA AGREGAR REGISTROS DE BLOG -->
<div class="modal fade inmodal" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
				<h1>Agregar contenido al blog</h1>
			</div>
			<div class="modal-body">
				<form role="form">
					<div class="form-group" style="display:none">
						<label>id_blog: </label>
						<input id="id_blog_content" name="id_blog_content" type="text" value="0"  class="form-control">
					</div>
					<div class="form-group">
						<label>Categoria: </label>
						<input id="categoria" name="categoria" type="text"  class="form-control">
					</div>
					<div class="form-group">
						<label>Titulo: </label>
						<input id="titulo" name="titulo" type="text" class="form-control">
					</div>
					<label>Contenido:</label>
					<textarea class="form-control" id="contenido" name="contenido" cols="50" rows="10"></textarea>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
				<button type="button" class="btn btn-primary" id="save_new_content">Guardar</button>
			</div>
		</div>
	</div>
</div>

<div class="col-lg-12">
	<div class="col-lg-1"></div>
	<div class="col-lg-12">
		<div class="row">
			<div class="col-lg-11">
				<h2>Bienvenido <?php echo $info['usuario']; ?></h2>
			</div>
			<div class="col-lg-1">
				<h2><a href="<?php echo base_url(); ?>login">Salir</a></h2>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<h4>Listado del contenido de blog</h4>
				<span class="new_content">
					<a href="#" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Agregar contenido</a>
				</span>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<hr /><br />
				<div id="blog-content-data"></div>
			</div>
		</div>
	</div>
	<div class="col-lg-1"></div>
</div>

<script type="text/javascript">
	
	$(document).ready(function() {
		obtenRegistroBlogs();
	});

	$(document).on('click', '#save_new_content', function(event) {
		event.preventDefault ? event.preventDefault() : event.returnValue = false;
		var valida = jsValidaForm();
		if(valida == 1){
			alert('Ingresa todos los campos');
			return false;
		}
		if(parseInt( $('#id_blog_content').val() )==0)
		{
			var url = "<?php echo base_url(); ?>blog/add_blog_content";
		}else{
			var url = "<?php echo base_url(); ?>blog/update_blog_content";
		}
		$.ajax({
		      url: url,
		      method: "POST",
		      data:{
		      	usuario	 			: '<?php echo $info['usuario']; ?>',
		        password 			: '<?php echo $info['password']; ?>',
		        category 			: $('#categoria').val(),
		        title	 			: $('#titulo').val(), 
		        content  			: $('#contenido').val(),
		        blog_content_id 	: $('#id_blog_content').val()
		      }
		})
		.done(function( msg ) {
		    if( msg == 'Regristro agregado exitosamente' || msg == 'Regristro actualizado exitosamente' ){
		    	$('#myModal').modal('hide')
		    	obtenRegistroBlogs();
		    }
		});
	});

	$(document).on('click', '.upd_content', function(event) {	
		$('#categoria').val($(this).attr("data-category"));
		$('#titulo').val($(this).attr("data-title"));
		$('#contenido').val($(this).attr("data-content"));
		$('#id_blog_content').val($(this).attr("data-value"));
	});

	$(document).on('click', '.new_content', function(event) {	
		$('#categoria').val('');
		$('#titulo').val('');
		$('#contenido').val('');
		$('#id_blog_content').val(0);
	});

	$(document).on('click', '.del_content', function(event) {
		event.preventDefault ? event.preventDefault() : event.returnValue = false;
		if(confirm('¿Estas seguro que deseas borrar el registro?'))
		{		
			$.ajax({
			      url: "<?php echo base_url(); ?>blog/delete_blog_content",
			      method: "POST",
			      data:{
			        blog_content_id : $(this).attr("data-value")
			      }
			})
			.done(function( msg ) {
				alert(msg);
			    if( msg == 'Regristro borrado exitosamente' ){
			    	obtenRegistroBlogs();
			    }
			});
		}
	});

	function obtenRegistroBlogs()
	{
		$( "#blog-content-data" ).load( "<?php echo base_url(); ?>blog/get_blog_content" );
	}

	function jsValidaForm(){

		var retorno = 0;

		if($('#categoria').val()=='' || $('#titulo').val()=='' || $('#contenido').val()==''){
			retorno = 1;
		}

		return retorno;
	}

</script>
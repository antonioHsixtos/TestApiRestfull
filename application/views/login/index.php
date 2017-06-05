<div class="col-lg-12">
<div class="col-lg-6">
	<div class="col-lg-1"></div>
	<div class="col-lg-10">
		<div class="col-lg-12">
			<h2>Login de Blog</h2>
			<div class="form-group">	
				<label>Usuario:</label>
				<input type="text" class="form-control" id="usuario_i" placeholder="Ingresa tu usuario" />
			</div>
			<div class="form-group">
				<label>Password:</label>
				<input type="password" class="form-control" id="password_i" placeholder="Ingresa tu password" />
			</div>
			<div class="form-group">
				<button type="button" class="btn btn-success" id="ingresar">Ingresar</button>
			</div>
		</div>
	</div>
	<div class="col-lg-1"></div>
</div>
<div class="col-lg-6">
	<div class="col-lg-1"></div>
	<div class="col-lg-10">
		<div class="col-lg-12">
			<h2>¿Aun no tienes usuario? Registrate</h2>
			<div class="form-group">	
				<label>Usuario:</label>
				<input type="text" class="form-control" id="usuario_r" placeholder="Ingresa tu usuario" />
			</div>
			<div class="form-group">
				<label>Password:</label>
				<input type="password" class="form-control" id="password_r" placeholder="Ingresa tu password" />
			</div>
			<div class="form-group">
				<button type="button" class="btn btn-primary" id="registrarse">Registrarse</button>
			</div>
		</div>
	</div>
	<div class="col-lg-1"></div>
</div>
</div>
<script type="text/javascript">
	$(document).on('click', '#ingresar', function(event) {
		event.preventDefault ? event.preventDefault() : event.returnValue = false;
		var valida = jsValidaForm('i');
		if(valida == 1){
			alert('Ingresa todos los campos');
			return false;
		}
		$.ajax({
		      url: "<?php echo base_url(); ?>login/sign_in",
		      method: "POST",
		      data:{
		      	usuario	 : $('#usuario_i').val(),
		        password : $('#password_i').val()
		      }
		})
		.done(function( msg ) {
		    if( msg == 'Ingresando...' ){
		    	window.location.replace('<?php echo base_url(); ?>blog/main/'+$('#usuario_i').val()+'/'+$('#password_i').val())
		    }
		});
	});

	$(document).on('click', '#registrarse', function(event) {
		event.preventDefault ? event.preventDefault() : event.returnValue = false;
		var valida = jsValidaForm('r');
		if(valida == 1){
			alert('Ingresa todos los campos');
			return false;
		}
		$.ajax({
		      url: "<?php echo base_url(); ?>login/sign_up",
		      method: "POST",
		      data:{
		      	usuario	 : $('#usuario_r').val(),
		        password : $('#password_r').val()
		      }
		})
		.done(function( msg ) {
		    alert( msg );
		    if( msg == 'Usuario agregado existosamete' ){
		    	window.location.replace('<?php echo base_url(); ?>blog/main/'+$('#usuario_r').val()+'/'+$('#password_r').val())
		    }
		});
	});

	function jsValidaForm(v){

		var retorno = 0;

		if($('#usuario_'+v).val()=='' || $('#password_'+v).val()==''){
			retorno = 1;
		}

		return retorno;
	}





</script>


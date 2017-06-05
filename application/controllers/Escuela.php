<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Escuela extends CI_CONTROLLER{

	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('Escuela_model', 'escuela');
	}

	public function metodo($alumno_id = null, $materia_id = null, $calificacion = null)
	{
		$metodo = $this->input->server('REQUEST_METHOD');
		switch ($metodo) {
			case 'GET':
				$this->get_escuela($alumno_id);
				break;
			case 'POST':
				$this->post_calificacion();
				break;
			case 'PUT':
				$this->put_escuela($alumno_id, $materia_id, $calificacion);
				break;
			case 'DELETE':
				$this->delete_escuela($alumno_id, $materia_id);
				break;
			default:
				$this->api_respuesta('Uncaught method', false, 400);
				break;
		}
	}


	public function get_escuela($alumno_id)
	{
		if( $alumno_id != null ){
			$response  = $this->escuela->obten_calificaciones($alumno_id);
			$response['promedio'] = $this->escuela->obten_promedio($alumno_id);
			$this->api_respuesta( $response , true );	
		}else{
			$this->api_respuesta( 'Ingresa alumno_id', false, 400);
		}
		
	}

	public function post_calificacion()
	{
		$this->set_datos_reglas();
		if ($this->form_validation->run()) {
			$post = $this->input->post();
			$calif = [
				'id_t_materias'  => $post['materia_id'],
				'id_t_usuarios'  => $post['alumno_id'],
				'calificacion'   => $post['calificacion'],
				'fecha_registro' => date('Y-m-d')
			];

			$this->escuela->inserta_registro('t_calificaciones', $calif);
			$this->api_respuesta('calificacion registrada', true, 201);
		} else {
			$this->api_respuesta( $this->validacion_errores(), false, 400);
		}
	}

	public function put_escuela($alumno_id, $materia_id, $calificacion)
	{
		if ($alumno_id!=null || $materia_id!=null || $calificacion!=null) {
			$post = $this->input->post();
			$data_where = [
				'id_t_materias'  	=> $materia_id,
				'id_t_usuarios'  	=> $alumno_id,
			];

			$data_upd = $calificacion;

			$this->escuela->actualiza_calificacion('t_calificaciones', $data_where, $data_upd);
			$this->api_respuesta('calificacion actualizada', true, 201);
		} else {
		 	$this->api_respuesta( $this->validacion_errores(), false, 400);
		}
	}

	public function set_datos_reglas()
	{
		$this->form_validation->set_rules('materia_id', 'materia_id', 'trim|required');
		$this->form_validation->set_rules('alumno_id', 'alumno_id', 'trim|required');
		$this->form_validation->set_rules('calificacion', 'calificacion', 'trim|required');
	}

	public function delete_escuela($alumno_id, $materia_id)
	{
		if( $alumno_id != null || $materia_id !=null ){
			$response  = $this->escuela->delete_calificaciones($alumno_id, $materia_id);
			$this->api_respuesta( 'calificacion eliminada' , true );	
		}else{
			$this->api_respuesta( 'Ingresa alumno_id o materia_id', false, 400);
		}
	}

	function api_respuesta($msg = null, $success = true, $codigo_resp = 200 )
	{
	    http_response_code( $codigo_resp );
	    header('access-control-allow-origin: *');
	    if( $success ){
	    	$resp = [ 'success' => 'ok', 'msg' => $msg ];
	    } else {
	        $resp = [ 'success' => 'error', 'msg' => $msg ];
	    }
	    header('Content-Type: application/json');
        echo json_encode( $resp ); 
	}

	public function validacion_errores()
	{
		$errors = [];
		foreach ($this->form_validation->error_array() as $key => $value) {
			$errors[] = $value;
		}
		return $errors;
	}

}
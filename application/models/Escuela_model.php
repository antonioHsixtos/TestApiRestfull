<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Escuela_model extends CI_Model {
	
	public function __construct()
	{
		parent::__construct();
	}

	public function obten_calificaciones($alumno_id)
	{
		$data = array();
		$sql = "SELECT ta.id_t_usuarios, ta.nombre, ta.ap_paterno AS apellido, tm.nombre AS materia, tc.calificacion, DATE_FORMAT(tc.fecha_registro,'%d-%m-%Y') AS fecha_registro
				FROM t_alumnos ta 
				INNER JOIN t_calificaciones tc ON tc.id_t_usuarios = ta.id_t_usuarios
				INNER JOIN t_materias tm ON tm.id_t_materias = tc.id_t_materias
				WHERE ta.id_t_usuarios = $alumno_id";
    	$query = $this->db->query($sql);
		if($query->num_rows()>0)
		{
			$data = $query->result();
		}
		return $data;
	}

	public function obten_promedio($alumno_id)
	{

		$sql = "SELECT ROUND(AVG(tc.calificacion),2) AS promedio
				FROM t_calificaciones tc 
				WHERE tc.id_t_usuarios = $alumno_id";
    	$query = $this->db->query($sql);
		$row = $query->row();
		return $row->promedio;
	}

	public function inserta_registro($table, $data)
	{
		$resp = 0;
		$query = $this->db->insert($table, $data );
		if($this->db->affected_rows()>0){
			$resp =  1;
		}
		return $resp;
	}

	public function actualiza_calificacion($table, $data_where, $data)
	{
		$res = 0;
		$this->db->where('id_t_usuarios', $data_where['id_t_usuarios']);
		$this->db->where('id_t_materias', $data_where['id_t_materias']);
		$this->db->set('calificacion', $data);
		$this->db->update('t_calificaciones');
		if($this->db->affected_rows()>0){
			$res =  1;
		}
		return $res;
	}

	public function delete_calificaciones($alumno_id, $materia_id)
	{
		$this->db->delete('t_calificaciones', array('id_t_usuarios' => $alumno_id, 'id_t_materias' => $materia_id));
	}

}
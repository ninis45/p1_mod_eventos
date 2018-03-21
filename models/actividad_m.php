<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * create sliders with swipe.js
 *
 * @author 		James Doyle (james2doyle)
 * @website		http://ohdoylerules.com/
 * @package 	PyroCMS
 * @subpackage 	Sliders
 * @copyright 	MIT
 */
class Actividad_m extends MY_Model {

	private $folder;

	public function __construct()
	{
		parent::__construct();
		$this->_table = 'default_eventos';
		
	}
	/*public function insert($input = array())
	{
		
		list($year,$month,$day)=explode('-',$input['fecha']);
		return parent::insert(array(
			'titulo'			=> $input['titulo'],
			'descripcion'	=> $input['descripcion'],
			'fecha' =>mktime(12,0,0,$month,$day,$year),
			'horario' =>$input['horario'],
			'lugar'=>$input['lugar'],
			'slug'=>$input['slug'],
			
		));
	}

	function update($id=0,$input=array()){
		
		list($year,$month,$day)=explode('-',$input['fecha']);
		return parent::update($id,array(
			'titulo'			=> $input['titulo'],
			'descripcion'	=> $input['descripcion'],
			'fecha' =>mktime(12,0,0,$month,$day,$year),
			'lugar'=>$input['lugar'],
			'slug'=>$input['slug'],
			'horario' =>$input['horario'],
			
		));
	}
   */ 
	function get_act($year,$month,$day=false){
		$base_where=array();
		if(is_numeric($day))
			$base_where['DAY(FechaInicio)']=$day;
		$actividades=$this->where('YEAR(FechaInicio)',$year)
						->where('MONTH(FechaInicio)',$month)
						->where($base_where)
						->get_all();
		return $actividades;
	}
	
	
}
?>
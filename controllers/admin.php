<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Roles controller for the groups module
 *
 * @author		Phil Sturgeon
 * @author		PyroCMS Dev Team
 * @package	 PyroCMS\Core\Modules\Groups\Controllers
 *
 */
class Admin extends Admin_Controller
{

	/**
	 * Constructor method
	 */
	protected $section = 'eventos';
	public function __construct()
	{
			parent::__construct();
			$this->load->model('actividad_m');
			$this->lang->load(array('actividad','evento'));
			$this->template->append_metadata('<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?file=api&v=3&&key=AIzaSyAHXd_wbPYIVTEtQRhFNZWp6t45UVhLncs"></script>')
                    ->set_breadcrumb('Actividades','actividad');
			$this->rules = array(
				
					array(
						'field' => 'titulo',
						'label' => 'Actividad',
						'rules' => 'trim|required'
						),
					array(
						'field' => 'descripcion',
						'label' => 'Descripcion',
						'rules' => 'trim'
						),
					array(
						'field' => 'fecha',
						'label' => 'Fecha inicio',
						'rules' => 'trim|required'
						),
     	              array(
						'field' => 'map_longitud',
						'label' => 'Longitud',
						'rules' => 'trim'
						),
                        array(
						'field' => 'map_latitud',
						'label' => 'Latitud',
						'rules' => 'trim'
						),
                        array(
						'field' => 'map_zoom',
						'label' => 'Zoom',
						'rules' => 'trim'
						),
					array(
						'field' => 'horario',
						'label' => 'Horario',
						'rules' => 'trim'
						),
				
					array(
						'field' => 'lugar',
						'label' => 'Lugar',
						'rules' => 'trim'
						),
					array(
						'field' => 'slug',
						'label' => 'Slug',
						'rules' => 'required'
						)
				);
	}
	
	function index(){
		//$groups = $this->group_m->get_all();
        $actividad=$this->actividad_m->get_all();
		$this->template
			->title($this->module_details['name'])
			->set('actividad', $actividad)
			//->append_css('compiled/tables.css')
			->build('admin/index');
	}
	function edit($id=0)
	{
		
		if(!$actividad=$this->actividad_m->get($id))
		{
			$this->session->set_flashdata('error', 'Error al cargar los datos de la actividad. Talves no existe o fue borrada');
			redirect('admin/actividad');
		
		}
        
        // Load up streams
		$this->load->driver('Streams');
		$stream = $this->streams->streams->get_stream('eventos', 'eventos');
		$stream_fields = $this->streams_m->get_stream_fields($stream->id, $stream->stream_namespace);
        
        
		$this->form_validation->set_rules($this->rules);
		if($this->form_validation->run()){
			unset($_POST['btnAction']);
            
            list($year,$month,$day)=explode('-',$this->input->post('fecha'));
            
            $extra=array(
            
                'titulo'		=> $this->input->post('titulo'),
    			'descripcion'	=> $this->input->post('descripcion'),
    			'fecha'         => mktime(12,0,0,$month,$day,$year),
    			'horario'       => $this->input->post('horario'),
    			'lugar'         => $this->input->post('lugar'),
    			'slug'          => $this->input->post('slug'),
                
                'map_latitud'          => $this->input->post('lat'),
                'map_longitud'         => $this->input->post('lng'),
                'map_zoom'             => $this->input->post('zoom')?$this->input->post('zoom'):null,
                
                'updated'		   => date('Y-m-d H:i:s', now()),
            );
            
			if($this->streams->entries->update_entry($id, $_POST, 'eventos', 'eventos', array('updated'), $extra))
            {
				$this->session->set_flashdata('success','La actividad ha sido modificado satisfactoriamente');
				redirect('admin/eventos');
			}
            else
            {
				$this->session->set_flashdata('error','Error al tratar de guardar los cambios a la actividad');
				redirect('admin/eventos/edit/'.$id);
			}
		}
		else
		{
			if($_POST)
				$actividad=(object)$_POST;
			else
				$actividad->fecha=format_date($actividad->fecha,'Y-m-d');
		}
        
        
        // Set Values
		$values = $this->fields->set_values($stream_fields, $actividad, 'edit');
        
		$this->template->set_partial('buttons','partials/buttons',array('buttons'=>array('cancel','save'),'msg'=>true))
			->title($this->module_details['name'], 'Modificar actividad')			
			->append_js('module::form.js')
            //->append_js('module::evento.directive.js')
            ->append_js('module::evento.controller.js')
            ->append_metadata('<script type="text/javascript">var lat='.($actividad->map_latitud?$actividad->map_latitud:0).',lng='.($actividad->map_longitud?$actividad->map_longitud:0).',zoom='.($actividad->map_zoom?$actividad->map_zoom:12).';</script>')
            ->set('stream_fields', $this->streams->fields->get_stream_fields($stream->stream_slug, $stream->stream_namespace, $values, $actividad->id))
			->set_breadcrumb('Modificar actividad','actividad/edit/'.$id)
			->build('admin/form',$actividad);
	}
	function create(){
		$actividad=new StdClass();
		$this->form_validation->set_rules($this->rules);
        
        // Get the blog stream.
		$this->load->driver('Streams');
		$stream = $this->streams->streams->get_stream('eventos', 'eventos');
		$stream_fields = $this->streams_m->get_stream_fields($stream->id, $stream->stream_namespace);
        
		if($this->form_validation->run())        
        {
			unset($_POST['btnAction']);
            
            list($year,$month,$day)=explode('-',$this->input->post('fecha'));
            
            $extra=array(
            
                'titulo'		=> $this->input->post('titulo'),
    			//'descripcion'	=> $this->input->post('descripcion'),
    			'fecha'         => mktime(12,0,0,$month,$day,$year),
    			'horario'       => $this->input->post('horario'),
    			'lugar'         => $this->input->post('lugar'),
    			'slug'          => $this->input->post('slug'),
                'created'		   => date('Y-m-d H:i:s', now()),
            );
            
            
			if($id = $this->streams->entries->insert_entry($_POST, 'eventos', 'eventos', array('created'), $extra))
            {
				
				$this->session->set_flashdata('success','El evento ha sido agregado satisfactoriamente');
				redirect('admin/eventos');
				
			}
            else
            {
				$this->session->set_flashdata('error','Error al tratar de guardar los datos de la actividad');
				redirect('admin/eventos/create');
			}
		}
		foreach ($this->rules as $rule)
		{
			$actividad->{$rule['field']} = set_value($rule['field']);
		}
        
        
        // Set Values
		$values = $this->fields->set_values($stream_fields, null, 'new');
        
		$this->template->set_partial('buttons','partials/buttons',array('buttons'=>array('save','cancel')))
			->title($this->module_details['name'], 'Agregar actividad')
			->set('stream_fields', $this->streams->fields->get_stream_fields($stream->stream_slug, $stream->stream_namespace, $values))
			->append_js('module::evento.controller.js')
			->set_breadcrumb('Agregar actividad','actividad/create')
			->build('admin/form',$actividad);
            
        
	}
	public function action()
	{
		switch ($this->input->post('btnAction'))
		{
			case 'publish':
				$this->publish();
			break;
			
			case 'delete':
				$this->delete();
			break;
			
			default:
				redirect('admin/actividad');
			break;
		}
	}
	function delete($id=0){
		$ids = ($id) ? array($id) : $this->input->post('action_to');

		// Go through the array of slugs to delete
		if ( ! empty($ids))
		{
			if($this->actividad_m->delete_many($ids))
			{
				$this->session->set_flashdata('success','Registros eliminados satisfactoriamente');
			}
			else
				$this->session->set_flashdata('error','Error al tratar de eliminar los registros');
		}
		else
		{
			$this->session->set_flashdata('notice','Al menos selecciona un registro');
		}
		redirect('admin/actividad');
	}
}
?>
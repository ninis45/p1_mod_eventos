<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * The public controller for the Pages module.
 *
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Core\Modules\Pages\Controllers
 */
class Eventos extends Public_Controller
{

	/**
	 * Constructor method
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->model('actividad_m');
		$config = array (
               'show_next_prev'  => TRUE,
               'next_prev_url'   => base_url('eventos'),
			   'template'=>'{table_open}<table border="0" cellpadding="0" cellspacing="0">{/table_open}

   {heading_row_start}<tr>{/heading_row_start}

   {heading_previous_cell}<th><a href="{previous_url}">&lt;&lt;</a></th>{/heading_previous_cell}
   {heading_title_cell}<th colspan="{colspan}">{heading}</th>{/heading_title_cell}
   {heading_next_cell}<th><a href="{next_url}">&gt;&gt;</a></th>{/heading_next_cell}

   {heading_row_end}</tr>{/heading_row_end}

   {week_row_start}<tr>{/week_row_start}
   {week_day_cell}<td>{week_day}</td>{/week_day_cell}
   {week_row_end}</tr>{/week_row_end}

   {cal_row_start}<tr>{/cal_row_start}
   {cal_cell_start}<td>{/cal_cell_start}

   {cal_cell_content}<a href="{content}" class="active">{day}</a>{/cal_cell_content}
   {cal_cell_content_today}<div class="highlight"><a href="{content}">{day}</a></div>{/cal_cell_content_today}

   {cal_cell_no_content}{day}{/cal_cell_no_content}
   {cal_cell_no_content_today}<div class="highlight">{day}</div>{/cal_cell_no_content_today}

   {cal_cell_blank}&nbsp;{/cal_cell_blank}

   {cal_cell_end}</td>{/cal_cell_end}
   {cal_row_end}</tr>{/cal_row_end}

   {table_close}</table>{/table_close}'
        );
		$this->load->library('calendar',$config);
		
	}
	function index()
	{
		$days=array();
		
        
			if($this->input->is_ajax_request())
            {
                
                $actividades=$this->actividad_m->where(array('fecha >= '=>$this->input->get('start'),'fecha <='=>$this->input->get('end')))
        
                        ->get_all();
        		$data=array();
                
                
                foreach($actividades as $row)
        		{
        		    $data[]=array(
                        'id'=>$row->id,
                        'title'=>$row->titulo,
                        'start'=>format_date($row->fecha,'Y-m-d'),
                        'url'=>base_url('eventos/'.format_date($row->fecha,'Y').'/'.format_date($row->fecha,'m').'/'.$row->slug)
                        
                    );
        			//$days[(int)format_date($row->fecha,'d')]='actividad/'.format_date($row->fecha,'Y').'/'.format_date($row->fecha,'m').'/'.format_date($row->fecha,'d');
        		}
                echo  json_encode($data);
            }
            else{
                	$this->template->set_breadcrumb('Eventos')
                        ->append_css('fullcalendar.css')
                        ->append_css('fullcalendar.print.css')
                        ->append_js('fullcalendar.min.js')			
    					->set('calendar',$this->calendar->generate(date('Y'),date('m'),$days))
    					//->set('actividades',$actividades)
    					->title($this->module_details['name'])
    					->build('index');
            }
		
	}
    function view($year,$month,$slug)
	{
		$days=array();
		
		$actividades=$this->actividad_m->get_many_by(array('YEAR(FROM_UNIXTIME(fecha))'=>$year,'MONTH(FROM_UNIXTIME(fecha))'=>$month));
		foreach($actividades as $row)
		{
			$days[(int)format_date($row->fecha,'d')]='actividad/'.format_date($row->fecha,'Y').'/'.format_date($row->fecha,'m').'/'.format_date($row->fecha,'d');
		}
		if(!$actividad=$this->db->where('slug',$slug)->get('eventos')->row())
		{
			show_404();
		}
        
        
		$this->template->set_breadcrumb('Eventos','eventos')
			->set_breadcrumb($actividad->titulo)
		    ->set('calendar',$this->calendar->generate($year,$month,$days))
			->set('actividad',$actividad)
			->title($this->module_details['name'])
			->build('details');
	}
    function listado($year='',$month='',$day='')
	{
		$days=array();
		$base_where=array();
		$links=array(
			'all'   => $day?'actividad/'.$year.'/'.$month:'',
			'today' => ''
		);
		if($day)
		{
			$base_where['DAY(FROM_UNIXTIME(fecha))']=$day;
		}
		$actividades=$this->actividad_m->get_many_by(array_merge($base_where,array('YEAR(FROM_UNIXTIME(fecha))'=>$year,'MONTH(FROM_UNIXTIME(fecha))'=>$month)));
		$actividades_calendario=$this->actividad_m->get_many_by(array('YEAR(FROM_UNIXTIME(fecha))'=>$year,'MONTH(FROM_UNIXTIME(fecha))'=>$month));
		
		foreach($actividades_calendario as $row)
		{
			$days[(int)format_date($row->fecha,'d')]='actividad/'.$year.'/'.$month.'/'.format_date($row->fecha,'d');
		}
		
		$this->template->set_breadcrumb('Actividades')
			->set('links',$links)
		    ->set('calendar',$this->calendar->generate($year,$month,$days))
			->set('actividades',$actividades)
			->title($this->module_details['name'])
			->build('index');
	}
 }
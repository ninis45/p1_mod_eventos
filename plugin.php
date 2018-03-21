<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Plugin_Eventos extends Plugin
{
	function listing()
	{
		$limit = $this->attribute('limit','4');
        $id    = $this->attribute('evento');
        
        $base_where = array();
        
        
        if($id)
        {
            $base_where['id'] = $id;
        }
        
		$result=$this->db->where($base_where)
                ->limit($limit,0)
				->get('eventos')->result();
		$inc=0;
        
        
		foreach($result  as &$row)
		{
			$row->css=$inc==0?' active':'';
			//$row->fecha=format_date_es($row->fecha_inicio,false);
            //echo format_date($row->fecha,'Y-m-d');
			$row->url=base_url('eventos/'.format_date($row->fecha,'Y').'/'.format_date($row->fecha,'m').'/'.$row->slug);
			$inc++;
		}
		return $result;
	}
}
?>
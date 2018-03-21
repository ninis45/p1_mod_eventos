<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Pages Module
 *
 * @author PyroCMS Dev Team
 * @package PyroCMS\Core\Modules\Pages
 */
class Module_Eventos extends Module
{
	public $version = '1.3';

	public function info()
	{
		$info=array(
			'name' => array(
				'en' => 'Events',
			
				'es' => 'Eventos',
				
			),
			'description' => array(
				'en' => '',
				
				'es' => 'Calendariza y administra tus eventos en tu sitio',
				
			),
			'frontend' => true,
			'backend'  => true,
			'skip_xss' => true,
			'menu'	  => 'content',

			'roles' => array(
				'put_live', 'edit', 'delete','admin_eventos_fields'
			),
            
            
            'sections' => array(
                'eventos'=>array(
                    'name'=>'eventos:list_title',
                    'uri' => 'admin/eventos',                    
                    'shortcuts' => array(
			             array(
  						    'name' => 'eventos:create_title',
  						    'uri' => 'admin/eventos/create',
  						    'class' => 'add'
			             )
    		        ),
               )
                
            ),
			
		);
        
        if (function_exists('group_has_role'))
		{
			if(group_has_role('eventos', 'admin_eventos_fields'))
			{
			    
				$info['sections']['fields'] = array(
							'name' 	=> 'global:custom_fields',
							'uri' 	=> 'admin/eventos/fields',
								'shortcuts' => array(
									'create' => array(
										'name' 	=> 'streams:add_field',
										'uri' 	=> 'admin/eventos/fields/create',
										'class' => 'add'
										)
									)
				);
			}
		}
        
        return $info;
	}

	public function install()
	{
		
		$this->dbforge->drop_table('eventos');

		$tables = array(
			
				//'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true),
				'titulo' => array('type' => 'VARCHAR', 'constraint' => 254),
				'descripcion' => array('type' => 'TEXT'),				
				'slug' => array('type' => 'VARCHAR', 'constraint' => 254),
				'lugar' => array('type' => 'VARCHAR', 'constraint' => 254),
				'horario' => array('type' => 'VARCHAR', 'constraint' => 254),
				'fecha' => array('type' => 'INT', 'constraint' => 11),
				//'created_on' => array('type' => 'INT', 'constraint' => 11),
			
		);
        
        
        
		 if (!$this->streams->streams->add_stream('eventos', 'eventos', 'eventos'))//if ( ! $this->install_tables($tables))
		{
			return false;
		}

        return $this->dbforge->add_column('eventos', $tables);

		
	}

	public function uninstall()
	{
		 $this->streams->utilities->remove_namespace('eventos');
        return true;
	}

	public function upgrade($old_version)
	{
		return true;
	}
}
?>
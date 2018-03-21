<section class="title">
	<h4>Actividades</h4>
</section>
<section class="item">
	<div class="content">
<?php echo form_open('admin/actividad/action');?>
   
    <?php if ($actividad): ?>
		<table class="table table-striped">
			<thead>
				<tr>
					<th width="3%" class="center">
                    	 <?php echo  form_checkbox(array(
                                
                                'class'=>'check-all'
                                ));?>
                    </th>
                    
					<th>Actividad</th>
                   
					<th width="10%">Fecha</th>
                    
                    <th width="16%"></th>
				</tr>
			</thead>
            <tbody>  
				<?php 
                foreach($actividad as $row){
                    
                ?>      	
                <tr>
                    <td class="center">
                       
                      <?php echo  form_checkbox(array(
                                  
                                  'name'=>'action_to[]',
                                  'value'=>$row->id
                                  
                            ));
                     
                      ?>	
                      
                    </td>
                    <td><?=$row->titulo?></td>
                    
                    <td><?=format_date($row->fecha,Settings::get('date_format'))?></td>
                   
                    <td  class="td-actions center">
                    
                        <div class="hidden-phone visible-desktop action-buttons">
                            <?php 
                            if(group_has_role('eventos','edit')):
                            ?>
                            <a href="<?=base_url('admin/eventos/edit/'.$row->id)?>" class="button" title="Editar">Editar</a> |   
                            <?php endif;
                            
                            
                           if(group_has_role('eventos','delete')):
                            ?>             
                            <a href="<?=base_url('admin/eventos/delete/'.$row->id)?>"  class="button" data-msg="Confirma eliminar la página [ <?=$row->titulo?> ] ?" title="Eliminar este elemento">Eliminar</a>
                            |
                            <?php endif;?>
                            
                            <a href="<?=base_url('admin/eventos/clone/'.$row->id)?>" class="button" title="Editar">Clonar</a>   
                        </div>
                    </td>
              </tr>
              <?php }?>
            </tbody>
	    </table>
    <?php else:?>
    <div class="no_data center">Actualmente no hay registros</div>
    <?php endif;?>
<?php echo form_close();?>
	</div>
</section>
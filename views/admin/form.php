<section class="lead text-success">
<?php if ($this->method == 'create'): ?>
	<?php echo lang('evento:create_title') ?>
<?php else: ?>
	<?php echo sprintf(lang('evento:edit_title'), $titulo) ?>
<?php endif ?>
</section>
<section class="item" ng-controller="InputCtrl">
	<div class="content">
<?php echo form_open_multipart(uri_string(), ' id="page-form" data-mode="'.$this->method.'"'); ?>
	
       
		<div class="form-group">
			<label for="titulo" class="control-label"><span>*</span> Titulo: </label>
			
				<?php echo form_input('titulo',$titulo,'id="titulo" class="form-control"');?>
            	<?=form_error('titulo','<span class="text-danger">','</span>')?>
            
		</div>
        <?php if($this->method=='create'){?>
       	<div class="form-group">
        	<label for="titulo" class="control-label"><span>*</span> Slug: </label>
			
            	
			<?php echo form_input('slug', $slug, 'id="slug" class="form-control" size="20" '.($this->method == 'edit' ? ' disabled' : '')) ?>
               
           
        </div>
        <?php }else{?>
			<?php echo  form_hidden('slug',$slug)?>
        <?php }?>
        <div class="form-group">
			<label for="descripcion" class="control-label"><span class="required">*</span> Descripción: </label>
			    <div text-angular ng-model="descripcion" name="descripcion" class="ui-editor"><?=$descripcion?></div>
				<?php //echo form_textarea('descripcion',$descripcion,'id="descripcion" class="form-control text-angular"');?>
   	        <div class="text-angular"></div>
            <?=form_error('descripcion','<span class="text-danger">','</span>')?>
            
		</div>
        <div class="form-group">
			<label for="descripcion" class="control-label"><span class="required">*</span> Fecha: </label>
		
			
               
                <input  type="text" name="fecha" class="form-control" id="id-date-range-picker-1" value="<?=$fecha?>"  />
               
                <?=form_error('fecha','<span class="text-danger">','</span>')?>
               
                
           
		</div>
        <div class="form-group">
			<label for="descripcion" class="control-label"><span class="required">*</span> Horario: </label>
			
				
               
                <input  type="text" name="horario"  class="form-control" value="<?=$horario?>"  />
               
                <?=form_error('horario','<span class="text-danger">','</span>')?>
               
                
           
		</div>
        <div class="form-group">
			<label for="lugar" class="control-label"><span class="required">*</span> Lugar: </label>
            
            	<?=form_textarea('lugar',$lugar,'class="form-control"');?>
                 <?=form_error('lugar','<span class="text-danger">','</span>')?>
            
        </div>
        
       	<hr />
        <div class="form-group">
            <label>Mapa del lugar del evento</label>
            <div class="row">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-addon">
                            Latitud
                        </span>
                        <input type="text" id="lat" class="form-control" name="lat" value="<?=$map_latitud?>" />
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            Longitud
                        </span>
                        <input type="text" id="lng" class="form-control" name="lng" value="<?=$map_longitud?>"/>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            Zoom
                        </span>
                        <input type="text" id="zoom" class="form-control" name="zoom" value="<?=$map_zoom?>"/>
                    </div>
                    <br />
                    <p class="text-center">
                        <a href="#" class="btn btn-success">Localizar</a>
                    </p>
                </div>
                <div class="col-md-8">
                     <div  id="map"  style="height: 400px;width:100%;">
                           
                                
                    </div>
                </div>
            
            </div>
        
       </div>
           
            
           
        
       <hr />
    <?php if ($stream_fields): ?>

    	<div class="form-group" id="blog-custom-fields">
    		
    			
    
    				<?php foreach ($stream_fields as $field) echo $this->load->view('admin/partials/streams/form_single_display', array('field' => $field), true) ?>
    
    			
    		
    	</div>
    
   	<?php endif; ?>
    <p class="x-12"><strong>Nota:</strong> Los campos marcados con * son obligatorios</p>
    <p class="form-actions">
        <?php template_partial('buttons');?>
    </p>
<?php echo form_close();?>
	</div>
</section>
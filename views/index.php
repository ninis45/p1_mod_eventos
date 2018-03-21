
<div class="container">
    
            <div class="row">
                
                <div class="col-lg-9">
                    <div id="page-main">
                        <section class="event-calendar">
                            <header><h1>Eventos</h1></header>
                            <section id="event-calendar">
                                <div class="calendar"></div>
                            </section>
                        </section>
                        
                    </div>
                    <!--div class="blog-item">
                    	<header><h2 class="skills">Calendario de eventos y actividades</h2></header>
                        <?php //if($links['all']){?>
                        <a href="<? //=$links['all']?>"><i class="fa fa-refresh"></i> Ver todos</a> 
                        <?php //}?>
                        
                        <hr/>
                        <?php if($actividades):?>
                    	<table class="table  table-striped">
                            <tr>
                                <th>Fecha</th>
                                <th>Evento</th>
                                <th>Hora</th>
                                <th>Lugar</th>
                            </tr>
                            <?php foreach($actividades as $row){?>
                            <tr>
                            	<td>
                                	<div class="fecha">                                    
        
                                                    <span class="dia"><?=format_date($row->fecha,'d')?></span> 
                                                    <span class="mes"><?=format_date($row->fecha,'M')?></span>
                                                    <span class="ano"><?=format_date($row->fecha,'Y')?></span> 
                                                </div> 
                                </td>
                                <td><a href="actividad/<?=format_date($row->fecha,'Y')?>/<?=format_date($row->fecha,'m')?>/<?=$row->slug?>"><?=$row->titulo?></a></td>
                                <td><?=$row->horario?></td>
                                <td><?=$row->lugar?></td>
                            </tr>
                            <?php }?>
                        </table>
                        <?php else:?>
                        <div class="alert alert-info center">
                        	No hay actividades en este momento
                        </div>
                        <?php endif;?>
                    </div-->
               </div>
               <div class="col-lg-3">
                    {{ widgets:area slug="sidebar" }}
               </div>
            </div>
    
</div>

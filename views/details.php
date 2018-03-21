
<div class="container">
    <header>
        <h2>{{ actividad:titulo }}</h2>
    </header>
    <div class="row">
        {{ if  actividad:portada != "dummy" }}
        <!-- Course Image -->
        
        <div class="col-md-2 col-sm-3">
                <figure class="event-image">
                    <div class="image-wrapper"><img src="{{ url:base}}files/cloud_thumb/{{ actividad:portada }}/165/155/fit"></div>
                </figure>
        </div><!-- end Course Image -->
        {{ endif }}
        <!--blog start-->
        <div class="{{ if  actividad:portada == "dummy" }} col-lg-9 {{ else }} col-lg-6 {{ endif }}">
            <div class="page-main">
            	<section id="event-detail">
                    <article class="event-detail">
                        <section id="event-header">
                                <header>
                                    <h2 class="event-date"><?=format_date($actividad->fecha,'d M Y')?></h2>
                                </header>
                                <hr/>
                                
                                <figure>
                                    <span id="course-length" class="course-summary"><i class="fa fa-calendar-o"></i><?=current(explode(',',timespan($actividad->fecha)))?></span>
                                    <span id="course-time-amount" class="course-summary"><i class="fa fa-map-marker"></i>{{ actividad:lugar }}</span>
                                    <span id="course-course-time" class="course-summary"><i class="fa fa-clock-o"></i>{{ actividad:horario }}</span>
                                </figure>
                        </section>
                        <section id="course-info">
                            <header><h2>Descripción</h2></header>
                            <p> {{ actividad:descripcion }}</p>
                        </section>
                       
                    </article>
                       
                </section>
                  
               
            </div>
       </div>
        <div class="col-lg-3">
        	{{ widgets:area slug="sidebar" }}
            <!--div class="">
            <?=$calendar?>
            </div-->
       </div>
    </div>
</div>


      <!-- Sponsors -->
      <section class="sponsors row"  data-scroll-index="5" >
        <div class="centered eight columns top-page">
          <h2>Patrocínio</h2>
          <i></i>
          <span class="description">As empresas que fizeram o Alagoas Dev Day acontecer</span>
        </div>

        <div class="clr"></div>

        <?php
        $args = array(
          'hide_empty'    => false,
        );
        $taxonomy = 'niveis';
        $categories = get_terms( $taxonomy, $args );
        if(is_array($categories)){
          foreach ($categories as $category) {
            ?>
            <div class="row sponsors-list">
              <div class="two columns cetgory-sponsors <?php echo $category->slug; ?>"><?php echo $category->name; ?></div>
              <?php
              $args = array(
                'tax_query' => array(
                  'relation'  => 'AND',
                  array(
                    'taxonomy'         => $taxonomy,
                    'field'            => 'slug',
                    'terms'            => array( $category->slug ),
                    'include_children' => true,
                    'operator'         => 'IN'
                  ),
                ),
              );
              $i = 0;
              $query = new WP_Query_Partners( $args );
              while($query->have_posts()){
                $query->the_post();
                ?>
                <div class="two columns">
                  <?php if (get_permalink()) {?>
                    <a href="<?php the_permalink();?>"><?php echo get_the_post_thumbnail(get_the_id(), 'sponsor' );?></a>
                  <?php }else{?>
                    <?php echo get_the_post_thumbnail(get_the_id(), 'sponsor' );?>
                  <?php }?>
                </div>
                <?php
                if ($i++ % 5 == 4){
                  ?>
                  </div>
                  <div class="row sponsors-list">
                    <div class="two columns"></div>
                  <?php
                }
              }
              ?>
              <div class="two columns"><a href="mailto:contato@alagoasdevday.com.br"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/website/sponsors.png" alt=""></a></div>
            </div>
            <?php
          }
        }
        ?>
      </section>
      <!-- End sponsors -->

      <!-- Realization -->
      <section class="realization">
        <div class="centered eight columns top-page">
          <h2>Créditos</h2>
          <i></i>
          <span class="description">Estes são os diretores responsáveis pelo ADD</span>
        </div>

        <div class="row">
          <div class="centered ten columns">
            
            <ul class="organizer-list five_up tiles">

              <li class="organizer-item">
                <figure class="organizer-photo">
                  <img class="photo" src="<?php echo get_template_directory_uri(); ?>/assets/images/organizers/carlyson.jpg" alt="Carlyson Oliveira" itemprop="image">
                </figure>

                <div class="organizer-about">
                  <h3 class="organizer-title centered eight columns">
                      Carlyson Oliveira
                  </h3>

                  <p class="organizer-participation-job">Organizador | Designer</p>
                
                  <ul class="organizer-social two_up tiles">
                    <li><a href="https://twitter.com/Carlyson" title="Twitter" class="icon-twitter" target="_blank"></a></li>
                    <li><a href="http://www.linkedin.com/in/carlyson" title="Linkedin" class="icon-linkedin" target="_blank"></a></li>
                  </ul>
                </div>
              </li>

              <li class="organizer-item">
                <figure class="organizer-photo">
                  <img class="photo" src="<?php echo get_template_directory_uri(); ?>/assets/images/organizers/gustavo.jpg" alt="Gustavo Cunha" itemprop="image">
                </figure>

                <div class="organizer-about">
                  <h3 class="organizer-title centered eight columns">
                      Gustavo Cunha
                  </h3>

                  <p class="organizer-participation-job">Organizador | Back-end</p>
                
                  <ul class="organizer-social two_up tiles">
                    <li><a href="https://twitter.com/gmmcal" title="Twitter" class="icon-twitter" target="_blank"></a></li>
                    <li><a href="http://www.linkedin.com/in/gmmcal" title="Linkedin" class="icon-linkedin" target="_blank"></a></li>
                  </ul>
                </div>
              </li>

              <li class="organizer-item">
                <figure class="organizer-photo">
                  <img class="photo" src="<?php echo get_template_directory_uri(); ?>/assets/images/organizers/hugo.jpg" alt="Hugo Oliveira" itemprop="image">
                </figure>

                <div class="organizer-about">
                  <h3 class="organizer-title centered eight columns">
                      Hugo Oliveira
                  </h3>

                  <p class="organizer-participation-job">Organizador | Conteúdo</p>
                
                  <ul class="organizer-social two_up tiles">
                    <li><a href="https://twitter.com/oliveira_hugo" title="Twitter" class="icon-twitter" target="_blank"></a></li>
                    <li><a href="http://www.linkedin.com/in/hugooliveira12" title="Linkedin" class="icon-linkedin" target="_blank"></a></li>
                  </ul>
                </div>
              </li>

              <li class="organizer-item">
                <figure class="organizer-photo">
                  <img class="photo" src="<?php echo get_template_directory_uri(); ?>/assets/images/organizers/ivan.jpg" alt="Ivan Santos" itemprop="image">
                </figure>

                <div class="organizer-about">
                  <h3 class="organizer-title centered eight columns">
                      Ivan Santos
                  </h3>

                  <p class="organizer-participation-job">Organizador | Front-end</p>
                
                  <ul class="organizer-social two_up tiles">
                    <li><a href="https://twitter.com/pragmaticivan" title="Twitter" class="icon-twitter" target="_blank"></a></li>
                    <li><a href="http://www.linkedin.com/in/pragmaticivan" title="Linkedin" class="icon-linkedin" target="_blank"></a></li>
                  </ul>
                </div>
              </li>

              <li class="organizer-item">
                <figure class="organizer-photo">
                  <img class="photo" src="<?php echo get_template_directory_uri(); ?>/assets/images/organizers/mac.jpg" alt="Maclévison Gyovanni" itemprop="image">
                </figure>

                <div class="organizer-about">
                  <h3 class="organizer-title centered eight columns">
                      Mac Gyovanni
                  </h3>

                  <p class="organizer-participation-job">Organizador | Front-end</p>
                
                  <ul class="organizer-social two_up tiles">
                    <li><a href="https://twitter.com/maclevison" title="Twitter" class="icon-twitter" target="_blank"></a></li>
                    <li><a href="http://www.linkedin.com/in/maclevison" title="Linkedin" class="icon-linkedin" target="_blank"></a></li>
                  </ul>
                </div>
              </li>

            </ul>
          </div>
        </div>
      </section>
      <!-- End Realization -->
      
      <footer>
        <div class="row">
          <div class="twelve columns" itemscope itemtype="http://schema.org/LocalBusiness">
            <span>Quer falar com a gente? Manda ver!</span>
            <a href="callto:+558230215586" itemprop="telephone">82 3021.5586</a> | <a href="mailto:contato@alagoasdevday.com.br">contato@alagoasdevday.com.br</a> 
          </div>
        </div>
      </footer>
    </div>
    <!-- End container Main -->
    <?php wp_footer(); ?>
    
    <script src="http://www.doity.com.br/js/box_inscricao.js" type="text/javascript"></script>

    <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/assets/js/vendor/scrollIt.min.js"></script>
    <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/assets/js/vendor/waypoints.min.js"></script>

    <script type="text/javascript">
      jQuery(document).ready(function($){
        $.scrollIt({
          topOffset: -100
        });
        $('body').waypoint(function(direction) {
            $("nav.nav").toggleClass('stick', direction=='down');

        }, { offset: 50 });
      })
    </script>


    <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
    <script>
    var _gaq=[['_setAccount','UA-22513742-22'],['_trackPageview']];
    (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
    g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
    s.parentNode.insertBefore(g,s)}(document,'script'));
    </script>

</body>
</html>
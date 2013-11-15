<?php get_header(); ?>
  <!-- Speakers -->
  <section class="speakers row">
    <div class="centered eight columns top-page">
      <h2>Nosso Elenco</h2>
      <i></i>
      <span class="description">Olha só o elenco que preparamos para nossa seção</span>
    </div>

    <div class="clearfix"></div>

    <ul class="speakers-list three_up tiles">
      <li class="speakers-item" itemprop="performer" itemscope itemtype="http://schema.org/Person">

        <figure class="speaker-photo">
          <img class="photo" src="<?php echo get_template_directory_uri(); ?>/assets/images/speakers/bernard.jpg" alt="Linus Torvalds" itemprop="image">
        </figure>

        <h3 class="speaker-title centered eight columns">
            <span class="speaker-name">Bernard de Luna</span>
            <span class="speaker-job">Brasiljs</span>
        </h3>

        <p class="speaker-bio">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo</p>
      
        <ul class="speaker-social three_up tiles">
          <li><a href="http://www.twitter.com/" title="Twitter" class="icon-twitter"></a></li>
          <li><a href="http://facebook.com/" title="facebook" class="icon-facebook"></a></li>
          <li><a href="http://linkedin.com/" title="linkedin" class="icon-linkedin"></a></li>
        </ul>
      </li>
      <li class="speakers-item" itemprop="performer" itemscope itemtype="http://schema.org/Person">

        <figure class="speaker-photo">
          <img class="photo" src="<?php echo get_template_directory_uri(); ?>/assets/images/speakers/bernard.jpg" alt="Linus Torvalds" itemprop="image">
        </figure>

        <h3 class="speaker-title centered eight columns">
            <span class="speaker-name">Bernard de Luna</span>
            <span class="speaker-job">Brasiljs</span>
        </h3>

        <p class="speaker-bio">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo</p>
      
        <ul class="speaker-social three_up tiles">
          <li><a href="http://www.twitter.com/" title="Twitter" class="icon-twitter"></a></li>
          <li><a href="http://facebook.com/" title="facebook" class="icon-facebook"></a></li>
          <li><a href="http://linkedin.com/" title="linkedin" class="icon-linkedin"></a></li>
        </ul>
      </li>  
      <li class="speakers-item" itemprop="performer" itemscope itemtype="http://schema.org/Person">

        <figure class="speaker-photo">
          <img class="photo" src="<?php echo get_template_directory_uri(); ?>/assets/images/speakers/bernard.jpg" alt="Linus Torvalds" itemprop="image">
        </figure>

        <h3 class="speaker-title centered eight columns">
            <span class="speaker-name">Bernard de Luna</span>
            <span class="speaker-job">Brasiljs</span>
        </h3>

        <p class="speaker-bio">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo</p>
      
        <ul class="speaker-social three_up tiles">
          <li><a href="http://www.twitter.com/" title="Twitter" class="icon-twitter"></a></li>
          <li><a href="http://facebook.com/" title="facebook" class="icon-facebook"></a></li>
          <li><a href="http://linkedin.com/" title="linkedin" class="icon-linkedin"></a></li>
        </ul>
      </li>  
    </ul>        
  </section> <!-- End Speakers -->

  <!-- Schedule -->
  <section class="schedule row">
    <div class="centered eight columns top-page">
      <h2>Roteiro</h2>
      <i></i>
      <span class="description">Tem ação, drama e até romance, só não tem terror</span>
    </div>

    <div class="clr"></div>

    <?php
    $query = new WP_Query_Schedule();
    while($query->have_posts()){
      $query->the_post();
      $time = get_post_meta( get_the_id(), 'hora', true );
      $theme = get_post_meta( get_the_id(), 'tema', true );
      if(empty($theme)){
        ?>
        <div class="schedule-item row">
          <span class="speech-time two columns"><?php echo $time; ?></span>
          <span class="ten columns"><?php the_title(); ?></span>
        </div>
        <?php
      }else{
        ?>
        <div class="schedule-item row">
          <span class="speech-time two columns"><?php echo $time; ?></span>
          <span class="speaker three columns">
            <figure>
              <?php echo get_the_post_thumbnail(get_the_id(), 'schedule' );?>
            </figure>
            <span class="speaker-name"><?php the_title(); ?></span>
          </span>
          <span class="speech-title seven columns"><?php echo $theme; ?></span>
        </div>
        <?php
      }
    }
    ?>
  </section> <!-- End Schedule -->

  <!-- Lightning Talk -->
  <section class="lighting-talks">
    <div class="centered eight columns top-page">
      <h2>Curtas metragens</h2>
      <i></i>
      <span class="description">Prepare seu roteiro e mande sua ideia para nós</span>
    </div>

    <div class="row">
      <div class="description-box centered eight columns">
        Você pode participar do Alagoas Dev Day com um <span>Lightning Talks</span> de 20 minutos. Serão 03 ideias escolhidas por voto popular.
      </div>
      <div class="submit-box centered eight columns">
        Inscreva seu projeto de desenvolvimento <span>(back-end, front-end ou design)</span> ou sua ideia de startup. É só submeter sua ideia no site e pedir aguardar a votação.
        <a href="#">Envie seu roteiro agora mesmo</a>
      </div>
    </div>

    <i class="popcorn"></i>
  </section> <!-- End Lightning Talk -->

  <!-- Registry -->
  <section class="registry row">
    <div class="centered eight columns top-page">
      <h2>Bilhetes</h2>
      <i></i>
      <span class="description">Garanta já sua entrada e cuidado para não perder a hora</span>
    </div>

    <div class="container-registry-box">
      <iframe src="http://www.eventick.com.br/alagoasdevday/embedded" frameborder="0" height="225px" width="100%" vspace="0" hspace="0" marginheight="5" marginwidth="0" scrolling="auto" allowtransparency="true"></iframe>
    </div>
  </section> 
  <!-- End Registry -->
<?php get_footer(); ?>
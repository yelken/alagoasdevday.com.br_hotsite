<?php get_header(); ?>
  <!-- Speakers -->
  <section class="speakers row" data-scroll-index="1">
    <div class="centered eight columns top-page">
      <h2>Nosso Elenco</h2>
      <i></i>
      <span class="description">Olha só o elenco que preparamos para nossa seção</span>
    </div>

    <div class="clearfix"></div>

    <ul class="speakers-list tiles">
      <?php
      $query = new WP_Query_Speakers();
      while($query->have_posts()){
        $query->the_post();
        $bio = get_post_meta( get_the_id(), 'bio', true );
        $empresa = get_post_meta( get_the_id(), 'empresa', true );
        $twitter = get_post_meta( get_the_id(), 'twitter', true );
        $facebook = get_post_meta( get_the_id(), 'facebook', true );
        $linkedin = get_post_meta( get_the_id(), 'linkedin', true );
        $hidden = get_post_meta( get_the_id(), 'hidden', true );
        ?>
        <li class="speakers-item columns four" itemprop="performer" itemscope itemtype="http://schema.org/Person">
          <?php
          if($hidden){
            ?>
            add some hidden style here
            <?php
          }else{
            ?>
            <figure class="speaker-photo">
              <?php echo get_the_post_thumbnail(get_the_id(), 'speaker' );?>
            </figure>
            <h3 class="speaker-title centered eight columns">
              <span class="speaker-name"><?php the_title(); ?></span>
              <span class="speaker-job"><?php echo $empresa?></span>
            </h3>
            <p class="speaker-bio"><?php echo $bio; ?></p>
            <ul class="speaker-social three_up tiles">
              <li><a href="<?php echo $twitter; ?>" target="_blank" title="Twitter" class="icon-twitter"></a></li>
              <li><a href="<?php echo $facebook; ?>" target="_blank" title="facebook" class="icon-facebook"></a></li>
              <li><a href="<?php echo $linkedin; ?>" target="_blank" title="linkedin" class="icon-linkedin"></a></li>
            </ul>
            <?php
          }
          ?>
        </li>
        <?php
      }
      ?>
    </ul>
  </section> <!-- End Speakers -->

  <!-- Schedule -->
  <section class="schedule row" data-scroll-index="2" >
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

  
  <section class="adapter" data-scroll-index="3">
    <div class="lighting-talks"> <!-- Lightning Talk -->
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
          Inscreva seu projeto de desenvolvimento <span>(back-end, front-end ou design)</span> ou sua ideia de startup. É só submeter sua ideia no site e pedir pra galera votar.
          <a href="http://call4paperz.com/events/alagoas-dev-day" target="_blank">Envie seu roteiro agora mesmo</a>
        </div>
      </div>

      <i class="popcorn"></i>
    </div> <!-- End Lightning Talk -->
  </section>
  

  <!-- Registry -->
  <section class="registry row" data-scroll-index="4">
    <div class="centered eight columns top-page">
      <h2>Bilhetes</h2>
      <i></i>
      <span class="description">Garanta já seu ingresso e cuidado para não perder a hora</span>
    </div>

    <div class="container-registry-box">

      <div class="row">
        <div class="description-box centered eight columns">
          Aproveite o primeiro lote de inscrições, com o valor promocional de <span class="price">R$45,00</span>. <span>Imperdível</span>.
        </div>

        <div class="submit-box centered eight columns">
          O Alagoas Dev Day procura um público seleto e restrito, para um dia inteiro de codificação e muita pipoca.
          <a href="http://www.doity.com.br/aldevday" target="_blank">Faça sua inscrição.</a>
        </div>
      </div>

    </div>
  </section> 
  <!-- End Registry -->
<?php get_footer(); ?>
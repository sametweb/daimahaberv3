<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-9" />
    <meta http-equiv="Content-language" content="tr" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/style.css" type="text/css" media="all" />
    <title>Daimahaber v3.0</title>
    <script>
      function slide(e, slider) {
        e.preventDefault();
        var mySlider = document.querySelector(`.${slider}-slider`);
        mySlider.scrollLeft =
          mySlider.clientWidth * (parseInt(e.target.textContent) - 1);
      }
    </script>
    <?php wp_head();?>
  </head>
  <body>
    <div id="root"><header>
        <div class="top-bar">
          <span>$ 5.67TRY</span>
          <span>E 6.21TRY</span>
          <span>BIST 95.4 +1.2</span>
        </div>
        <div class="logo-block">
          <img src="<?php echo get_template_directory_uri(); ?>/images/logo.png" alt="Logo" title="Logo" />
          <div class="logo-block-right">Buraya Reklam Gelebilir</div>
          <div class="burger-menu">
            <input type="checkbox" />
            <span></span>
            <span></span>
            <span></span>
            <ul class="menu">
              <li>
                <a href="#">Gündem</a>
              </li>
              <li>
                <a href="#">Politika</a>
              </li>
              <li>
                <a href="#">Dış Politika</a>
              </li>
              <li>
                <a href="#">Sağlık</a>
              </li>
              <li>
                <a href="#">Magazin</a>
              </li>
              <li>
                <a href="#">Spor</a>
              </li>
              <li>
                <a href="#">Teknoloji</a>
              </li>
              <li>
                <a href="#">Meclis Gündemi</a>
              </li>
              <li>
                <a href="#">Yemek</a>
              </li>
            </ul>
          </div>
        </div>
        <nav class="main-navbar">
          <ul class="menu">
            <li>
              <a href="#">Gündem</a>
            </li>
            <li>
              <a href="#">Politika</a>
            </li>
            <li>
              <a href="#">Dış Politika</a>
            </li>
            <li>
              <a href="#">Sağlık</a>
            </li>
            <li>
              <a href="#">Magazin</a>
            </li>
            <li>
              <a href="#">Spor</a>
            </li>
            <li>
              <a href="#">Teknoloji</a>
            </li>
            <li>
              <a href="#">Meclis Gündemi</a>
            </li>
            <li>
              <a href="#">Yemek</a>
            </li>
          </ul>
        </nav>
      </header>
      <section class="headline">
        <div class="item">
          <a href="#" alt="" class="link">
            <img src="<?php echo get_template_directory_uri(); ?>/images/haber1.jpg" />
            <h3>
              Bu haber başlığı Türkçe karakterden oluşur ve biraz da uzundur
            </h3>
          </a>
        </div>
        <div class="item">
          <a href="#" alt="" class="link">
            <img src="<?php echo get_template_directory_uri(); ?>/images/haber2.jpg" />
            <h3>Türkçe bir başlık görüntülemektesiniz</h3>
          </a>
        </div>
        <div class="item">
          <a href="#" alt="" class="link">
            <img src="<?php echo get_template_directory_uri(); ?>/images/haber3.jpg" />
            <h3>Bu başlıkta Türkçe karakterler kullanılmıştır</h3>
          </a>
        </div>
        <div class="item">
          <a href="#" alt="" class="link">
            <img src="<?php echo get_template_directory_uri(); ?>/images/haber4.jpg" />
            <h3>Şimdi biz ne desek size yalan gelir</h3>
          </a>
        </div>
        <div class="item">
          <a href="#" alt="" class="link">
            <img src="<?php echo get_template_directory_uri(); ?>/images/haber5.jpg" />
            <h3>Bizim haber sitemiz hep doğruları söyler</h3>
          </a>
        </div>
      </section>
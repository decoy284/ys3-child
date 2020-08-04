<?php

?>
<?php if(!is_amp_endpoint()) { ?>
<div class="ads">
  <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
  <!-- index-middle-responsive -->
  <ins class="adsbygoogle"
  style="display:block"
  data-ad-client="ca-pub-3276272379788817"
  data-ad-slot="4783697016"
  data-ad-format="auto"></ins>
  <script>
  (adsbygoogle = window.adsbygoogle || []).push({});
  </script>
</div>
<?php } ?>
<?php
if(is_single()) {
  $category = get_the_category();
  $ranking_data = sga_ranking_get_date($args);
  $cat_slug = $category[0]->slug;
  if( !ys_is_mobile()) { ?>
    <h3 class="popularpost"><span>『<?=$category[0]->cat_name?>』カテゴリの人気記事</span></h3>
    <?php
    echo do_shortcode( "[ys_recent_posts filter=sga taxonomy=category term_slug=\"$cat_slug\" list_type=card col_pc=4 thumbnail_size=medium count=8]" );
  }
  if( ys_is_mobile()) { ?>
    <div class="popularpost-content-box">
      <h3 class="popularpost"><span>『<?=$category[0]->cat_name?>』カテゴリの人気記事</span></h3>
      <?php echo do_shortcode( "[ys_recent_posts filter=sga taxonomy=category term_slug=\"$cat_slug\" list_type=list thumbnail_size=medium count=8 thumbnail_ratio=16-9]" ); ?>
    </div>
  <?php
  }
} else { ?>
  <?php
  if( !ys_is_mobile()) { ?>
    <!-- <div class="popularpost-content-box"> -->
    <h3 class="popularpost"><span>人気の記事</span></h3>
    <?php echo do_shortcode( "[ys_recent_posts filter=sga list_type=card col_pc=4 thumbnail_size=medium count=8]" ); ?>
  <!-- </div> -->
  <?php }
  if( ys_is_mobile()) { ?>
    <div class="popularpost-content-box">
      <h3 class="popularpost"><span>人気の記事</span></h3>
      <?php echo do_shortcode( "[ys_recent_posts filter=sga list_type=list thumbnail_size=medium count=8 thumbnail_ratio=16-9]" ); ?>
    </div>
  <?php
  }
}
?>

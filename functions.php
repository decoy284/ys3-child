<?php
/**
 * ystandard子テーマの関数
 */
function meta_headcustomtags() {
$headcustomtag = <<<EOF

<!-- Google Tag Manager -->
	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','GTM-MRRNNPG');</script>
<!-- End Google Tag Manager -->
<!-- LinkSwitch -->
<script type="text/javascript" language="javascript">
	var vc_pid = "884856821";
</script><script type="text/javascript" src="//aml.valuecommerce.com/vcdal.js" async></script>
<!-- End LinkSwitch -->
EOF;

$amp_headcustomtag = <<<EOF

<!-- AMP tag -->
<meta name="amp-google-client-id-api" content="googleanalytics">
<script async custom-element="amp-ad" src="https://cdn.ampproject.org/v0/amp-ad-0.1.js"></script>
<script async custom-element="amp-analytics" src="https://cdn.ampproject.org/v0/amp-analytics-0.1.js"></script>
<script async custom-element="amp-link-rewriter" src="https://cdn.ampproject.org/v0/amp-link-rewriter-0.1.js"></script>
<!-- End AMP tag -->

EOF;

if(function_exists('is_amp_endpoint') && is_amp_endpoint()) {
  echo $amp_headcustomtag;
} else {
  echo $headcustomtag;
}

}
add_action( 'wp_head', 'meta_headcustomtags', 99);

add_action( 'wp_body_open', function() {
	?>
  <!-- Google Tag Manager (noscript) -->
  <?php if(function_exists('is_amp_endpoint') && is_amp_endpoint()) { ?>
  	<amp-analytics config="https://www.googletagmanager.com/amp.json?id=GTM-PXCNGFJ&gtm.url=SOURCE_URL" data-credentials="include"></amp-analytics>
  <?php } else { ?>
  	<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MRRNNPG"
  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
  <?php } ?>
  <!-- End Google Tag Manager (noscript) -->
  <?php if(function_exists('is_amp_endpoint') && is_amp_endpoint()) { ?>
  	<!-- LinkSwitch (noscript) -->
  	<amp-link-rewriter layout="nodisplay">
  	  <script type="application/json">
  	    {
  	      "output": "https://lsr.valuecommerce.com/ard?p=${vc_pid}&u=${href}&vcptn=${vc_ptn}&s=SOURCE_URL&r=DOCUMENT_REFERRER",
  	      "vars": { "vc_pid": "884856821", "vc_ptn": "ampls" }
  	    }
  	  </script>
  	</amp-link-rewriter>
  	<!-- End LinkSwitch (noscript) -->
  <?php } ?>
	<?php
});

add_filter( 'ys_copyright', 'd_get_copyright_default' );
function d_get_copyright_default($copy) {
  $copy = '&copy; 2012 decoy284.net';
  return $copy;
}

function add_ad_before_h2_for_3times($the_content) {  
//広告（AdSense）タグを記入
$ad1 = <<< EOF

<div class="ads">
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<ins class="adsbygoogle"
     style="display:block; text-align:center;"
     data-ad-layout="in-article"
     data-ad-format="fluid"
     data-ad-client="ca-pub-3276272379788817"
     data-ad-slot="6666326188"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>
</div>

EOF;

$ad2 = <<< EOF

<div class="ads">
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<ins class="adsbygoogle"
     style="display:block; text-align:center;"
     data-ad-layout="in-article"
     data-ad-format="fluid"
     data-ad-client="ca-pub-3276272379788817"
     data-ad-slot="4711463257"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>
</div>

EOF;

$ad3 = <<< EOF

<div class="ads">
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<ins class="adsbygoogle"
     style="display:block; text-align:center;"
     data-ad-layout="in-article"
     data-ad-format="fluid"
     data-ad-client="ca-pub-3276272379788817"
     data-ad-slot="7912341660"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>
</div>

EOF;

  if ( !is_amp_endpoint() && is_single() ) {
    $h2 = '/^<h2.*?>.+?<\/h2>$/im';
    if ( preg_match_all( $h2, $the_content, $h2s )) {
      if ( $h2s[0] ) {
        if ( $h2s[0][2] ) {
          $the_content  = str_replace($h2s[0][2], $ad1.$h2s[0][2], $the_content);
        }
        if ( $h2s[0][4] ) {
          $the_content  = str_replace($h2s[0][4], $ad2.$h2s[0][4], $the_content);
        }
        if ( $h2s[0][6] ) {
          $the_content  = str_replace($h2s[0][6], $ad3.$h2s[0][6], $the_content);
        }
      }
    }
  }
  return $the_content;
}
add_filter('the_content','add_ad_before_h2_for_3times');

add_filter('the_content', 'wpautop', 0, 1);

function shortcode_exif($atts){
  extract(shortcode_atts(array(
        'img' => 0,
    ), $atts));
  $get_exif = @exif_read_data($img);
  $exif_camera = $get_exif['Model'];
  if (isset($get_exif["UndefinedTag:0xA434"])) {
  	$exif_lens = $get_exif["UndefinedTag:0xA434"];
  }
  if (isset($get_exif['COMPUTED']['ApertureFNumber'])) {
  	$exif_fnum = $get_exif['COMPUTED']['ApertureFNumber'];
  }
  if (isset($get_exif['ExposureTime'])) {
      $exif_ss = $get_exif['ExposureTime'];
      $parts = explode("/", $exif_ss);
      $exif_ss = implode("/", array(1, $parts[1]/$parts[0]));
  }
  if (isset($get_exif['Software'])) {
  	$exif_software = $get_exif['Software'];
  }
  if (isset($get_exif['ISOSpeedRatings'])) {
  	$exif_iso = 'ISO '.$get_exif['ISOSpeedRatings'];
  }

  $exif = $exif_camera . ', ' . $exif_lens . ', ' . $exif_ss . ', ' . $exif_fnum . ', ' . $exif_iso;
  return $exif;
}
add_shortcode( 'exif', 'shortcode_exif');

function my_dequeue_style_and_script(){
    wp_dequeue_style('newpost-catch');
    if(!is_single()){
        //wp_dequeue_style('toc-screen');
        wp_dequeue_style('aalb_basics_css');
        wp_dequeue_style('yyi_rinker_stylesheet');
        //wp_dequeue_script('toc-front');
        //wp_dequeue_style('ty_amazonjs_reviewer');
    }
    if(!is_page()){
        wp_dequeue_style('contact-form-7');
        wp_dequeue_script('contact-form-7');
    }
}
add_action( 'wp_enqueue_scripts', 'my_dequeue_style_and_script');

// add_filter( 'amp_post_template_metadata', 'xyz_amp_modify_json_metadata', 10, 2 );
// function xyz_amp_modify_json_metadata( $metadata, $post ) {
//     $metadata['publisher']['logo'] = array(
//         '@type' => 'ImageObject',
//         'url' => "https://decoy284.net/wp-content/uploads/decoy284-amp-logo.png",
//         'width' => "150",
//         'height' => "60",
//     );
//     return $metadata;
// }

function shortcode_button($atts){
  extract( shortcode_atts( array(
    'class' => 'std',
    'url' => 'url',
    'text' => 'hoge'
  ), $atts ));
  $html = '<span class="' . $class . '-btn"><a href="' . $url . '" target="_blank" rel="nofollow">' . $text . '</a></span>';
  return $html;
}
add_shortcode( 'btn', 'shortcode_button');

// add loading="lazy"
function get_thumb_img($size = 'full', $alt = null, $p_id = null , $class = null) {
  $p_id = ($p_id) ? $p_id : get_the_ID();
  $thumb_id = get_post_thumbnail_id($p_id);
  $thumb_img = wp_get_attachment_image_src($thumb_id, $size);
  $thumb_src = $thumb_img[0];
  $alt = ($alt) ? $alt : get_the_title($p_id);
  $class = $class ;
  return '<img src="'.$thumb_src.'" alt="'.$alt.'" class="'.$class.'" loading="lazy">';
}

function customize_img_lazy($content) {
  if(function_exists('is_amp_endpoint') && is_amp_endpoint()) {
    return $content;
  } else {
    $re_content = preg_replace('/(<img[^>]*)\s+class="([^"]*)"/', '$1 class="$2" loading="lazy"', $content);
    return $re_content;
  }
}
add_filter('the_content','customize_img_lazy');

function yyi_rinker_custom_shop_labels( $attr ) {
  if ( $attr[ 'klabel' ] === '' ) {
		$attr[ 'klabel' ]	= 'Kindle版を購入する';
	}
	if ( $attr[ 'alabel' ] === '' ) {
		$attr[ 'alabel' ]	= 'Amazonで購入する';
	}
	if ( $attr[ 'rlabel' ] === '' ) {
		$attr[ 'rlabel' ]	= '楽天で探す';
	}
	if ( $attr[ 'ylabel' ] === '' ) {
		$attr[ 'ylabel' ]	= 'Yahooショッピングで探す';
	}
	return $attr;
}
add_action( 'yyi_rinker_update_attribute', 'yyi_rinker_custom_shop_labels' );

function yyi_rinker_rel_target_text() {
	if ( wp_is_mobile() ) {
		return '';
	} else {
		return 'rel="nofollow noopener" target="_blank"';
	}

}
add_filter ( 'yyi_rinker_rel_target_text', 'yyi_rinker_rel_target_text', 20 );

function add_ad_related() {
  get_template_part('adsense_related');
}
add_action('ys_singular_footer','add_ad_related',45);

function add_sga_ranking() {
  get_template_part('popularpost');
}
add_action('ys_singular_footer','add_sga_ranking',55);

add_filter( 'ys_get_archive_type', function ( $type ) {
	$type = 'card';
	if ( ys_is_mobile() ) {
		$type = 'list';
	}

	return $type;
} ); 
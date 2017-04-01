//缩略图获取
add_theme_support( 'post-thumbnails' );
set_post_thumbnail_size( 220, 150 ,true );//设置缩略图的尺寸
function dm_the_thumbnail() {
    global $post;
    // 判断该文章是否设置的缩略图，如果有则直接显示
    if ( has_post_thumbnail() ) {
        echo '<a href="'.get_permalink().'">';
        the_post_thumbnail();
        echo '</a>';
    } else { //如果文章没有设置缩略图，则查找文章内是否包含图片
        $content = $post->post_content;
        preg_match_all('/<img.*?(?: |\\t|\\r|\\n)?src=[\'"]?(.+?)[\'"]?(?:(?: |\\t|\\r|\\n)+.*?)?>/sim', $content, $strResult, PREG_PATTERN_ORDER);
        $n = count($strResult[1]);
        if($n > 0){ // 如果文章内包含有图片，就用第一张图片做为缩略图
            echo '<a href="'.get_permalink().'"><img src="'.$strResult[1][0].'" /></a>';
        }else { // 如果文章内没有图片，则用默认的图片。
            echo '<a href="'.get_permalink().'"><img src="'.get_bloginfo('template_url').'/images/noimage.png" /></a>';
        }
    }
}

function _get_post_thumbnail($size = 'thumbnail', $class = 'thumb') {
	$html = '';
	if (has_post_thumbnail()) {

		/*$domsxe = simplexml_load_string(get_the_post_thumbnail());
		$src = $domsxe->attributes()->src;

		$src_array = wp_get_attachment_image_src(_get_attachment_id_from_src($src), $size);
		$html = sprintf('<img data-src="%s" class="%s"/>', $src_array[0], $class);*/

        $domsxe = get_the_post_thumbnail();
        // print_r($domsxe);
        preg_match_all('/<img.*?(?: |\\t|\\r|\\n)?src=[\'"]?(.+?)[\'"]?(?:(?: |\\t|\\r|\\n)+.*?)?>/sim', $domsxe, $strResult, PREG_PATTERN_ORDER);  
        $images = $strResult[1];
        foreach($images as $src){
            $html = sprintf('<img data-src="%s" class="thumb">', $src);
            break;
        }

	} else { //如果文章没有设置缩略图，则查找文章内是否包含图片
        $content = $post->post_content;
        preg_match_all('/<img.*?(?: |\\t|\\r|\\n)?src=[\'"]?(.+?)[\'"]?(?:(?: |\\t|\\r|\\n)+.*?)?>/sim', $content, $strResult, PREG_PATTERN_ORDER);
        $n = count($strResult[1]);
        if($n > 0){ // 如果文章内包含有图片，就用第一张图片做为缩略图
            echo '<a href="'.get_permalink().'"><img src="'.$strResult[1][0].'" /></a>';
        } else {
		$html = sprintf('<img data-src="%s" class="%s">', get_stylesheet_directory_uri() . '/img/thumbnail.png', $class);
	}

	return $html;
}

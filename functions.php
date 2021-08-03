<?php
/*  ----------------------------------------------------------------------------
    Newspaper V9.0+ Child theme - Please do not use this child theme with older versions of Newspaper Theme

    What can be overwritten via the child theme:
     - everything from /parts folder
     - all the loops (loop.php loop-single-1.php) etc
	 - please read the child theme documentation: http://forum.tagdiv.com/the-child-theme-support-tutorial/

 */


/*  ----------------------------------------------------------------------------
    add the parent style + style.css from this folder
 */
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles', 11);
function theme_enqueue_styles() {
    wp_enqueue_style('td-theme', get_template_directory_uri() . '/style.css', '', TD_THEME_VERSION, 'all' );
    wp_enqueue_style('td-theme-child', get_stylesheet_directory_uri() . '/style.css', array('td-theme'), TD_THEME_VERSION . 'c', 'all' );

}

function td_get_post_coauthors(){
    global $post;
    $home = home_url( '/' );
    $td_mod_single = new td_module_single($post);

  if (td_util::get_option('tds_p_show_author_name') != 'hide') {
        //echo $td_mod_single->get_author();
        $coauths = get_coauthors();
        if (count($coauths) > 1) {
            echo '<div class="td-post-author-name multiple-authors"><div class="td-author-by">By</div>';
            foreach ($coauths as $key => $coauth) {
            echo '<a href="'.$home.'/author/' . $coauth->user_nicename . '">' . $coauth->display_name . '</a>';
            }
            echo '<div class="td-author-line"> - </div></div>';
        }   else {
            echo $td_mod_single->get_author();
        };
    }
}

function td_get_post_coauthors_box(){
    global $post;
    $home = home_url( '/' );
    $td_mod_single = new td_module_single($post);
    if (td_util::get_option('tds_show_author_box') != 'hide') {
        $coauths = get_coauthors();
        if (count($coauths) > 1) {
            echo '<div class="author-box-list">';
            foreach ($coauths as $key => $coauth) {
                echo '<div class="author-box-wrap"><a href="'.$home.'/author/' . $coauth->user_nicename . '">';
                echo get_avatar($coauth->user_email, '96');
                    echo '</a><div class="desc"><div class="td-author-name vcard author"><span class="fn"><a href="'.$home.'/author/' . $coauth->user_nicename . '">' . $coauth->display_name . '</a></span></div>';
                echo '<div class="td-author-description">' . $coauth->description . '</div>';
                echo '<div class="td-author-social">';
                foreach (td_social_icons::$td_social_icons_array as $td_social_id => $td_social_name) {
                    $authorMeta = get_the_author_meta($td_social_id, $coauth->ID);
                    if (!empty($authorMeta)) {
                        echo td_social_icons::get_icon($authorMeta, $td_social_id, true);
                    }
                }
                echo '</div>';
                echo '</div><div class="clearfix"></div></div>';
            }
            echo '</div>';
        } else {
            echo $td_mod_single->get_author_box();
        };
    }
}

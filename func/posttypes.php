<?php
/* Initialize Poat Types */
add_action('init', 'pTypesInit');
function pTypesInit() {
    global $siteS, $snipS, $statuS, $questionS;
    $siteS 		= new siteSubmit();
    $snipS 		= new snipSubmit();
    $statuS		= new statusSubmit();
    $questionS 	= new questionSubmit();
}

/*** Sites Post Type ***/
class siteSubmit {
    public $meta_fields = array("title", "description", "siteurl");
	public $siteurl = '';
	
    function siteSubmit() {
        $sitelabels = array(
                'name' => __( 'Sites', 'post type general name' ),
                'singular_name' => __( 'Site', 'post type singular name' ),
                'add_new' => __( 'Add New', 'site' ),
                'add_new_item' => __( 'Add New Site' ),
                'edit_item' => __( 'Edit Site' ),
                'new_item' => __( 'New Site' ),
                'view_item' => __( 'View Site' ),
                'search_items' => __( 'Search Sites' ),
                'not_found' =>  __( 'No sites found in search' ),
                'not_found_in_trash' => __( 'No sites found in Trash' ),
                'parent_item_colon' => ''
        );
        $siteargs = array( 'labels' => $sitelabels,
                'public' => true, 'show_ui' => true, '_builtin' => false, 'capability_type' => 'post', 'hierarchical' => false, 'rewrite' => array('slug' => 'site'), 'query_var' => 'site', 'supports' => array('title','editor','author','comments')
        );
        register_post_type( 'site', $siteargs );

        add_action( 'admin_init', array(&$this, 'admin_init') );
        add_action( 'template_redirect', array(&$this, 'template_redirect') );
        add_action( 'wp_insert_post', array(&$this, 'wp_insert_post'), 10, 2 );
    }
    function site_edit_columns($columns) {
        $columns = array(
                "cb" 		=> "<input type=\"checkbox\" />",
                "title" 	=> "Site Title",
                "siteurl" 		=> "URL",
                "description"   => "Description",
                "sitetags" 	=> "Tags"
        );
        return $columns;
    }
    function site_custom_columns($column) {
        global $post;
        switch ($column) {
            case "title" : the_title();
                break;
            case "siteurl" : $custom = get_post_custom();
                $img = 'http://s.wordpress.com/mshots/v1/' . urlencode($custom["siteurl"][0]);
                echo '<img src="' . $img . '" width="50" />';
                break;
            case "description": the_content();
                break;
            case "tags" : echo get_the_term_list($post->ID, 'Tags', '', ', ','');
                break;
        }
    }
    function template_redirect() {
        global $wp;
        if ($wp->query_vars["post_type"] == "site") {
            include(TEMPLATEPATH . "/single-site.php");
            die();
        }
    }
    function admin_init() {
        add_meta_box("siteS-meta", "Site", array(&$this, "meta_options"), "site", "side", "high");
    }
    function save_details() {
        global $post;
        update_post_meta($post->ID, "siteurl", $_POST["siteurl"]);
    }
    function wp_insert_post($post_id, $post = null) {
        if ($post->post_type == "site") {
            foreach ($this->meta_fields as $key) {
                $value = @$_POST[$key];
                if (empty($value)) {
                    delete_post_meta($post_id, $key);
                    continue;
                }
                if (!is_array($value)) {
                    if (!update_post_meta($post_id, $key, $value)) {
                        add_post_meta($post_id, $key, $value);
                    }
                } else {
                    delete_post_meta($post_id, $key);
                    foreach ($value as $entry) add_post_meta($post_id, $key, $entry);
                }
            }
        }
    }
	// Admin post meta contents
	public function meta_options() {
		global $post, $url;
		$custom = get_post_custom($post->ID);
		$url = $custom["siteurl"][0];		
		$myurl = trailingslashit( get_post_meta( $post->ID, 'siteurl', true ) );
		if ( $myurl != '' ) {
		/* validate url
		/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \?=.-]*)*\/?$/
		*/
			if ( preg_match( "/http(s?):\/\//", $myurl )) {
				$siteurl = get_post_meta( $post->ID, 'siteurl', true );
				$mshoturl = 'http://s.wordpress.com/mshots/v1/' . urlencode( $myurl );
			} else {
				$siteurl = 'http://' . get_post_meta( $post->ID, 'siteurl', true );
				$mshoturl .= 'http://s.wordpress.com/mshots/v1/' . urlencode( 'http://' . $myurl );
			}
			$imgsrc  = '<img src="' . $mshoturl . '?w=250" alt="' . $title . '" title="' . $title . '" />';
		} ?>
		<p><label>Clean Url: <input id="siteurl" size="26" name="siteurl" value="<?php echo $url; ?>" /></label></p>
		<p><label>Mshot Url: <input id="mshoturl" size="26" name="mshoturl" value="<?php echo $mshoturl; ?>" /></label></p>
		<p><?php echo '<a href="'.$siteurl.'">'.$imgsrc.'</a>'; ?></p>
	<?php
	} // end meta options


    public function mshot($mshotsize) {
        global $post, $url;
        $imgWidth = $mshotsize;
        $myurl = get_post_meta($post->ID, 'siteurl', true);
        if ( !empty($myurl) && preg_match('/http(s?):\/\//', $myurl) ) {
            $siteurl = get_post_meta($post->ID, 'siteurl', true);
            $newurl = "http://s.wordpress.com/mshots/v1/".urlencode($myurl);
        	echo '<img src="'.$newurl.'?w='.$imgWidth.'" alt="'.get_the_title().'" title="'.get_the_title().'" />';
		} else {
			echo '<img src="'.$newurl.'?w='.$imgWidth.'" alt="'.get_the_title().'" title="'.get_the_title().'" />';
        
        return;
    	}
	}

/*
    public function meta_options() {
        global $post, $url;
        $custom = get_post_custom($post->ID);
        $url = $custom["siteurl"][0];
        $valid = "/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \?=.-]*)*\/?$/";
        $myurl = get_post_meta( $post->ID, 'siteurl', true );

        if ( !empty($myurl) && preg_match($valid, $myurl) ) {
            $enc_url = urlencode( $myurl );
            $newurl  = 'http://s.wordpress.com/mshots/v1/' . $enc_url;
            return;
        }
        ?>
<p><label>Site Url: <input id="siteurl" size="26" name="siteurl" value="<?php echo $url; ?>" /></label></p>
<p><label>Mshot Url: <input id="newurl" size="26" name="newurl" value="<?php echo $newurl; ?>" /></label></p>
        <?php
        echo '<p><a href="'.$url.'"><img src="'.$newurl.'?w=250" alt="'.get_the_title().'" title="'.get_the_title().'" /></a></p>';
    }
*

	
	// mshot image
	public function mshot($mshotsize) {		
		global $post, $url;
		$imgWidth = $mshotsize;
		$myurl = get_post_meta($post->ID, 'siteurl', true);
		if ($myurl != '') {
			if (preg_match("/http(s?):\/\//", $myurl)) {
				$siteurl = get_post_meta($post->ID, 'siteurl', true);
				$newurl = 'http://s.wordpress.com/mshots/v1/' . urlencode($myurl) . '?w=' . $imgWidth; 			} else {
				$siteurl = 'http://' . get_post_meta($post->ID, 'siteurl', true);
				$newurl = 'http://s.wordpress.com/mshots/v1/' . urlencode('http://' .$myurl) . '?w=' . $imgWidth;
			}
			echo '<img src="' . $newurl . '" alt="' . get_the_title() . '" title="' . get_the_title() . '" />';
			return;
		}
	} // end mshot()
*/

}


/*** Code Snippets Post Type ***/
class snipSubmit {
    public $meta_fields = array("title", "description", "snipS");

    function snipSubmit() {
        $sniplabels = array(
                'name' => __( 'Snippets', 'post type general name' ),
                'singular_name' => __( 'Snippet', 'post type singular name' ),
                'add_new' => __( 'Add New', 'snippet' ),
                'add_new_item' => __( 'Add New Snippet' ),
                'edit_item' => __( 'Edit Snippet' ),
                'new_item' => __( 'New Snippet' ),
                'view_item' => __( 'View Snippet' ),
                'search_items' => __( 'Search Snippets' ),
                'not_found' =>  __( 'No snippets found in search' ),
                'not_found_in_trash' => __( 'No snippets found in Trash' ),
                'parent_item_colon' => ''
        );
        $snipargs = array( 'labels' => $sniplabels,
                'public' => true, 'show_ui' => true, '_builtin' => false, 'capability_type' => 'post', 'hierarchical' => false, 'rewrite' => array('slug' => 'snippet'), 'query_var' => 'snippet', 'supports' => array('title','editor','excerpt','author','comments')
        );
		/* Code Type Taxonomy */		
		$sniptax = array(
			'name' => __( 'Syntax', 'taxonomy general name' ),
			'singular_name' => __( 'Syntax', 'taxonomy singular name' ),
			'search_items' =>  __( 'Search Syntaxes' ),
			'popular_items' => __( 'Popular Syntaxes' ),
			'all_items' => __( 'All Syntaxes' ),
			'parent_item' => null, 'parent_item_colon' => null,
			'edit_item' => __( 'Edit Syntax' ), 
			'update_item' => __( 'Update Syntax' ),
			'add_new_item' => __( 'Add New Syntax' ),
			'new_item_name' => __( 'New Syntax Name' ),
			'separate_items_with_commas' => __( 'Separate syntax with commas' ),
			'add_or_remove_items' => __( 'Add or remove syntax' ),
			'choose_from_most_used' => __( 'Choose from the most used syntax' )
		);
		/* Register Syntax Taxonomy - Hierarchical */
		register_taxonomy( 'syntax', 'snip', array( 'hierarchical' => true, 'labels' => $sniptax, 'show_ui' => true, 'query_var' => 'syntax', 'rewrite' => array( 'slug' => 'syntax' )
		));
        register_post_type( 'snip', $snipargs );

        add_action( 'admin_init', array(&$this, 'admin_init') );
        add_action( 'template_redirect', array(&$this, 'template_redirect') );
        add_action( 'wp_insert_post', array(&$this, 'wp_insert_post'), 10, 2 );
    }
    function template_redirect() {
        global $wp;
        if ($wp->query_vars["post_type"] == "snip") {
            include(TEMPLATEPATH . "/snip.php");
            die();
        }
    }
    function admin_init() {
        add_meta_box("snipS-meta", "Snippet", array(&$this, "meta_options"), "snip", "normal");
    }
    function meta_options() {
        global $post;
        $custom = get_post_custom($post->ID);
        $snip = $custom["snip"][0];
        echo '<h2>Snippet:</h2><textarea name="snip" cols="60" rows="6" /></textarea>';
    }
    function wp_insert_post($post_id, $post = null) {
        if ($post->post_type == "snip") {
            foreach ($this->meta_fields as $key) {
                $value = @$_POST[$key];
                if (empty($value)) {
                    delete_post_meta($post_id, $key);
                    continue;
                }
                if (!is_array($value)) {
                    if (!update_post_meta($post_id, $key, $value)) {
                        add_post_meta($post_id, $key, $value);
                    }
                } else {
                    delete_post_meta($post_id, $key);
                    foreach ($value as $entry) add_post_meta($post_id, $key, $entry);
                }
            }
        }
    }
}


/** Status Post Type **/
class statusSubmit {
    public $meta_fields = array("title", "status");

    function statusSubmit() {
        $statuslabels = array(
                'name' => __( 'Status Updates', 'post type general name' ),
                'singular_name' => __( 'Status', 'post type singular name' ),
                'add_new' => __( 'Add New', 'status' ),
                'add_new_item' => __( 'Add New Status Update' ),
                'edit_item' => __( 'Edit Status Update' ),
                'new_item' => __( 'New Status Update' ),
                'view_item' => __( 'View Status Updates' ),
                'search_items' => __( 'Search Status Updates' ),
                'not_found' =>  __( 'No status updates found' ),
                'not_found_in_trash' => __( 'No status updates found in Trash' ),
                'parent_item_colon' => ''
        );
        $statusargs = array( 'labels' => $statuslabels,
                'public' => true, 'show_ui' => true, '_builtin' => false, 'capability_type' => 'post', 'hierarchical' => false, 'rewrite' => array('slug' => 'status'), 'query_var' => 'status',
                'supports' => array('title','author','comments')
        );
        register_post_type( 'status', $statusargs );

        add_action( 'admin_init', array(&$this, 'admin_init') );
        add_action( 'template_redirect', array(&$this, 'template_redirect') );
        add_action( 'wp_insert_post', array(&$this, 'wp_insert_post'), 10, 2 );
    }
    function template_redirect() {
        global $wp;
        if ($wp->query_vars["post_type"] == "status") {
            include(TEMPLATEPATH . "/status.php");
            die();
        }
    }
    function admin_init() {
        add_meta_box("status-meta", "Status", array(&$this, "meta_options"), "status", "normal");
    }
    function meta_options() {
        global $post;
        $custom = get_post_custom($post->ID);
        $status = $custom["status"][0];
        echo '<h2>Update Your Status:</h2><textarea name="status" cols="60" rows="6" /></textarea>';
    }
    function wp_insert_post($post_id, $post = null) {
        if ($post->post_type == "status") {
            foreach ($this->meta_fields as $key) {
                $value = @$_POST[$key];
                if (empty($value)) {
                    delete_post_meta($post_id, $key);
                    continue;
                }
                if (!is_array($value)) {
                    if (!update_post_meta($post_id, $key, $value)) {
                        add_post_meta($post_id, $key, $value);
                    }
                } else {
                    delete_post_meta($post_id, $key);
                    foreach ($value as $entry) add_post_meta($post_id, $key, $entry);
                }
            }
        }
    }
}


/*** Questions Post Type ***/
class questionSubmit {
    public $meta_fields = array("title", "description", "question");

    function questionSubmit() {
        $questionlabels = array(
                'name' => __( 'Questions', 'post type general name' ),
                'singular_name' => __( 'Question', 'post type singular name' ),
                'add_new' => __( 'Add New', 'Question' ),
                'add_new_item' => __( 'Add New Question' ),
                'edit_item' => __( 'Edit Question' ),
                'new_item' => __( 'New Question' ),
                'view_item' => __( 'View Questions' ),
                'search_items' => __( 'Search Questions' ),
                'not_found' =>  __( 'No questions found' ),
                'not_found_in_trash' => __( 'No questions found in Trash' ),
                'parent_item_colon' => ''
        );
        $questionargs = array( 'labels' => $questionlabels,
                'public' => true, 'show_ui' => true, '_builtin' => false, 'capability_type' => 'post', 'hierarchical' => false, 'rewrite' => array('slug' => 'question'), 'query_var' => 'question',
                'supports' => array('title','editor','author','comments')
        );
        register_post_type( 'question', $questionargs );

        add_action( 'admin_init', array(&$this, 'admin_init') );
        add_action( 'template_redirect', array(&$this, 'template_redirect') );
        add_action( 'wp_insert_post', array(&$this, 'wp_insert_post'), 10, 2 );
    }
    function template_redirect() {
        global $wp;
        if ($wp->query_vars["post_type"] == "question") {
            include(TEMPLATEPATH . "/question.php");
            die();
        }
    }
    function admin_init() {
        add_meta_box("question-meta","Question", array(&$this, "meta_options"),"question","advanced");
    }
    function meta_options() {
        global $post;
        $custom = get_post_custom($post->ID);
        $question = $custom["question"][0];
        echo '<h2>Ask Something:</h2><textarea name="question" cols="60" rows="6" /></textarea>';
    }
    function wp_insert_post($post_id, $post = null) {
        if ($post->post_type == "question") {
            foreach ($this->meta_fields as $key) {
                $value = @$_POST[$key];
                if (empty($value)) {
                    delete_post_meta($post_id, $key);
                    continue;
                }
                if (!is_array($value)) {
                    if (!update_post_meta($post_id, $key, $value)) {
                        add_post_meta($post_id, $key, $value);
                    }
                } else {
                    delete_post_meta($post_id, $key);
                    foreach ($value as $entry) add_post_meta($post_id, $key, $entry);
                }
            }
        }
    }
}
?>
<?php
$insert = new siteSubmit();

if( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] )) {
		$post = array(
			'post_title'	=> $_POST['title'],
			'description'	=> $_POST['description'],
			'siteurl'		=> $_POST['site'],
			'cat'			=> $_POST['category'],
			'labels'		=> $_POST['lbls'],
			'post_status'	=> 'publish',
			'post_type'		=> $_POST['post_type']
		);
		wp_insert_post($post);
		
		$insert->template_redirect();
}
$insert->wp_insert_post($post);

// do_action('wp_insert_post', 'wp_insert_post');
	
?>

<div id="postbox">
	<div id="tabs">
		<ul>
			<li><a href="#tab1">Site</a></li>
			<li><a href="#tab2">Snippet</a></li>
			<li><a href="#tab3">Status</a></li>
			<li><a href="#tab4">Question</a></li>
		</ul>
		
		<div id="tab1" class="default">
			<div class="adminaccess">
				<form id="new_site" name="new_site" method="post" action="">
					<div id="media-buttons" class="hide-if-no-js"><?php echo N2::media_buttons2(); ?></div>
					<p><label for="title">Title:</label> 
						<input type="text" name="title" id="title" tabindex="1" size="30" value="" /></p>
					<p><label for="siteurl">Site:</label> 
						<input value="" name="siteurl" id="siteurl" onkeyup="siteValue(this.value)" tabindex="2" size="30" /> 
						<div id="mshot"></div></p>
							
					<p><label for="description">Description:</label><br />
					<textarea class="expand70-200" name="description" id="description" tabindex="3" rows="4" cols="45"></textarea></p>
	
					<p><?php wp_dropdown_categories( 'show_option_none=Category&tab_index=4&taxonomy=category' ); ?></p>
					
					<p><label for="labels">Labels:</label> 
					<?php $lbls = get_taxonomy( 'label' ); ?>
					<input type="text" name="lbls" id="lbls" value="" tabindex="5" size="30" /></p>
	
					<input type="hidden" name="post_type" id="post_type" value="site" />
					<p align="right"><input type="submit" name="submit" id="submit" tabindex="6" value="Submit Site" /></p>
	
					<span class="progress" id="ajaxActivity">
						<img src="<?php bloginfo('template_directory'); ?>'/images/ajax-loader.gif" alt="<?php esc_attr_e( 'Loading...', 'n2' ); ?>" title="<?php esc_attr_e( 'Loading...', 'n2' ); ?>" />
					</span>
					<input type="hidden" name="action" value="post" />
					<?php wp_nonce_field( 'new-post' ); ?>
				</form>
			</div>
		</div>
		
		<div id="tab2">
			<div class="adminaccess">
				<form id="new_snip" name="new_snip" method="post" action="">
					<p><label for="title">Title:</label> 
						<input type="text" name="title" id="title" tabindex="1" size="30" value="" /></p>
					<p><label for="snip">Snippet</label><br />
					<textarea class="expand70-200" id="snip" name="snip" tabindex="2" rows="5" cols="45"></textarea>
					<label class="post-error" for="snip" id="postsnip_error"></label></p>
					
					<p><label for="description">Description</label><br />
					<textarea class="expand70-200" id="description" name="description" tabindex="3" rows="3" cols="45"></textarea>
					<label class="post-error" for="description" id="postsnip_error"></label></p>

					<p><?php $syntax = get_object_taxonomies('snip');
					$syntaxterms=get_terms($syntax, 'orderby=count&offset=1&hide_empty=0&fields=all');
					// var_dump($syntaxterms); die; ?>
					<select name='syntax' id='syntax' tabindex="4">
						<option value='' <?php if (!count( $names )) echo "selected";?>>Select syntax</option>
						<?php foreach ( $syntaxterms as $code ) { echo '<option value="' . $code->slug . '" selected>' . $code->name . '</option>',"\n"; } ?>
					</select></p>
					
					<p><label for="tags">Tags:</label>
					<?php $tags = get_taxonomy( 'post_tags' ); ?>
					<input type="text" name="tags" id="tags" value="" tabindex="5" size="30" /></p>

					<input type="hidden" name="post_type" id="post_type" value="snip" />
					<p align="right"><input type="submit" name="submit" id="submit" tabindex="6" value="Post Snippet" /></p>
					<span class="progress" id="ajaxActivity">
						<img src="<?php bloginfo('template_directory'); ?>'/images/ajax-loader.gif" alt="<?php esc_attr_e( 'Loading...', 'n2' ); ?>" title="<?php esc_attr_e( 'Loading...', 'n2' ); ?>" />
					</span>
				<input type="hidden" name="action" value="post" />
				<?php wp_nonce_field( 'new-post' ); ?>
			</form>
			</div>
		</div>
		
		<div id="tab3">
			<div class="adminaccess">
				<form id="new_status" name="new_status" method="post" action="">
					<div id="media-buttons" class="hide-if-no-js"><?php echo N2::media_buttons2(); ?></div>
					<p><label for="status">What's up with you...</label><br />
					<textarea class="expand70-200" name="status" id="status" tabindex="2" rows="4" cols="45"></textarea></p>
					<label class="post-error" for="status" id="posttext_error"></label>

					<p><label for="tags">Tags:</label>
					<?php $tags = get_taxonomy( 'post_tags' ); ?>
					<input type="text" name="tags" id="tags" value="" tabindex="3" size="30" /></p>
					
					<input type="hidden" name="post_type" id="post_type" value="status" />
					<p align="right"><input type="submit" name="submit" id="submit" tabindex="4" value="Update Status" /></p>
	
					<span class="progress" id="ajaxActivity">
						<img src="<?php bloginfo('template_directory'); ?>'/images/ajax-loader.gif" alt="<?php esc_attr_e( 'Loading...', 'n2' ); ?>" title="<?php esc_attr_e( 'Loading...', 'n2' ); ?>" />
					</span>
				<input type="hidden" name="action" value="post" />
				<?php wp_nonce_field( 'new-post' ); ?>
			</form>
			</div>
		</div>
		
		<div id="tab4">
			<div class="adminaccess">

				<form id="new_question" name="new_question" method="post" action="">
					<p><label for="title">Title:</label> 
						<input type="text" name="title" id="title" tabindex="1" size="30" value="" /></p>
					<label for="question">Question:</label><br />
					<textarea class="expand70-200" name="question" id="question" tabindex="2" rows="4" cols="45"></textarea>
					<label class="post-error" for="question" id="posttext_error"></label>

					<p><label for="tags">Tags:</label>
					<?php $tags = get_taxonomy( 'post_tags' ); ?>
					<input type="text" name="tags" id="tags" value="" tabindex="3" size="30" /></p>

					<input type="hidden" name="post_type" id="post_type" value="question" />
					<p align="right"><input type="submit" name="submit" id="submit" tabindex="4" value="Post Question" /></p>
	
					<span class="progress" id="ajaxActivity">
						<img src="<?php bloginfo('template_directory'); ?>'/images/ajax-loader.gif" alt="<?php esc_attr_e( 'Loading...', 'n2' ); ?>" title="<?php esc_attr_e( 'Loading...', 'n2' ); ?>" />
					</span>
				<input type="hidden" name="action" value="post" />
				<?php wp_nonce_field( 'new-post' ); ?>
			</form>
			</div>
		</div>
	</div>
</div>
<div id="tabs">
	<ul>
		<li><a href="#tab1">Login</a></li>
		<li><a href="#tab2">Register</a></li>
		<li><a href="#tab3">Lost Password</a></li>
	</ul>
	<div id="tab1">
		<?php wp_login_form(); ?>
	</div>
	<div id="tab2">
		<form method="post" action="<?php echo site_url('wp-login.php?action=register', 'login_post') ?>" id="registerform" name="registerform">
			<p>
				<label>Username<br />
				<input type="text" tabindex="10" size="20" value="" class="input" id="user_login" name="user_login" />
				</label>
			</p>
			<p>
				<label>Email<br />
				<input type="text" tabindex="20" size="25" value="" class="input" id="user_email" name="user_email" />
				</label>
			</p>
			<p id="reg_passmail">A password will be e-mailed to you.</p>
			<br class="clear">
			<p class="submit">
			<?php do_action('login_form', 'register'); ?>
				<input type="submit" tabindex="100" value="Register" class="button-primary" id="wp-submit" name="wp-submit"											 />
				<input type="hidden" name="redirect_to" value="/" />
				<input type="hidden" name="cookie" value="1" />
			</p>
		</form>
	</div>			
	<div id="tab3">
		<form method="post" action="<?php echo site_url('wp-login.php?action=lostpassword', 'login_post') ?>" id="lostpasswordform" name="lostpasswordform">
			<p>
				<label>Username or Email:<br />
				<input type="text" tabindex="10" size="20" value="" class="input" id="user_login" name="user_login" />
				</label>
			</p>
			<p class="submit">
			<?php do_action('login_form', 'lostpassword'); ?>
				<input type="submit" tabindex="100" value="Get New Password" class="button-primary" id="wp-submit" name="wp-submit" />
				<input type="hidden" name="redirect_to" value="/" />
				<input type="hidden" name="cookie" value="1" />
			</p>
		</form>
	</div>
</div>
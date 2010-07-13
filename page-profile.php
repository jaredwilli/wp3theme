<?php get_header(); ?>
<div id="post">
	<article class="entry">

	<?php
	if ( $user_ID ) { 
		global $current_user;
		get_currentuserinfo(); ?>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td rowspan="7" align="center" valign="top"><?php echo member_get_avatar( $current_user_id, get_the_author_email( ), 50 ); ?></td>
			</tr>
			<tr>
				<td>User ID:</td>
				<td><?php $current_user->ID; ?></td>
			</tr>
			<tr>
				<td>Username:</td>
				<td><?php echo $current_user->user_login; ?></td>
			</tr>
			<tr>
				<td>Name:</td>
				<td><?php echo $current_user->user_firstname . $current_user->user_lastname; ?></td>
			</tr>
			<tr>
				<td>Display name:</td>
				<td><?php echo $current_user->display_name; ?></td>
			</tr>
			<tr>
				<td>Email:</td>
				<td><?php echo $current_user->user_email; ?></td>
			</tr>
			<tr>
				<td>User level:</td>
				<td><?php echo $current_user->user_level; ?></td>
			</tr>
		</table>

	<?php } else { 
		require_once($func . '/widgets/loginform.php');
	} ?>
	
	</article>
</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
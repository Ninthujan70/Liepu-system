<?php

/**
 * This is main home page template for the development
 *
 * @package document_child
 *
 */

get_header();

$posts_list = get_posts(
	array(
		'post_type'      => 'document',
		'posts_per_page' => -1,
	)

);
$downloadsCount = 0;
if ($posts_list) {
	foreach ($posts_list as $key => $value) {
		$downloads 	=	get_post_meta($value->ID, 'pdf_download_count', true);
		if ($downloads) {
			$downloadsCount += $downloads;
		}
	}
}
?>
<main>
	<div class="dahsboard">
		<h1 class="main-title">DMS Dashboard</h1>
		<ul class="dash-item">
			<li>
				<h2><?php echo count($posts_list); ?></h2>
				<h3>Total Documents</h3>
			</li>
			<li>
				<h2><?php echo esc_html(count_users()['total_users']); ?></h2>
				<h3>Total Users</h3>
			</li>
			<?php
			if (isset(count_users()['avail_roles']['administrator'])) :
			?>
				<li>
					<h2><?php echo esc_html(count_users()['avail_roles']['administrator']); ?></h2>
					<h3>Total Admins</h3>
				</li>
			<?php endif; ?>
			<?php
			if (isset(count_users()['avail_roles']['editor'])) :
			?>
				<li>
					<h2><?php echo esc_html(count_users()['avail_roles']['editor']); ?></h2>
					<h3>Total Editors</h3>
				</li>
			<?php endif; ?>
			<?php
			if (isset(count_users()['avail_roles']['author'])) :
			?>
				<li>
					<h2><?php echo esc_html(count_users()['avail_roles']['author']); ?></h2>
					<h3>Total Author</h3>
				</li>
			<?php endif; ?>
			<li>
				<h2><?php echo $downloadsCount ?></h2>
				<h3>Total Downloads</h3>
			</li>
		</ul>
		<a class="goto-admin" href="<?php echo esc_html(get_site_url()); ?>/wp-admin/edit.php?post_type=document">Manage Documents</a>
	</div>
</main>
<?php
get_footer();

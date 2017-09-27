<?php
// echo 'http://dev.dev/wp-content/plugins/obm-genesis-generator/submit.php';
?>
<div class="rhyzz-bootstrap">

	<header role="banner">

		<div id="progress"><span>0%</span><div></div></div>

	</header>

	<div id="form-pager">

		<!-- <form class="steps" method="post" action="http://dev.dev/wp-content/plugins/obm-genesis-generator/submit.php"> -->
		<form class="steps" method="post">

			<input type="hidden" name="obmgenesis_generate" value="1" />

			<section id="page1" class="step">

				<h3>Theme Basics</h3>

				<div class="form-input one-half first">
					<label for="theme-name"><span>*</span> Theme Name</label>
					<input type="text" name="theme-name" id="theme-name" required>
				</div>

				<div class="form-input one-half">
					<label for="theme-slug"><span>*</span> Theme Slug</label>
					<input type="text" name="theme-slug" id="theme-slug" required>
				</div>

				<div class="form-input">
					<label for="theme-uri">Theme URI</label>
					<input type="text" name="theme-uri" id="theme-uri">
				</div>

				<div class="form-input one-half first">
					<label for="author-name">Author Name</label>
					<input type="text" name="author-name" id="author-name">
				</div>

				<div class="form-input one-half">
					<label for="author-email">Author Email</label>
					<input type="text" name="author-email" id="author-email">
				</div>

				<div class="form-input">
					<label for="author-uri">Author URI</label>
					<input type="text" name="author-uri" id="author-uri">
				</div>

				<div class="form-input">
					<label for="theme-description">Theme Description</label>
					<input type="text" name="theme-description" id="theme-description">
				</div>

			</section>

			<section id="page2" class="pure-form-aligned step">

				<h3>Menus, Layouts, Sidebars, Widgets</h3>

				<div class="repeat">

					<h4>All menu locations that will be enabled in the theme</h4>
					<table class="table table-striped table-bordered">
						<tbody class="container ui-sortable" data-rf-row-count="2">
							<tr class="template row" style="display: none;">
								<td width="90%">
									<div class="form-input one-half first">
										<label for="menu-areas[{{row-count-placeholder}}][name]">Menu Name</label>
										<input type="text" name="menu-areas[{{row-count-placeholder}}][name]" id="menu-areas[{{row-count-placeholder}}][name]" disabled="">
									</div>

									<div class="form-input one-half">
										<label for="menu-areas[{{row-count-placeholder}}][slug]">Menu Slug</label>
										<input type="text" name="menu-areas[{{row-count-placeholder}}][slug]" id="menu-areas[{{row-count-placeholder}}][slug]" disabled="">
									</div>
								</td>
								<td width="10%"><span class="remove btn btn-danger">Remove</span></td>
							</tr>
							<tr class="row">
								<td width="90%">
									<div class="form-input one-half first">
										<label for="menu-areas[0][name]">Menu Name</label>
										<input type="text" name="menu-areas[0][name]" id="menu-areas[0][name]" value="Header Navigation">
									</div>

									<div class="form-input one-half">
										<label for="menu-areas[0][slug]">Menu Slug</label>
										<input type="text" name="menu-areas[0][slug]" id="menu-areas[0][slug]" value="nav-primary">
									</div>
								</td>
								<td width="10%"><span class="remove btn btn-danger">Remove</span></td>
							</tr>
							<tr class="row">
								<td width="90%">
									<div class="form-input one-half first">
										<label for="menu-areas[1][name]">Menu Name</label>
										<input type="text" name="menu-areas[1][name]" id="menu-areas[1][name]" value="Footer Navigation">
									</div>

									<div class="form-input one-half">
										<label for="menu-areas[1][slug]">Menu Slug</label>
										<input type="text" name="menu-areas[1][slug]" id="menu-areas[1][slug]" value="nav-secondary">
									</div>
								</td>
								<td width="10%"><span class="remove btn btn-danger">Remove</span></td>
							</tr>
						</tbody>
						<tfoot>
							<tr>
								<td width="10%" colspan="2"><span class="add btn btn-success">Add</span></td>
							</tr>
						</tfoot>
					</table>

				</div>

				<div class="form-input">
					<h4 for="genesis-layouts">Unregister Genesis Layouts</h4>
					<input type="checkbox" name="genesis-layouts[]" value="full-width-content">Full Width<br />
					<input type="checkbox" name="genesis-layouts[]" value="content-sidebar">Content Sidebar<br />
					<input type="checkbox" name="genesis-layouts[]" value="sidebar-content">Sidebar Content<br />
					<input type="checkbox" name="genesis-layouts[]" value="content-sidebar-sidebar" checked>Content Sidebar Sidebar<br />
					<input type="checkbox" name="genesis-layouts[]" value="sidebar-content-sidebar" checked>Sidebar Content Sidebar<br />
					<input type="checkbox" name="genesis-layouts[]" value="sidebar-sidebar-content" checked>Sidebar Sidebar Content
				</div>

				<div class="form-input">
					<h4 for="genesis-sidebars">Unregister Default Genesis Sidebars</h4>
					<input type="checkbox" name="genesis-sidebars[]" value="header-right">Header Right<br />
					<input type="checkbox" name="genesis-sidebars[]" value="sidebar">Primary Sidebar<br />
					<input type="checkbox" name="genesis-sidebars[]" value="sidebar-alt">Secondary Sidebar<br />
					<label for="footer-sidebars">Number of Footer Sidebars</label>
					<input type="number" name="footer-sidebars" id="footer-sidebars" value="2">
				</div>

				<div class="repeat">

					<h4>Additional Sidebars</h4>
					<table class="table table-striped table-bordered">
						<tbody class="container ui-sortable" data-rf-row-count="2">
							<tr class="template row" style="display: none;">
								<td width="90%">
									<div class="form-input one-half first">
										<label for="sidebars[{{row-count-placeholder}}][name]"><span>*</span> Sidebar Name</label>
										<input type="text" name="sidebars[{{row-count-placeholder}}][name]" id="sidebars[{{row-count-placeholder}}][name]" disabled="">
									</div>

									<div class="form-input one-half">
										<label for="sidebars[{{row-count-placeholder}}][slug]"><span>*</span> Sidebar Slug</label>
										<input type="text" name="sidebars[{{row-count-placeholder}}][slug]" id="sidebars[{{row-count-placeholder}}][slug]" disabled="">
									</div>
								</td>
								<td width="10%"><span class="remove btn btn-danger">Remove</span></td>
							</tr>
							<tr class="row">
								<td width="90%">
									<div class="form-input one-half first">
										<label for="sidebars[0][name]">Sidebar Name</label>
										<input type="text" name="sidebars[0][name]" id="sidebars[0][name]" value="After Post">
									</div>

									<div class="form-input one-half">
										<label for="sidebars[0][slug]">Sidebar Slug</label>
										<input type="text" name="sidebars[0][slug]" id="sidebars[0][slug]" value="after-post">
									</div>
								</td>
								<td width="10%"><span class="remove btn btn-danger">Remove</span></td>
							</tr>
						</tbody>
						<tfoot>
							<tr>
								<td width="10%" colspan="2"><span class="add btn btn-success">Add</span></td>
							</tr>
						</tfoot>
					</table>

				</div>

			</section>

			<section id="page3" class="step">

				<h3>Additional Theme Settings</h3>

				<div class="repeat">

					<h4>Image Sizes</h4>
					<table class="table table-striped table-bordered">
						<tbody class="container ui-sortable" data-rf-row-count="2">
							<tr class="template row" style="display: none;">
								<td width="90%">
									<div class="form-input one-fourth first">
										<label for="image-sizes[{{row-count-placeholder}}][slug]">Image Slug</label>
										<input type="text" name="image-sizes[{{row-count-placeholder}}][slug]" id="image-sizes[{{row-count-placeholder}}][slug]" disabled="">
									</div>

									<div class="form-input one-fourth">
										<label for="image-sizes[{{row-count-placeholder}}][width]">Image Width</label>
										<input type="text" name="image-sizes[{{row-count-placeholder}}][width]" id="image-sizes[{{row-count-placeholder}}][width]" disabled="">
									</div>

									<div class="form-input one-fourth">
										<label for="image-sizes[{{row-count-placeholder}}][height]">Image Height</label>
										<input type="text" name="image-sizes[{{row-count-placeholder}}][height]" id="image-sizes[{{row-count-placeholder}}][height]" disabled="">
									</div>

									<div class="form-input one-fourth">
										<label for="image-sizes[{{row-count-placeholder}}][crop]">Crop Image</label>
										<input type="checkbox" name="image-sizes[{{row-count-placeholder}}][crop]" id="image-sizes[{{row-count-placeholder}}][crop]" disabled="">
									</div>
								</td>
								<td width="10%"><span class="remove btn btn-danger">Remove</span></td>
							</tr>
							<tr class="row">
								<td width="90%">
									<div class="form-input one-fourth first">
										<label for="image-sizes[0][slug]">Image Slug</label>
										<input type="text" name="image-sizes[0][slug]" id="image-sizes[0][slug]">
									</div>

									<div class="form-input one-fourth">
										<label for="image-sizes[0][width]">Image Width</label>
										<input type="text" name="image-sizes[0][width]" id="image-sizes[0][width]">
									</div>

									<div class="form-input one-fourth">
										<label for="image-sizes[0][height]">Image Height</label>
										<input type="text" name="image-sizes[0][height]" id="image-sizes[0][height]">
									</div>

									<div class="form-input one-fourth">
										<label for="image-sizes[0][crop]">Crop Image</label>
										<input type="checkbox" name="image-sizes[0][crop]" id="image-sizes[0][crop]" checked>
									</div>
								</td>
								<td width="10%"><span class="remove btn btn-danger">Remove</span></td>
							</tr>
						</tbody>
						<tfoot>
							<tr>
								<td width="10%" colspan="2"><span class="add btn btn-success">Add</span></td>
							</tr>
						</tfoot>
					</table>

				</div>

				<div class="form-input">
					<h4 for="genesis-settings">Genesis Layouts</h4>
					<input type="checkbox" name="genesis-settings[]" value="remove-title">Remove Site Title<br />
					<input type="checkbox" name="genesis-settings[]" value="remove-subtitle">Remove Site Description<br />
					<!-- <input type="checkbox" name="genesis-settings[]" value="remove-post-info">Remove Post Info<br /> -->
					<!-- <input type="checkbox" name="genesis-settings[]" value="remove-post-meta">Remove Post Meta<br /> -->
				</div>

			</section>

			<footer class="steps-nav">

				<button type="button" class="prev pure-button">Previous</button>
				<button type="button" class="next pure-button">Next</button>
				<button type="submit" class="submit pure-button">Submit</button>

			</footer>

		</form>

	</div>

</div>

<script type="text/javascript">
jQuery(function() {
	jQuery('.repeat').each(function() {
		jQuery(this).repeatable_fields({
			wrapper: 'table',
			container: 'tbody',
		});
	});
});
</script>
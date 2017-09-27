<?php
/**
 * Plugin Name: OBM Genesis Child Generator
 * Description: Generates themes based on the obm-genesis-child theme.
 * Author: David Laietta
 * Author URI: https://orangeblossommedia.com
 */

class OBM_Genesis_Generator_Plugin {

	protected $theme = array(
		  'theme-name'  		=> 'OBM Genesis Child',
		  'theme-slug'  		=> 'obm-genesis-child',
		  'theme-uri'   		=> 'https://orangeblossommedia.com',
		  'author-name' 		=> 'David Laietta',
		  'author-email'		=> 'david@orangeblossommedia.com',
		  'author-uri'  		=> 'https://orangeblossommedia.com',
		  'theme_description'	=> '',
		  'menu-areas'   		=> array(),
		  'genesis-layouts' 	=> array(),
		  'genesis-sidebars'	=> array(),
		  'footer-sidebars' 	=> '',
		  'sidebars'  			=> array(),
		  'image-sizes' 		=> array(),
		  'genesis-settings'	=> array(),
		);
	protected $templates;

	/**
	 * Fired when file is loaded.
	 */
	public function __construct() {

		add_action( 'init', array( $this, 'init' ) );

		add_filter( 'obmgenesis_generator_file_contents', array( $this, 'do_replacements' ), 10, 2 );

		add_shortcode( 'obmgenesis_generator', array( $this, 'obmgenesis_generator_create' ) );

		add_action( 'wp_enqueue_scripts', array( $this, 'obmgenesis_enqueue_scripts' ) );

	}

	public function obmgenesis_generator_create() {

		return file_get_contents( plugin_dir_url( __FILE__) . 'obmgenesis-generator-form.php' );

	}

	public function obmgenesis_enqueue_scripts() {

		global $post;
		$assets_url = plugin_dir_url( __FILE__) . 'assets/';

		wp_register_script( 'jquery-validate', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js', array( 'jquery' ), '1.17.0', true );
		wp_register_script( 'jquery-repeatable-fields', $assets_url . 'repeatable-fields.js', array( 'jquery' ), '1.0', true );
		wp_register_script( 'obmgenesis-generator', $assets_url . 'genesis-generator.js', array( 'jquery' ), '1.0', true );
		wp_register_style( 'obmgenesis-generator-css', $assets_url . 'genesis-generator.css' );

		if( is_a( $post, 'WP_Post' ) && has_shortcode( $post->post_content, 'obmgenesis_generator') ) {
			wp_enqueue_script( 'jquery' );
			wp_enqueue_script( 'jquery-ui-core' );
			wp_enqueue_script( 'jquery-validate' );
			wp_enqueue_script( 'jquery-repeatable-fields' );
			wp_enqueue_script( 'obmgenesis-generator' );
			wp_enqueue_style( 'obmgenesis-generator-css' );
		}

	}

	/**
	 * Creates zip files and does a bunch of other stuff.
	 */
	public function init() {

		if ( ! isset( $_REQUEST['obmgenesis_generate'], $_REQUEST['theme-name'] ) )
			return;

		if ( empty( $_REQUEST['theme-name'] ) )
			wp_die( 'Please enter a theme name. Please go back and try again.' );

		$this->define_settings();

		$zip = new ZipArchive;
		$zip_filename = sprintf( '/tmp/obm-genesis-child-%s.zip', md5( print_r( $this->theme, true ) ) );
		$res = $zip->open( $zip_filename, ZipArchive::CREATE && ZipArchive::OVERWRITE );

		$prototype_dir = dirname( __FILE__ ) . '/obm-genesis-child-base/';

		$exclude_files = array( '.travis.yml', 'codesniffer.ruleset.xml', '.jscsrc', '.jshintignore', 'CONTRIBUTING.md', '.git', '.svn', '.DS_Store', '.gitignore', '.', '..' );
		$exclude_directories = array( '.git', '.svn', '.github', '.', '..' );

		$iterator = new RecursiveDirectoryIterator( $prototype_dir );
		foreach ( new RecursiveIteratorIterator( $iterator ) as $filename ) {

			if ( in_array( basename( $filename ), $exclude_files ) )
				continue;

			foreach ( $exclude_directories as $directory )
				if ( strstr( $filename, "/{$directory}/" ) )
					continue 2; // continue the parent foreach loop

			$local_filename = str_replace( trailingslashit( $prototype_dir ), '', $filename );

			if ( 'languages/obm-genesis-child-base.pot' == $local_filename )
				$local_filename = sprintf( 'languages/obm-genesis-child-base.pot', $this->theme['slug'] );

			$contents = file_get_contents( $filename );
			$contents = apply_filters( 'obmgenesis_generator_file_contents', $contents, $local_filename );
			$zip->addFromString( trailingslashit( $this->theme['slug'] ) . $local_filename, $contents );

		}

		$zip->close();

		header( 'Content-type: application/zip' );
		header( sprintf( 'Content-Disposition: attachment; filename="%s.zip"', $this->theme['slug'] ) );
		readfile( $zip_filename );
		unlink( $zip_filename );
		die();

	}

	public function define_settings() {

		$this->theme['name']  = trim( $_REQUEST['theme-name'] );

		if ( ! empty( $_REQUEST['theme-slug'] ) ) {
			$this->theme['slug'] = sanitize_title_with_dashes( $_REQUEST['theme-slug'] );
		} else {
			$this->theme['slug'] = sanitize_title_with_dashes( $_REQUEST['theme-name'] );
		}
		// Let's check if the slug can be a valid function name.
		if ( ! preg_match( '/^[a-z_]\w+$/i', str_replace( '-', '_', $this->theme['slug'] ) ) ) {
			wp_die( 'Theme slug could not be used to generate valid function names. Please go back and try again.' );
		}

		if ( ! empty( $_REQUEST['theme-uri'] ) ) {
			$this->theme['theme_uri'] = trim( $_REQUEST['theme-uri'] );
		}

		if ( ! empty( $_REQUEST['author-name'] ) ) {
			$this->theme['author_name'] = trim( $_REQUEST['author-name'] );
		}

		if ( ! empty( $_REQUEST['author-email'] ) ) {
			$this->theme['author_email'] = trim( $_REQUEST['author-email'] );
		}

		if ( ! empty( $_REQUEST['author-uri'] ) ) {
			$this->theme['author_uri'] = trim( $_REQUEST['author-uri'] );
		}

		if ( ! empty( $_REQUEST['theme-description'] ) ) {
			$this->theme['description'] = trim( $_REQUEST['theme-description'] );
		}

		if ( ! empty( $_REQUEST['footer-sidebars'] ) ) {
			$this->theme['footer_sidebars'] = trim( $_REQUEST['footer-sidebars'] );
		}

		if ( ! empty( $_REQUEST['menu-areas'] ) ) {
			$this->theme['menu_areas'] = $_REQUEST['menu-areas'];
		}

		if ( ! empty( $_REQUEST['genesis-layouts'] ) ) {
			$this->theme['genesis_layouts'] = $_REQUEST['genesis-layouts'];
		}

		if ( ! empty( $_REQUEST['genesis-sidebars'] ) ) {
			$this->theme['genesis_sidebars'] = $_REQUEST['genesis-sidebars'];
		}

		if ( ! empty( $_REQUEST['sidebars'] ) ) {
			$this->theme['sidebars'] = $_REQUEST['sidebars'];
		}

		if ( ! empty( $_REQUEST['image-sizes'] ) ) {
			$this->theme['image_sizes'] = $_REQUEST['image-sizes'];
		}

		if ( ! empty( $_REQUEST['genesis-settings'] ) ) {
			$this->theme['genesis_settings'] = $_REQUEST['genesis-settings'];
		}
		// $this->theme['sass']  = (bool) isset( $_REQUEST['obmgenesis_sass'] );

	}


	/**
	 * Runs when looping through files contents, does the replacements fun stuff.
	 */
	public function do_replacements( $contents, $filename ) {

		// Replace only text files, skip png's and other stuff.
		$valid_extensions = array( 'php', 'css', 'scss', 'js', 'txt' );
		$valid_extensions_regex = implode( '|', $valid_extensions );
		if ( ! preg_match( "/\.({$valid_extensions_regex})$/", $filename ) )
			return $contents;

		// Special treatment for style.css
		if ( in_array( $filename, array( 'style.css', 'sass/style.scss' ), true ) ) {
			$theme_headers = array(
				'Theme Name'	=> $this->theme['name'],
				'Theme URI'		=> esc_url_raw( $this->theme['theme_uri'] ),
				'Author'		=> $this->theme['author_name'],
				'Author URI'	=> esc_url_raw( $this->theme['author_uri'] ),
				'Author Email'  => $this->theme['author_email'],
				'Description'	=> $this->theme['description'],
				'Text Domain'	=> $this->theme['slug'],
			);

			foreach ( $theme_headers as $key => $value ) {
				$contents = preg_replace( '/(' . preg_quote( $key ) . ':)\s?(.+)/', '\\1 ' . $value, $contents );
			}

			$contents = preg_replace( '/\b_s\b/', $this->theme['name'], $contents );

			return $contents;
		}

		// Special treatment for functions.php
		if ( 'functions.php' == $filename ) {

			$contents = str_replace( "http://obm-genesis-child.com/", sprintf( "%s",  $this->theme['theme_uri'] ), $contents );

			// Theme Menus
			if ( ! empty( $this->theme['menu_areas'] ) ) {
				$menus = '';
				$menu_list = $this->theme['menu_areas'];
				foreach ( $menu_list as $menu_areas => $menu_area ) {
					$menus .= "\r\t\t'{$menu_area['slug']}' => '{$menu_area['name']}',";
				}
				$contents = str_replace( "//theme_menus", sprintf( "%s",  $menus ), $contents );
			}

			// Unregister Genesis Layouts
			if ( ! empty( $this->theme['genesis_layouts'] ) ) {
				$layouts = '';
				foreach ( $this->theme['genesis_layouts'] as $genesis_layout ) {
					$layouts .= "\r\tgenesis_unregister_layout( '{$genesis_layout}' );";
				}
				$contents = str_replace( "//unregister_layouts", sprintf( "%s",  $layouts ), $contents );
			}

			// Unregister Genesis Default Sidebars
			if ( ! empty( $this->theme['genesis_sidebars'] ) ) {
				$genesis_sidebars = '';
				foreach ( $this->theme['genesis_sidebars'] as $genesis_sidebar ) {
					$genesis_sidebars .= "\r\tunregister_sidebar( '{$genesis_sidebar}' );";
				}
				$contents = str_replace( "//unregister_sidebars", sprintf( "%s",  $genesis_sidebars ), $contents );
			}

			// Add Genesis Footer Sidebars
			if ( ! empty( $this->theme['footer_sidebars'] ) ) {
				$contents = str_replace( "//footer_widgets", sprintf( "\r\tadd_theme_support( 'genesis-footer-widgets', %d );",  $this->theme['footer_sidebars'] ), $contents );
			}

			// Add Sidebars
			if ( ! empty( $this->theme['sidebars'] ) ) {
				$additional_sidebars = '';
				$sidebar_list = $this->theme['sidebars'];
				foreach ( $sidebar_list as $sidebars => $sidebar ) {
					$additional_sidebars .= "\r\tgenesis_register_sidebar( array(\r\t\t'id' => '{$sidebar['slug']}',\r\t\t'name' => __( '{$sidebar['name']}', '{$this->theme['slug']}' ),\r\t) );";
				}
				$contents = str_replace( "//sidebars", sprintf( "%s",  $additional_sidebars ), $contents );
			}

			// Add Image Sizes
			if ( ! empty( $this->theme['image_sizes'] ) ) {
				$additional_image_sizes = '';
				$image_size_list = $this->theme['image_sizes'];
				foreach ( $image_size_list as $image_sizes => $image_size ) {
					if ( isset ( $image_size['crop'] ) ) {
						$crop = 'TRUE';
					} else {
						$crop = 'FALSE';
					}
					$additional_image_sizes .= "\r\tadd_image_size( '{$image_size['slug']}', {$image_size['width']}, {$image_size['height']}, {$crop} );";
				}
				$contents = str_replace( "//image_sizes", sprintf( "%s",  $additional_image_sizes ), $contents );
			}

			// Site Title and Description
			if ( ! empty( $this->theme['genesis_settings'] ) ) {
				$theme_settings = $this->theme['genesis_settings'];
				foreach ( $theme_settings as $theme_setting ) {
					if ( $theme_setting == "remove-title" ) {
						$contents = str_replace( "// remove_action( 'genesis_site_title', 'genesis_seo_site_title' );", "remove_action( 'genesis_site_title', 'genesis_seo_site_title' );", $contents );
					}
					if ( $theme_setting == "remove-subtitle" ) {
						$contents = str_replace( "// remove_action( 'genesis_site_description', 'genesis_seo_site_description' );", "remove_action( 'genesis_site_description', 'genesis_seo_site_description' );", $contents );
					}
				}
			}

		}

		// // Special treatment for readme.txt
		// if ( 'readme.txt' == $filename ) {
		// 	$contents = preg_replace('/(?<=Description ==) *.*?(.*(?=(== Installation)))/s', "\n\n" . $this->theme['description'] . "\n\n", $contents );
		// 	$contents = str_replace( '_s, or underscores', $this->theme['name'], $contents );
		// }

		// Edit file header comments
		$file_headers = array(
			'Theme Name'	=> $this->theme['name'],
			'URI'			=> esc_url_raw( $this->theme['theme_uri'] ),
			'Author'		=> $this->theme['author_name'],
		);

		foreach ( $file_headers as $key => $value ) {
			$contents = preg_replace( '/(' . preg_quote( $key ) . ':)\s?(.+)/', '\\1 ' . $value, $contents );
		}

		$contents = preg_replace( '/\b_s\b/', $this->theme['name'], $contents );

		// Function names can not contain hyphens.
		$slug = str_replace( '-', '_', $this->theme['slug'] );

		// Regular treatment for all other files.
		$contents = str_replace( "obm-", sprintf( "%s-",  $this->theme['slug'] ), $contents ); // Script/style handles.
		$contents = str_replace( "'obm_theme'", sprintf( "'%s'",  $this->theme['slug'] ), $contents ); // Textdomains.
		$contents = str_replace( "obm_", $slug . '_', $contents ); // Function names.
		$contents = preg_replace( '/\b_s\b/', $this->theme['name'], $contents );
		return $contents;

	}

}
$OBM_Genesis_Generator_Plugin = new OBM_Genesis_Generator_Plugin;
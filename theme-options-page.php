<?php

// create theme options menu
add_action('admin_menu', 'hyperion_create_menu');

function hyperion_create_menu() {
	//create new top-level menu
	add_theme_page('Theme Options', 'Theme Options', 'administrator', 'hyperion', 'hyperion_settings_page_setup');
	
	//call register settings function
	add_action( 'admin_init', 'register_mysettings' );
}

function register_mysettings() {
	//register our settings
	register_setting( 'settings-group', 'option_name_1' );
	register_setting( 'settings-group', 'option_name_2' );

	$tab = ( isset( $_GET['tab'] ) ? $_GET['tab'] : 'tab1' ); 

	if( $tab == 'tab1'){
		//add_settings_section( $id, $title, $callback, $page ); 
		add_settings_section( 'options_section_1', '', 'settings_section_setup', 'hyperion' ); 
		//add our fields to sections
		add_settings_field('option_name_1', 'Sample option 1', 'option_1_setup', 'hyperion', 'options_section_1');
	}

	if( $tab == 'tab2'){
		//add_settings_section( $id, $title, $callback, $page ); 
		add_settings_section( 'options_section_2', '', 'settings_section_setup', 'hyperion' ); 
		//add our fields to sections
		add_settings_field('option_name_2', 'Sample option 2', 'option_2_setup', 'hyperion', 'options_section_2');
	}
}

function settings_section_setup() { }
function help_section_setup() { }

function option_1_setup() { 
	echo "<input name='option_name_1' value='".get_option('option_name_1')."'/>";
}

function option_2_setup() { 
	echo "<input name='option_name_2' value='".get_option('option_name_2')."'/>";
}
	
function hyperion_settings_page_setup() {
?>

<div class="wrap">

	<?php page_tabs() ?>
	<?php if ( isset( $_GET['settings-updated'] ) ) {
		echo "<div class='updated'><p>Theme settings updated successfully.</p></div>";
	} 
	$tab = ( isset( $_GET['tab'] ) ? $_GET['tab'] : 'tab1' ); 
	?>

	<form method="post" action="options.php">

		<?php settings_fields( 'settings-group' ); ?>
		<?php do_settings_sections( 'hyperion' ); ?>
    		<p class="submit">
			<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
		</p>
	</form>
</div>
<?php 
} 

add_action('admin_print_styles-appearance_page_hyperion', 'slider_enqueue_admin_style', 11 );
function slider_enqueue_admin_style() {

    // define admin stylesheet
    $admin_handle = 'hyperion_admin_stylesheet';
    $admin_stylesheet = get_template_directory_uri() . '/admin/admin.css';
    wp_enqueue_style( $admin_handle, $admin_stylesheet );

}

function page_tabs(){			

	if ( isset ( $_GET['tab'] ) ) :
          	$current = $_GET['tab'];
     	else:
         	$current = 'tab1';
     	endif;
     	$tabs = array( 'tab1' => 'Tab 1', 'tab2' => 'Tab 2', 'tab3' => 'Tab 3' );
     	$links = array();
     	foreach( $tabs as $tab => $name ) :
          	if ( $tab == $current ) :
               		$links[] = "<a class='nav-tab nav-tab-active' href='?page=hyperion&tab=$tab'>$name</a>";
          	else :
               		$links[] = "<a class='nav-tab' href='?page=hyperion&tab=$tab'>$name</a>";
          	endif;
	endforeach;
	echo '<div id="icon-themes" class="icon32"><br /></div>';
     	echo '<h2 class="nav-tab-wrapper">';
     	foreach ( $links as $link )
          	echo $link;
     	echo '</h2>';
}
?>
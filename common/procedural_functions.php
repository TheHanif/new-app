<?php
// Custom auto loader
function class_autoloader($class) {
    include_once ADMINABS.'classes/class.' . $class . '.php';
}

// Register custom auto loader as > php 5.1.2
spl_autoload_register('class_autoloader');


/**
 * Translator function
 * 
 * @param string $key Language key
 */
$lang = new language();

function __($key)
{	
	global $lang;
	return $lang->get_key($key);
}

// Alternate of print_r
function print_f($data, $exit = false)
{
	echo '<pre>';
	print_r($data);
	echo '</pre>';

	if($exit) exit;
}

// Get current URL from address bar
function get_actual_url()
{
	$actual_url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	return urlencode($actual_url);
}

/**
 * Check user login status
 * 
 * @param boolean $redirect
 */
function is_logged_in($redirect = false)
{
	$status = Users::is_logged_in();

	// $URL = (isset($_GET['URL']))? urlencode($_GET['URL']) : get_actual_url();

	if (!$status && $redirect) {
		header("location:login.php?URL=".get_actual_url());
	}

	return $status;
}

/**
 * Get requested file name
 * @return string
 */
function get_script_name()
{
	return end(explode('/', rtrim($_SERVER['SCRIPT_NAME'], '.php')));
}

function is_page_active($page, $echo = true)
{	
	if ($page == get_script_name()) {
		if ($echo) {
			echo "active";
		}else{
			return 'active';
		}
	}
}

/**
 * Generate Admin sidebar navigation $admin_sidebar_navigation
 */
function generate_admin_menu()
{
	global $admin_sidebar_navigation;
	foreach ($admin_sidebar_navigation as $key => $data) {
		$parent_active = '';
		if (strpos($data['file'], '.')) {
			$file = array_shift(array_slice(explode('.', $data['file']), 0, 1));
			$parent_active = is_page_active($file, false);
		}
	?>
		<li class="<?php echo (isset($data['submenu']))? check_submenu($data['submenu']) : ''; ?>">
			<?php if (isset($data['submenu'])) {
				echo '<a href="javascript:;" data-parent="#side" data-toggle="collapse" class="accordion-toggle" data-target="#'.$key.'">';
			}else{
				?><a class="<?php echo $parent_active; ?>" href="<?php echo $data['file']; ?>"><?php
				} ?>
				<i class="fa fa-<?php echo $data['icon']; ?>"></i> <?php __($data['title']); ?> <?php echo (isset($data['submenu']))? '<span class="fa arrow"></span>' : ''; ?>
			</a>
			<?php // Get Submenu
				if (isset($data['submenu'])) {
					?>
						<ul class="collapse nav" id="<?php echo $key; ?>">
							<?php // Submenu loop
								foreach ($data['submenu'] as $submenu_key => $submenu_data) {
									$submenu_item_active = '';
									if (strpos($submenu_data['file'], '.')) {
										$file = array_shift(array_slice(explode('.', $submenu_data['file']), 0, 1));
										$submenu_item_active = is_page_active($file, false);
									}
									?>
										<li>
											<a class="<?php echo $submenu_item_active; ?>" href="<?php echo $submenu_data['file']; ?>">
												<i class="fa fa-<?php echo $submenu_data['icon']; ?>"></i> <?php __($submenu_data['title']); ?>
											</a>
										</li>
									<?php
								} // end for foreach
							?>
						</ul>
					<?php
				} // end submenu
			 ?>
		</li>
	<?php
	} // end foreach
} // end of generate_admin_menu()

/**
 * Get classes for submenus
 */
function check_submenu($data)
{
	$open = '';
	foreach ($data as $key => $value) {
		if (strpos($value['file'], '.')) {
			$file = array_shift(array_slice(explode('.', $value['file']), 0, 1));
			if (is_page_active($file, false)) {
				$open = 'open';
			}
		}
	}// end foreach

	$class = 'panel '.$open;
	return $class;
} // check_submenu

/**
 * Add item admin sidebar navigation
 * @param string $name   item key
 * @param string $title  item text
 * @param string $icon   fa icon
 * @param string $file   file name
 * @param string $parent parent key
 */
function add_navigation_item($name, $title, $icon, $file, $parent = NULL)
{
	global $admin_sidebar_navigation;

	// Prepare item data
	$item = array();
	$item = array(
		'title' => $title
		,'icon' => $icon
		,'file' => $file
	);

	if (isset($parent)) { // Submenu item
		$admin_sidebar_navigation[$parent]['submenu'][$name]=$item;
	}else{ // Top level item
		$admin_sidebar_navigation[$name]=$item;
	}

} // end of add_navigation_item
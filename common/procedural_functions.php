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
	foreach ($admin_sidebar_navigation as $key => $data) {
		$parent_active = '';
		if (strpos($data['file'], '.')) {
			$file = array_shift(array_slice(explode('.', $data['file']), 0, 1));
			$parent_active = is_page_active($file, false);
		}
	?>
		<li class="<?php echo (isset($data['submenu']))? 'panel' : ''; ?>">
			<a class="<?php echo $parent_active; ?>" href="<?php echo $data['file']; ?>">
				<i class="fa fa-<?php echo $data['icon']; ?>"></i> <?php echo $data['title']; ?> <?php echo (isset($data['submenu']))? '<span class="fa arrow"></span>' : ''; ?>
			</a>
			<?php 
				if (isset($data['submenu'])) {
					?>
						<ul class="collapse nav" id="forms">
							<?php 
								foreach ($data['submenu'] as $submenu_key => $submenu_data) {
									$submenu_item_active = '';
									if (strpos($submenu_data['file'], '.')) {
										$file = array_shift(array_slice(explode('.', $submenu_data['file']), 0, 1));
										$submenu_item_active = is_page_active($file, false);
									}
									?>
										<li>
											<a class="<?php echo $submenu_item_active; ?>" href="<?php echo $submenu_data['file']; ?>">
												<i class="fa fa-<?php echo $submenu_data['icon']; ?>"></i> <?php echo $submenu_data['title']; ?>
											</a>
										</li>
									<?php
								}
							?>
						</ul>
					<?php
				}
			 ?>
		</li>
	<?php
	}
} // end of generate_admin_menu()
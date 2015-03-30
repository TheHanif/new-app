<?php
/**
 * Procedural Functiobs for Admin only
 */

// Custom auto loader
function admin_autoloader($class) {
    include_once ADMINABS.'classes/class.' . $class . '.php';
}
spl_autoload_register('admin_autoloader');

/**
 * Translator function
 * 
 * @param string $key Language key
 */
$lang = new language();

function __($key, $echo = true)
{	
	global $lang;

	if ($echo) {
		echo $lang->get_key($key);
	}else{
		return $lang->get_key($key);
	}
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
function get_actual_url($encode = true)
{
	$actual_url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	if ($encode) {
		return urlencode($actual_url);
	}else{
		return $actual_url;
	}
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
		header("location:login.php?return=".get_actual_url());
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

function is_page_active($page, $id = NULL, $echo = true)
{	
	$state = true;

	if (isset($id) && get_query_string()) {
		
		 $query_strings = get_query_string();

		if (isset($query_strings['type']) && !in_array($id, $query_strings)) {
			$state = false;
		}
	}

	if (((is_array($page) && in_array(get_script_name(), $page)) || ($page == get_script_name())) && $state) {
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

	foreach ($admin_sidebar_navigation as $id => $data) {
		$parent_active = '';
		if (strpos($data['file'], '.')) {
			$file = array_shift(array_slice(explode('.', $data['file']), 0, 1));

			$data['child_files'][] = $file;
			$parent_active = is_page_active($data['child_files'], $id, false);

			// Go to unlock the page
			unlock_page(is_page_active($data['child_files'], $id, false), $data['has_settings'], $data['has_capability']);
		}
	?>
		<li class="<?php echo (isset($data['submenu']))? check_submenu($data['submenu'], $id) : ''; ?>">
			<?php if (isset($data['submenu'])) {
				echo '<a href="javascript:;" data-parent="#side" data-toggle="collapse" class="accordion-toggle" data-target="#'.$id.'">';
			}else{
				?><a class="<?php echo $parent_active; ?>" href="<?php echo $data['file']; ?>"><?php
				} ?>
				<i class="fa fa-<?php echo $data['icon']; ?>"></i> <?php __($data['title']); ?> <?php echo (isset($data['submenu']))? '<span class="fa arrow"></span>' : ''; ?>
			</a>
			<?php // Get Submenu
				if (isset($data['submenu'])) {
					?>
						<ul class="collapse nav" id="<?php echo $id; ?>">
							<?php // Submenu loop
								foreach ($data['submenu'] as $submenu_key => $submenu_data) {
									$submenu_item_active = '';
									if (strpos($submenu_data['file'], '.')) {
										$file = array_shift(array_slice(explode('.', $submenu_data['file']), 0, 1));

										$submenu_data['child_files'][] = $file;
										
										$submenu_item_active = is_page_active($submenu_data['child_files'], $id, false);

										// Go to unlock the page
										unlock_page(is_page_active($submenu_data['child_files'], $id, false), $submenu_data['has_settings'], $submenu_data['has_capability']);
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
 * Unlock admin page
 * 
 * @return boolean	true if unlocked
 */
function unlock_page($is_active, $has_settings, $has_capabilities)
{
	global $lock_page;
	if ($is_active && is_allowed($has_settings, $has_capabilities)) {
		$lock_page = false;
		return true;
	}
} // end of unlock_page()

/**
 * Get the lock status of page
 * If false, include footer file and exit the page to prevent loading of page contents
 */
function get_lock_status()
{	
	global $lock_page;

	if ($lock_page) {
		generate_message('ACCESS DENIED!', 'You do not have sufficient capabilities to access this area.', 'danger');
		include ADMINABS.'include/footer.php';
		exit;
	}
} // end of get_lock_status()

/**
 * Get classes for submenus
 */
function check_submenu($data, $id = NULL)
{
	$open = '';
	foreach ($data as $key => $value) {
		if (strpos($value['file'], '.')) {
			$file = array_shift(array_slice(explode('.', $value['file']), 0, 1));

			$value['child_files'][] = $file;

			if (is_page_active($value['child_files'], $id, false)) {
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
function add_navigation_item($name, $title, $icon, $file, $child_files = array(), $parent = NULL, $settings = NULL, $capability = NULL)
{
	global $admin_sidebar_navigation;

	// Check rights and capabilities
	if (!is_allowed($settings, $capability)) {
		return;
	}

	// Remove extensions
	foreach ($child_files as $key => $value) {
		$child_files[$key] = rtrim($value, '.php');
	}

	// Prepare item data
	$item = array();
	$item = array(
		'title' => $title
		,'icon' => $icon
		,'file' => $file
		,'child_files' => $child_files
		,'has_settings' => $settings
		,'has_capability' => $capability
	);

	if (isset($parent)) { // Submenu item
		if (isset($admin_sidebar_navigation[$parent])) {
			$admin_sidebar_navigation[$parent]['submenu'][$name]=$item;
		}
	}else{ // Top level item
		$admin_sidebar_navigation[$name]=$item;
	}

} // end of add_navigation_item

/**
 * Add message for admin area
 * @param  string $title   Message title
 * @param  string $message Message
 * @param  string $type    alert type
 */
function register_admin_message($title, $message, $type)
{
	global $messages;

	$message = array(
			'title' => $title
			,'message' => $message
			,'type' => $type
		);
	$messages[] = $message;
} // register_admin_message

/**
 * Get all messages for admin
 * @return string alert HTML markup
 */
function get_messages()
{
	global $messages;
	$types = array('warning', 'info', 'danger', 'success', 'primary', 'inverse');

	foreach ($messages as $message) {
		if(!in_array($message['type'], $types)) continue;
		?>
		<div class="alert bg-<?php echo $message['type'] ?>">
			<button aria-hidden="true" data-dismiss="alert" class="close" type="button">x</button>
			<p><strong><?php __($message['title']); ?>:</strong><br>  <?php __($message['message']); ?></p>
		</div>
		<?php
	} // end of foreach
} // end of get_messages()

/**
 * Generate alert message for admin
 * @return string alert HTML markup
 */
function generate_message($title, $message, $type)
{
	$types = array('warning', 'info', 'danger', 'success', 'primary', 'inverse');

	if(!in_array($type, $types)) return;
	?>
	<div class="alert bg-<?php echo $type; ?>">
		<button aria-hidden="true" data-dismiss="alert" class="close" type="button">x</button>
		<p><strong><?php __($title); ?>:</strong><br>  <?php __($message); ?></p>
	</div>
	<?php
} // end of get_messages()

/**
 * Check if user have capabities in some areas
 * @param  contants  $settings   main settings variables
 * @param  array  $capability user role have rights in this
 * @return boolean
 */
function is_allowed($settings = null, $capability = null){

	global $Users;

	// By default every thing is allowed.
	$state = true;

	// Default settings
	if ((isset($settings) && $settings == false)) {
		$state = false;
	}

	// User Rights and capabilitirs
	if ((isset($capability) && !$Users->has_capabilities($capability))) {
		$state = false;
	}

	return $state;
} // end of is_allowed()


/**
 * Add new capabilty
 * @param  string $group
 * @param  string $key
 */
function register_capability($group, $key)
{
	global $capabilities_groups;

	if (isset($capabilities_groups[$group])) {
		$capabilities_groups[$group][] = $key;
	}
} // end of register_capability()
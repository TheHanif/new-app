<?php 
// Initialization
include_once 'include/init.php';

// Page title
$admin_title = 'Dashboard';

// Header file
include 'include/header.php';
?>
<!-- BEGIN MAIN PAGE CONTENT -->
<div id="page-wrapper">
	<!-- BEGIN PAGE HEADING ROW -->
		<div class="row">
			<div class="col-lg-12">
				<!-- BEGIN BREADCRUMB -->
				<?php include 'include/breadcrumb.php'; ?>
				<!-- END BREADCRUMB -->	
				
				<div class="page-header title">
				<!-- PAGE TITLE ROW -->
					<h1><?php echo __($admin_title); ?> <span class="sub-title">sub title</span></h1>								
				</div>
				
				<?php get_messages(); ?>	

			</div><!-- /.col-lg-12 -->
		</div><!-- /.row -->
	<!-- END PAGE HEADING ROW -->

		<?php
		// Check page for loack status
		// get_lock_status(); ?>
		
		<div class="row">
			<div class="col-lg-12">
			
			<!-- START YOUR CONTENT HERE -->
				<?php 
// 				mysql_connect('localhost', 'root', '') or die(mysql_error());
// 				mysql_select_db('new_app')  or die(mysql_error());
// $a = mysql_query("SELECT *
// FROM objects AS o
// INNER JOIN meta AS m ON m.object_id = o.ID
// WHERE m.meta_key = 'category'
// LIMIT 0 , 30") or die(mysql_error());


// print_f(mysql_fetch_object($a));

$DB = new database1();

// $query = "SELECT *
// FROM objects AS o
// INNER JOIN meta AS m ON m.object_id = o.ID AND m.meta_key = :h1
// INNER JOIN categories AS c ON c.category_id = m.meta_value

// WHERE c.category_slug = :h2
// ";

// $DB->_query = $DB->_DB->prepare(filter_var($query, FILTER_SANITIZE_STRING));

// $DB->_query->bindValue(':h1', 'category', $DB->get_type('category'));
// $DB->_query->bindValue(':h2', 'sample-category-2', $DB->get_type('sample-category-2'));

// $DB->_query->execute();

$DB->select(array('m.meta_value'=>'template', 'c.meta_value'=>'category'));

$DB->inner_join('meta', 'm', 'm.object_id = objects.ID');
$DB->inner_join('meta', 'c', 'c.object_id = objects.ID');
// $DB->inner_join('categories', 'c', 'c.category_id = m.meta_value');

// $DB->where('c.category_slug', 'sample-category-2');
$DB->where('m.meta_key', 'template');
$DB->where('c.meta_key', 'category');

$DB->from('objects');

print_f($DB->all_results());




				 ?>
			<!-- END YOUR CONTENT HERE -->
	
			</div>
		</div>
<?php include 'include/footer.php'; ?>
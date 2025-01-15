<?php require_once( '../../../private/initialize.php' ); ?>

<?php 

$menu_name = ( isset($_GET['menu_name']) ) ? h( $_GET['menu_name'] ) : '';

$id = ( isset($_GET['id']) ) ? h( $_GET['id'] ) : '';

$subject = get_subject_by_id($id);
?>

<?php $page_title = 'Show page ' . $menu_name; ?>

<?php include( SHARED_PATH . '/staff_header.php'); ?>
<?php include( SHARED_PATH . '/staff_aside.php'); ?>

<main>
<a href="<?php echo get_url_root('staff/subjects/index.php'); ?>" class='breadcrumb-menu'>&laquo; Go back to the previous page</a>
<h2 class='page-heading'><?php echo h( $subject['subject_name'] ); ?></h2>
  <section>
    <div class="content">
      <p><?php echo h( $subject['description']); ?></p>
      <p>Position: <?php echo h( $subject['position']); ?></p>
      <p>Visibility: <?php echo h( $subject['visible']); ?></p>
    </div>
  </section>
</main>

<?php include( SHARED_PATH . '/staff_footer.php'); ?>

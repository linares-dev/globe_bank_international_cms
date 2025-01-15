<?php require_once( '../../../private/initialize.php' ); ?>

<?php 

$id = ( isset($_GET['id']) ) ? h( $_GET['id'] ) : '';

$page = get_page_by_id($id);
?>

<?php $page_title = 'Show page '; ?>

<?php include( SHARED_PATH . '/staff_header.php'); ?>
<?php include( SHARED_PATH . '/staff_aside.php'); ?>

<main>
<a href="<?php echo get_url_root('staff/pages/index.php'); ?>" class='breadcrumb-menu'>&laquo; Go back to the previous page</a>
<h2 class='page-heading'><?php echo h( $page['page_name'] ); ?></h2>
  <section>
    <div class="content">
      <p>Position: <?php echo h( $page['position'] ); ?></p>
      <p>Visibility: <?php echo h( $page['visible'] ); ?></p>
      <p>Subject: <?php
        // get subject_name
        $subject_name = get_subject_by_id( $page['subject_id'] )['subject_name'];
        // display subject_name
        echo h( $subject_name); 
      ?></p>
      <p><?php echo h( $page['content']); ?></p>
    </div>
  </section>
</main>

<?php include( SHARED_PATH . '/staff_footer.php'); ?>
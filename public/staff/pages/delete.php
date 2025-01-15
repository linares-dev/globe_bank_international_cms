<?php 
  /** 
   * Single Page Form Processing
   * This file displays the form and processes it. With validation and checks along the way. 
   * 
   */
  
   require_once( '../../../private/initialize.php' );

  // check if id is set, otherwise redirect. 
  // we don't want to display the form if no id is provided
  if( !isset( $_GET['id'] ) ){
    redirect_client('/staff/pages/index.php');
  }

  $id = h($_GET['id']);

  if(request_is_post()){

    delete_page_by_id($id);
    redirect_client(get_url_root('staff/pages/index.php?result=success'));

  }else{
    $page = get_page_by_id($id);
    $subject_name = get_subject_by_id($page['subject_id'])['subject_name'];
  }

  // include html header and set page title.
  $page_title = 'Delete Page';
  include(SHARED_PATH . '/staff_header.php');
?>

<main>
  <div class="content">
    <a href="<?php echo get_url_root('/staff/pages/index.php'); ?>" class="breadcrumb-menu"><< Go back to the previous page</a>
    <h2 class="page-heading">Delete Page</h2>
    <div style="background-color: rgb(234, 234, 234); padding:10px 25px;">
      <p><?php echo $page['page_name']; ?></p>
      <p><?php echo $page['content']; ?></p>
      <p>ID: <?php echo $page['id']; ?></p>
      <p>Position: <?php echo $page['position']; ?></p>
      <p>Visible: <?php echo $page['visible']; ?></p>
      <p>Subject: <?php echo $subject_name; ?></p>
    </div>
    <p>Are you sure you want to delete the page?</p>
    <form action="<?php echo get_url_root( 'staff/pages/delete.php?id=' . ue($id) ); ?>" method="POST" >
      <input type="submit" value="delete" />
    </form>
  </div>
</main>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
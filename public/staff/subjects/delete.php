<?php 
/**
 * This file processes a deletion request
 */

  // import important preliminaries
  require_once('../../../private/initialize.php');

  // check if id is set, otherwise redirect. 
  // we don't want to display the form if no id is provided
  if( !isset( $_GET['id'] ) ){
    redirect_client(get_url_root('/staff/subjects/index.php'));
  }

  // store id from url
  $id = $_GET['id'];

  // get subject details
  $subject = get_subject_by_id($id);

  if(request_is_post()){

    // process deletion
    delete_subject_by_id($id);

    // redirect client to subjects page upon success
    redirect_client( get_url_root('staff/subjects/index.php' . "?result=success") );
  }

?>

<?php 

$page_title ='Delete Subject';

include( SHARED_PATH . '/staff_header.php' ); 

?>

<main>
  <div class="content">
    <a href="<?php echo get_url_root('staff/subjects/index.php') ?>" class='breadcrumb-menu'>&laquo; Go back to the previous page</a>
  <h2 class='page-heading'>Delete Subject</h2>
  <div style='background-color: rgb(234, 234, 234); padding:10px 25px;'>
    <p><?php echo $subject['subject_name']; ?></p>
    <p><?php echo $subject['description']; ?></p>
    <p>Id: <?php echo $subject['id']; ?></p>
    <p>Position: <?php echo  $subject['position']; ?></p>
  </div>
  <p>Are you sure you want to delete the subject?</p>
  <form action="<?php echo get_url_root('staff/subjects/delete.php?id=' . h(ue($id))); ?>" method='POST'>
    <input type='submit' value='Delete Subject' />
  </form>
  </div>
</main>
<?php include( SHARED_PATH . '/staff_footer.php' ); 


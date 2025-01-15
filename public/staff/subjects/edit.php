<?php 
  /** Single Page Form Processing
   * This file displays the form and processes it. With validation and checks along the way. 
   * 
   */
  
   require_once( '../../../private/initialize.php' );

  // check if id is set, otherwise redirect. 
  // we don't want to display the form if no id is provided
  if( !isset( $_GET['id'] ) ){
    redirect_client('/staff/subjects/index.php');
  } 
  
  // set other variables
  $id = h($_GET['id']);

  // form post submission processing
  if( request_is_post() ){
    $subject = [];
    $subject ['id'] = $id;
    $subject ['subject_name'] = $_POST['subject_name'] ?? '';
    $subject ['visible'] = $_POST['visible'] ?? '';
    $subject ['position'] = $_POST['position'] ?? '';
    $subject ['description'] = $_POST['description'] ?? '';

    // store result of updating subject success or failure
    $result = update_subject_by_id($subject);
    if($result === true){
      $url = get_url_root('/staff/subjects/show.php?id=' . $id);
      redirect_client( $url );      
    }else{
      $errors = $result;
    }

  }else{
    // form was not submitted so retrieve current info from db
    $subject = get_subject_by_id($id);
  }

      
    // for position options get important variables
    // get all subjects
    $result = find_all_subjects();
    // get all subjects total count
    $subject_count = mysqli_num_rows($result);
    // free result
    mysqli_free_result($result);
?>

<?php $page_title = 'Edit Subject'; ?>

<?php include( SHARED_PATH . '/staff_header.php' ); ?>

<main>
  <a href='<?php echo get_url_root('/staff/subjects/index.php'); ?>' class='breadcrumb-menu'>&laquo; back to subjects list</a>

  <h2 class='page-heading'>Edit a Subject</h2>
  
  <?php echo display_errors($errors); ?>
  
  <form action='<?php get_url_root('/staff/subjects/edit.php?id=' . ue($id)) . '?id=' . h(ue($id)); ?>' method='POST'>
  <div>
    <label for='subject_name'>Subject Name</label>
    <input type='text' id='subject_name' name='subject_name' value='<?php echo $subject['subject_name']; ?>' />
    <small>Enter a descriptive subject name.</small>
  </div>
  <div>
      <label for="description">Description</label>
      <textarea name="description" id="description" rows="6" cols="50" ><?php echo $subject['description']; ?></textarea>
      <small>Enter an optional description for subjects.</small>
    </div>
  <div>
    <label for='position'>Position</label>
    <select name='position' id='position'>
      <?php 
      for($i=0; $i <= $subject_count; $i++){
        $selected = ($subject['position'] == $i) ? 'selected' : '';
        echo "<option value='{$i}' {$selected}>" . $i . "</option>";
      }
      ?>
    </select>
  </div>
  <div>
    <label for='visible'>Visible</label>
    <input type='hidden' name='visible' value='0' />
    <input type='checkbox' name='visible' value='1' <?php echo ($subject['visible'] == '1') ? 'checked' : ''; ?> />
  </div>
  <input type='submit' value='Update Subject' />
  </form>
</main>

<?php include( SHARED_PATH . '/staff_footer.php' ); 
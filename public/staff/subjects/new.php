<?php
  /**
   * File process creation of subjects
   */

  // import import preliminaries
  require_once( '../../../private/initialize.php' ); 

  // set variables
  $subject = [];

  // calculate subject count
  $subject_set = find_all_subjects(); 
  $subject_count = mysqli_num_rows( $subject_set ) + 1;
  mysqli_free_result($subject_set); // free memory

  // check client request and determine form submission method
  if(request_is_post()){
    // Handle form values sent by form
    $subject = [];
    $subject ['subject_name'] = $_POST['subject_name'] ?? '';
    $subject ['position'] = $_POST['position'] ?? '';
    $subject ['visible'] = $_POST['visible'] ?? '';
    $subject ['description'] = $_POST['description'] ?? '';

    // create subject with post parameters and store result
    $result = create_subject( $subject );

    // check if create subject was successful or a failure
    if( $result === true ){

      // store the newly created db record's id
      $new_id = mysqli_insert_id($db);

      // after processing redirect to view the new subject details
      redirect_client( get_url_root('/staff/subjects/show.php?id=' . $new_id ));
    }else{
      $errors = $result;
    }
  }else{
    //display client back the form with previous inputted values
    $subject ['subject_name'] = '';
    $subject ['position'] = $subject_count;
    $subject ['visible'] = '';
    $subject ['description'] = '';
  }

  // set title for html document
  $page_title = 'Create Subject'; 

  // import staff header template
  include( SHARED_PATH . '/staff_header.php' );

?>

<main>
  <a href='<?php echo get_url_root('/staff/subjects/index.php'); ?>' class='breadcrumb-menu'>&laquo; back to subjects list</a>
  <h2 class='page-heading'>Create Subject</h2>

  <?php echo display_errors($errors); ?>

  <form action='<?php echo get_url_root('/staff/subjects/new.php'); ?>' method='POST'>
    <div>
      <label for='subject_name'>Subject Name</label>
      <input type='text' id='subject_name' name='subject_name' />
      <small>Enter a descriptive subject name.</small>
    </div>
    <div>
      <label for="description">Description</label>
      <textarea name="description" id="description" rows="6" cols="50" ></textarea>
      <small>Enter an optional description for subjects.</small>
    </div>
    <div>
      <label for='position'>Position</label>
      <select name='position' id='position'>
      <?php 
        for( $i=0; $i <= $subject_count; $i++ ){
          $selected = ($subject['position'] === $i) ? 'selected':'';
          echo "<option value='{$i}' {$selected}>" . $i . "</option>";
        }
        ?>
      </select>
    </div>
    <div>
      <label for='visible'>Visible</label>
      <input type='hidden' name='visible' value='0' />
      <input type='checkbox' name='visible' value='1' />
    </div>
    <input type='submit' value='Create Subject' />
  </form>
</main>

<?php include( SHARED_PATH . '/staff_footer.php' ); 
<?php 
  /** 
   * Single Page Form Processing
   * This file displays the form and processes it. With validation and checks along the way. 
   * 
   */
  
   require_once( '../../../private/initialize.php' );

  // Set Variables

  // redirect - we don't want to display the form if no id is provided
  if( !isset( $_GET['id'] ) ){
    redirect_client('/staff/pages/index.php');
  } 

  $id = h($_GET['id']);

  // calculate number of records
  $pages_set = find_all_pages();
  $pages_count = mysqli_num_rows($pages_set);
  mysqli_free_result($pages_set); // free memory

  // form post submission processing
  if( request_is_post() ){

    $page['id'] = $id;
    $page['page_name'] = $_POST['page_name'];
    $page['content'] = $_POST['content'];
    $page['position'] = $_POST['position'];
    $page['visible'] = $_POST['visible'];
    $page['subject_id'] = $_POST['subjects_option'];

    // update record and store result
    $result = update_page_by_id($page);
    
    if( $result === true ){
      redirect_client(get_url_root('/staff/pages/show.php?id=' . $id));
    }else{
      // update initialized errors variable
      $errors = $result;
    }
  }else{
    // display form with default values
    $page = get_page_by_id($id);
  }
?>

<?php $page_title = 'Edit page'; ?>

<?php include( SHARED_PATH . '/staff_header.php' ); ?>

<main>
  <a href='<?php echo get_url_root('/staff/pages/index.php'); ?>' class='breadcrumb-menu'>&laquo; back to pages list</a>
  <h2 class='page-heading'>Edit a page</h2>
  <?php echo display_errors($errors); ?>
  <form action='<?php get_url_root('/staff/pages/edit.php') . '?id=' . h(ue($id)); ?>' method='POST'>
  <div>
    <label for='page_name'>Page Name</label>
    <input type='text' id='page_name' name='page_name' value='<?php echo $page['page_name']; ?>' />
    <small>Enter a name for web page.</small>
  </div>
  <div>
    <label for="content">Page Content</label>
    <textarea name="content" id="content" rows='10' cols='90'><?php echo $page['content']; ?></textarea>
    <small>Enter an option content for pages.</small>
  </div>
  <div>
    <label for="subjects_option">Subject</label>
    <select name="subjects_option" id="subjects_options">
      <?php
        // get $page subject_id
        $subject_name = get_subject_by_id($page['subject_id'])['subject_name'];

        // get subject count
        $subjects_set = find_all_subjects();
        $subjects_count = mysqli_num_rows($subjects_set);

        // print out subjects_option list
        // and determine which is selected by default
        for($i=0; $i < $subjects_count; $i++){
          $subject_arr = mysqli_fetch_array($subjects_set);
          $selected = $page['subject_id'] == $subject_arr['id'] ? 'selected' : '';

          echo "<option name='subjects_option' value='" . $subject_arr['id'] . "' $selected >" . $subject_arr['subject_name'] . "</option>";
        }
        mysqli_free_result($subjects_set)
      ?>
    </select>
  </div>
  <div>
    <label for='position'>Position</label>
    <select name='position' id='position'>
      <?php
        for($i=0; $i <= $pages_count; $i++){
          $selected = $page['position'] == $i ? 'selected' : '';
          echo "<option name='position' value='$i' $selected >$i</option>";
        }     
      ?>
    </select>
  </div>
  <div>
    <label for='visible'>Visible</label>
    <input type='hidden' name='visible' value='0' />
    <input type='checkbox' name='visible' value='1' <?php echo $page['visible']  === '1' ? 'checked' : ''; ?>/>
  </div>
  <input type='submit' value='Edit Page' />
  </form>
</main>

<?php include( SHARED_PATH . '/staff_footer.php' ); 
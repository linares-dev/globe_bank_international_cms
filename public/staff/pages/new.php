<?php
  /**
   * File processes a new page
   */
  require_once('../../../private/initialize.php'); 

  // Set variables

  // calculate number of page records
  $page_set = find_all_pages();
  $page_count = mysqli_num_rows( $page_set ) + 1;
  mysqli_free_result($page_set); // free memory

  // setup subject array for use
  $page = [];
  $page['position'] = $page_count;

  // process post parameters if any
  if(request_is_post()){
    // process post parameters
    $page['page_name'] = $_POST['page_name'] ?? '';
    $page['position'] = $_POST['position'] ?? '';
    $page['visible'] = $_POST['visible'] ?? '';
    $page['content'] = $_POST['content'] ?? '';
    $page['subject_id'] = $_POST['subjects_option'] ?? '';

    // create page and store result: true or false
    $result = create_page($page);

    // determine success or failure of creation
    if( $result === true){
      
      // get  and store new record i
      $new_id = mysqli_insert_id($db);

      // redirect client to show.php to view page details
      redirect_client( get_url_root('/staff/pages/show.php?id=' . $new_id) );

    }else{
      $errors = $result;
    }

  }else{
    // display blank form
    $page['page_name'] = '';
    $page['position'] = $page_count;
    $page['visible'] = '';
    $page['content'] = '' ;
    $page['subject_id'] = '';
  }

  // head tag requirements
  $page_title = 'Create Page';

  // bring over the header
  include( SHARED_PATH . '/staff_header.php' );

?>

<main>
  <a href='<?php echo get_url_root('/staff/pages/index.php'); ?>' class='breadcrumb-menu'>&laquo; back to pages list</a>
  <h2 class='page-heading'>Create a Page</h2>

  <?php echo display_errors($errors); ?>

  <form action='<?php echo get_url_root('/staff/pages/new.php'); ?>' method='POST'>
  <div>
    <label for='page_name'>Page Name</label>
    <input type='text' id='page_name' name='page_name' />
    <small>Please provide a title for your page.</small>
  </div>
  <div>
    <label for="content">Description</label>
    <textarea name="content" id="content" rows='10' cols='100'></textarea>
    <small>Optionally provide your content for the page.</small>
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
          $selected = $subject_arr['id'] == 11 ? 'selected' : '';

          echo "<option name='subjects_option' value='" . $subject_arr['id'] . "' $selected >" . $subject_arr['subject_name'] . "</option>";
        }
        mysqli_free_result($subjects_set)
      ?>
    </select>
    <small>Select one subject for web page.</small>
  </div>    
  <div>
    <label for='position'>Position</label>
    <select name='position' id='position'>
      <?php 
      for($i=0; $i <= $page_count; $i++){
        $selected = $page['position'] == $i ? 'selected' : '';
        echo "<option value='$i' $selected >" . $i . "</option>";
      }
      ?>
    </select>
  </div>
  <div>
    <label for='visible'>Visible</label>
    <input type='hidden' name='visible' value='0' />
    <input type='checkbox' name='visible' value='1' />
  </div>
  <input type='submit' value='Create Page' />
  </form>
</main>


<?php include( SHARED_PATH . '/staff_footer.php' ); ?>

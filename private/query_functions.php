<?php

include('validation_functions.php');

/**
 * Validation functions
 */

function validate_subject($subject){
  $errors = [];

  // check if subject_name given
  if( is_blank( $subject['subject_name'] ) ){
    $errors[] = "Name cannot be blank.";
  }

  // check if subject name has proper length
  if( !has_length( $subject['subject_name'], ['min' => 2,'max' => 255] ) ){
    $errors[] = "Name must be between 2 and 255 characters.";
  }

  // subject name is unique
  if( !has_unique_subject_name($subject['subject_name'])){
    $errors[] = "Subject name must be unique.";
  }

  // check position if integer and is within range
  $position_int = (int) $subject['position'];

  if($position_int <= 0){
    $errors[] = "Position must be greater than zero";
  }

  if($position_int > 999){
    $errors[] = "Position should be less than 999";
  }

  // check visibility for string and inclusion
  $visible_str = (string) $subject['visible'];
  if(!has_inclusion_of($visible_str, ['0','1'])){
    $erros[] = "Visible must be true or false";
  }
  return $errors;
}

function validate_page($page){
  
  // setup error variable to hold error message(s)
  $errors = [];

  // is page_name set?
  if( is_blank( $page['page_name'] )){
    $errors[] = "Page name cannot be blank";
  }

  // is page_name of right length?
  if( !has_length( $page['page_name'], ['min' => 2, 'max' => 255] )){
    $errors[] = "Page name must be between 2 and 255 characters";
  }

  // is unique name? 
  if( !has_unique_page_name($page['page_name'], $page['id'])){
    $errors[] = "Page name must be unique";
  }

  // check if position is between 0 and 999
  $position_int = (int) $page['position'];

  if($position_int <= 0){
    $errors[] = "Position must be greater than zero";
  }

  if($position_int > 999){
    $errors[] = "Position should be less than 999";
  }

  // check visibility for string and inclusion
  $visible_str = (string) $page['visible'];

  if( !has_inclusion_of( $visible_str, ['0','1'] )){
    $erros[] = "Visible must be true or false";
  }
  
  // return errors or none depending on checks
  return $errors;


}

function has_unique_page_name($page_name, $current_id="0"){
  global $db;

  $sql = "SELECT * FROM pages WHERE page_name='";
  $sql .= db_escape($db,$page_name) . "'";
  $sql .= "AND id !='" . db_escape($db, $current_id) ."'";

  $result = mysqli_query($db, $sql);
  // check success or failure
  if($result){
    $is_unique = ( mysqli_num_rows($result) == 0 );
    mysqli_free_result($result);
    return $is_unique;
  }else{
    // Query failed, output error
    echo "Database query failed: " . mysqli_error($db);
    db_close($db);
    exit;
  } 
}

function has_unique_subject_name($subject_name){
  global $db;

  $sql = "SELECT * FROM subjects WHERE subject_name='" . db_escape($db,$subject_name) . "'";

  $result = mysqli_query($db, $sql);
  // check success or failure
  if($result){
    $is_unique = ( mysqli_num_rows($result) == 0 );
    mysqli_free_result($result);
    return $is_unique;
  }else{
    // Query failed, output error
    echo "Database query failed: " . mysqli_error($db);
    db_close($db);
    exit;
  } 
}

/**
 * Query Functions
 */
function find_all_subjects(){
  global $db;
  $sql = 'SELECT * FROM subjects ';
  $sql .= 'ORDER BY position ASC';
  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
  return $result;
}

function find_all_pages(){
  global $db;
  $sql = 'SELECT * FROM pages ';
  $sql .= 'ORDER BY subject_id ASC';
  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
  return $result;
}

function get_subject_by_id($id){
  global $db;
  $sql = "SELECT * FROM subjects WHERE id='" . db_escape($db,$id) . "'";
  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
  // find subject with provided id
  $subject = mysqli_fetch_assoc($result);
  // free result set
  mysqli_free_result($result);
  return $subject;
}

function get_page_by_id($id){
  global $db;

  $sql = "SELECT * FROM pages WHERE ";
  $sql .= "id='" . db_escape($db,$id) . "'";

  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
  // find page with provided id
  $page = mysqli_fetch_assoc($result);
  // free result set
  mysqli_free_result($result);
  return $page;
}

function create_subject($subject){
  global $db;

  // validate data before creating a record in db
  $errors = validate_subject($subject);

  // array is not empty, so return errors and stop execution
  if(!empty($errors)){
    return $errors;
  }

  // prepare sql query statement
  $sql = "INSERT INTO subjects (subject_name, position, visible,description)";
  $sql .= "VALUES (";
  $sql .= "'" . db_escape($db, $subject ['subject_name']) . "',";
  $sql .= "'" . db_escape($db, $subject ['position']) . "',";
  $sql .= "'" . db_escape($db, $subject ['visible']) . "',";
  $sql .= "'" . db_escape($db, $subject ['description']) . "')";

  // excute sql query statement
  $result = mysqli_query($db,$sql); // returns true or false

  // check success or failure
  if($result){
    return true;
  }else{
    // creation failed, so get error message, close and exit
    echo mysqli_error($db);
    db_close($db);
    exit;
  } 
}

function create_page($page){
  global $db;

  // validate page submission
  $errors = validate_page($page);

  // check if errors were produced
  if( !empty($errors) ){
    return $errors;
  }

  // prepare sql statement
  $sql = "INSERT INTO pages (page_name, position, visible, content, subject_id)";
  $sql .= "VALUES (";
  $sql .= "'" . db_escape($db, $page ['page_name']) . "',";
  $sql .= "'" . db_escape($db,$page ['position']) . "',";
  $sql .= "'" . db_escape($db,$page ['visible']) . "',";
  $sql .= "'" . db_escape($db,$page ['content']) . "',";
  $sql .= "'" . db_escape($db,$page ['subject_id']) . "')";

  // execute sql statement
  $result = mysqli_query($db,$sql); // returns true or false

  // check success or failure
  if($result){
    return true;
  }else{
    // creation failed
    echo mysqli_error($db);
    db_close($db);
    exit;
  } 
}

function update_subject_by_id($subject){
  global $db;

  //validate data
  $errors = validate_subject($subject);
  
  // check if array is not empty and return error, stop execution
  if(!empty($errors)){
    return $errors;
  }

  $sql = "UPDATE subjects SET ";
  $sql .= "subject_name='" . db_escape($db,$subject['subject_name']) ."',";
  $sql .= "position='" . db_escape($db,$subject['position']) ."',";
  $sql .= "visible='" . db_escape($db,$subject['visible']) ."',";
  $sql .= "description='" . db_escape($db,$subject['description']) ."'";
  $sql .= "WHERE id='" . db_escape($db,$subject['id']) . "' ";
  $sql .= "LIMIT 1";
  $result = mysqli_query($db,$sql);
  if($result){
    return true;
  }else{
    // after failure do the following
    echo mysqli_error($db);
    db_close($db);
    exit;
  }
}

function update_page_by_id($page){
  global $db;

  // validate data
  $errors = validate_page($page);

  // check result: true or false
  if( !empty($errors) ){
    return $errors;
  }

  // prepare sql statement
  $sql = "UPDATE pages SET ";
  $sql .= "page_name='" . db_escape($db,$page['page_name']) ."',";
  $sql .= "position='" . db_escape($db,$page['position']) ."',";
  $sql .= "visible='" . db_escape($db,$page['visible']) ."',";
  $sql .= "content='" . db_escape($db,$page['content']) ."',";
  $sql .= "subject_id='" . db_escape($db,$page['subject_id']) ."'";
  $sql .= "WHERE id='" . db_escape($db,$page['id']) . "' ";
  $sql .= "LIMIT 1";

  // excute sql statement
  $result = mysqli_query($db,$sql);
  // check success or failure
  if($result){
    return true;
  }else{
    // after failure do the following
    echo mysqli_error($db);
    db_close($db);
    exit;
  }
}

function delete_subject_by_id($id){
  global $db;
  // create sql
  $sql = "DELETE FROM subjects WHERE id='$id' LIMIT 1";

  // query db and get result
  $result = mysqli_query($db,$sql);

  // check for result failure
  confirm_result_set($result);

  if($result){
    return true;
  }else{
    // after failing do the following
    echo mysqli_error($db);
    db_close($db);
    exit;
  }
}

function delete_page_by_id($id){
  global $db;
  // create sql
  $sql = "DELETE FROM pages WHERE id='";
  $sql .=  db_escape($db,$id) . "' LIMIT 1";

  // query db and get result
  $result = mysqli_query($db,$sql);

  // check for result failure
  confirm_result_set($result);

  if($result){
    return true;
  }else{
    // after failing do the following
    echo mysqli_error($db);
    db_close($db);
    exit;
  }
}
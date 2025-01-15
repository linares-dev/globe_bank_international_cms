<?php require_once( '../../../private/initialize.php' );

$page_title = 'Subjects';

include( SHARED_PATH . '/staff_header.php' ); 
include( SHARED_PATH . '/staff_aside.php' );
?>

<?php
 $subject_set = find_all_subjects();
?>

<main>
  <h2>Subjects</h2>
  <p><a href='<?php echo get_url_root( '/staff/subjects/new.php' ); ?>'>Create a new subject</a></p>
  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Position</th>
        <th>Visible</th>
        <th>Name</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
      </tr>
    </thead>
    <tbody>
      <?php 
        while( $subject = mysqli_fetch_array($subject_set) ){ 
          $view = get_url_root('staff/subjects/show.php') . '?id=' . ue( $subject['id'] ) . '&subject_name=' . ue( $subject['subject_name'] );
          $edit = get_url_root('staff/subjects/edit.php') . '?id=' . $subject['id'];
          $delete = get_url_root('staff/subjects/delete.php') . '?id=' . $subject['id']; ?>
          <tr>
            <td><?php echo h($subject['id']); ?></td>
            <td><?php echo h($subject['position']); ?></td>
            <td><?php echo $subject['visible'] == '1' ? 'true' : 'false'; ?></td>
            <td><?php echo h($subject['subject_name']); ?></td>
            <td><a href='<?php echo $view ?>'>View</a></td>
            <td><a href='<?php echo $edit ?>'>Edit</a></td>
            <td><a href='<?php echo $delete ?>'>Delete</a></td>
        </tr>
       <?php } ?>
    </tbody>
    <tfoot>
      <tr><td colspan='7'>&nbsp;</td></tr>
    </tfoot>
  </table>
  <?php mysqli_free_result($subject_set); ?>
</main>

<?php include( SHARED_PATH . '/staff_footer.php'); ?>
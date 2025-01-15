<?php 
  require_once( '../../../private/initialize.php' );

  $page_title = 'Pages';
  include( SHARED_PATH . '/staff_header.php'); 

  include( SHARED_PATH . '/staff_aside.php');
?>

<?php $pages_set = find_all_pages(); ?>

<main>
  <h2>Pages</h2>
  <p><a href='<?php echo get_url_root('/staff/pages/new.php'); ?>'>Create a new page</a></p>
  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Subject ID</th>
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
        while($pages = mysqli_fetch_assoc($pages_set)){ 
          /* * clean output data 
          * use urlencode() when including data in urls
          * use htmlspecialchars() when outputting to html
          */
          $view = get_url_root('staff/pages/show.php') . '?id=' . h(ue( $pages['id'] )) . '&page_name=' . h(ue( $pages['page_name'] ));

          $edit = get_url_root('staff/pages/edit.php') . '?id=' . h(ue($pages['id']));

          $delete = get_url_root('staff/pages/delete.php') . '?id=' . h(ue($pages['id'])); ?>

          <tr>
            <td><?php echo h($pages['id']); ?></td>
            <td><?php 
              $subject_name = get_subject_by_id($pages['subject_id'])['subject_name'];
              echo h($subject_name); 
            ?></td>
            <td><?php echo h($pages['position']); ?></td>
            <td><?php echo $pages['visible'] == '1' ? 'true' :  'false'; ?></td>
            <td><?php echo $pages['page_name'] ?></td>
            <td><a href='<?php echo $view ?>'>View</a></td>
            <td><a href='<?php echo $edit ?>'>Edit</a></td>
            <td><a href='<?php echo $delete ?>'>Delete</a></td>
        </tr>
       <?php } ?>
       <?php mysqli_free_result($pages_set); ?>
    </tbody>
    <tfoot>
      <tr><td colspan='7'>&nbsp;</td></tr>
    </tfoot>
  </table>
</main>

<?php include( SHARED_PATH . '/staff_footer.php'); ?>
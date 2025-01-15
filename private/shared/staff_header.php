<?php (isset($page_title)) ? $page_title : $page_title = 'Staff Area'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GBI - <?php echo h($page_title); ?></title>
  <link rel="stylesheet" media="all" href="<?php echo get_url_root('/assets/styles/staff.css'); ?>" />
</head>
<body>
  <div class="grid-container">
    <header>
      <h1><abbr title="Globe Bank International">GBI</abbr> Staff Area</h1>
    </header>
    <nav class='flex-container'>
      <ul class='flex-container'>
        <li><a href="<?php echo get_url_root('index.php'); ?>">GBI Website</a></li>
      </ul>
    </nav>
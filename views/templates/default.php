<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Default View
 *
 * @package    Template
 * @category   View
 * @author     Rolando Henry
 * @copyright (c) 2010 Rolando Henry
 * @license    http://creativecommons.org/licenses/BSD/
 */
?><!doctype html>
<html>
<head>
    <meta charset="<?php echo Kohana::$charset ?>">

    <title><?php echo $title ?></title>

    <?php
    /* page meta, styles and scripts */
    foreach ($meta as $key => $value): 
        if ($value != '') :?><meta name="<?php echo $key ?>" content="<?php echo $value ?>">
    <?php endif; endforeach;
    echo $styles ?>

    <?php echo $scripts['head'] ?>

    <?php echo Template::ie_shiv() ?>

</head>
<body>
    <?php
      // page content here
      echo $content;

      // where most of the scripts will load
      echo $scripts['body'];

      // Profiler stats for developer environment
      if (Kohana::$environment === Kohana::DEVELOPMENT)
        echo View::factory('profiler/stats'); ?>

</body>
</html>


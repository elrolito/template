<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Default View
 *
 * @package    test
 * @category   View
 * @author     rolo
 * @copyright (c) 2010 rolo
 * @license    http://creativecommons.org/licenses/BSD/
 */
?><!doctype html>
<html>
<head>
    <meta charset="<?php echo Kohana::$charset ?>">

    <title><?php echo $title ?></title>

    <?php if ( ! empty($meta['description'])): ?><meta name="description" content="<?php echo $meta['description'] ?>">
    <?php endif; if ( ! empty($meta['keywords'])): ?><meta name="keywords" content="<?php echo $meta['keywords'] ?>">
    <?php endif; echo $head ?>

</head>
<body>
    <?php
      // page content here
      echo $content;

      // where most of the scripts will load
      echo $body_scripts;

      // Profiler stats for developer environment
      if (Kohana::$environment === Kohana::DEVELOPMENT)
        echo View::factory('profiler/stats'); ?>

</body>
</html>


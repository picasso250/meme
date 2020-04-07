<?php
!defined('IN_PTF') && exit('ILLEGAL EXECUTION');
/**
 * @file    page404
 * @author  ryan <cumt.xiaochi@gmail.com>
 * @created Jun 30, 2012 11:13:21 AM
 */
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title><?php echo $page['title']; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <?php
        echo css_node('reset'), "\n";
        echo css_node('style'), "\n";
        foreach ($page['styles'] as $style) {
            echo css_node($style), "\n";
        }
        ?>
    </head>
    <body>
        <div class="header">
            <?php include smart_view('header'); ?>
        </div>
        <div class="misssing">
            没有页面 404
        </div>
    </body>
</html>

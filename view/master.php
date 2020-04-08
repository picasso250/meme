<?php
!defined('IN_PTF') && exit('ILLEGAL EXECUTION');
/**
 * @file    master
 * @author  ryan <cumt.xiaochi@gmail.com>
 * @created
 */
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title><?php echo $page['title']; ?></title>
        <meta property="qc:admins" content="245072756550631611006375" />
        <meta name="description" content="<?php echo i($page['description']); ?>" />
        <meta name="keywords" content="<?php echo implode(', ', i($page['keywords'], array())); ?>" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="stylesheet" type="text/css" href="<?= URL_ROOT ?>/css/bootstrap.min.css">
        <?php
        echo css_node('reset'), "\n";
        echo css_node('style'), "\n";
        foreach ($page['styles'] as $style) {
            echo css_node($style), "\n";
        }
        ?>
        <script>var URL_ROOT='<?=URL_ROOT?>';</script>
    </head>
    <?php ob_flush(); ?>
    <body>
        <div class="append_parent"></div>
        <div class="header">
            <?php include smart_view('header'); ?>
        </div>
        <div class="content">
            <?php include smart_view($content); ?>
        </div>
        <div class="footer">
            <?php include smart_view('footer'); ?>
        </div>
        <?php
        echo js_node('jquery-1.7.2.min'), "\n";
        echo js_var('_G', array('ROOT'=>ROOT)), "\n";
        echo js_node('every');
        foreach ($page['scripts'] as $script) {
            echo js_node($script), "\n";
        }
        ?>

        <?php if (isset($_SERVER['HTTP_APPNAME'])): ?>
        <script type="text/javascript">

        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-35430726-1']);
        _gaq.push(['_trackPageview']);

        (function() {
          var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
          ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
          var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
        })();

        </script>
        <?php endif ?>
        
    </body>
</html>

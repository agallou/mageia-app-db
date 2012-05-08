<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <?php $madbConfig = new madbConfig(); ?>
    <head>
        <?php include_http_metas() ?>
        <?php include_metas() ?>
        <?php echo content_tag('title', $madbConfig->get('name'))."\n"; ?>
        <link rel="shortcut icon" href="/favicon.ico" />
        <?php include_stylesheets() ?>
        <?php include_javascripts() ?>
    </head>
    <body>
        <div id="container">
            <div id="header">
                <h1><?php echo link_to($madbConfig->get('name'), 'http://' . $madbConfig->get('host')) ?></h1>
                <div id="search">
                    <?php include_component('default', 'searching', array(
                      'module_to' => 'package',
                      'action_to' => 'list',
                    )) ?>
                </div>
                <div id="user_infos">
                    <?php if ($sf_user->isAuthenticated()): ?>
                        <?php echo $sf_user->getUsername() ?>
                        (<?php echo $sf_user->getProfile()->getMail() ?>)
                        <?php echo link_to('Logout', url_for('@logout')); ?>
                    <?php else: ?>
                        <span>Register? |</span>
                        <?php echo link_to('Login', url_for('@login')) ?>
                    <?php endif; ?>
                </div>
            </div>
      <!--      <div id="global"> -->
                <div id="menu">
                    <?php include_component('default', 'menu') ?>
                </div>                
                <div id="content">
                    <div id="filtering">
                      <?php include_component_slot('filtering') ?>
                    </div>
                    <?php echo $sf_content ?>
                </div>

                    
                <div id="footer">
                <div class="content">
                  <?php include_component('default', 'footer') ?>
                </div>
            </div>
            </div>
        <!-- </div> -->
    </body>
</html>

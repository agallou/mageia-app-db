<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <?php $madbConfig = new madbConfig(); ?>
    <head>
        <?php include_http_metas() ?>
        <?php include_metas() ?>
        <?php echo content_tag('title', $madbConfig->get('name') . ' - ' . $madbConfig->get('subname'))."\n"; ?>
        <link rel="shortcut icon" href="/favicon.ico" />
        <?php include_stylesheets() ?>
        <?php include_javascripts() ?>
    </head>
    <body>
        <div id="container">
            <div id="header">
                <div id="appname">
                  <?php echo link_to($madbConfig->get('name'), 'http://' . $madbConfig->get('host')) ?><br />
                  <?php if (strlen($subname = $madbConfig->get('subname'))): ?>
                  <span class="subname"><?php echo link_to($subname, 'http://' . $madbConfig->get('host')) ?></span>
                  <?php endif ?>
                </div>
                <div id="search">
                    <?php include_component('default', 'searching', array(
                      'module_to' => 'package',
                      'action_to' => 'list',
                    )) ?>
                </div>
                <div id="user_infos">
                    <?php if ($sf_user->isAuthenticated()): ?>
                        <?php echo $sf_user->getUsername() ?>
                        <?php if ($mail = $sf_user->getProfile()->getMail()): ?>
                          (<?php echo $sf_user->getProfile()->getMail() ?>)
                        <?php endif ?>
                        <?php echo link_to('<i class="icon-signout"></i>', url_for('@sf_guard_signout')); ?>
                    <?php else: ?>
                        <?php echo link_to('<i class="icon-signin" title="Login"></i>', url_for('@sf_guard_signin')) ?>
                    <?php endif; ?>
                </div>
            </div>
      <!--      <div id="global"> -->
                <div id="menu">
                    <?php include_component('default', 'menu', $sf_request->getParameterHolder()->getAll()) ?>
                </div>
                <div id="content">
                    <?php if (has_slot('name')): ?>
                      <div class="pagename">
                        <p><?php include_slot('name') ?></p>
                      </div>

                    <?php endif ?>
                    <div id="filtering-border">
                        <div id="filtering">
                          <?php include_component_slot('filtering') ?>
                        </div>
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
    <?php include_component('default', 'tracker') ?>
    </body>
</html>

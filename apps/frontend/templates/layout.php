<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <?php $madbConfig = new madbConfig(); ?>
    <?php $madbAsset = new madbAssets('/assets/'); ?>
    <head>
        <?php include_http_metas() ?>
        <?php include_metas() ?>
        <title>
	    <?php echo $madbConfig->get('name');

		  if(($slot = get_slot('title')) != '') {
		    echo ' - ' . $slot;
		  }
	    ?>
        </title>
        <link rel="shortcut icon" href="/favicon.ico" />
        <link rel="stylesheet" href="<?php echo $madbAsset->robotAsset('css/main.css') ?>" />
        <script src="<?php echo $madbAsset->robotAsset('js/main.js') ?>"></script>
    </head>
    <body>
        <div id="container">

            <div id="header">

              <div id="header-container">
                <?php include_component('default', 'mageiaNav') ?>

                  <div id="madb-header">
                      <div id="madb-header-container">
                          <div id="appname">
                              <?php $linkName = $madbConfig->get('name') . '<br />'; ?>
                              <?php if (strlen($subname = $madbConfig->get('subname'))): ?>
                                  <?php $linkName .= '<span class="subname">' . $subname . '</subname>'; ?>
                              <?php endif ?>
                              <?php echo link_to($linkName, 'http://' . $madbConfig->get('host')) ?>
                          </div>
                          <div id="search">
                              <?php include_component('default', 'searching', array(
                                  'module_to' => 'package',
                                  'action_to' => 'list',
                              )) ?>
                          </div>
                          <div id="user_infos">
                              <div class="header-button">
                                  <?php if ($sf_user->isAuthenticated()): ?>
                                      <?php echo link_to('<i class="icon-signout"></i><br />Logout', url_for('@sf_guard_signout')); ?>
                                  <?php else: ?>
                                      <?php echo link_to('<i class="icon-signin"></i><br />Login', url_for('@sf_guard_signin')) ?>
                                  <?php endif; ?>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
            </div>

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
                <div id="search-page">
                  <?php include_component_slot('searching') ?>
                </div>

                <div id="sfcontent">
                  <?php echo $sf_content ?>
                </div>


            </div>


             <div id="footer">
                <?php include_component('default', 'footer') ?>
             </div>

            </div>



    <?php include_component('default', 'tracker') ?>
    </body>
</html>

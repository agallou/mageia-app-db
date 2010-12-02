<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <?php include_http_metas() ?>
        <?php include_metas() ?>
        <?php include_title() ?>
        <link rel="shortcut icon" href="/favicon.ico" />
        <?php include_stylesheets() ?>
        <?php include_javascripts() ?>
    </head>
    <body>
        <div id="container">
            <div id="header">
                <h1>Mageia app DB</h1>
                <div id="user_infos">
                    <?php if ($sf_user->isAuthenticated()): ?>
                        <?php echo link_to('Logout', url_for('@logout')); ?>
                    <?php else: ?>
                        <?php echo link_to('Login', url_for('@login')) ?>
                    <?php endif; ?>
                </div>
            </div>
      <!--      <div id="global"> -->
                <div id="menu">
                    <?php include_component('default', 'menu') ?>
                </div>
                <div id="content">
                    <?php echo $sf_content ?>
                </div>
                <div id="footer">
                <div class="content">
                 <!--   <span class="symfony">
                        powered by
                        <a href="http://www.symfony-project.org/">
                            <img src="/images/symfony2.gif" alt="symfony framework" />
                        </a>
                    </span> -->
                </div>
            </div>
            </div>
        <!-- </div> -->
    </body>
</html>

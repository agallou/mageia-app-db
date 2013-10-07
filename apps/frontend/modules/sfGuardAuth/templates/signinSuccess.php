<?php slot('name', 'Login') ?>

<div id="login_form">
  <form action="<?php echo url_for('@sf_guard_signin') ?>" method="post">

    <?php echo $form->renderGlobalErrors(); ?>

    <h2><i class="icon-user"></i> Username</h2>
    <?php echo $form['username']->render(array('placeholder' => "Username")) ?>
    <?php echo $form['username']->renderError() ?>
    <br />
    <h2><i class="icon-key"></i> Password</h2>
    <?php echo $form['password']->render(array('placeholder' => 'Password')) ?>
    <?php echo $form['password']->renderError() ?>
    <br /><br />
    <?php echo tag('input', array('type' => 'submit', 'value' => 'Sign in')) ?>

  </form>
</div>

<?php use_helper('JavascriptBase') ?>
<?php echo javascript_tag() ?>
$('#filtering-border').remove();
$('#login_form input:first').focus();
<?php end_javascript_tag() ?>



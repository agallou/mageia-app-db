<div id="login_form">
  <form action="<?php echo url_for('@sf_guard_signin') ?>" method="post">

    <?php echo $form->renderGlobalErrors(); ?>

    <h2>Username</h2>
    <?php echo $form['username']->renderError() ?>
    <?php echo $form['username']->render() ?>
    <br />
    <h2>Password</h2>
    <?php echo $form['password']->renderError() ?>
    <?php echo $form['password']->render() ?>
    <br /><br />
    <?php echo tag('input', array('type' => 'submit', 'value' => 'Sign in')) ?>

  </form>
</div>

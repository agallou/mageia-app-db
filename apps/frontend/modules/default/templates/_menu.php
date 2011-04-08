<?php $definition = new menuGroupBuilderFrontend($sf_user); ?>
<?php $group      = $definition->getMenuGroup() ?>
<?php $renderer   = new menuRenderer($madbcontext, $madburl, $sf_request); ?>
<?php echo $renderer->render($group) ?>

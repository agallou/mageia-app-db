<?php $url = new madbUrl($sf_context)?>
<?php $cultures = array('fr', 'en'); ?>
<?php foreach ($cultures as $culture): ?>
  <?php $params = $sf_params->getAll(); ?>
  <?php unset($params['module']) ?>
  <?php unset($params['action']) ?>
  <?php $params['sf_culture'] = $culture ?>
  <?php // FIXME: should be nice links, not ugly ones ?>
  <?php // echo link_to($culture, url_for(sprintf('%s/%s', $sf_params->get('module'), $sf_params->get('action'))) . '?' .http_build_query($params)); ?>
<?php endforeach; ?>
<p>
Powered by <a href="http://madb.org">Mageia App Db</a>
-
Synchronized from <a href="http://sophie.zarb.org">http://sophie.zarb.org</a>
<?php if ($sf_user->isAuthenticated() && $sf_user->hasCredential('admin')): ?>
 - <?php echo link_to('Administration', cross_app_url_for('backend', '@homepage')) ?>
<?php endif; ?>
 - Version <?php echo sfConfig::get('app_version') ?>
</p>

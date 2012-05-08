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
-
Powered by <a href="http://madb.org">Mageia App Db</a>
under the <a href="http://www.gnu.org/licenses/agpl-3.0.html">AGPLv3 License</a>. 
<a href="https://gitorious.org/mageia-app-db/mageia-app-db">Get source code</a>.
-
Synchronized from <a href="http://sophie.zarb.org">http://sophie.zarb.org</a>
<?php if ($sf_user->isAuthenticated() && $sf_user->hasCredential('admin')): ?>
 - <?php echo link_to('Administration', cross_app_url_for('backend', '@homepage')) ?>
<?php endif; ?>
 - Version <?php echo sfConfig::get('app_version') ?>

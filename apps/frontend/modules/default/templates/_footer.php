Synchronized from <a href="http://sophie.zarb.org">http://sophie.zarb.org</a>
<?php if ($sf_user->isAuthenticated() && $sf_user->hasCredential('admin')): ?>
 - <?php echo link_to('Administration', cross_app_url_for('backend', '@homepage')) ?>
<?php endif; ?>
 - Version <?php echo sfConfig::get('app_version') ?>

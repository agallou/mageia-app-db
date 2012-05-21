<?php
class screenshotsAction extends madbActions
{
  public function execute($request)
  {
    // get JSON information from screenshots.debian.org
    $package = urlencode($request->getParameter('package'));
    $time_start = microtime(true);
    $url = "http://screenshots.debian.net/json/package/$package";
    $json = @file_get_contents($url);
    $duration = round(microtime(true) - $time_start, 3);
    $result = json_decode($json, true);
    $i=0;
    if (isset($result['screenshots']) and is_array($result['screenshots']) and !empty($result['screenshots']))
    {
      $output = "";
      foreach ($result['screenshots'] as $screenshot_info)
      {
        $i++;
        $output .= <<<EOF
<a rel="screenshots" href="$screenshot_info[large_image_url]">
<img src="$screenshot_info[small_image_url]" alt="screenshot"/>
</a>
EOF;
      } 
    }
    else
    {
      $output = "<p>No screenshot found for $package.";
      //$output .= "<a href=\"http://screenshots.debian.net/upload/$package\">Add one</a>.</p>";
    }
    
    $output .= <<<EOF
<script type="text/javascript">
//<![CDATA[
$("a[rel=screenshots]").fancybox({
  'transitionIn' : 'none',
  'transitionOut' : 'none',
  'type' : 'image'
});
//]]>
</script>
EOF;
    return $this->renderText($output);
  }

}

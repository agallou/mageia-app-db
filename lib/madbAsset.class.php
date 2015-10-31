<?php
class madbAssets
{

    protected $assetsDir    = null;
    protected $basePath = null;
  
    public function __construct($basePath = null)
    {
        $this->assetsDir = sfConfig::get("sf_web_dir") . '/assets';
        $this->basePath = $basePath;
    }

    /**
     * @param string $filename
     *
     * @return string
     */
    public function robotAsset($filename)
    {
        $pattern = vsprintf('%s*.%s', array(
            pathinfo($filename, PATHINFO_FILENAME),
            pathinfo($filename, PATHINFO_EXTENSION),
        ));
        $subdir = pathinfo($filename, PATHINFO_DIRNAME);
        return $this->getCompiledFile($pattern, $subdir);
    }
    /**
     * @param string $pattern
     * @param string $subDir
     *
     * @throws \Exception
     *
     * @return string
     */
    protected function getCompiledFile($pattern, $subDir)
    {
        $files = glob($this->assetsDir . '/' . $subDir . '/' . $pattern);

        if (0 === count($files)) {
            throw new \Exception(sprintf("Asset file not found", $pattern));
        }

        if (count($files) > 1) {
            throw new \Exception('There should not have more than one file in the assets dir');
        }

        return sprintf('%s/%s/%s', $this->basePath, $subDir, basename($files[0]));
    }
  
}

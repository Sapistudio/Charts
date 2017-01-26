<?php
namespace SapiStudio\Charts\Amchart;
/*

/**
 * Class to create a world chart from the amCharts library.
 */
class AmWorldChart extends AmChart
{
    protected $defaultSliceConfig = array();
    protected $jsPath = "pie.js";
    /**
     * @see AmChart::getJSPath()
     */
    public function getJSPath()
    {
        return $this->jsPath;
    }
    /**
     * @see AmChart::setJSPath($path)
     */
    public function setJsPath($path)
    {
        $this->jsPath = $path;
    }
    protected function setDefaultConfig()
    {
        $this->config['type'] = "pie";
        $this->config['titleField'] = "title";
        $this->config['valueField'] = "value";
    }
    /**
     * Returns the config array.
     *
     * @return    array
     */
    public function getConfig()
    {
        return $this->config;
    }
}

<?php
namespace SapiStudio\Charts\Amchart;
/*
 * AmCharts-PHP 0.3
 * Copyright (C) 2009-2014 Fusonic GmbH
 *
 * This file is part of AmCharts-PHP.
 *
 * AmCharts-PHP is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * AmCharts-PHP is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library. If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * Base class for amChart PHP-Library
 */
abstract class AmChart extends \Charts\Handler
{
    protected $config = [];
    protected $libraryPath;

    /**
     * Constructor can only be called from derived class because AmChart
     * is abstract.
     *
     * @param	string				$id
     */
    public function __construct($id = null)
    {
        $this->element          = ($id) ? $id : substr(md5(uniqid() . microtime()), 3, 5);
        $http                   = ($_SERVER['HTTPS']) ? 'https' : 'http';
        $this->libraryPath      = $http.'://'.$_SERVER['HTTP_HOST'].str_replace($_SERVER['DOCUMENT_ROOT'], '', dirname( __FILE__ )). '/amcharts/';
        $this->config['width']  = "100%";
        $this->config['height'] = "300px";
        $this->setDefaultConfig();
    }

    /**
     * Add a title to the chart
     *
     * @param   string          $text
     * @param   string          $color
     * @param   int             $size
     * @param   string          $id         HTML-ID of the title
     * @param   int             $alpha
     * @return  void
     */
    public function addTitle($text, $color = "", $size = 14, $id = "chart-title", $alpha = 1)
    {
        $this->config["titles"][] = [
            "text" => $text,
            "color" => $color,
            "size" => $size,
            "id" => $id,
            "alpha" => $alpha
        ];
    }

    /**
     * Returns the HTML Code to insert on the page.
     *
     * @return	string
     */
    public function getCode()
    {
        $code = '<div class="amChart" id="' . $this->element . '" style="width: ' . $this->config["width"] . '; height: ' . $this->config["height"] . '"></div>' . "\n";
        $code .= '<script src="' . $this->libraryPath . '/amcharts.js"></script>';
        $code .= '<script src="' . $this->libraryPath . '/' . $this->getJSPath() . '"></script>';
        $code .= '<script>' . "\n" . $this->getJavaCode() . "\n". '</script>' . "\n";
        return $code;
    }
    
    /**
     * AmChart::getJavaCode()
     * 
     * @return
     */
    public function getJavaCode()
    {
        unset($this->config["width"]);
        unset($this->config["height"]);
        return 'var chart = AmCharts.makeChart("' . $this->element . '",' . $this->getChartJSON() . ');';
    }

    /**
     * Sets the config array. It should look like this:
     * array(
     *   "width" => "300px",
     *   "height" => "100px",
     * )
     *
     * @param	array				$config
     * @param	bool				$merge
     */
    public function setConfigAll(array $config, $merge = false)
    {
        if($merge)
        {
            foreach($config AS $key => $value)
            {
                $this->config[$key] = $value;
            }
        }
        else
        {
            $this->config = $config;
        }
    }

    /**
     * Sets one config variable.
     *
     * @param	string				$key
     * @param	mixed				$value
     */
    public function setConfig($key, $value)
    {
        $this->config[$key] = $value;
    }
    
    public function prepareData()
    {
        $this->setConfig("pathToImages", $this->libraryPath.'/images/');
        $this->setConfig("categoryField", $this->_categoryField);
        $this->setConfig("marginRight", 40);
        $this->setConfig("marginLeft", 40);
        $this->setConfig("autoMarginOffset", 20);
        $this->setConfig("chartScrollbar", ["gridAlpha"=>0,"color"=>"#888888","scrollbarHeight"=>2,"backgroundAlpha"=>0,"selectedBackgroundAlpha"=>0.1,"selectedBackgroundColor"=>"#888888","graphFillAlpha"=>0,"autoGridCount"=>true,"selectedGraphFillAlpha"=>0,"graphLineAlpha"=>0.2,"graphLineColor"=>"#c2c2c2","selectedGraphLineColor"=>"#888888","selectedGraphLineAlpha"=>1]);
        $this->setConfig("chartCursor",["cursorPointer" => "mouse","pan" =>true,"valueLineEnabled" => true,"cursorAlpha" =>0.1,"cursorColor" => "#000000","valueLineBalloonEnabled" =>true,"fullWidth" =>true,"cursorColor" => "#258cbb","valueLineAlpha" => 0.2,"valueZoomable" => true]);
        //$this->setConfig("chartCursor",["categoryBalloonDateFormat" => "DD","cursorAlpha" =>0.1,"cursorColor" => "#000000","fullWidth" =>true,"valueBalloonsEnabled" => false,"zoomable" => false]);
        $this->setConfig("categoryAxis",["parseDates" => true,"dashLength" =>1,"minorGridEnabled" => true]);
        $this->setConfig("mouseWheelZoomEnabled",true);
        $this->setConfig("dataDateFormat","YYYY-MM-DD");
        $this->setConfig("theme","light");
        $this->setConfig("theme","light");
        $this->setConfig('valueAxes',$this->chartSettings['valueAxes']);
        $this->setConfig('legend',["enabled"=>true,"useGraphSettings"=>true]);
        $default = ["balloonText"=>"[[title]] :[[value]]","bullet"=>"round","bulletBorderAlpha"=>2,"bulletColor"=> "#FFFFFF","bulletSize"=> 1,"useLineColorForBulletBorder"=>true,"legendPeriodValueText"=>"[[value.sum]]","legendValueText"=> "[[value]]"];
        foreach($this->getYkeys() as $a=>$value){
            $settings=(isset($this->chartSettings['graphs'][$value])) ? array_merge($this->chartSettings['graphs'][$value],$default) : $default;
            $this->addGraph($value,$settings);
        }
            
    }

    /**
     * Returns the config array.
     *
     * @return	array
     */
    public abstract function getConfig();

    /**
     * Returns the ready-to-use config JSON string
     * @return	string
     */
    public function getChartJSON()
    {
        $this->config["dataProvider"] = $this->getData();
        return json_encode($this->getConfig());
    }

    /**
     * Returns the path to the chart-specific js file.
     *
     * @return	string
     */
    protected abstract function getJSPath();

    /**
     * Sets the Path of the JS file the chart uses
     *
     * @param       string          $path
     * @return      void
     */
    protected abstract function setJSPath($path);

    /**
     * @param   string          $libraryPath
     */
    public function setLibraryPath($libraryPath)
    {
        $this->libraryPath = $libraryPath;
    }

    /**
     * @return  string
     */
    public function getLibraryPath()
    {
        return $this->libraryPath;
    }

    protected abstract function setDefaultConfig();

}

<?php
namespace SapiStudio\Charts;
/**
 * Main Morris model class
 *
 * @class           MorrisCharts
 * @author          =undo= <info@wpxtre.me>
 * @copyright       Copyright (C) 2012-2014 wpXtreme Inc. All Rights Reserved.
 * @date            2014-04-01
 * @version         1.0.0
 *
 */
abstract class Handler
{
    public $_categoryField = [];
    /**  Type of chart. This value is used in Javascript Morris method*/
    protected $__chart_type     = null;
    /** The ID of (or a reference to) the element into which to insert the graph. Note: this element must have a width and height defined in its styling.*/
    public $element             = '';
    /** The data to plot. This is an array of objects, containing x and y attributes as described by the xkey and ykeys options.*/
    public $data                = [];
    public $chartSettings       = [];
        
    /** Return a singleton instance of Morris class */
    public static function init($element_id)
    {
        static $instance = null;
        if (is_null($instance))
            $instance = new self($element_id);
        return $instance;
    }
    
    /** Handler::__set()  */
    public function __set($key, $value)
    {
                           
        $this->$key = $value;
    }
    
    /** Handler::__call()  */
    public function __call($method, $args) {
        $this->$method = $args[0];
        return $this;
    }
    
    /** Handler::setElement()*/
    public function setElement($element_id)
    {
        $this->element = $element_id;
        return $this;
    }
    
    /** Handler::getElement()*/
    public function getElement($element_id)
    {
        return $this->element;
    }
    
    /** Handler::setXkey()*/
    public function setXkey($value)
    {
        $this->_categoryField = [$value];
        return $this;
    }
    
    /** Handler::getYkeys() */
    public function getYkeys()
    {
        return array_values(array_diff(array_keys($this->getFirstDataEntry()), $this->_categoryField));
    }
    
    /** Return the jSON encode of this chart*/
    public function toJSON($returnAsArray = false)
    {
        $return = [];
        foreach ($this as $property => $value)
        {
            if ('__' == substr($property, 0, 2) || '' === $value || is_null($value) || (is_array($value) && empty($value)))
                continue;
            $return[$property] = $value;
        }
        return ($returnAsArray) ? $return : json_encode($return);
    }
    
    /** Handler::setData() */
    public function setData($data)
    {
        $this->data = $data;
        $this->prepareData();
        return $this;
    }
    
    /** Handler::setSettings() */
    public function setSettings($settings)
    {
        $this->chartSettings = $settings;
        return $this;
    }
    
    /** Handler::getFirstDataEntry() */
    public function getFirstDataEntry()
    {
        return (isset($this->data[0])) ? $this->data[0] : $this->data;
    }
    
    /** Handler::toJavascript()*/
    public function toJavascript()
    {
        return '<script type="text/javascript">' . "\n" . $this->drawJsChart() . "\n" . '</script>' . "\n";
    }
    
    /** Handler::toRemote()*/
    public function drawJsChart()
    {
        return 'jQuery(function (jQuery){"use strict"; var '.$this->getElement().'=' . $this->getJavaCode() . ';});';
    }
    
    /** Handler::prepareData()*/
    public abstract function prepareData();
    /** Handler::getJavaCode() */
    public abstract function getJavaCode();
}
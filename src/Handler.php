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
    /**
     * Type of chart. This value is used in Javascript Morris method
     *
     * @brief Chart
     *
     * @var string $__chart_type
     */
    protected $__chart_type = null;
    /**
     * The ID of (or a reference to) the element into which to insert the graph.
     * Note: this element must have a width and height defined in its styling.
     *
     * @brief Element
     *
     * @var string $element
     */
    public $element = '';
    /**
     * The data to plot. This is an array of objects, containing x and y attributes as described by the xkey and ykeys options.
     * Note: the order in which you provide the data is the order in which the bars are displayed.
     *
     * Note 2: if you need to update the plot, use the setData method on the object that Morris.Bar
     * returns (the same as with line charts).
     *
     * @brief Data
     *
     * @var array $data
     */
    public $data = [];
    
    public $chartSettings = [];
        
    /**
     * Return a singleton instance of Morris class
     *
     * @brief Singleton
     *
     * @return Morris
     */
    public static function init($element_id)
    {
        static $instance = null;
        if (is_null($instance))
        {
            $instance = new self($element_id);
        }
        return $instance;
    }
    
    /**
     * Create an instance of Morris class
     *
     * @brief Construct
     *
     * @param string $element_id The element id
     * @param string $chart      Optional. Chart Type of chart. Default MorrisChartTypes::LINE
     *
     * @return Morris
     */
    public function __construct($element_id = null, $chart = MorrisChartTypes::LINE)
    {
        $this->element = $element_id;
        $this->__chart_type = $chart;
    }
    
    public function __set($key, $value)
    {
        $this->$key = $value;
    }
    
    public function __call($method, $args) {
        $this->$method = $args[0];
        return $this;
    }
    
    /**
     * Handler::setElement()
     * 
     * @param mixed $element_id
     * @return
     */
    public function setElement($element_id)
    {
        $this->element = $element_id;
        return $this;
    }
    
    public function getElement($element_id)
    {
        return $this->element;
    }
    
    /**
     * Return the array of this object
     *
     * @brief Array
     *
     * @return array
     */
    public function toArray()
    {
        $return = [];
        foreach ($this as $property => $value)
        {
            if ('__' == substr($property, 0, 2) || '' === $value || is_null($value) || (is_array
                ($value) && empty($value)))
            {
                continue;
            }
            $return[$property] = $value;
        }
        return $return;
    }
    
    /**
     * Handler::setXkey()
     * 
     * @param mixed $value
     * @return
     */
    public function setXkey($value)
    {
        $this->_categoryField = [$value];
        return $this;
    }
    
    /**
     * Handler::getYkeys()
     * 
     * @return
     */
    public function getYkeys()
    {
        $main = $this->getData();
        return array_values(array_diff(array_keys($main), $this->_categoryField));
    }
    
    /**
     * Return the jSON encode of this chart
     *
     * @brief JSON
     *
     * @return string
     */
    public function toJSON()
    {
        return str_ireplace(["'function",'"function',"}'",'}"'],["function",'function',"}",'}'],json_encode($this->toArray()));
    }
    
    /**
     * Handler::getDataJSON()
     * 
     * @return
     */
    public function getDataJSON()
    {
        return json_encode($this->getData());
    }
    
    /**
     * Handler::setData()
     * 
     * @param mixed $data
     * @return
     */
    public function setData($data)
    {
        $this->data = $data;
        $this->prepareData();
        return $this;
    }
    
    public function setSettings($settings)
    {
        $this->chartSettings = $settings;
        return $this;
    }
    
    /**
     * Handler::getData()
     * 
     * @return
     */
    public function getData()
    {
        return (isset($this->data[0])) ? $this->data[0] : $this->data;
    }
    
    /**
     * Handler::prepareData()
     * 
     * @return
     */
    public abstract function prepareData();
    
    /**
     * Handler::getCode()
     * 
     * @return
     */
    public abstract function getCode();
    
    /**
     * Handler::getJavaCode()
     * 
     * @return
     */
    public abstract function getJavaCode();
    
    /**
     * Handler::toJavascript()
     * 
     * @return void
     */
    public function toJavascript()
    {
        return $this->getCode() . '<script type="text/javascript">' . "\n" . $this->toRemote() . "\n" . '</script>' . "\n";
    }
    
    /**
     * Handler::toRemote()
     * 
     * @return void
     */
    public function toRemote()
    {
        return 'jQuery(function ( $ ){"use strict"; var '.$this->getElement().'=' . $this->getJavaCode() . ';});';
    }
}

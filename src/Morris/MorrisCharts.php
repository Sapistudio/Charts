<?php

namespace SapiStudio\Charts\Morris;
use SapiStudio\Charts\Handler;
/**
 * Morris Charts common model
 *
 * @class           MorrisCharts
 * @author          =undo= <info@wpxtre.me>
 * @copyright       Copyright (C) 2012-2014 wpXtreme Inc. All Rights Reserved.
 * @date            2014-04-01
 * @version         1.0.0
 *
 */
abstract class MorrisCharts extends Handler
{
    /**
     * A string containing the name of the attribute that contains date (X) values.
     * Timestamps are accepted in the form of millisecond timestamps (as returned by Date.getTime() or as strings in the following formats:
     */
    public $xkey = [];
    /**
     * A list of strings containing names of attributes that contain Y values (one for each series of data to be plotted).
     */
    public $ykeys = [];
    /**
     * A list of strings containing labels for the data series to be plotted (corresponding to the values in the ykeys option).
     */
    public $labels = [];
    /**
     * Max. bound for Y-values. Alternatively, set this to 'auto' to compute automatically, or 'auto [num]' to
     * automatically compute and ensure that the max y-value is at least [num].
     *
     */
    public $ymax = 'auto';
    /**
     * Min. bound for Y-values. Alternatively, set this to 'auto' to compute automatically, or 'auto [num]' to
     * automatically compute and ensure that the min y-value is at most [num].
     * Hint: you can use this to create graphs with false origins.
     *
     */
    public $ymin = 0;
    /**
     * Set to false to always show a hover legend.
     * Set to true or 'auto' to only show the hover legend when the mouse cursor is over the chart.
     * Set to 'always' to never show a hover legend.
     */
    public $hideHover = 'auto';
    /**
     * Provide a function on this option to generate custom hover legends. The function will be called with the index of
     * the row under the hover legend, the options object passed to the constructor as arguments, and a string containing
     * the default generated hover legend content HTML.
     * eg:
     *
     *     hoverCallback: function (index, options, content) {
     *       var row = options.data[index];
     *       return "sin(" + row.x + ") = " + row.y;
     *     }
     *
     */
    public $hoverCallback = '';
    /**
     * Set to false to disable drawing the x and y axes.
     */
    public $axes = true;
    /**
     * Set to false to disable drawing the horizontal grid lines.
     */
    public $grid = true;
    /**
     * Set the color of the axis labels (default: #888).
     */
    public $gridTextColor = '#888';
    /**
     * Set the point size of the axis labels (default: 12).
     */
    public $gridTextSize = '12';
    /**
     * Set the font family of the axis labels (default: sans-serif).
     */
    public $gridTextFamily = 'sans-serif';
    /**
     * Set the font weight of the axis labels (default: normal).
     */
    public $gridTextWeight = 'normal';
    /**
     * Set to true to enable automatic resizing when the containing element resizes. (default: false).
     * This has a significant performance impact, so is disabled by default.
     */
    public $resize              = false;
    public $rangeSelect         = null;
    public $rangeSelectColor    = '#eef';
    public $padding             = 25;
    public $numLines            = 5;
    /**
     * A list of x-values to draw as vertical 'event' lines on the chart.
     *
     * eg: events: ['2012-01-01', '2012-02-01', '2012-03-01']
     */
    public $events = [];
    /**
     * Width, in pixels, of the event lines.
     */
    public $eventStrokeWidth = 1;
    /**
     * Array of color values to use for the event line colors. If you list fewer colors here than you have lines in
     * events, then the values will be cycled.
     */
    public $eventLineColors = ['#005a04', '#ccffbb', '#3a5f0b', '#005502'];
    /**
     * A list of y-values to draw as horizontal 'goal' lines on the chart.
     */
    public $goals = [];
    /**
     * Width, in pixels, of the goal lines.
     */
    public $goalStrokeWidth = 1;
    /**
     * Array of color values to use for the goal line colors. If you list fewer colors here than you have lines in goals,
     * then the values will be cycled.
     */
    public $goalLineColors = ['#666633', '#999966', '#cc6666', '#663333'];
    /**
     * Set to false to skip time/date parsing for X values, instead treating them as an equally-spaced series.
     */
    public $parseTime = true;
    /**
     * Set to a string value (eg: '%') to add a label suffix all y-labels.
     */
    public $postUnits = '';
    /**
     * Set to a string value (eg: '$') to add a label prefix all y-labels.
     */
    public $preUnits = '';
    /**
     * Angle of x label
     */
    public $xLabelAngle = 0;
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
     
    public $makeLegend = true;
    
    public $legendItem = null;
    
    
    /**
     * MorrisCharts::__construct()
     * 
     * @return void
     */
    public function __construct($element_id = null, $chart = MorrisChartTypes::LINE)
    {
        $this->element      = $element_id;
        $this->__chart_type = $chart;
    }
    
    /**
     * MorrisCharts::setConfig()
     * 
     * @param mixed $values
     * @return void
     */
    public function setConfig($values){}
    
    /**
     * MorrisCharts::setLegend()
     * 
     * @param bool $legend
     * @return void
     */
    public function setLegend($legend=false){
        if(!$legend)
            $this->makeLegend = false;
        else{
            if(is_array($legend)){
                foreach($legend as $label=>$value)
                    $legendItemData .=$this->generateLineLegened($label,$value);
                $this->legendItem = $legendItemData;
            }else
                $this->legendItem = $legend;
        }
        return $this;
    }
    
    /**
     * Return the HTML markup for Javascript code
     *
     * @brief Brief
     * @return string
     */
    public function getCode(){}
    
    /**
     * MorrisCharts::prepareData()
     * 
     * @return void
     */
    public function prepareData()
    {   
        $ykeys          = $this->getYkeys();
        $this->ykeys    = $ykeys;
        $this->labels   = $ykeys;
        $this->xkey     = $this->_categoryField;
    }
    
    /**
     * MorrisCharts::BuildLegend()
     * 
     * @return
     */
    public function BuildLegend(){
        if(!$this->makeLegend)
            return false;
        return (!is_null($this->legendItem)) ? 'var legendItem = "'.$this->legendItem.'";' : 'var legendItem = "";
        '.$this->getElement().'.options.labels.forEach(function(label, i){
            legendItem += "<li class=\"legenditem\"><i style=\"background-color:"+'.$this->getElement().'.options.lineColors[i]+"\">&nbsp;</i>"+label+"</li>";
        });';
    }
    
    /**
     * MorrisCharts::generateLineLegened()
     * 
     */
    public function generateLineLegened($label='',$value=''){
        return '<li class=\"legenditem\"><i style=\"background-color:\"'.$label.'\">&nbsp;</i>'.$label.' : '.$value.'</li>';
    }
    /**
     * MorrisCharts::getJavaCode()
     * 
     * @return
     */
    public function getJavaCode()
    {
        $legend = $this->BuildLegend();
        $jsCode = 'Morris.' . $this->__chart_type . '(' . $this->toJSON() . ');';
        if($legend)
            $jsCode .= $legend.'$("#'.$this->getElement().'").append("<div class=\"'.strtolower($this->__chart_type).' morrisLegend\">"+legendItem+"</div>");';
        return $jsCode;
    }
}

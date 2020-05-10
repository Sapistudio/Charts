<?php

namespace SapiStudio\Charts\Morris;
use SapiStudio\Charts\Handler;
/** Morris Charts common model*/
abstract class MorrisCharts extends Handler
{
    /** Array of color values to use for the goal line colors. If you list fewer colors here than you have lines in goals, then the values will be cycled.*/
    public $goalLineColors      = ['#666633', '#cc6666', '#cc6666', '#663333'];
    /** Array of color values to use for the event line colors. If you list fewer colors here than you have lines in events, then the values will be cycled.*/
    public $eventLineColors     = ['#005a04', '#ccffbb', '#3a5f0b', '#005502'];
    /**  Array containing colors for the series bars. */
    public $barColors           = ["#2F6497","#E8743B","#E32B62","#188490","#626e82","#dd8d56","#ff7588"];
    /** An array of strings containing HTML-style hex colors for each of the donut segments. Note: if there are fewer*/
    public $colors              = ["#03778e","#ff7d4d","#ff4558","#2bd7a3","#626e82","#dd8d56","#ff7588"];
    /** Array containing colors for the series lines/points.*/
    public $lineColors          = ["#2F6497","#E8743B","#188490","#ED4A7B","#626e82","#dd8d56","#ff7588"];
    
    /** A list of x-values to draw as vertical 'event' lines on the chart. */
    public $events              = [];
    /** A list of y-values to draw as horizontal 'goal' lines on the chart.*/
    public $goals               = [];
    /** A string containing the name of the attribute that contains date (X) values. */
    public $xkey                = [];
    /** A list of strings containing names of attributes that contain Y values (one for each series of data to be plotted).*/
    public $ykeys               = [];
    /** A list of strings containing labels for the data series to be plotted (corresponding to the values in the ykeys option).*/
    public $labels              = [];
    
    /** Max. bound for Y-values. Alternatively, set this to 'auto' to compute automatically*/
    public $ymax                = 'auto';
    /** Min. bound for Y-values. Alternatively, set this to 'auto' to compute automatically*/
    public $ymin                = 0;
    /** Set to false to always show a hover legend,Set to true or 'auto' to only show the hover legend when the mouse cursor is over the chart. Set to 'always' to never show a hover legend.*/
    public $hideHover           = 'auto';
    /** Provide a function on this option to generate custom hover legends. The function will be called with the index of the row under the hover legend*/
    public $hoverCallback       = '';
    /** Set to false to disable drawing the x and y axes.*/
    public $axes                = true;
    /** Set to false to disable drawing the horizontal grid lines. */
    public $grid                = true;
    /** Set the color of the axis labels (default: #888).*/
    public $gridTextColor       = '#333';
    /** Set the point size of the axis labels (default: 12).*/
    public $gridTextSize        = '12';
    /** Set the font family of the axis labels (default: sans-serif). */
    public $gridTextFamily      = 'sans-serif';
    /** Set the font weight of the axis labels (default: normal).*/
    public $gridTextWeight      = 'normal';
    /** Set to true to enable automatic resizing when the containing element resizes. (default: false).*/
    public $resize              = true;
    /** Width, in pixels, of the event lines. */
    public $eventStrokeWidth    = 1;
    /** Width, in pixels, of the goal lines. */
    public $goalStrokeWidth     = 1;
    /** Set to false to skip time/date parsing for X values, instead treating them as an equally-spaced series.*/
    public $parseTime           = true;
    /** Set to a string value (eg: '%') to add a label suffix all y-labels.*/
    public $postUnits           = '';
    /** Set to a string value (eg: '$') to add a label prefix all y-labels.*/
    public $preUnits            = '';
    /** Angle of x label*/
    public $xLabelAngle         = 0;
    
    /** Area charts variables*/
    /** Change the opacity of the area fill colour. Accepts values between 0.0 (for completely transparent) and 1.0 (for completely opaque).*/
    public $fillOpacity         = 'auto';
    /** Set to true to overlay the areas on top of each other instead of stacking them.*/
    public $behaveLikeLine      = true;
    
    /** output legend.*/
    public $makeLegend          = false;
    /** legend items.*/
    public $legendItem          = null;
    public $rangeFilterSlider   = false;
    
    public $rangeSelect         = null;
    public $rangeSelectColor    = '#eef';
    public $padding             = 25;
    public $numLines            = 5;
    
    
    /** MorrisCharts::__construct()*/
    public function __construct($element_id = null, $chart = MorrisChartTypes::LINE)
    {
        $this->element      = $element_id;
        $this->__chart_type = $chart;
    }
    
    /** MorrisCharts::setConfig()*/
    public function setConfig($values){}
    
    /** MorrisCharts::displayRangeSlider()*/
    public function displayRangeSlider(){
        $this->rangeFilterSlider = true;
        return $this;
    }
    
    /** MorrisCharts::displayLegend()*/
    public function displayLegend($legend = []){
        $this->makeLegend = true;
        $this->legendItem = ($legend && is_array($legend)) ? $legend : false;
        return $this;
    }
    
    /** MorrisCharts::hideLegend()*/
    public function hideLegend(){
        $this->makeLegend = false;
        return $this;
    }
    
    /** MorrisCharts::prepareData()*/
    public function prepareData()
    {   
        $ykeys          = $this->getYkeys();
        $this->ykeys    = $ykeys;
        $this->labels   = $ykeys;
        $this->xkey     = (is_array($this->_categoryField)) ? $this->_categoryField[0] : $this->_categoryField;
    }
    
    /** MorrisCharts::getJavaCode()*/
    public function getJavaCode()
    {
        return 'Morris.' . $this->__chart_type . '(' . $this->toJSON() . ');';
    }
}
<?php
namespace SapiStudio\Charts\Morris;
/** Morris Line Charts*/
class MorrisLineCharts extends MorrisCharts {
    /** Width of the series lines, in pixels.*/
    public $lineWidth           = 3;
    /** Diameter of the series points, in pixels.*/
    public $pointSize           = 4;
    /** Colors for the series points. By default uses the same values as lineColors*/
    public $pointFillColors     = [];
    /** Colors for the outlines of the series points. (#ffffff by default). */
    public $pointStrokeColors   = [];
    /** Set to false to disable line smoothing.*/
    public $smooth              = true;
    /** A function that accepts millisecond timestamps and formats them for display as chart labels. */
    public $dateFormat          = '';
    /** Sets the x axis labelling interval. By default the interval will be automatically computed.
     *  "decade" * "year" * "month" * "day" * "hour" * "30min" * "15min" * "10min" * "5min" * "minute" * "30sec" * "15sec" * "10sec" * "5sec" * "second" */
    public $xLabels             = [];
    /** A function that accepts Date objects and formats them for display as x-axis labels. Overrides the default formatter chosen by the automatic labeller or the xLabels option.*/
    public $xLabelFormat        = '';
    /** A function that accepts y-values and formats them for display as y-axis labels. eg: function (y) { return y.toString() + 'km'; }*/
    public $yLabelFormat        = '';
    /** When set to false (the default), all null and undefined values in a data series will be ignored and lines will be drawn spanning them. When set to true, null values will break the line and undefined values will be spanned.*/
    public $continuousLine      = false;
}
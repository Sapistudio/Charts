<?php

namespace SapiStudio\Charts\Morris;
/** Morris Area Charts*/
class MorrisAreaCharts extends MorrisLineCharts
{
    /** Width of the series lines, in pixels.*/
    public $lineWidth = 1;
    /** Diameter of the series points, in pixels.*/
    public $pointSize = 0;
    
    /** Create an instance of MorrisAreaCharts class */
    public function __construct($element_id)
    {
        parent::__construct($element_id, MorrisChartTypes::AREA);
    }
}
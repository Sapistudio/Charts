<?php
namespace SapiStudio\Charts\Morris;
/** Morris Bar Charts*/
class MorrisBarCharts extends MorrisCharts {

  public $barSizeRatio  = 0.75;
  public $barGap        = 3;
  public $barOpacity    = 1.0;
  public $barRadius     = [0, 0, 0, 0 ];
  public $xLabelMargin  = 50;
  /** Set to true to draw bars stacked vertically. */
  public $stacked       = true;

  /** Create an instance of MorrisBarCharts class*/
  public function __construct($element_id)
  {
    parent::__construct($element_id, MorrisChartTypes::BAR);
  }
}
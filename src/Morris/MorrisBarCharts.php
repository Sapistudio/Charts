<?php
namespace SapiStudio\Charts\Morris;
/**
 * Morris Bar Charts
 *
 * @class           MorrisBarCharts
 * @author          =undo= <info@wpxtre.me>
 * @copyright       Copyright (C) 2012-2014 wpXtreme Inc. All Rights Reserved.
 * @date            2014-04-01
 * @version         1.0.0
 *
 */
class MorrisBarCharts extends MorrisCharts {

  public $barSizeRatio  = 0.75;
  public $barGap        = 3;
  public $barOpacity    = 1.0;
  public $barRadius     = [0, 0, 0, 0 ];
  public $xLabelMargin  = 50;

  /**
   * Array containing colors for the series bars.
   *
   * @brief Bars colors
   *
   * @var array $barColors
   */
  public $barColors = ["#00a5a8","#ff7d4d","#ff4558","#2bd7a3","#626e82","#dd8d56","#ff7588"];

  /**
   * Set to true to draw bars stacked vertically.
   *
   * @brief Stacked
   *
   * @var bool $stacked
   */
  public $stacked = true;

  /**
   * Create an instance of MorrisBarCharts class
   *
   * @brief Construct
   *
   * @param string $element_id The element id
   *
   * @return MorrisBarCharts
   */
  public function __construct( $element_id )
  {
    parent::__construct( $element_id, MorrisChartTypes::BAR );
  }
  
  /**
   * MorrisBarCharts::BuildLegend()
   * 
   * @return
   */
  public function BuildLegend(){
        return 'var legendItem = "";
        '.$this->getElement().'.options.labels.forEach(function(label, i){
            legendItem += "<span class=\"legenditem\"><i style=\"background-color:"+'.$this->getElement().'.options.barColors[i]+"\">&nbsp;</i>"+label+"</span>";
        });';
    }
}
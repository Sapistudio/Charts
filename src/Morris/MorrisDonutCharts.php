<?php
namespace SapiStudio\Charts\Morris;
/**
 * Morris Donut Charts
 *
 * @class           MorrisAreaCharts
 * @author          =undo= <info@wpxtre.me>
 * @copyright       Copyright (C) 2012-2014 wpXtreme Inc. All Rights Reserved.
 * @date            2014-04-01
 * @version         1.0.0
 *
 */
class MorrisDonutCharts extends MorrisCharts  {

  /**
   * An array of strings containing HTML-style hex colors for each of the donut segments. Note: if there are fewer
   * colors than segments, the colors will cycle back to the start of the array when exhausted.
   *
   * @brief Colors
   *
   * @var array $colors
   */
  public $colors = ["#00a5a8","#ff7d4d","#ff4558","#2bd7a3","#626e82","#dd8d56","#ff7588"];

  /**
   * A function that will translate a y-value into a label for the centre of the donut.
   *
   * eg: currency function (y, data) { return '$' + y }
   *
   * Note: if required, the method is also passed an optional second argument, which is the complete data row for the given value.
   *
   * @brief Formatter
   *
   * @var string $formatter
   */
  public $formatter = '';

  public $backgroundColor   = '#FFFFFF';
  public $labelColor        = '#000000';

  /**
   * Create an instance of MorrisDonutCharts class
   *
   * @brief Construct
   *
   * @param string $element_id The element id
   *
   * @return MorrisDonutCharts
   */
  public function __construct( $element_id )
  {
    parent::__construct( $element_id, MorrisChartTypes::DONUT );
  }
  
  /**
   * MorrisDonutCharts::BuildLegend()
   * 
   * @return
   */
  public function BuildLegend(){
        return 'var legendItem = "";
        '.$this->getElement().'.options.data.forEach(function(label, i){
            legendItem += "<li class=\"legenditem\"><i style=\"background-color:"+'.$this->getElement().'.options.colors[i]+"\">&nbsp;</i>"+label["label"]+"</li>";
        });';
    }
}
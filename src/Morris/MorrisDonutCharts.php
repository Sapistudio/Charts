<?php
namespace SapiStudio\Charts\Morris;
/** Morris Donut Charts*/
class MorrisDonutCharts extends MorrisCharts  {

  /** A function that will translate a y-value into a label for the centre of the donut.*/
  public $formatter         = '';
  public $backgroundColor   = '#FFFFFF';
  public $labelColor        = '#000000';

  /** Create an instance of MorrisDonutCharts class*/
  public function __construct($element_id)
  {
    parent::__construct($element_id, MorrisChartTypes::DONUT);
  }
  
  /** MorrisDonutCharts::BuildLegend()*/
  public function BuildLegend(){
      if(!$this->makeLegend)
        return false;
      return 'var legendItem = "";
        '.$this->getElement().'.options.data.forEach(function(label, i){
            legendItem += "<li class=\"legenditem\"><i style=\"background-color:"+'.$this->getElement().'.options.colors[i]+"\">&nbsp;</i>"+label["label"]+"</li>";
        });';
    }
}
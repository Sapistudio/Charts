# Charts -  Generating charts with morris and amchart
adaptation after:
  https://github.com/fusonic/amcharts-php
  https://github.com/gfazioli/morris-php
  https://github.com/pierresh/morris.js

You can now have legend display(with filters) and range slider filter
```php
use SapiStudio\Charts\Morris\MorrisLineCharts;

(new MorrisLineCharts())->setElement($element)->setSettings($settings)->setXkey('date')->resize(true)->displayLegend()->displayRangeSlider()->setData($jsondata)->drawJsChart();
```

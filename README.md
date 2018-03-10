# Charts -  Generating charts with morris and amchart
adaptation after:
  https://github.com/fusonic/amcharts-php
  https://github.com/gfazioli/morris-php

```php
use SapiStudio\Charts\Morris\MorrisLineCharts;

(new MorrisLineCharts())->setElement($element)->setSettings($settings)->setXkey('date')->resize(true)->setData($jsondata)->toRemote();
```

# parse-url
### *PHP lightweight library to parse non-standard urls and standard urls too!*

## Actual list of conversion
*Comparison with parse_url()* ->
[Conversions](../master/Conversions.md)

# Basic usage
*Full usage you will find here -> [Wiki](https://github.com/pjpawel/parse-url/wiki)*
```php
<?php

use pjpawel\Url;
use pjpawel\Exceptions\ParseException;

$url = "www.malformed.url.com";

try {
    $parsedUrl = Url::parse($url);
    var_dump($parsedUrl);
} catch (ParseException $e) {
    echo "Exception $e->getmessage()";
}
```

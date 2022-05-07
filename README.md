# parse-url
### *PHP lightweight library to parse non-standard urls and standard urls too!*

[![Latest Version on Packagist](https://img.shields.io/packagist/v/pjpawel/parse-url.svg?style=flat-square)](https://packagist.org/packages/pjpawel/parse-url)
<!--[![Tests](https://github.com/pjpawel/parse-url)](https://github.com/pjpawel/parse-url)-->
<!--[![Total Downloads](https://img.shields.io/packagist/dt/spatie/url.svg?style=flat-square)](https://packagist.org/packages/spatie/url)-->

## Installation
```
composer require pjpawel/parse-url
```

## Actual list of conversion
*Comparison with parse_url()* ->
[Conversions](../master/Conversions.md)

# Basic usage
*Full usage you will find here -> [Wiki](https://github.com/pjpawel/parse-url/wiki)*
```php
<?php

use pjpawel\UrlParser;

$url = "www.malformed_url.com";

$parsedUrl = UrlParser::parse($url);
var_dump($parsedUrl);
/*
array(1) {
  ["host"]=>
  string(21) "www.malformed_url.com"
}
 */

echo UrlParser::createUrl($parsedUrl)
/*
www.malformed_url.com
 */
```
Output array of `URL::parse()` is the same as [parse_url()](https://www.php.net/manual/en/function.parse-url.php)

<?php

namespace tests;

use PHPUnit\Framework\TestCase;
use pjpawel\Exceptions\ParseException;
use pjpawel\Url;

class UrlTest extends TestCase
{
    /*
     * Urls with schema
     */

    public function testParseUrlWithScheme()
    {
        $url = Url::parse('http://www.abc.pl/');
        $this->assertEquals('www.abc.pl', $url['host']);
    }

    public function testParseUrlWithSchemeHTTPS()
    {
        $url = Url::parse('https://www.abc.pl/');
        $this->assertEquals('www.abc.pl', $url['host']);
    }
    public function testParseUrlWithSchemeBackSlashes()
    {
        $url = Url::parse('//www.abc.pl/');
        $this->assertEquals('www.abc.pl', $url['host']);
    }

    /*
     * File URI
     */

    public function testParseFile3BackSlashes()
    {
        $url = Url::parse('file:///var/log/');
        $this->assertEquals('/var/log/', $url['path']);
    }

    public function testParseFile2BackSlashes()
    {
        $url = Url::parse('file://var/log/');
        $this->assertEquals('/var/log/', $url['path']);
    }

    public function testParseFile1BackSlashes()
    {
        $url = Url::parse('file:/var/log/');
        $this->assertEquals('/var/log/', $url['path']);
    }

    public function testParseFile0BackSlashes()
    {
        $url = Url::parse('file:var/log/');
        $this->assertEquals('/var/log/', $url['path']);
    }

    /*
     * Other urls
     */

    public function testParseUrlOnlyWWW()
    {
        $this->expectException('pjpawel\Exceptions\ParseException');
        Url::parse('');
    }
}
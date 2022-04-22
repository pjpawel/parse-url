<?php

namespace tests;

use PHPUnit\Framework\TestCase;
use pjpawel\Exceptions\ParseException;
use pjpawel\UrlParser;

class UrlTest extends TestCase
{
    /*
     * Urls with schema
     */

    public function testParseUrlWithScheme()
    {
        $url = UrlParser::parse('http://www.abc.pl/');
        $this->assertEquals('www.abc.pl', $url['host']);
    }

    public function testParseUrlWithSchemeHTTPS()
    {
        $url = UrlParser::parse('https://www.abc.pl/');
        $this->assertEquals('www.abc.pl', $url['host']);
    }
    public function testParseUrlWithSchemeBackSlashes()
    {
        $url = UrlParser::parse('//www.abc.pl/');
        $this->assertEquals('www.abc.pl', $url['host']);
    }

    /*
     * File URI
     */

    public function testParseFile3BackSlashes()
    {
        $url = UrlParser::parse('file:///var/log/');
        $this->assertEquals('/var/log/', $url['path']);
    }

    public function testParseFile2BackSlashes()
    {
        $url = UrlParser::parse('file://var/log/');
        $this->assertEquals('/var/log/', $url['path']);
    }

    public function testParseFile1BackSlashes()
    {
        $url = UrlParser::parse('file:/var/log/');
        $this->assertEquals('/var/log/', $url['path']);
    }

    public function testParseFile0BackSlashes()
    {
        $url = UrlParser::parse('file:var/log/');
        $this->assertEquals('/var/log/', $url['path']);
    }

    /*
     * Other urls
     */

    public function testParseUrlOnlyWWW()
    {
        $url = UrlParser::parse('https://www.abc.pl/');
        $this->assertEquals('www.abc.pl', $url['host']);
    }
}
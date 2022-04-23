<?php

namespace tests;

use PHPUnit\Framework\TestCase;
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
        $url = UrlParser::parse('www.abc.com');
        $this->assertEquals('www.abc.com', $url['host']);
    }

    public function testParseUrlWithoutWWW()
    {
        $url = UrlParser::parse('abc.com');
        $this->assertEquals('abc.com', $url['host']);
    }

    /*
     * Unhandled cases
     */

    public function testParseUrlUnhandledCases()
    {
        $url = UrlParser::parse('.com');
        $this->assertEquals(parse_url('.com'), $url);
    }
}
<?php

namespace Test;

use PHPUnit\Framework\TestCase;
use pjpawel\UrlParser;

class UrlParserTest extends TestCase
{
    /**
     * parse()
     */
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

    public function testParseUrlOnlyPath()
    {
        $url = UrlParser::parse('/only-path/to/article');
        $this->assertEquals('/only-path/to/article', $url['path']);
    }

    /*
     * Unhandled cases
     */

    public function testParseUrlUnhandledCases()
    {
        $url = UrlParser::parse('.com');
        $this->assertEquals(parse_url('.com'), $url);
    }

    /**
     * createUrl()
     */

    public function testCreateUrlExampleFromManual()
    {
        $url = 'http://username:password@hostname:9090/path?arg=value#anchor';
        $parsedUrl = UrlParser::parse($url);
        $createdUrl = UrlParser::createUrl($parsedUrl);
        $this->assertEquals($createdUrl, $url);
    }

    public function testCreateUrlExampleWithoutPassword()
    {
        $url = 'http://username:@hostname:9090/path?arg=value#anchor';
        $parsedUrl = UrlParser::parse($url);
        $createdUrl = UrlParser::createUrl($parsedUrl);
        $this->assertEquals($createdUrl, $url);
    }

    public function testCreateUrlExampleWithoutPassword2()
    {
        $url = 'http://parser:@php.net/path';
        $parsedUrl = [
            "scheme" => "http",
            "host" => "php.net",
            //"port" => "",
            "user" => "parser",
            //"pass" => "",
            "path" => "/path",
            //"query" => "",
            //"fragment" => "",
        ];
        $createdUrl = UrlParser::createUrl($parsedUrl);
        $this->assertEquals($createdUrl, $url);
    }

    public function testCreateFileUrlExample()
    {
        $url = 'file:///var/log/';
        $parsedUrl = [
            "scheme" => "file",
            "path" => "/var/log/",
        ];
        $createdUrl = UrlParser::createUrl($parsedUrl);
        $this->assertEquals($createdUrl, $url);
    }

    public function testCreateFileUrlExampleMakeRightUrl()
    {
        $url = 'file:/var/log/';
        $urlRight = 'file:///var/log/';
        $parsedUrl = UrlParser::parse($url);
        $createdUrl = UrlParser::createUrl($parsedUrl);
        $this->assertEquals($createdUrl, $urlRight);
    }

    public function testCreateUrlOnlyWWW()
    {
        $url = 'www.malformed_url.com';
        $urlRight = '//www.malformed_url.com';
        $parsedUrl = UrlParser::parse($url);
        $createdUrl = UrlParser::createUrl($parsedUrl);
        $this->assertEquals($createdUrl, $url);
    }

    /*
     * Test compare domains
     */
    public function testSameDomains()
    {
        $url1 = "www.abc.com/about/";
        $url2 = "www.abc.com/company";
        $same = UrlParser::sameDomain($url1, $url2);
        $this->assertTrue($same);
    }

    public function testSameDomainsFalse()
    {
        $url1 = "www.abc.com/about/";
        $url2 = "www.abcd.com/company";
        $same = UrlParser::sameDomain($url1, $url2);
        $this->assertFalse($same);
    }

    /*
     * Test compare urls
     */
    public function testSameUrlsQuery()
    {
        $url1 = "www.abc.com/about/";
        $url2 = "www.abc.com/about/?";
        $same = UrlParser::sameUrl($url1, $url2);
        $this->assertTrue($same);
    }

    public function testSameUrlsAnchor()
    {
        $url1 = "www.abc.com/about/";
        $url2 = "www.abc.com/about/#";
        $same = UrlParser::sameUrl($url1, $url2);
        $this->assertTrue($same);
    }

    public function testSameUrlsQueryAndAnchor()
    {
        $url1 = "www.abc.com/about/";
        $url2 = "www.abc.com/about/?#";
        $same = UrlParser::sameUrl($url1, $url2);
        $this->assertTrue($same);
    }
}
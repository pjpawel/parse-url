<?php

namespace pjpawel;

use pjpawel\Exceptions\ParseException;

class UrlParser
{

    /**
     * Url parser that handles non-standard urls in which parser_url() gives wrong result
     * Where needed url is changed and parse by parse_url() function
     * 
     * @param string $url
     * @param int $component default = -1
     * @return array
     * @throws ParseException
     */
    public static function parse(string $url, int $component = -1): array
    {
        if (preg_match('/^http(s)?:\/\/|^\/\/|^\/|^mailto:|^tel:/', $url, )) {
            return parse_url($url, $component);
        } elseif (preg_match('/^file/', $url)) {
            return self::parseFile($url, $component);
        } elseif (preg_match('/^(\S)+?\./', $url)) {
            return parse_url("//" . $url, $component);
        } else {
            $parse = parse_url($url, $component);
            if ($parse === false) {
                throw new ParseException('Incorrect url');
            }
            return $parse;
        }
    }

    /**
     * For given url (file uri) corrects url if needed
     * and return parse_url() array
     * 
     * @param string $url
     * @param int $component
     * @return array
     * @throws ParseException
     */
    private static function parseFile(string $url, int $component): array
    {
        if (preg_match('/^file:\/\/\//', $url)) {
            return parse_url($url, $component);
        } elseif (preg_match('/^file:\/\//', $url)) {
            return parse_url(self::correctFile($url), $component);
        } elseif (preg_match('/^file:\//', $url)) {
            return parse_url(self::correctFile($url), $component);
        } elseif (preg_match('/^file:/', $url)) {
            return parse_url(self::correctFile($url), $component);
        } else {
            throw new ParseException('Incorrect file uri: missing :///');
        }
    }

    /**
     * Change file://, file:/ or file: to file:///
     * at the beginning of url
     * 
     * @param string $url
     * @return string
     */
    private static function correctFile(string $url): string
    {;
        return preg_replace('/^file:\/\/|^file:\/|^file:/', "file:///", $url, 1);
    }

}
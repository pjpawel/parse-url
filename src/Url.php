<?php

namespace pjpawel;

use pjpawel\Exceptions\ParseException;

class Url
{

    /**
     * @param string $url
     * @param int $component default = -1
     * @return array
     * @throws ParseException
     */
    public static function parse(string $url, int $component = -1): array
    {
        if (preg_match('/^http(s)?:\/\/|^\/\//', $url, )) {
            return parse_url($url, $component);
        } elseif (preg_match('/^file/', $url)) {
            return self::parseFile($url, $component);
        } else {
            /*
             * mailto:
             * tel:
             * /cos/tam
             *
             */
            throw new ParseException('Incorrect url');
        }
    }

    /**
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
            return parse_url(self::correctFile($url, 1), $component);
        } elseif (preg_match('/^file:\//', $url)) {
            return parse_url(self::correctFile($url, 2), $component);
        } elseif (preg_match('/^file:/', $url)) {
            return parse_url(self::correctFile($url, 3), $component);
        } else {
            throw new ParseException('Incorrect file uri');
        }
    }

    /**
     * @param string $url
     * @param int $slashNumber
     * @return string
     */
    private static function correctFile(string $url, int $slashNumber): string
    {
        $scheme = "file:";
        $scheme .= str_repeat("/", $slashNumber);
        return preg_replace('/^file:\/\/|^file:\/|^file:/', $scheme, $url, 1);
    }
}
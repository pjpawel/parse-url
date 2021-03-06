<?php

namespace pjpawel;

class UrlParser
{

    /**
     * Url parser that handles non-standard urls in which parser_url() gives wrong result
     * Where needed url is changed and parse by parse_url() function
     *
     * @param string $url
     * @param int $component default = -1
     * @return array|false
     */
    public static function parse(string $url, int $component = -1)
    {
        if (preg_match('/^http(s)?:\/\/|^\/\/|^\/|^mailto:|^tel:/', $url)) {
            return parse_url($url, $component);
        } elseif (str_starts_with($url, "file")) {
            return self::parseFile($url, $component);
        } elseif (preg_match('/^(\S)+?\./', $url)) {
            return parse_url("//" . $url, $component);
        } else {
            return parse_url($url, $component);
        }
    }

    /**
     * For given url (file uri) corrects url if needed
     * and return parse_url() array
     *
     * @param string $url
     * @param int $component
     * @return array|false
     */
    private static function parseFile(string $url, int $component)
    {
        if (str_starts_with($url, "file:///")) {
            return parse_url($url, $component);
        } elseif (preg_match('/^file:\/\/|^file:\/|^file:/', $url)) {
            return parse_url(self::correctFile($url), $component);
        } else {
            return false;
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
    {
        return preg_replace('/^file:\/\/|^file:\/|^file:/', "file:///", $url, 1);
    }

    /**
     * Gives back the url from parse_url() or UrlParser::parse()
     *
     * @param array $parsedUrl
     * @return string
     */
    public static function createUrl(array $parsedUrl): string
    {
        $url = "";
        $user = false;
        if (isset($parsedUrl["scheme"])) {
            if (str_starts_with($parsedUrl["scheme"], "http")) {
                $url .= $parsedUrl["scheme"] . "://";
            } elseif (str_starts_with($parsedUrl["scheme"], "file")) {
                $url .= (isset($parsedUrl['path'])) ? "file://" : "file:///";
            } else {
                $url .= $parsedUrl["scheme"] . ":";
            }
        }
        if (isset($parsedUrl["user"])) {
            $user = true;
            $password = $parsedUrl["pass"] ?? "";
            $url .= $parsedUrl["user"] . ":" . $password;
        }
        if (isset($parsedUrl["host"])) {
            if ($user) {
                $url .= "@";
            }
            $url .= $parsedUrl["host"];
        }
        if (isset($parsedUrl["port"])) {
            $url .= ":" . $parsedUrl["port"];
        }
        if (isset($parsedUrl["path"])) {
            $url .= $parsedUrl["path"];
        }
        if (isset($parsedUrl["query"])) {
            $url .= "?" . $parsedUrl["query"];
        }
        if (isset($parsedUrl["fragment"])) {
            $url .= "#" . $parsedUrl["fragment"];
        }
        return $url;
    }

    /**
     * Check if 2 urls have the same domain
     *
     * @param string $url1
     * @param string $url2
     * @return bool
     */
    public static function sameDomain(string $url1, string $url2): bool
    {
        return (self::parse($url1, PHP_URL_HOST) == self::parse($url2, PHP_URL_HOST));
    }

    public static function sameUrl(string $url1, string $url2): bool
    {
        return self::createUrl(array_filter(self::parse($url1))) == self::createUrl(array_filter(self::parse($url2)));
    }
}
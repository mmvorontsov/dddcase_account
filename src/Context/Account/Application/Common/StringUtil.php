<?php

namespace App\Context\Account\Application\Common;

use App\Context\Account\Domain\Common\Util\StringUtil as DomainStringUtil;

use function array_merge;
use function http_build_query;
use function parse_str;
use function preg_match;

/**
 * Class StringUtil
 * @package App\Context\Account\Application\Common
 */
final class StringUtil extends DomainStringUtil
{
    /**
     * @param string $url
     * @param array $additionalQueryParams
     * @return string
     */
    public static function enrichUrlQuery(string $url, array $additionalQueryParams): string
    {
        preg_match("/^([^?#]+)(\?([^#]*))?(#.*)?$/", $url, $matches);

        $base = $matches[1] ?? '';
        $query = $matches[3] ?? '';
        $fragment = $matches[4] ?? '';

        if ($query || $additionalQueryParams) {
            $parsedQuery = [];
            parse_str($query, $parsedQuery);
            $query = '?' . http_build_query(array_merge($parsedQuery, $additionalQueryParams));
        }

        return "$base$query$fragment";
    }
}

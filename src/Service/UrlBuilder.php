<?php

namespace Framework\Service;

/**
 * Class UrlBuilder
 * @package Framework\Service
 */
class UrlBuilder
{

    /**
     * Build a query parameter string
     *
     * @param array $queryParameters
     * @return string
     */
    public function getUrl(array $queryParameters): string
    {
        $resultString = '?';
        foreach ($queryParameters as $name => $value) {
            if ($value !== '') {
                $resultString .= "$name=$value&";
            }
        }

        return substr($resultString, 0, -1);
    }
}
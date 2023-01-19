<?php

interface HttpClient
{
    /**
     * @param string $url
     * @param array  $params
     * @return string|null Response as text
     */
    public function get(string $url, array $params = []): ?string;
}
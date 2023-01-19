<?php

class CurlHttpClient implements HttpClient
{
    public function get(string $url, array $params = []): ?string
    {
        if ($params) {
            if (str_contains($url, '?')) {
                $url .= '&';
            } else {
                $url .= '?';
            }
            $url .= http_build_query($params);
        }

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result ?: null;
    }
}
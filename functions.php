<?php

require_once __DIR__ . '/parameters.php';

/**
 * Get information about affiliate link. Access granted
 * only with valid access key.
 *
 * @param  string  $pid
 * @return array
 * @author Mykola Martynov
 **/
function getAffiliateLink($pid)
{
    global $access_key;
    
    $api_url = 'http://' . AFFILIATE_DOMAIN . '/api/links/get.php';
    $data = [
        'access_key' => $access_key,
        'target_id' => $pid,
    ];

    $info = getAffiliateResult($api_url, $data);

    return $info;
}

/**
 * Return result from affiliate api
 *
 * @param  string  $url
 * @param  array   $data
 * @return array
 * @author Mykola Martynov
 **/
function getAffiliateResult($url, $data, $type = 'json')
{
    $content = http_build_query($data);

    $options = array(
        'http' => array(
            'method' => 'POST',
            'header' => implode(array(
                "Content-type: application/x-www-form-urlencoded\r\n",
                "Content-length: " . strlen($content) . "\r\n"
                )),
            'content' => $content
            )
        );
    $context = stream_context_create($options);

    $remote_file = fopen($url, 'r', false, $context);
    if ($remote_file == false) {
        return null;
    }

    $content = stream_get_contents($remote_file);
    fclose($remote_file);

    if ($type == 'json') {
        $content = json_decode($content, true);
    }

    return $content;
}

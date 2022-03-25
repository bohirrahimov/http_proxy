<?php
 $url = "https://news.ycombinator.com";
 $url.= $_SERVER['REQUEST_URI'];
 $_SERVER['HTTP_HOST'] = 'https://news.ycombinator.com/';
 
$result = get_proxy_site_page($url);
$headers = $result['header_size'] ;
$result['content'] = substr($result['content'],$headers );
$result["content"] = str_replace("news.css?U4Pc202vc5MEd4M0yfRK", "https://news.ycombinator.com/news.css?U4Pc202vc5MEd4M0yfRK", $result['content']);
$result["content"] = str_replace("hn.js?U4Pc202vc5MEd4M0yfRK", "https://news.ycombinator.com/hn.js?U4Pc202vc5MEd4M0yfRK", $result['content']);
$replacement = "<script type='text/javascript' src='index.js'></script>";
$start = strlen($result['content']) - 8;
echo substr_replace($result['content'], $replacement,$start, 0);
// echo $result["content"];


function get_proxy_site_page($url)
{
    $options = [
        CURLOPT_RETURNTRANSFER => true,     // return web page
        CURLOPT_HEADER         => true,     // return headers
        CURLOPT_FOLLOWLOCATION => true,     // follow redirects
        CURLOPT_ENCODING       => "",       // handle all encodings
        CURLOPT_AUTOREFERER    => true,     // set referer on redirect
        CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
        CURLOPT_TIMEOUT        => 120,      // timeout on response
        CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
    ];

    $ch = curl_init($url);
    curl_setopt_array($ch, $options);
    $remoteSite = curl_exec($ch);
    $header = curl_getinfo($ch);
    curl_close($ch);

    $header['content'] = $remoteSite;
    return $header;
}


<?php

$url = "https://news.ycombinator.com";
$url.= $_SERVER['REQUEST_URI'];
 
$result = get_proxy_site_page($url);
$headers = $result['header_size'] ;
$result['content'] = substr($result['content'],$headers );
$result["content"] = str_replace("https://news.ycombinator.com", "/", $result['content']);
$result["content"] = str_replace("news.css?U4Pc202vc5MEd4M0yfRK", "https://news.ycombinator.com/news.css?U4Pc202vc5MEd4M0yfRK", $result['content']);
$result["content"] = str_replace("hn.js?U4Pc202vc5MEd4M0yfRK", "https://news.ycombinator.com/hn.js?U4Pc202vc5MEd4M0yfRK", $result['content']);
$result["content"] = str_replace("<link rel=\"shortcut icon\" href=\"favicon.ico\">", "<link rel=\"shortcut icon\" href=\"https://news.ycombinator.com/favicon.ico\">", $result['content']);
$result["content"] = str_replace("<img src=\"y18.gif\" width=\"18\" height=\"18\" style=\"border:1px white solid;\">", "<img src=\"https://news.ycombinator.com/y18.gif\" width=\"18\" height=\"18\" style=\"border:1px white solid;\">", $result['content']);

$replacement = get_js();
$start = strlen($result['content']) - 8;
http_response_code($result['http_code']); 
echo substr_replace($result['content'], $replacement,$start, 0);


function get_proxy_site_page($url)
{
    $options = [
        CURLOPT_RETURNTRANSFER => true,     
        CURLOPT_HEADER         => true,     
        CURLOPT_FOLLOWLOCATION => true,     
        CURLOPT_ENCODING       => false,    
        CURLOPT_AUTOREFERER    => true,     
        CURLOPT_CONNECTTIMEOUT => 120,      
        CURLOPT_TIMEOUT        => 120,      
        CURLOPT_MAXREDIRS      => -1,   
            
    ];

    $ch = curl_init($url);
    curl_setopt_array($ch, $options);
    $mh = curl_multi_init();
    $remoteSite = curl_exec($ch);
    $header = curl_getinfo($ch);
    curl_close($ch);

    $header['content'] = $remoteSite;
    return $header;
};


function get_js(){
    $code = "
    <script type=\"text/javascript\">
    const tagnames = ['p','h1','h2','h3', 'h4', 'h5', 'h6','a', 'span'];
    let result = '';
    let list = [];
    let string = \"\";
    let newword = \"\";
    let elements = [];
    for(let i=0; i<tagnames.length; i++){
        elements = document.querySelectorAll(tagnames[i]);
        elements.forEach(el =>{
            let replacedWords = [];
            result = el.innerText;
            string = el.innerText;
            result = result.replaceAll(/[`~!@#$%^&*()_|+\-=?;:'\",.<>\{\}\[\]\\\/]/gi, ' ');
            // result = result.replaceAll(/[^\w ]\"-.'’/g, \" \");
            list = result.split(\" \");
        list.map(word => {
            if(word.length === 6){
                if(!replacedWords.includes(word)){
                    newword = word + \"™\";
                    el.innerText = el.innerText.replaceAll(word, newword);
                    replacedWords.push(word);
                }
                
            }
    
        });
            
        });
        }
    </script>";
    return $code;
}
<?php
    error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE ^ E_DEPRECATED); 
    session_start(); 
    $url = 'http://103.56.148.28:8100/ws/live2.php'; 
    
    function runWS($data, $type='json') { 
        global $url;

        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_POST, 1); 
        $headers = array(); 
        if ($type == 'xml') 
            $headers[] = 'Content-Type: application/xml'; 
        else 
            $headers[] = 'Content-Type: application/json'; 
            
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        if ($data) { 
            if ($type == 'xml') { 
                /* contoh xml: <?xml version="1.0"?><data><act>GetToken</act><username>agus</username><password>abcdef</password></data> */ 
                $data = stringXML($data); 
            } else { 
                /* contoh json: {"act":"GetToken","username":"agus","password":"abcdef"} */ 
                $data = json_encode($data); 
            } 
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data); 
        } 
        curl_setopt($ch, CURLOPT_URL, $url); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        $result = curl_exec($ch); 
        curl_close($ch); 
        return $result; 
    }
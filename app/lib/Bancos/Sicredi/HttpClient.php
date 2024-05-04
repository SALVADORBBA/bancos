<?php

class HttpClient {
    public static function sendRequest($url, $method, $data, $headers) {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => $headers,
        ));

        $response = curl_exec($curl);

        if ($response === false) {
            // Erro na solicitação cURL
            $error = curl_error($curl);
            curl_close($curl);
            return ["error" => $error];
        }

        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if ($httpCode >= 400) {
            // Erro HTTP
            return ["error" => "Erro HTTP {$httpCode}: $response"];
        }

        return json_decode($response, true);
    }
}

 
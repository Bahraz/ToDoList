<?php
namespace Bahraz\ToDoApp\Service;

//TODO: Probalby this is to delete, because it is not used in the project
class ApiService{
    
    private function fetchApi(string $url): ?array
    {
        $curlHandle = curl_init();
        curl_setopt($curlHandle, CURLOPT_URL, $url);
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curlHandle, CURLOPT_TIMEOUT, 5); // Set a timeout for the request

        $response = curl_exec($curlHandle);
        $httpCode = curl_getinfo($curlHandle, CURLINFO_HTTP_CODE);
        curl_close($curlHandle);

        if ($httpCode === 200 && $response !== false) {
            return json_decode($response, true);
        }
    return null;
    }
}
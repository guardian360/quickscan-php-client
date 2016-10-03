<?php

namespace Quickscan\Api;

use GuzzleHttp\Client as HttpClient;

/**
 * Quickscan API Client class
 * @author  Sjors van Dongen <s.vandongen@intermax.nl>
 * @version 1.3
 */
class Client
{
    /**
     * Http client class
     * @var GuzzleHttp\Client $httpClient
     */
    private $httpClient;

    /**
     * The authorization token
     * @var string $token
     */
    private $token;

    /**
     * Request headers
     * @var array
     */
    private $headers = [];

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->httpClient = new HttpClient(['base_uri' => 'https://quickscan.guardian360.nl/api/v1/', 'exceptions' => false]);
    }

    /**
     * Login and receive JWT token
     * @param  string $email
     * @param  string $password
     * @return string [JWT token]
     */
    public function login($email, $password)
    {
        $response = $this->httpClient->post('login', [
            'form_params' => [
                'email' => $email,
                'password' => base64_encode($password),
            ]
        ]);

        // If response is successful
        if ($response->getStatusCode() == 200) {
            $response = json_decode($response->getBody());
            $this->token = $response->data->token;
            $this->headers['Authorization'] = "Bearer $this->token";

            return true;
        }

        return $response->getBody()->getContents();
    }

    /**
     * Scan URL
     * @param  string $url
     * @return StdClass
     */
    public function scan($url)
    {
        $response = $this->httpClient->post('scan?url=' . $url, ['headers' => $this->headers]);

        // If response is successful
        if ($response->getStatusCode() == 200) {
            $response = json_decode($response->getBody());
            return $response->data;
        }

        return $response->getBody()->getContents();
    }

    /**
     * Send report
     * @param  string $url
     * @param  array  $contact
     * @return bool
     */
    public function sendReport($url, array $contact)
    {
        $response = $this->httpClient->post('scan/report', [
            'headers' => $this->headers,
            'form_params' => [
                'url'       => $url,
                'company'   => $contact['company'],
                'firstname' => $contact['firstname'],
                'surname'   => $contact['surname'],
                'email'     => $contact['email'],
            ]
        ]);

        if ($response->getStatusCode() == 200) {
            $response = json_decode($response->getBody());
            return $response->data;
        }

        return $response->getBody()->getContents();
    }
}

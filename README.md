# Guardian360 Quickscan PHP client
Quickscan API client written in PHP.

### Installation

Install the API client through [Composer](http://getcomposer.org) with the follow command:

    composer require guardian360/quickscan-php-client

The API client has a couple of requirements:

- >= PHP 5.5
- PHP cURL extensie
- GuzzleHttp library (automatically installed along with the Quickscan client)

### Usage

```php

<?php

require 'vendor/autoload.php';

// Initialize a new API client
$client = new Guardian360\Quickscan\Client;

// URL to scan
$url = 'http://example.com';

// Example contact. These four fields are mandatory
$contact = [
    'company'   => 'Acme',
    'firstname' => 'John',
    'surname'   => 'Doe',
    'email'     => 'johndoe@example.com',
];

// Login so we receive a JWT token. Password will be encoded
$client->login('test@example.nl', 'test');

// Always call the scan method before sending a report!
$result = $client->scan($url);

// Send a report to the contact
$result = $client->sendReport($url, $contact);

```
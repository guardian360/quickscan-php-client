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
$client = new Quickscan\Api\Client;

// URL to scan
$url = 'http://sjorsvandongen.com';

// Example contact. These four fields are mandatory
$contact = [
    'company'   => 'Intermax',
    'firstname' => 'Sjors',
    'surname'   => 'van Dongen',
    'email'     => 'sjors@intermax.nl',
];

// Login so we receive a JWT token. Password will be encoded
$client->login('test@example.nl', 'test');

// Always call the scan method before sending a report!
$result = $client->scan($url);

// Send a report to the contact
$result = $client->sendReport($url, $contact);

```
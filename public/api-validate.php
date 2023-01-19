<?php

require_once __DIR__ . '/../bootstrap.php';
$config = require __DIR__ . '/../config.php';

try {
    $address = new Address($_GET);
} catch (MissingFieldException $e) {
    $response = new JsonResponse([
        'success'  => false,
        'message' => $e->getMessage()
    ], JsonResponse::STATUS_INVALID_INPUT);
    $response->outputAndTerminate();
}

$client    = new CurlHttpClient;
$uspsApi   = new UspsApi($client, $config['USPS_USERNAME']);
$validator = new AddressValidator($uspsApi);

try {
    $normalized_address = $validator->validate($address);
    $response = new JsonResponse([
        'success'  => true,
        'normalized_address' => $normalized_address->toArray(),
    ]);
} catch (AddressVerificationError $e) {
    $response = new JsonResponse([
        'success'  => false,
        'message' => $e->getMessage(),
    ]);
}

$response->outputAndTerminate();

<?php
require 'vendor/autoload.php';
use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;
 
$bucketName = 'new-demo-bucket';
$IAM_KEY = 'AKIAIHEXYY5NUX7UDKIQ';
$IAM_SECRET = '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';
 
$client = S3Client::factory(
    array(
        'credentials' => array(
            'key' => $IAM_KEY,
            'secret' => $IAM_SECRET
        ),
        'version' => 'latest',
        'region'  => 'ap-south-1',
        'http'    => [         'verify' => false     ] 
    )
);
 
try {
    $result = $client->createBucket([
        'Bucket' => $bucketName, // REQUIRED
        
    ]);
    echo "Bucket created successfully.";
} catch (Aws\S3\Exception\S3Exception $e) {
    // output error message if fails
    echo $e->getMessage();
}
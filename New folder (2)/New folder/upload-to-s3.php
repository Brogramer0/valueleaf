<?php
require 'vendor/autoload.php';

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

// AWS Info
$bucketName = 'release-note-beta';
$IAM_KEY = 'AKIAIHEXYY5NUX7UDKIQ';
$IAM_SECRET = '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';
// Connect to AWS
try {
   
    $s3 = S3Client::factory(
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
} catch (Exception $e) {
   
    die("Error: " . $e->getMessage());
}
$keyName = basename($_FILES["fileToUpload"]['name']);
$pathInS3 = 'https://s3.ap-south-1.amazonaws.com/' . $bucketName . '/' . $keyName;
try {
    
    $file = $_FILES["fileToUpload"]['tmp_name'];
    $result = $s3->putObject([
        'Bucket' => $bucketName,
        'Key'    => $keyName,
        'Body'   => fopen($file, 'r')
    ]);

    // Print the URL to the object.
    echo $result['ObjectURL'] . "<br>" . PHP_EOL ;
    
} catch (S3Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}

echo 'Done';

?>


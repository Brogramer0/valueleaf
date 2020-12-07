<?php
require 'vendor/autoload.php';

use Aws\Ses\SesClient;
use Aws\S3\Exception\S3Exception;
// AWS Info
$bucketName = 'release-note-beta';
$IAM_KEY = 'AKIAIHEXYY5NUX7UDKIQ';
$IAM_SECRET = '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';
$recipient = $_POST['email'];
$name = $_POST['name'];
$phone = $_POST['phone'];

$html = '<h2>Hi</h2>' . $name . '<br> <p>Your Contact Number is:</p> ' . $phone . '<br> <p>Your E-mail is:</p> ' . $recipient . '<p>Thank you.</p>';
//inserting in database
$servername = "localhost";
$username = "root";
$password = "12345Tyuio";
$dbname = "myDB";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "INSERT INTO MyGuests (firstname, lastname, email)
VALUES ('$name', '$phone', '$recipient')";

if ($conn->query($sql) === TRUE) {
  $last_id = $conn->insert_id;
  echo "New record created successfully. Last inserted ID is: " . $last_id;
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

// Connect to AWS
try {
   
    $client = SesClient::factory(
        array(
            'credentials' => array(
                'key' => $IAM_KEY,
                'secret' => $IAM_SECRET
            ),
            'version' => 'latest',
            'region'  => 'ap-southeast-1',
            'http'    => [         'verify' => false     ] 
        )
    );
} catch (Exception $e) {
   
    die("Error: " . $e->getMessage());
}

try {
    
    $result = $client->sendEmail(array(
        // Source is required
        'Source' => 'support@whistle.mobi',
        // Destination is required
        'Destination' => array(
            'ToAddresses' => array($recipient),
            'CcAddresses' => array(),
            'BccAddresses' => array(),
        ),
        // Message is required
        'Message' => array(
            // Subject is required
            'Subject' => array(
                // Data is required
                'Data' => 'Test Mail',
                'Charset' => 'UTF-8',
            ),
            // Body is required
            'Body' => array(
                'Html' => array(
                    // Data is required
                    'Data' => $html,
                    'Charset' => 'UTF-8',
                ),
            ),
        ),
        //'ReplyToAddresses' => array(),
        //'ReturnPath' => 'string',
        //'SourceArn' => 'string',
        //'ReturnPathArn' => 'string',
    ));
    header("Location: ses_index.php?flag=Email sent ");
} catch (S3Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}
?>
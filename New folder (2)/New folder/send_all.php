<?php
require 'vendor/autoload.php';

use Aws\Ses\SesClient;
use Aws\S3\Exception\S3Exception;
// AWS Info
$bucketName = 'release-note-beta';
$IAM_KEY = 'AKIAIHEXYY5NUX7UDKIQ';
$IAM_SECRET = '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';


$html = '<h2>Hi</h2><br> <p> <p>Thank you.</p>';

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

//getting data from database
$sql1 = "SELECT id, firstname, email FROM MyGuests";
$result1 = $conn->query($sql1);

if ($result1->num_rows > 0) {
  // output data of each row
  while($row = $result1->fetch_assoc()) {
    
    $subject = 'Hello' . $row["firstname"];
    try {
    
        $result = $client->sendEmail(array(
            // Source is required
            'Source' => 'support@whistle.mobi',
            // Destination is required
            'Destination' => array(
                'ToAddresses' => array($row["email"]),
                'CcAddresses' => array(),
                'BccAddresses' => array(),
            ),
            // Message is required
            'Message' => array(
                // Subject is required
                'Subject' => array(
                    // Data is required
                    'Data' => $subject,
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
        //header("Location: ses_index.php?flag=Email sent ");
    } catch (S3Exception $e) {
        echo $e->getMessage() . PHP_EOL;
    }
  }
} else {
  echo "0 results";
}


$conn->close();
?>
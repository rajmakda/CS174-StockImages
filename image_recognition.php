<?php
    require 'vendor/autoload.php';
    putenv('HOME=/opt/lampp/htdocs');
    use Aws\Rekognition\RekognitionClient;
    use Aws\Exception\AwsException;
    $client = new RekognitionClient(([
        'profile' => 'default',
        'region' => 'us-west-2',
        'version' => 'latest'
    ]));
    header('Content-Type: application/json');
    if (isset($_POST)) {
        $content = file_get_contents("php://input");
        $im = imagecreatefromstring($content);
        $aResult = image_recognition($content, $client);
        echo json_encode($aResult);
    }
    
    function image_recognition($image, $client)
    {
        $label = $client->detectLabels([
            'Image' => [
                'Bytes'=> $image
            ],
            'MaxLabels' => 5
        ]);
        $label = $label['Labels'];
        $result = array();
        for ($i = 0; $i < sizeof($label); $i++) {
            array_push($result, $label[$i]['Name']);
        }
        return $result;
    }
?>
<?php
session_start();
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/src/Provider/FeideProvider.php';

?>
<html>
<head>
    <meta charset="UTF-8">
    <title>Feide innlogget</title>
</head>
<body>
<h1>Innlogget på Feide</h1>
<?php
if (!isset($_GET["service"])) {
    die("undefined service 400");
}

try {
    $feideProvider = new \IBok\OAuth2\Client\Provider\FeideProvider([
        'clientId' => '1949ffce-a9a5-40c0-a960-681c22130ae4',
        'clientSecret' => '3ea32500-4e0f-4658-848d-231d1ab97d9f',
        'redirectUri' => 'http://longslimjohn.local:8888/feide-auth/user.php?service=feide'
    ]);
} catch (Exception $e) {
    echo "Failed to use Feide provider<br>";
    die($e->getMessage());

}

$_SESSION["token"] = null;

if(!isset($_SESSION["token"])){
    try{
        $token = $feideProvider->getAccessToken('authorization_code', [
            'code' => $_GET['code']
        ]);

        var_dump($token);
        $_SESSION['token'] = $token;
    } catch (Exception $e){
        echo 'Could not get Feidetoken <br>';
        die($e->getMessage());
    }
}

try{
    $user = $feideProvider->getResourceOwner($_SESSION["token"]);

    echo '<pre>';
    var_dump($user->toArray());
    echo '</pre>';

    $img = $user->toArray()['user']['profilephoto'];



    echo $img. "<br>";

    $_SESSION['user'] = [
        'first_name' => $user->getFirstName(),
        'last_name' => $user->getLastName(),
        'email' => $user->getEmail(),
        'service_id' => $user->getId(),
        'service' => 'feide'
    ];
} catch (\Exception $e){
    echo "Failed to get resource owner";
    die($e->getMessage());
}

?>
</body>
</html>

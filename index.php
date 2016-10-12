<?php
session_start();
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/src/Provider/FeideProvider.php';

$feideProvider = new \IBok\OAuth2\Client\Provider\FeideProvider([
    'clientId' => '1949ffce-a9a5-40c0-a960-681c22130ae4',
    'clientSecret' => '3ea32500-4e0f-4658-848d-231d1ab97d9f',
    'redirectUri' => 'http://longslimjohn.local:8888/feide-auth/user.php?service=feide'
]);
?>
<html>
<head>
    <title>Oatuh</title>
</head>
<body>
<h1>Feide Oauth</h1>
<?php
if (!isset($_GET['code'])) {
    $authUrl = $feideProvider->getAuthorizationUrl([
        'scope' => [] // DENNE MÅ STÅ TOM FOR FEIDE
    ]);

    $_SESSION['oauth2state'] = $feideProvider->getState();

    echo '<a href="' . $authUrl . '"> Log in via Feide</a>';
} elseif (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {
    unset($_SESSION['oauth2state']);
    echo 'Invalid state.';
    exit;
}

?>

</body>
</html>
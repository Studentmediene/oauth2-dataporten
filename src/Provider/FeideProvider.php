<?php namespace IBok\OAuth2\Client\Provider;

use \IBok\OAuth2\Client\Entity\FeideUser;

use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Provider\AbstractProvider;
use Psr\Http\Message\ResponseInterface;


class FeideProvider extends AbstractProvider
{
    const ACCESS_TOKEN_RESOURCE_OWNER_ID = null;

    public function __construct(array $options = [])
    {
        parent::__construct($options);
    }

    public function getBaseAuthorizationUrl()
    {
        return "https://auth.dataporten.no/oauth/authorization";
    }

    public function getBaseAccessTokenUrl(array $params)
    {
        return "https://auth.dataporten.no/oauth/token";
    }

    public function getResourceOwnerDetailsUrl(AccessToken $token)
    {

        return "https://auth.dataporten.no/userinfo";
    }


    protected function getDefaultScopes()
    {
        return []; // DENNE MÅ STÅ TOM FOR FEIDE
    }

    protected function getAuthorizationHeaders($token = null)
    {

        return ["Authorization" => "Bearer " . $token];
    }

    protected function checkResponse(ResponseInterface $response, $data)
    {
        // TODO: Implement checkResponse() method.
        if (!empty($data['error'])) {
            var_dump($data);
            $message = $data['message'];
            throw new IdentityProviderException($message, 403, $data);
        }
    }

    protected function createResourceOwner(array $response, AccessToken $token)
    {
        // TODO: Implement createResourceOwner() method.
        if (isset($response['audience'])) {
            if ($response['audience'] != $this->clientId) {
                throw new IdentityProviderException("Audience does not match clientid", 403, $response);
            }
        } else {
            throw new IdentityProviderException('Missing property "audience" in response', 403, $response);
        }

        return new FeideUser($response);
    }

}
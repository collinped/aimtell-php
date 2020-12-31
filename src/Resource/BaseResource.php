<?php


namespace Collinped\Aimtell\Resource;

use BadMethodCallException;
use Collinped\Aimtell\Aimtell;
use Collinped\Aimtell\Exception\AimtellException;
use Collinped\Aimtell\Exception\AuthorizationException;
use Collinped\Aimtell\Exception\NetworkErrorException;
use Collinped\Aimtell\Exception\RequestException;
use Collinped\Aimtell\Exception\UnexpectedErrorException;
use Error;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\GuzzleException;
use InvalidArgumentException;

abstract class BaseResource
{
    /**
     * @var Aimtell
     */
    protected Aimtell $aimtell;

    /**
     * @var Client
     */
    protected Client $client;

    /**
     * @var string|null
     */
    protected ?string $resourceId;

    /**
     * @var bool
     */
    protected bool $isSiteResource;

    /**
     * Protect assigned methods from being executed by a resource.
     *
     * @var array
     */
    protected array $guarded = [];

    /**
     * @param Aimtell $aimtell
     */
    public function __construct(Aimtell $aimtell)
    {
        $this->aimtell = $aimtell;
        $this->isSiteResource = $this->resourceName() === 'site';

        $this->client = new Client([
            'base_uri' => 'https://api.aimtell.com',
        ]);
    }

    /**
     * Get all results for a resource.
     *
     * @param array $query
     * @return mixed
     * @throws AimtellException
     * @throws AuthorizationException
     * @throws NetworkErrorException
     * @throws RequestException
     * @throws UnexpectedErrorException
     * @throws GuzzleException
     */
    public function all(array $query = [])
    {
        $this->guardMethod(__FUNCTION__);
        $endStr = '';

        if (! $this->isSiteResource) {
            if (! $siteId = $this->aimtell->getSiteId()) {
                throw new InvalidArgumentException('A valid site id is required.');
            }

            $endStr = '/' .$siteId;
        }

        return $this->sendRequest(
            'GET',
            $this->resourceName(). 's' . $endStr, // plural endpoint
            $query
        );
    }

    /**
     * Create a new resource.
     *
     * @param array $data
     * @param array $headers
     * @return mixed
     * @throws AimtellException
     * @throws AuthorizationException
     * @throws NetworkErrorException
     * @throws RequestException
     * @throws UnexpectedErrorException
     * @throws GuzzleException
     */
    public function create(array $data, array $headers = [])
    {
        $this->guardMethod(__FUNCTION__);

        if (! $this->isSiteResource) {
            if (! $siteId = $this->aimtell->getSiteId()) {
                throw new InvalidArgumentException('A valid site id is required.');
            }

            $data['idSite'] = $siteId;
        }

        return $this->sendRequest(
            'POST',
            $this->resourceName(). 's',
            [],
            $data,
            $headers
        );
    }

    /**
     * Update an existing resource.
     *
     * @param array $data
     * @param array $headers
     * @return mixed
     * @throws AimtellException
     * @throws AuthorizationException
     * @throws NetworkErrorException
     * @throws RequestException
     * @throws UnexpectedErrorException
     * @throws GuzzleException
     */
    public function update(array $data, array $headers = [])
    {
        $this->guardMethod(__FUNCTION__);
        $this->confirmResourceIdNotEmpty();

        return $this->sendRequest(
            'PUT',
            $this->resourceName(). '/' .$this->resourceId,
            [],
            $data,
            $headers
        );
    }

    /**
     * Find a resource by id.
     *
     * @param string $id
     * @param array $query
     * @return mixed
     * @throws AimtellException
     * @throws AuthorizationException
     * @throws NetworkErrorException
     * @throws RequestException
     * @throws UnexpectedErrorException
     * @throws GuzzleException
     */
    public function find(string $id, array $query = [])
    {
        $this->guardMethod(__FUNCTION__);

        return $this->sendRequest(
            'GET',
            $this->resourceName(). '/' .$id,
            $query
        );
    }

    /**
     * Delete a resource.
     *
     * @return mixed
     * @throws AimtellException
     * @throws AuthorizationException
     * @throws NetworkErrorException
     * @throws RequestException
     * @throws UnexpectedErrorException
     * @throws GuzzleException
     */
    public function delete()
    {
        $this->guardMethod(__FUNCTION__);
        $this->confirmResourceIdNotEmpty();

        return $this->sendRequest(
            'DELETE',
            $this->resourceName(). '/' .$this->resourceId
        );
    }

    /**
     * Get aggregate resource results by a set of dates.
     *
     * @param array $dates
     * @return mixed
     * @throws AimtellException
     * @throws AuthorizationException
     * @throws NetworkErrorException
     * @throws RequestException
     * @throws UnexpectedErrorException
     * @throws GuzzleException
     */
    public function getResultsByDate(array $dates = [])
    {
        $this->guardMethod(__FUNCTION__);

        if ($this->isSiteResource) {
            throw new BadMethodCallException('Method is not allowed.');
        } elseif (! array_key_exists('startDate', $dates) || ! array_key_exists('endDate', $dates)) {
            throw new InvalidArgumentException('Both startDate and endDate are required.');
        }

        $this->confirmResourceIdNotEmpty();

        return $this->sendRequest(
            'GET',
            $this->resourceName(). '/' .$this->resourceId. '/results',
            $dates
        );
    }

    /**
     * Get the current resource name.
     *
     * @return string
     */
    protected function resourceName(): string
    {
        $class = explode('\\', get_called_class());

        return $this->camelToUnderscore(array_pop($class));
    }

    /**
     * Convert a resource class name to camel case.
     *
     * @param $string
     * @param string $us
     * @return string
     */
    protected function camelToUnderscore($string, $us = "-"): string
    {
        $patterns = [
            '/([a-z]+)([0-9]+)/i',
            '/([a-z]+)([A-Z]+)/',
            '/([0-9]+)([a-z]+)/i',
        ];
        $string = preg_replace($patterns, '$1'.$us.'$2', $string);
        $string = strtolower($string);

        return $string;
    }

    /**
     * Send a Guzzle request to Aimtell.
     *
     * @param $method
     * @param $path
     * @param array $query
     * @param array $body
     * @param array $headers
     * @return mixed
     * @throws AimtellException
     * @throws AuthorizationException
     * @throws NetworkErrorException
     * @throws RequestException
     * @throws UnexpectedErrorException
     * @throws GuzzleException
     */
    protected function sendRequest($method, $path, array $query = [], array $body = [], array $headers = [])
    {
        $apiKey = $this->aimtell->getApiKey();

        if (! is_string($apiKey) || empty($apiKey)) {
            throw new InvalidArgumentException('A valid API key is required.');
        }

        try {
            $response = $this->client->request(
                $method,
                $this->getPath($path, $query),
                $this->getOptions($body, $headers)
            );

            $response = json_decode(strval($response->getBody()), true);
        } catch (ConnectException $e) {
            throw new NetworkErrorException($e->getMessage());
        } catch (ClientException $e) {
            throw new RequestException(
                $this->errorMessageFromJsonBody(strval($e->getResponse()->getBody())),
                $e->getResponse()->getStatusCode()
            );
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            if (! $e->hasResponse()) {
                throw new UnexpectedErrorException('An unexpected error has occurred: ' . $e->getMessage());
            }

            $responseErrorBody = strval($e->getResponse()->getBody());
            $errorMessage = $this->errorMessageFromJsonBody($responseErrorBody);
            $statusCode = $e->getResponse()->getStatusCode();

            if ($statusCode === 401) {
                throw new AuthorizationException($errorMessage, 401);
            }

            if ($statusCode === 400) {
                throw new RequestException($errorMessage, 400);
            }

            throw new UnexpectedErrorException('An unexpected error has occurred: ' . $e->getMessage());
        } catch (Exception $e) {
            throw new UnexpectedErrorException('An unexpected error has occurred: ' . $e->getMessage());
        }

        if (isset($response['result']) && $response['result'] === 'error') {
            throw new AimtellException($response['message']);
        }

        return $response;
    }

    /**
     * Build the path for an endpoint.
     *
     * @param string $path
     * @param array $query
     * @return string
     */
    protected function getPath(string $path, array $query = []): string
    {
        $path = strval('/prod/'.$path);
        $queryString = '';

        if (! empty($query)) {
            $queryString = '?'.http_build_query($query);
        }

        return $path.$queryString;
    }

    /**
     * Build the options and headers for a request.
     *
     * @param array $body
     * @param array $headers
     * @return array
     */
    protected function getOptions(array $body = [], array $headers = []): array
    {
        $contentType = count($body) > 0
            ? 'application/x-www-form-urlencoded'
            : 'application/json';

        $options = [
            'headers' => array_merge([
                'Content-Type' => $contentType,
                'Accepts' => $contentType,
                'X-Authorization-Api-Key' => $this->aimtell->getApiKey(),
            ], $headers),
        ];

        if ($whiteLabelId = $this->aimtell->getWhiteLabelId()) {
            $options['headers']['Aimtell-Whitelabel-ID'] = $whiteLabelId;
        }

        if (count($body) > 0) {
            $options['body'] = json_encode($this->stringifyBooleans($body));
        }

        return $options;
    }

    /**
     * Because guzzle uses http_build_query it will turn all booleans into '' and '1' for
     * false and true respectively. This function will turn all booleans into the string
     * literal 'false' and 'true'
     *
     * @param $body
     * @return array
     */
    protected function stringifyBooleans($body): array
    {
        return array_map(function ($value) {
            if (is_bool($value)) {
                return $value ? 'true' : 'false';
            } elseif (is_array($value)) {
                return $this->stringifyBooleans($value);
            }

            return $value;
        }, $body);
    }

    /**
     * Return error message. This will confirm all errors are caught.
     *
     * @param $body
     * @return string
     */
    protected function errorMessageFromJsonBody($body): string
    {
        $response = json_decode($body, true);

        if (is_array($response)) {
            if (isset($response['error'])) {
                $error = $response['error'];

                return $error['message'];
            } elseif (isset($response['message'])) {
                return $response['message'];
            }
        }

        return 'An internal error has occurred.';
    }

    /**
     * Confirm item has a resource id.
     */
    protected function confirmResourceIdNotEmpty(): void
    {
        if (! $this->resourceId) {
            throw new InvalidArgumentException('A valid resource id is required.');
        }
    }

    /**
     * @param string $method
     */
    protected function guardMethod(string $method): void
    {
        if (in_array($method, $this->guarded)) {
            throw new BadMethodCallException(sprintf(
                'Call to prohibited method %s::%s()',
                static::class,
                $method
            ));
        }
    }

    /**
     * Handle dynamic method calls to resources.
     *
     * @param  string  $method
     * @param  array  $arguments
     * @return mixed
     */
    public function __call(string $method, array $arguments)
    {
        if ($this->isSiteResource && $this->resourceId) {
            $this->aimtell->setSiteId($this->resourceId);
        }

        try {
            $resolver = $this->aimtell->{$method}(...$arguments);
        } catch (Error | BadMethodCallException $e) {
            $pattern = '~^Call to undefined method (?P<class>[^:]+)::(?P<method>[^\(]+)\(\)$~';

            if (! preg_match($pattern, $e->getMessage(), $matches)) {
                throw $e;
            }

            throw new BadMethodCallException(sprintf(
                'Call to undefined method %s::%s()',
                static::class,
                $method
            ));
        }

        return $resolver;
    }
}

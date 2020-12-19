<?php


namespace Collinped\Aimtell\Resource;

use BadMethodCallException;
use Collinped\Aimtell\Aimtell;
use Error;

class Site extends BaseResource
{
    /**
     * @param Aimtell $aimtell
     * @param string|null $siteId
     */
    public function __construct(Aimtell $aimtell, ?string $siteId = null)
    {
        parent::__construct($aimtell);
        $this->resourceId = $siteId;
    }

    public function getCode()
    {
        return $this->sendRequest(
            'GET',
            $this->resourceName().'/code/'.strval($this->siteId)
        );
    }

    public function getSettings()
    {
        return $this->sendRequest(
            'GET',
            $this->resourceName().'/'.strval($this->siteId) . '/settings'
        );
    }

    public function updateSettings(array $data, array $headers = null)
    {
        return $this->sendRequest(
            'POST',
            $this->resourceName().'/'.strval($this->siteId) . '/settings',
            [],
            $data,
            $headers
        );
    }

    public function updatePackage(array $data, array $headers = null)
    {
        return $this->sendRequest(
            'POST',
            $this->resourceName().'/package/'.strval($this->siteId),
            [],
            $data,
            $headers
        );
    }

    public function getKeys()
    {
        return $this->sendRequest(
            'GET',
            $this->resourceName().'/'.strval($this->siteId) . '/keys'
        );
    }

    public function upsertKeys(array $data, array $headers = null)
    {
        return $this->sendRequest(
            'POST',
            $this->resourceName().'/'.strval($this->siteId) . '/keys/upsert',
            [],
            $data,
            $headers
        );
    }

    public function analytics(array $query)
    {
        return $this->sendRequest(
            'GET',
            'report/dashboard/'.strval($this->siteId),
            $query
        );
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
        if ($this->resourceId) {
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

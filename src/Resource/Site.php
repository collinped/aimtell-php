<?php


namespace Collinped\Aimtell\Resource;

use Collinped\Aimtell\Aimtell;

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

    /**
     * Returns Aimtell push & website tracking code.
     *
     * @return mixed
     */
    public function getCode()
    {
        return $this->sendRequest(
            'GET',
            $this->resourceName().'/code/'.strval($this->resourceId)
        );
    }

    /**
     * Get a site's tracking settings.
     *
     * @return mixed
     */
    public function getSettings()
    {
        return $this->sendRequest(
            'GET',
            $this->resourceName().'/'.strval($this->resourceId) . '/settings'
        );
    }

    /**
     * Update a site's tracking settings.
     *
     * @param array $data
     * @param array $headers
     * @return mixed
     */
    public function updateSettings(array $data, array $headers = [])
    {
        return $this->sendRequest(
            'POST',
            $this->resourceName().'/'.strval($this->resourceId) . '/settings',
            [],
            $data,
            $headers
        );
    }

    /**
     * Updates the Safari push package for a site.
     *
     * @param array $data
     * @param array $headers
     * @return mixed
     */
    public function updatePackage(array $data, array $headers = [])
    {
        return $this->sendRequest(
            'POST',
            $this->resourceName().'/package/'.strval($this->resourceId),
            [],
            $data,
            $headers
        );
    }

    /**
     * Gets a Website's VAPID or FCM Keys. Keys that are marked "is_primary" are the ones that will be currently used
     * on the site for new subscribers. If the results are empty, this means you are using legacy Aimtell keys. We
     * advise you to generate your own VAPID keys within the dashboard.
     *
     * @return mixed
     */
    public function getKeys()
    {
        return $this->sendRequest(
            'GET',
            $this->resourceName().'/'.strval($this->resourceId) . '/keys'
        );
    }

    /**
     * Update a Website's VAPID or FCM Keys. Note: this can directly impact your opt-in rate and/or push delivery.
     * Only update these if you know what you are doing.
     *
     * @param array $data
     * @param array $headers
     * @return mixed
     */
    public function upsertKeys(array $data, array $headers = [])
    {
        return $this->sendRequest(
            'POST',
            $this->resourceName().'/'.strval($this->resourceId) . '/keys/upsert',
            [],
            $data,
            $headers
        );
    }

    /**
     * Shows a report of the number of unsubscribes that occurred as a result of being able to deliver notifications
     * over time.
     *
     * @param array $query
     * @return mixed
     */
    public function analytics(array $query)
    {
        return $this->sendRequest(
            'GET',
            'report/dashboard/'.strval($this->resourceId),
            $query
        );
    }
}

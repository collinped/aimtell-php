<?php


namespace Collinped\Aimtell\Resource;

use Collinped\Aimtell\Aimtell;

class Subscriber extends BaseResource
{
    /**
     * @param Aimtell $aimtell
     * @param string|null $subscriberId
     */
    public function __construct(Aimtell $aimtell, ?string $subscriberId = null)
    {
        parent::__construct($aimtell);
        $this->resourceId = $subscriberId;
    }

    public function setAttributes(array $attributes, array $data)
    {
        $siteId = ($data['site_id'] ? $data['site_id'] : $this->siteId);

        $data['idSite'] = strval($siteId);
        $data['subscriber_uid'] = $this->resourceId;

        $data['attributes'] = $attributes;

        return $this->sendRequest(
            'POST',
            $this->resourceName(),
            [],
            $data
        );
    }

    public function trackEvent(array $event, array $data)
    {
        $siteId = ($data['site_id'] ? $data['site_id'] : $this->siteId);

        $data['idSite'] = strval($siteId);
        $data['subscriber_uid'] = $this->resourceId;

        $data['event'] = $event;

        return $this->sendRequest(
            'POST',
            $this->resourceName(),
            [],
            $data
        );
    }

    public function optOut(array $data)
    {
        $siteId = ($data['site_id'] ? $data['site_id'] : $this->siteId);

        $data['idSite'] = strval($siteId);
        $data['subscriber_uid'] = $this->resourceId;
        $data['optout'] = true;

        return $this->sendRequest(
            'POST',
            $this->resourceName(),
            [],
            $data
        );
    }
}

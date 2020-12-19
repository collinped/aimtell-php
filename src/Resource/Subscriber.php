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

    /**
     * @param array $attributes
     * @param array $data
     * @return mixed
     */
    public function setAttributes(array $attributes, array $data)
    {
        $data['idSite'] = strval($this->aimtell->getSiteId());
        $data['subscriber_uid'] = $this->resourceId;

        $data['attributes'] = $attributes;

        return $this->sendRequest(
            'POST',
            $this->resourceName(),
            [],
            $data
        );
    }

    /**
     * @param array $event
     * @param array $data
     * @return mixed
     */
    public function trackEvent(array $event, array $data)
    {
        $data['idSite'] = strval($this->aimtell->getSiteId());
        $data['subscriber_uid'] = $this->resourceId;

        $data['event'] = $event;

        return $this->sendRequest(
            'POST',
            $this->resourceName(),
            [],
            $data
        );
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function optOut(array $data)
    {
        $data['idSite'] = strval($this->aimtell->getSiteId());
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

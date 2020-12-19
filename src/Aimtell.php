<?php

namespace Collinped\Aimtell;

use Collinped\Aimtell\Resource\ApiCampaign;
use Collinped\Aimtell\Resource\Campaign;
use Collinped\Aimtell\Resource\EventCampaign;
use Collinped\Aimtell\Resource\Push;
use Collinped\Aimtell\Resource\RssCampaign;
use Collinped\Aimtell\Resource\RssNotification;
use Collinped\Aimtell\Resource\Segment;
use Collinped\Aimtell\Resource\Site;
use Collinped\Aimtell\Resource\Subscriber;
use InvalidArgumentException;

class Aimtell
{
    /**
     * @var string
     */
    protected string $apiKey;

    /**
     * @var string|null
     */
    protected ?string $defaultSiteId = null;

    /**
     * @var string|null
     */
    protected ?string $whiteLabelId = null;

    /**
     * @var string|null
     */
    protected ?string $currentSiteId = null;

    /**
     * @param string $apiKey
     * @param string|null $defaultSiteId
     * @param string|null $whiteLabelId
     */
    public function __construct(string $apiKey, ?string $defaultSiteId = null, ?string $whiteLabelId = null)
    {
        $this->setApiKey($apiKey);

        if (! is_null($defaultSiteId)) {
            $this->setDefaultSiteId($defaultSiteId);
        }

        if (! is_null($whiteLabelId)) {
            $this->setWhitelabelId($whiteLabelId);
        }
    }

    /**
     * Set the current site id.
     *
     * @return string|null
     */
    public function getSiteId(): ?string
    {
        return $this->currentSiteId ?: $this->defaultSiteId;
    }

    /**
     * Set the current site id.
     *
     * @param string|null $siteId
     * @return Aimtell
     */
    public function setSiteId(?string $siteId): Aimtell
    {
        if (! is_string($siteId) || empty($siteId)) {
            throw new InvalidArgumentException('Site id must be a non-empty string.');
        }

        $this->currentSiteId = $siteId;

        return $this;
    }

    /**
     * Get the API key.
     *
     * @return string|null
     */
    public function getApiKey(): ?string
    {
        return $this->apiKey;
    }

    /**
     * Set the API key.
     *
     * @param $apiKey
     * @return $this
     */
    public function setApiKey($apiKey): Aimtell
    {
        if (! is_string($apiKey) || empty($apiKey)) {
            throw new InvalidArgumentException('API Key must be a non-empty string.');
        }

        $this->apiKey = $apiKey;

        return $this;
    }

    /**
     * Get default site id.
     *
     * @return string|null
     */
    public function getDefaultSiteId(): ?string
    {
        return $this->defaultSiteId;
    }

    /**
     * Set default site id.
     *
     * @param $siteId
     * @return $this
     */
    public function setDefaultSiteId($siteId): Aimtell
    {
        if (! is_string($siteId) || empty($siteId)) {
            throw new InvalidArgumentException('Default site id must be a non-empty string.');
        }

        $this->defaultSiteId = $siteId;

        return $this;
    }

    /**
     * Get white label.
     *
     * @return string|null
     */
    public function getWhiteLabelId(): ?string
    {
        return $this->whiteLabelId;
    }

    /**
     * Set white label.
     *
     * @param $whiteLabelId
     * @return $this
     */
    public function setWhitelabelId($whiteLabelId): Aimtell
    {
        if (! is_string($whiteLabelId) || empty($whiteLabelId)) {
            throw new InvalidArgumentException('White label id must be a non-empty string.');
        }

        $this->whiteLabelId = $whiteLabelId;

        return $this;
    }

    /**
     * Site resource.
     *
     * @param null $siteId
     * @return Site
     */
    public function site($siteId = null): Site
    {
        return new Site($this, $siteId ?: $this->defaultSiteId);
    }

    /**
     * Push resource.
     *
     * @return Push
     */
    public function push(): Push
    {
        return new Push($this);
    }

    /**
     * Subscriber resource.
     *
     * @param string|null $subscriberId
     * @return Subscriber
     */
    public function subscriber(?string $subscriberId = null): Subscriber
    {
        return new Subscriber($this, $subscriberId);
    }

    /**
     * Campaign resource.
     *
     * @param string|null $campaignId
     * @return Campaign
     */
    public function campaign(?string $campaignId = null): Campaign
    {
        return new Campaign($this, $campaignId);
    }

    /**
     * Event campaign resource.
     *
     * @param string|null $eventCampaignId
     * @return EventCampaign
     */
    public function eventCampaign(?string $eventCampaignId = null): EventCampaign
    {
        return new EventCampaign($this, $eventCampaignId);
    }

    /**
     * RSS campaign resource.
     *
     * @param string|null $rssCampaignId
     * @return RssCampaign
     */
    public function rssCampaign(?string $rssCampaignId = null): RssCampaign
    {
        return new RssCampaign($this, $rssCampaignId);
    }

    /**
     * API campaign resource.
     *
     * @param string|null $apiCampaignId
     * @return ApiCampaign
     */
    public function apiCampaign(?string $apiCampaignId = null): ApiCampaign
    {
        return new ApiCampaign($this, $apiCampaignId);
    }

    /**
     * Segment resource.
     *
     * @param string|null $segmentId
     * @return Segment
     */
    public function segment(?string $segmentId = null): Segment
    {
        return new Segment($this, $segmentId);
    }

    /**
     * RSS notification resource.
     *
     * @param string|null $rssNotificationId
     * @return RssNotification
     */
    public function rssNotification(?string $rssNotificationId = null): RssNotification
    {
        return new RssNotification($this, $rssNotificationId);
    }
}

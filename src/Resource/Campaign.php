<?php


namespace Collinped\Aimtell\Resource;

use Collinped\Aimtell\Aimtell;

class Campaign extends BaseResource
{
    /**
     * @param Aimtell $aimtell
     * @param string|null $campaignId
     */
    public function __construct(Aimtell $aimtell, ?string $campaignId = null)
    {
        parent::__construct($aimtell);
        $this->resourceId = $campaignId;
    }

    /**
     * Get aggregate campaign results by clicks.
     *
     * @return mixed
     */
    public function getClicks()
    {
        $this->confirmResourceIdNotEmpty();

        return $this->sendRequest(
            'GET',
            $this->resourceName(). '/' .$this->resourceId. '/clicks'
        );
    }
}

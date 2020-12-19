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
}

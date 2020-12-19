<?php


namespace Collinped\Aimtell\Resource;

use Collinped\Aimtell\Aimtell;

class Segment extends BaseResource
{
    /**
     * Segment constructor.
     * @param Aimtell $aimtell
     * @param string|null $segmentId
     */
    public function __construct(Aimtell $aimtell, ?string $segmentId = null)
    {
        parent::__construct($aimtell);
        $this->resourceId = $segmentId;
    }
}

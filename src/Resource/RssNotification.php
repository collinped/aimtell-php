<?php


namespace Collinped\Aimtell\Resource;

use Collinped\Aimtell\Aimtell;

class RssNotification extends BaseResource
{
    /**
     * @param Aimtell $aimtell
     * @param string|null $rssNotificationId
     */
    public function __construct(Aimtell $aimtell, ?string $rssNotificationId = null)
    {
        parent::__construct($aimtell);
        $this->resourceId = $rssNotificationId;
    }
}

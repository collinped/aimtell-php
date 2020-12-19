<?php


namespace Collinped\Aimtell\Resource;

use Collinped\Aimtell\Aimtell;

class Push extends BaseResource
{
    private int $ttl = 604800;
    private ?string $title = null;
    private ?string $message = null;
    private ?string $link = null;
    private ?string $icon = null;
    private ?string $image = null;
    private ?string $subscribers = null;
    private ?string $alias = null;
    private int $autoHide = 0;
    private ?int $segment = null;
    private array $actionButtons = [];

    public function __construct(Aimtell $aimtell)
    {
        parent::__construct($aimtell);
    }

    public function send(array $data = [])
    {
        $siteId = (isset($data['site_id']) ? $data['site_id'] : $this->aimtell->getSiteId());
        $data['idSite'] = $siteId; // Aimtell API Reference

        // Check that at least one is filled subscribers, segment, or alias

        $data['title'] = $this->title;
        $data['body'] = $this->message;
        $data['link'] = $this->link;
        $data['subscriber_uids'] = $this->subscribers;
        $data['segmentId'] = $this->segment;
        $data['alias'] = $this->alias;
        $data['customIcon'] = $this->icon;
        $data['customImage'] = $this->image;
        $data['push_ttl'] = $this->ttl;
        $data['auto_hide'] = $this->autoHide;

        if (! empty($this->actionButtons)) {
            $data['actions'] = $this->actionButtons;
        }

        return $this->sendRequest(
            'POST',
            $this->resourceName(),
            [],
            $data
        );
    }

    public function title($title = null): Push
    {
        $this->title = $title;

        return $this;
    }

    public function message($message = null): Push
    {
        $this->message = $message;

        return $this;
    }

    public function body($message = null): Push
    {
        $this->message = $message;

        return $this;
    }

    public function link($url = null): Push
    {
        $this->link = $url;

        return $this;
    }

    public function withIcon($icon = null): Push
    {
        $this->icon = $icon;

        return $this;
    }

    public function withImage($image = null): Push
    {
        $this->image = $image;

        return $this;
    }

    public function ttl($seconds): Push
    {
        $this->ttl = $seconds;

        return $this;
    }

    public function hideAfter($seconds): Push
    {
        $this->autoHide = $seconds;

        return $this;
    }

    public function toSegment($segmentId): Push
    {
        $this->segment = $segmentId;

        return $this;
    }

    public function toAlias(string $identifier, string $value): Push
    {
        $this->alias = $identifier . '==' . $value;

        return $this;
    }

    public function toSubscriber(string $subscriber): Push
    {
        $this->subscribers = $subscriber;

        return $this;
    }

    public function toSubscribers(array $subscribers): Push
    {
        $this->subscribers = implode(',', $subscribers);

        return $this;
    }

    public function withButton(array $button): Push
    {
        $actionButtons = $this->actionButtons;
        $actionButtonCount = count($actionButtons);

        $actionKey = 'a01';
//        if ($actionButtonCount >= 2) {
//            return 'error';
//        } elseif {
        if ($actionButtonCount === 1) {
            $actionKey = 'a02';
        }

        array_push($actionButtons, [$actionKey => $button]);

        $this->actionButtons = $actionButtons;

        return $this;
    }

    public function withButtons(array $buttons): Push
    {
        foreach (array_slice($buttons, 0, 2) as $button) {
            $this->withButton($button);
        }

        return $this;
    }
}

<?php


namespace Collinped\Aimtell\Resource;

use Collinped\Aimtell\Aimtell;

class Push extends BaseResource
{
    /**
     * @var int
     */
    private int $ttl = 604800;

    /**
     * @var string|null
     */
    private ?string $title = null;

    /**
     * @var string|null
     */
    private ?string $message = null;

    /**
     * @var string|null
     */
    private ?string $link = null;

    /**
     * @var string|null
     */
    private ?string $icon = null;

    /**
     * @var string|null
     */
    private ?string $image = null;

    /**
     * @var string|null
     */
    private ?string $subscribers = null;

    /**
     * @var string|null
     */
    private ?string $alias = null;

    /**
     * @var int
     */
    private int $autoHide = 0;

    /**
     * @var int|null
     */
    private ?int $segment = null;

    /**
     * @var array
     */
    private array $actionButtons = [];

    /**
     * @param Aimtell $aimtell
     */
    public function __construct(Aimtell $aimtell)
    {
        parent::__construct($aimtell);
    }

    /**
     * Send a push notification.
     *
     * @param array $data
     * @return mixed
     */
    public function send(array $data = [])
    {
        $data['idSite'] = $this->aimtell->getSiteId(); // Aimtell API Reference
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

        // check that at least one is filled subscribers, segment, or alias
        $this->checkPushNotification();

        return $this->sendRequest(
            'POST',
            $this->resourceName(),
            [],
            $data
        );
    }

    /**
     * @param string $title
     * @return $this
     */
    public function title(string $title): Push
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @param string $message
     * @return $this
     */
    public function message(string $message): Push
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @param string $message
     * @return $this
     */
    public function body(string $message): Push
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @param string $url
     * @return $this
     */
    public function link(string $url): Push
    {
        $this->link = $url;

        return $this;
    }

    /**
     * @param string $icon
     * @return $this
     */
    public function withIcon(string $icon): Push
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * @param string $image
     * @return $this
     */
    public function withImage(string $image): Push
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @param int $seconds
     * @return $this
     */
    public function ttl(int $seconds): Push
    {
        $this->ttl = $seconds;

        return $this;
    }

    /**
     * @param int $seconds
     * @return $this
     */
    public function hideAfter(int $seconds): Push
    {
        $this->autoHide = $seconds;

        return $this;
    }

    /**
     * @param string $segmentId
     * @return $this
     */
    public function toSegment(string $segmentId): Push
    {
        $this->segment = $segmentId;

        return $this;
    }

    /**
     * @param string $identifier
     * @param string $value
     * @return $this
     */
    public function toAlias(string $identifier, string $value): Push
    {
        $this->alias = $identifier . '==' . $value;

        return $this;
    }

    /**
     * @param string $subscriber
     * @return $this
     */
    public function toSubscriber(string $subscriber): Push
    {
        $this->subscribers = $subscriber;

        return $this;
    }

    /**
     * @param array $subscribers
     * @return $this
     */
    public function toSubscribers(array $subscribers): Push
    {
        $this->subscribers = implode(',', $subscribers);

        return $this;
    }

    /**
     * @param array $button
     * @return $this
     */
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

    /**
     * @param array $buttons
     * @return $this
     */
    public function withButtons(array $buttons): Push
    {
        foreach (array_slice($buttons, 0, 2) as $button) {
            $this->withButton($button);
        }

        return $this;
    }

    protected function checkPushNotification()
    {
    }
}

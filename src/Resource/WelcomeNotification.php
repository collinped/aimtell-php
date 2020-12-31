<?php


namespace Collinped\Aimtell\Resource;

use BadMethodCallException;
use Collinped\Aimtell\Aimtell;
use Collinped\Aimtell\Exception\AimtellException;
use Collinped\Aimtell\Exception\AuthorizationException;
use Collinped\Aimtell\Exception\NetworkErrorException;
use Collinped\Aimtell\Exception\RequestException;
use Collinped\Aimtell\Exception\UnexpectedErrorException;
use GuzzleHttp\Exception\GuzzleException;
use InvalidArgumentException;

class WelcomeNotification extends BaseResource
{
    /**
     * Protect assigned methods from being executed by a resource.
     *
     * @var array
     */
    protected array $guarded = [
        'all',
        'delete',
    ];

    /**
     * @param Aimtell $aimtell
     * @param string|null $welcomeCampaignId
     */
    public function __construct(Aimtell $aimtell, ?string $welcomeCampaignId = null)
    {
        parent::__construct($aimtell);
        $this->resourceId = $welcomeCampaignId;
    }

    /**
     * Get the welcome notification for the site.
     *
     * @param array $query
     * @return mixed
     * @throws AimtellException
     * @throws AuthorizationException
     * @throws NetworkErrorException
     * @throws RequestException
     * @throws UnexpectedErrorException
     * @throws GuzzleException
     */
    public function get(array $query = [])
    {
        $this->guardMethod(__FUNCTION__);
        $endStr = '';

        if (! $this->isSiteResource) {
            if (! $siteId = $this->aimtell->getSiteId()) {
                throw new InvalidArgumentException('A valid site id is required.');
            }

            $endStr = '/' .$siteId;
        }

        return $this->sendRequest(
            'GET',
            'site' . $endStr . '/welcome',
            $query
        );
    }

    /**
     * Get aggregate resource results by a set of dates.
     *
     * @param array $dates
     * @return mixed
     * @throws AimtellException
     * @throws AuthorizationException
     * @throws NetworkErrorException
     * @throws RequestException
     * @throws UnexpectedErrorException
     * @throws GuzzleException
     */
    public function getResultsByDate(array $dates = [])
    {
        $this->guardMethod(__FUNCTION__);

        if ($this->isSiteResource) {
            throw new BadMethodCallException('Method is not allowed.');
        } elseif (! array_key_exists('startDate', $dates) || ! array_key_exists('endDate', $dates)) {
            throw new InvalidArgumentException('Both startDate and endDate are required.');
        }

        // If there is no resourceId then do a call to the get method to retrieve the ID for the welcome notification
        if (! $this->resourceId) {
            $welcomeNotificationResponse = $this->get();
            $this->resourceId = $welcomeNotificationResponse['id'];
        }

        $this->confirmResourceIdNotEmpty();

        return $this->sendRequest(
            'GET',
            $this->resourceName(). 's/' .$this->resourceId. '/results',
            $dates
        );
    }

    /**
     * Create a new resource.
     *
     * @param array $data
     * @param array $headers
     * @return mixed
     * @throws AimtellException
     * @throws AuthorizationException
     * @throws NetworkErrorException
     * @throws RequestException
     * @throws UnexpectedErrorException
     * @throws GuzzleException
     */
    public function create(array $data, array $headers = [])
    {
        $this->guardMethod(__FUNCTION__);

        return $this->sendToAimtell($data, $headers);
    }

    /**
     * Create a new resource.
     *
     * @param array $data
     * @param array $headers
     * @return mixed
     * @throws AimtellException
     * @throws AuthorizationException
     * @throws NetworkErrorException
     * @throws RequestException
     * @throws UnexpectedErrorException
     * @throws GuzzleException
     */
    public function update(array $data, array $headers = [])
    {
        $this->guardMethod(__FUNCTION__);

        return $this->sendToAimtell($data, $headers);
    }

    /**
     * Create a new resource.
     *
     * @param array $data
     * @param array $headers
     * @return mixed
     * @throws AimtellException
     * @throws AuthorizationException
     * @throws NetworkErrorException
     * @throws RequestException
     * @throws UnexpectedErrorException
     * @throws GuzzleException
     */
    protected function sendToAimtell(array $data, array $headers = [])
    {
        if (! $siteId = $this->aimtell->getSiteId()) {
            throw new InvalidArgumentException('A valid site id is required.');
        }


        return $this->sendRequest(
            'POST',
            'site/' . $siteId . '/welcome/upsert',
            [],
            $data,
            $headers
        );
    }
}

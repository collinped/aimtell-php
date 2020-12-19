# Aimtell PHP SDK

[![Latest Version on Packagist](https://img.shields.io/packagist/v/collinped/laravel-aimtell.svg?style=flat-square)](https://packagist.org/packages/collinped/laravel-aimtell)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/collinped/laravel-aimtell/run-tests?label=tests&style=flat-square)](https://github.com/collinped/laravel-aimtell/actions?query=workflow%3Arun-tests+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/collinped/laravel-aimtell.svg?style=flat-square)](https://packagist.org/packages/collinped/laravel-aimtell)

[Aimtell](https://aimtell.com/) offers a service for push notifications to users who give permission. This package allows for interfacing with Aimtell's backend API to manage your account.

[Aimtell REST API Documentation](https://developers.aimtell.com/reference#authenticating-calls)

## Installation

You can install the package via composer:

```bash
composer require collinped/aimtell-php
```

## Usage

#### Quick Example

``` php
$aimtell = new Collinped\Aimtell($apiKey, $defaultSiteId, $whiteLabelId);

$site = $aimtell->site()
                ->create([
                    'name' => 'Sample Website',
                    'url' => 'collinped.com'
                ]);

$campaigns = $aimtell->site($siteId)
                     ->campaign()
                     ->all();

$campaign = $aimtell->site($siteId)
                    ->campaign()
                    ->find($campaignId);
```
### Authentication

- Get API Key
- Set API Key
- Get Default Site ID
- Set Default Site ID
- Get White Label ID
- Set White Label ID

### Sites
- Get All Websites
- Get Website
- Get Website Code
- Add Website
- Update Website Details
- Get Website Settings
- Update Website Settings
- Update Website Package (Safari)
- Delete Website
- Get Website Keys
- Upsert Website Keys

### Subscribers
- Get All Subscribers
- Get Subscriber
- Track Subscriber Attributes
- Track Subscriber Event
- Opt-Out Subscriber

### Segments
- Get All Segments
- Get Segment
- Create Segment
- Update Segment
- Delete Segment
- Get Segment Counts Over Time

### Manual Campaigns
- Get All Manual Campaigns
- Get Manual Campaign
- Get Manual Campaign Clicks
- Get Manual Campaign Results (By Day)
- Create Manual Campaign
- Update Manual Campaign
- Delete Manual Campaign

### Triggered Campaigns
- Get All Event Triggered Campaigns
- Get Event Triggered Campaign
- Get Event Triggered Campaign Results (By Day)
- Create Event Triggered Campaign
- Update Event Triggered Campaign
- Delete Event Triggered Campaign

### RSS Campaigns
- Get All RSS Campaigns
- Get RSS Campaign
- Create RSS Campaign
- Update RSS Campaign
- Delete RSS Campaign

### API Campaigns
- Get All API Campaigns
- Get API Campaign
- Get Event API Campaign Results (By Day)

### Send Push Notifications
- Send a Push Notification



### Authentication

#### Get API Key

``` php
$aimtell = $aimtell->getApiKey();
```

#### Set API Key

``` php
$aimtell = $aimtell->setApiKey($apiKey);
```

#### Get Default Site ID

``` php
$aimtell = $aimtell->getDefaultSiteId();
```

#### Set Default Site ID

``` php
$aimtell = $aimtell->setDefaultSiteId($defaultSiteId);
```

#### Get White Label ID

``` php
$aimtell = $aimtell->getWhiteLabelId();
```

#### Set White Label ID

``` php
$aimtell = $aimtell->setWhiteLabelId($whiteLabelId);
```

### Sites

#### Get All Websites

``` php
$websites = $aimtell->site()
                    ->all();
```

#### Get Website

``` php
$website = $aimtell->site()
                   ->find($siteId);
```

#### Get Website Code

``` php
$website = $aimtell->site($siteId)
                   ->getCode();
```

#### Add Website

``` php
$websites = $aimtell->site()
                    ->create([
                        'name' => 'Website Name', // Required
                        'url' => 'facebook.com' // Required
                    ]);
```

#### Update Website Details

``` php
$websites = $aimtell->site($siteId)
                    ->update([
                        'name' => 'Website Name',
                        'url' => 'facebook.com'
                        'icon' => 'imageUrl.jpg'
                    ]);
```

#### Get Website Settings

``` php
$websites = $aimtell->site($siteId)
                    ->getSettings();
```

#### Update Website Settings

``` php
$websites = $aimtell->site($siteId)
                    ->updateSettings([
                        ...
                    ]);
```

#### Update Website Package (Safari)

``` php
$websites = $aimtell->site($siteId)
                    ->updatePackage();
```

#### Delete Website

``` php
$websites = $aimtell->site($siteId)
                    ->delete();
```

#### Update Website Keys

``` php
$websites = $aimtell->site($siteId)
                    ->getKeys();
```

#### Upsert Website Keys

``` php
$websites = $aimtell->site($siteId)
                    ->upsertKeys([
                        ...
                    ]);
```

### Subscribers

#### Get All Subscribers

``` php
$subscribers = $aimtell->site($siteId)
                       ->subscriber()
                       ->all();
```

#### Get Subscriber

``` php
$subscriber = $aimtell->site($siteId)
                      ->subscriber()
                      ->find($subscriberId);
```

#### Track Subscriber Attribute

``` php
$subscriber = $aimtell->site($siteId)
                      ->subscriber($subscriberId)
                      ->trackEvent([
                          'first_name' => 'jeff'
                          'gender' => 'male'
                      ]);
```

#### Track Subscriber Event

``` php
$subscriber = $aimtell->site($siteId)
                      ->subscriber($subscriberId)
                      ->trackEvent([
                          'category' => '' // Required
                          'action' => '', // Required
                          'label' => '',
                          'value' => 1.00
                      ]);
```
#### Opt-Out Subscriber

``` php
$subscriber = $aimtell->site($siteId)
                      ->subscriber($subscriberId)
                      ->optOut();
```

### Manual Campaigns

#### Get All Manual Campaigns

``` php
$campaigns = $aimtell->site($siteId)
                     ->campaign()
                     ->all();
```

#### Get Manual Campaign

``` php
$campaign = $aimtell->site($siteId)
                    ->campaign()
                    ->find($campaignId);
```

#### Get Manual Campaign Clicks

``` php
$campaign = $aimtell->site($siteId)
                    ->campaign($campaignId)
                    ->getClicks();
```

#### Get Manual Campaign Results (By Day)

``` php
$campaign = $aimtell->site($siteId)
                    ->campaign($campaignId)
                    ->getResultsByDate([
                        'startDate' => '01/01/2020',
                        'endDate' => '02/15/2020',
                    ]);
```

#### Create Manual Campaign - [Aimtell Docs](https://developers.aimtell.com/reference#create-campaign)

``` php
$campaign = $aimtell->site($siteId)
                    ->campaign($campaignId)
                    ->create([
                        'name' => 'Campaign Name', // Required
                        'title' => 'Campaign Title',
                        ...
                    ]);
```

#### Update Manual Campaign - [Aimtell Docs](https://developers.aimtell.com/reference#update-campaign)

``` php
$campaign = $aimtell->site($siteId)
                    ->campaign($campaignId)
                    ->update([
                        'name' => 'New Campaign Name',
                        'title' => 'New Campaign Title',
                        ...
                    ]);
```

#### Delete Manual Campaign

``` php
$campaign = $aimtell->site($siteId)
                    ->campaign($campaignId)
                    ->delete();
```

### Send Push Notifications

#### Send a Push Notification

``` php
$notification = $aimtell->site($siteId)
                        ->push()
                        ->title('Sample Notification')
                        ->message('Here is your sample message')
                        ->link('https://www.laravel.com')
                        ->toSubscriber($subscriberId)
                        ->withButton([
                            'link' => 'sampleUrl',
                            'title' => 'Sample Title 1',
                        ])
                        ->withButton([
                            'link' => 'sampleUrl2',
                            'title' => 'Sample Title 2',
                        ])
                        ->send();
```

## Testing

``` bash
composer test
```

## Todo

- [ ] A/B Tests for Manual Campaigns
- [ ] Create Manual Campaign (Batch)
- [ ] Update Manual Campaign (Batch)
- [ ] Delete Manual Campaign (Batch)
- [ ] Create Event Triggered Campaign (Batch)
- [ ] Update Event Triggered Campaign (Batch)
- [ ] Delete Event Triggered Campaign (Batch)
- [ ] Get Notification Logs
- [ ] Get Attributes Logs
- [ ] Get Pageview Logs
- [ ] Get Event Logs

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Collin Pedersen](https://github.com/collinped)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

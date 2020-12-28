# Aimtell PHP SDK

[![Latest Version on Packagist](https://img.shields.io/packagist/v/collinped/aimtell-php.svg?style=flat-square)](https://packagist.org/packages/collinped/aimtell-php)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/collinped/aimtell-php/run-tests?label=tests&style=flat-square)](https://github.com/collinped/aimtell-php/actions?query=workflow%3Arun-tests+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/collinped/aimtell-php.svg?style=flat-square)](https://packagist.org/packages/collinped/aimtell-php)

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
- Get Segment Counts Over Time (By Day)
### Welcome Notification Campaign
- Get Welcome Notification
- Get Welcome Notification Campaign Results (By Day)
- Update Welcome Notification (Upsert)

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

#### Get All Websites - [Aimtell Docs](https://developers.aimtell.com/reference#get-all-websites)

``` php
$websites = $aimtell->site()
                    ->all();
```

#### Get Website - [Aimtell Docs](https://developers.aimtell.com/reference#api-get-website)

``` php
$website = $aimtell->site()
                   ->find($siteId);
```

#### Get Website Code - [Aimtell Docs](https://developers.aimtell.com/reference#get-website-code)

``` php
$website = $aimtell->site($siteId)
                   ->getCode();
```

#### Add Website - [Aimtell Docs](https://developers.aimtell.com/reference#add-website)

``` php
$websites = $aimtell->site()
                    ->create([
                        'name' => 'Website Name', // Required
                        'url' => 'facebook.com' // Required
                    ]);
```

#### Update Website Details - [Aimtell Docs](https://developers.aimtell.com/reference#update-website)

``` php
$websites = $aimtell->site($siteId)
                    ->update([
                        'name' => 'Website Name',
                        'url' => 'facebook.com'
                        'icon' => 'imageUrl.jpg'
                    ]);
```

#### Get Website Settings - [Aimtell Docs](https://developers.aimtell.com/reference#api-get-website-settings)

``` php
$websites = $aimtell->site($siteId)
                    ->getSettings();
```

#### Update Website Settings - [Aimtell Docs](https://developers.aimtell.com/reference#update-website-settings)

``` php
$websites = $aimtell->site($siteId)
                    ->updateSettings([
                        ...
                    ]);
```

#### Update Website Package (Safari) - [Aimtell Docs](https://developers.aimtell.com/reference#update-website-push-package-safari)

``` php
$websites = $aimtell->site($siteId)
                    ->updatePackage();
```

#### Delete Website - [Aimtell Docs](https://developers.aimtell.com/reference#delete-website)

``` php
$websites = $aimtell->site($siteId)
                    ->delete();
```

#### Get Website Keys - [Aimtell Docs](https://developers.aimtell.com/reference#api-get-website-keys)

``` php
$websites = $aimtell->site($siteId)
                    ->getKeys();
```

#### Upsert Website Keys - [Aimtell Docs](https://developers.aimtell.com/reference#api-upsert-website-keys)

``` php
$websites = $aimtell->site($siteId)
                    ->upsertKeys([
                        ...
                    ]);
```

### Subscribers

#### Get All Subscribers - [Aimtell Docs](https://developers.aimtell.com/reference#get-subscribers)

``` php
$subscribers = $aimtell->site($siteId)
                       ->subscriber()
                       ->all();
```

#### Get Subscriber - [Aimtell Docs](https://developers.aimtell.com/reference#get-subscriber)

``` php
$subscriber = $aimtell->site($siteId)
                      ->subscriber()
                      ->find($subscriberId);
```

#### Track Subscriber Attribute - [Aimtell Docs](https://developers.aimtell.com/reference#api-track-subscriber-attribute)

``` php
$subscriber = $aimtell->site($siteId)
                      ->subscriber($subscriberId)
                      ->trackEvent([
                          'first_name' => 'jeff'
                          'gender' => 'male'
                      ]);
```

#### Track Subscriber Event - [Aimtell Docs](https://developers.aimtell.com/reference#api-track-subscriber-event)

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
#### Opt-Out Subscriber - [Aimtell Docs](https://developers.aimtell.com/reference#api-optout-subscriber)

``` php
$subscriber = $aimtell->site($siteId)
                      ->subscriber($subscriberId)
                      ->optOut();
```

### Segments

#### Get All Segments - [Aimtell Docs](https://developers.aimtell.com/reference#get-available-segments)

``` php
$segments = $aimtell->site($siteId)
                       ->segment()
                       ->all();
```

#### Get Segment - [Aimtell Docs](https://developers.aimtell.com/reference#get-segment)

``` php
$segment = $aimtell->site($siteId)
                       ->segment()
                       ->find($segmentId);
```

#### Create Segment - [Aimtell Docs](https://developers.aimtell.com/reference#create-segment)

``` php
$segment = $aimtell->site($siteId)
                       ->segment()
                       ->create([
                           'name' => 'Segment Name'
                           'definition' => 'city==Irvine' // See Aimtell Docs
                       ]);
```

#### Update Segment - [Aimtell Docs](https://developers.aimtell.com/reference#update-segment)

``` php
$segment = $aimtell->site($siteId)
                       ->segment($segmentId)
                       ->update([
                           'name' => 'Segment Name'
                           'definition' => 'city==Irvine' // See Aimtell Docs
                       ]);
```

#### Delete Segment - [Aimtell Docs](https://developers.aimtell.com/reference#delete-segment)

``` php
$segment = $aimtell->site($siteId)
                       ->segment($segmentId)
                       ->delete();
```

#### Get Segment Counts Over Time (By Day) - [Aimtell Docs](https://developers.aimtell.com/reference#api-get-segment-counts-over-time)

``` php
$results = $aimtell->site($siteId)
                   ->segment($segmentId)
                   ->getResultsByDate([
                       'startDate' => '1/1/2020',
                       'endDate' => '1/30/2020'
                    ]);
```
### Welcome Notifications

#### Get Welcome Notification - [Aimtell Docs](https://developers.aimtell.com/reference#api-get-welcome-campaign)

``` php
$welcomeNotification = $aimtell->site($siteId)
                               ->welcomeNotification()
                               ->get();
```

#### Get Welcome Notification Results (By Day) - [Aimtell Docs](https://developers.aimtell.com/reference#api-get-welcome-campaign-results-by-day)

``` php
$results = $aimtell->site($siteId)
                   ->welcomeNotification()
                   ->getResultsByDate([
                       'startDate' => '1/1/2020',
                       'endDate' => '1/30/2020'
                    ]);
```

#### Update Welcome Notification (Upsert) - [Aimtell Docs](https://developers.aimtell.com/reference#api-upsert-welcome-campaign)

``` php
$welcomeNotification = $aimtell->site($siteId)
                               ->welcomeNotification()
                               ->update([
                                   'title' => 'Welcome Title', // Required
                                   'body' => 'Welcome body', // Required
                                   'link' => 'http://facebook.com', // Required
                                   'status' => '1' // Required - 0 = Draft, 1 = Active
                               ]);
```

### Manual Campaigns

#### Get All Manual Campaigns - [Aimtell Docs](https://developers.aimtell.com/reference#get-all-campaigns)

``` php
$campaigns = $aimtell->site($siteId)
                     ->campaign()
                     ->all();
```

#### Get Manual Campaign - [Aimtell Docs](https://developers.aimtell.com/reference#get-campaign)

``` php
$campaign = $aimtell->site($siteId)
                    ->campaign()
                    ->find($campaignId);
```

#### Get Manual Campaign Clicks - [Aimtell Docs](https://developers.aimtell.com/reference#get-campaign-clicks)

``` php
$campaign = $aimtell->site($siteId)
                    ->campaign($campaignId)
                    ->getClicks();
```

#### Get Manual Campaign Results (By Day) - [Aimtell Docs](https://developers.aimtell.com/reference#get-manual-campaign-results-by-day)

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

#### Delete Manual Campaign - [Aimtell Docs](https://developers.aimtell.com/reference#delete-campaign)

``` php
$campaign = $aimtell->site($siteId)
                    ->campaign($campaignId)
                    ->delete();
```

### Send Push Notifications

#### Send a Push Notification - [Aimtell Docs](https://developers.aimtell.com/reference#api-send-push-notification)

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

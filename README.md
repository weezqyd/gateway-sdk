
## Roamtech Gateway API Package
### Installation

Pull in the package through Composer to get the latest stable version.
 
 `$ composer require roamtech/gateway-api`

### Native Addon
When using vanilla PHP, modify your `composer.json` file to include:

```json
  "scripts": {
    "post-update-cmd": [
        "Roamtech\\Gateway\\Support\\Bootstrap::run"
    ]
  },
```
This script will copy the default configuration file to a config folder in the root directory of your project.
Now proceed to require the package.

### Laravel

When using Laravel 5.5+, the package will automatically register. For laravel 5.4 and below,
include the service provider and its alias within your `config/app.php`.

```php
'providers' => [
    Roamtech\Gateay\Laravel\ServiceProvider::class,
],
```

Publish the package specific config using:
```bash
php artisan vendor:publish --provider 'Roamtech\Gateay\Laravel\ServiceProvider'
```


### Configuration

For Vanilla PHP you will need to initialize the sdk bootstrapper to get started.

```php
use GuzzleHttp\Client;
use Roamtech\Gateway\Engine\Core;
use Roamtech\Gateway\Native\NativeCache;
use Roamtech\Gateway\Native\NativeConfig;
use Roamtech\Gateway\Client as GatewayClient;

require "vendor/autoload.php";

$config = new NativeConfig(__DIR__.'/config/roamtechapi.php');
// Configure the HTTP client
$client = new Client(['base_uri' => $config->get('roamtechapi.api_endpoint')]);
$core = new Core($client, $config, new NativeCache($config));
$gateway = new GatewayClient($core);

```
#### Laravel
The Gateway client is resolved from the service container as:  

```php
use use Roamtech\Gateway\Client as GatewayClient;

$gateway = resolve('roamtech.client');
// Or
$gateway = resolve(GatewayClient::class);
``` 

## SMS

#### Send Bulk SMS
Send SMS in bulk mode, this endpoints allows you to send multiple messages in a single API call.

```php
$messages = [
    ['recipient' => '25472xxxxxxx', 'message' => 'This is a test message'],
    ['recipient' => '25471xxxxxxx', 'message' => 'This is a a custom message']
];
// Using the gateway instance we can now invoke the API with our payload

$response = $gateway->sms()->sendBulkMessages($messages, ['from' => 'YourSenderId']);
var_dump($response);
``` 
#### Send single SMS
This API allows you to send a single message to one or multiple recipients. 

```php
$recipients = ['25472xxxxxxx', '25471xxxxxxx'];
$message = 'A test message to say hello';
$options = [
    'from' => 'YourSenderId'
    'messageId' => '345623', 
    'callback' => 'http://yoursite.com/sms/callback/345623',
];

// Let us send our message 
$response = $gateway->sms()->sendMessage($message, $recipients, $options);
var_dump($response);
```
#### Get Delivery reports
To get delivery reports for messages use this snipet
```php
$messageId = '448768fjkhgcs4cykxuy8747r9c489';
$response = $gateway->sms()->getDeliveryReport($messageId);
var_dump($response);
```

### Airtime

You can also credit airtime to your customers instantly. 
This Api is asynchronous when you initiate a request our API will respond back to you with the transaction and a pending status. 
We will then send a callback to your application with the final status.

```php
$recipients = [
    [
        'phoneNumber' => '25472xxxxxxx',
        'amount' => 10
    ],
    [
        'phoneNumber' => '25471xxxxxxx',
        'amount' => 10
    ]
];
$callback = 'http://mysite.com/callback?id=50';

// initiate the airtime purchase transaction
$response = $gateway->airtime()
->setRecipients($recipients)
->setCallback($callback)
->purchase();

var_dump($response);
```

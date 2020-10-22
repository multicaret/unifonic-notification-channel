<p align="center">
<img src="http://cdn.multicaret.com/packages/assets/img/unifonic-logo.png">
</p>


# Unifonic notification channel for Laravel 8.x +
The Unifonic channel makes it possible to send out Laravel notifications as SMS

<p align="center">
<a href="https://packagist.org/packages/multicaret/unifonic-notification-channel"><img src="https://poser.pugx.org/multicaret/unifonic-notification-channel/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/multicaret/unifonic-notification-channel"><img src="https://poser.pugx.org/multicaret/unifonic-notification-channel/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/multicaret/unifonic-notification-channel"><img src="https://poser.pugx.org/multicaret/unifonic-notification-channel/license.svg" alt="License"></a>
</p>


## Installation

You can install this package via composer:

``` bash
composer require multicaret/unifonic-notification-channel
```

The service provider gets loaded automatically.

### Setting up the Unifonic service

Check out the configuration of [Laravel Unifonic Library]()


## Usage

To use this package, you need to create a notification class, like `InvoicePaid` from the example below, in your Laravel application. Make sure to check out [Laravel's documentation](https://laravel.com/docs/master/notifications) for this process.

### Notification Example

```php
<?php
namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Multicaret\Notifications\Messages\UnifonicMessage;

class InvoicePaid extends Notification
{
   private $message;

    /**
     * Create a new notification instance.
     *
     * @param $message
     */
    public function __construct($message)
    {
        $this->message = $message;
    }
    
    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [
            'unifonic',
        ];
    }

    /**
     * Get the text message representation of the notification
     *
     * @param  mixed $notifiable
     *
     * @return UnifonicMessage
     */
    public function toUnifonic($notifiable)
    {
        return (new UnifonicMessage())
            ->content($this->message);
    }
}
```

Or pass the content you want directly into the constructor
````php
public function toUnifonic($notifiable)
{
    return new UnifonicMessage('Laravel notifications are awesome!');
}
````

### Sending Notifications
There are two methods to send a notification in Laravel:
#### Method 1
Using `notify()` function on any model that uses `Notifiable` trait.
to achieve this you have to feed it with the proper column to be used as the recipient number,
as shown in the following example, this function is placed within the User model (You might want to write it in different model in your case, just make sure to `use Notifiable`)  
````php
    /**
     * Route notifications for the Unifonic channel.
     *
     * @param  \Illuminate\Notifications\Notification $notification
     *
     * @return string
     */
    public function routeNotificationForUnifonic($notification)
    {
        return $this->phone; // where phone is the column within your, let's say, users table.
    }
````

#### Method 2
Using `route()` static function on Notification class.  
````php
Notification::route('unifonic', 'xxxxx')
                 ->notify(
                    new \App\Notifications\InvoicePaid('Laravel notifications are awesome!')
                 );
                 // where xxxxx is the phone number you want to sent to,
                 // i.e: 1xxxxxxx - NO NEED for _00_ or _+_ 
````





### Contributing
See the [CONTRIBUTING](CONTRIBUTING.md) guide.

### Changelog
Please see [CHANGELOG](CHANGELOG.md) for more information about what has changed recently.

ZfSnapHipChat
=============

HipChat module for Zend Framework 2

Module helps to use [HipChat](https://www.hipchat.com/) API and log messages to yours rooms!

The simplest usage
--------------
Add auth token (you can [create it here](https://inweb.hipchat.com/admin/api) - remember to set type `admin`) to your config:

```php
return array(
  'zf_snap_hip_chat' => array(
    'api' => array(
      'auth_token' => 'yourauthtoken',
    ),
  ),
);
```

And then get HipChat API object from Service Manager:

```php
$hipChat = $this->getServiceLocator()->get('hipchat');
```
That's all!
Module uses [official HipChat library for PHP](https://github.com/hipchat/hipchat-php).

How to install?
---------------

Via [composer.json](https://getcomposer.org/)
```json
{
  "require": {
    "snapshotpl/zf-snap-hip-chat": "1.*"
  }
}
```

and add module `ZfSnapHipChat` to `application.config.php`.

Use HipChat as logger
---------------------

To use HipChat as logger, you need to set room ID (or IDs) in config:

```php
return array(
  'zf_snap_hip_chat' => array(
    'logger' => array(
      'room_id' => array(100001, 100002),
    ),
  ),
);
```

Now you have access to log writer from service manager:

```php
$logger = new Zend\Log\Logger();
$hipChat = $this->getServiceLocator()->get('hipchat_log_writer');
$logger->addWriter($hipChat);
$logger->debug('HipChat debug message!');
```

...or logger:

```php
$logger = $this->getServiceLocator()->get('hipchat_logger');
$logger->debug('HipChat debug message!');
```

Options
-------

You can customize logger using config:

```php
return array(
  'zf_snap_hip_chat' => array(
    'api' => array(
      'auth_token' => null, // Required auth token
      'api_target' => HipChat::DEFAULT_TARGET, // Url address to HipChat API
      'api_version' => HipChat::VERSION_1, // Api version
    ),
    'logger' => array(
      'room_id' => null, // string, int or array with IDs, required for logger
      'from' => 'ZfSnapHipChat', // Author name for log messages in your rooms
      'notify' => false, // Enables sounds notify in HipChat
      'format' => HipChat::FORMAT_HTML, // Message format
    ),
  ),
);
```

TODO
----

* Console usage

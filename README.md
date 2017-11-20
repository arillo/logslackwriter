# SilverStripe LogSlackWriter

Publish SilverStripe errors and warnings into a Slack channel via an incoming webhook.

## Usage

Use Slack's 'Incoming WebHooks' app to add a webhook to post into the channel of your choice. Copy the URL that Slack generates and add it to your env variables:

```php
define('SS_SLACK_LOG_WEBHOOK', '{your-webhook-url}');
define('SS_SLACK_LOG_CHANNEL', '{your-webhook-channel}');
```


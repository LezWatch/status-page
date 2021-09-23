## LezWatch Status Page

A dynamic status page, showing uptime/downtime statistics.

This makes use of the [Uptime Robot](https://uptimerobot.com) API for monitoring.

Forked from [Steven Cotterill's Website Status Page](https://github.com/stevie-c91/Website-Status-page)

## Directions

Update your API Keys from Uptime Robot in the array on line 17 of 'monitoring.php' and you are good to go.

```
$api_keys = array(
	'site1' => 'm123456789-abc123def456ghi789jkl012',
	'site2' => 'm123456789-abc123def456ghi789jkl012',
	'site3' => 'm123456789-abc123def456ghi789jkl012',
	'site4'  > 'm123456789-abc123def456ghi789jkl012',
);
```

Those are the API keys that can only use the read-only GetMonitors API method for a given monitor. They can be safely shared and/or used in client-side code as the main API key won't be revealed.

## Updates

This is automagically updated when code is pushed to Production via Github Actions.

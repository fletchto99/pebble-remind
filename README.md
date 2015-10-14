# Remind

## About

Remind is a simple library to remind your users to give your app a heart. A day after the user installs your app they will receive a timeline pin reminding them to heart your app. 

##  Setup

Ensure your application is setup to use [Pebble Timeline](http://developer.getpebble.com/guides/timeline/timeline-enabling/)

Copy the contents of `lib/reminder.js` to the top of your `pebble-app-js.js` file. In your ready event call `Reminder.remind(<app name>)`

A `Reminder` Object accepts the following parameters

| Name                 | Type                                 | Argument   | Default                                              | Description                                                              |
| ----                 | :----:                               | :--------: | ---------                                            | -------------                                                            |
| `app`                | string                               | (required) |                                                      | The ID that represents the pin                                           |
| `message`            | string                               | (optional) | Please give %app% a heart if you like it! Thanks!    | The UTC Datetime of the event                                            |
| `time`               | PHP DateInterval formatted string    | (optional) | 1 Day                                                | The description of the values of the pin                                 |

Example:
```js
//Remind code here
Pebble.addEventListener('ready', function() {
    Reminder.remind({
        app: 'Demo', //Required
        message: 'Please like my awesome app :P', // Optional - A custom message to send your users when reminding them
        time: 'P1W2DT3H5M' //Optional - 1 week, 2 days, 3 hours and 5 minutes
    });
}
```

_Uses [PHPebbleTimeline](https://github.com/fletchto99/phpebbletimeline) to push the pins_
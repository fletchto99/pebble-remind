var Reminder = {};

Reminder.remind = function(params) {
    if (!params.app || typeof(params.app) !== 'string') {
        console.log('app is a required parameter, and must be a string!');
    } else if (!localStorage.getItem('reminder_sent')) {
        Pebble.getTimelineToken(function(watchtoken) {
            var request = new XMLHttpRequest();
            request.open('POST', 'https://fletchto99.com/other/pebble/reminder/web/api.php', true);
            request.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
            request.responseType = 'json';
            request.onload = function() {
                if (request.response.status == 0) {
                    console.log('Heart reminder sent!');
                    localStorage.setItem('reminder_sent', true);
                } else if(request.response.status == 1) {
                    console.log('Error setting heart reminder.')
                }
            };
            request.send(JSON.stringify({
                app:params.app,
                usertoken:watchtoken,
                message: params.message || '',
                time: params.time || ''
            }));
        }, function() {
            console.log('Error retrieving timeline token. Ensure timeline is enabled in your settings!')
        });
    } else {
        console.log('Reminder already sent!')
    }
};
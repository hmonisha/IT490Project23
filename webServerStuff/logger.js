function event_logger(event, message) {
    const fs = require('fs');
    const rabbitMQClient = require('rabbitmq-client');

    const fp = 'events.log';
    const logEntry = `[${new Date().toISOString()}] Event '${event}': ${message}\n`;

    fs.appendFileSync(fp, logEntry);

    const client = new rabbitMQClient();
    const req = {
        type: 'log',
        log_type: event,
        log_message: message
    };
    const response = client.send_request(req);
}

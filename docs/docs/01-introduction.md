# Introduction
LmcCors is a simple Laminas MVC module that helps you to deal with Cross-Origin Resource Sharing (CORS).

It allows to easily configure your Laminas MVC application so that it automatically builds HTTP responses that follow the CORS documentation.

## What is CORS ?

CORS is a mechanism that allows to perform cross-origin requests from your browser.

For instance, let's say that your website is hosted in the domain `http://example.com`.
By default, user agents won't be allowed to perform AJAX requests to another domain for security
reasons (for instance `http://funny-domain.com`).

With CORS, you can allow your server to reply to such requests.

You can find better documentation on how CORS works on the web:

* [Mozilla documentation about CORS](https://developer.mozilla.org/en-US/docs/HTTP/Access_control_CORS)
* [CORS server flowchart](http://www.html5rocks.com/static/images/cors_server_flowchart.png)

## Support

- File issues at https://github.com/LM-Commons/LmcCors/issues.
- Ask questions in the [LM-Commons gitter](https://gitter.im/Lm-Commons/community) chat.

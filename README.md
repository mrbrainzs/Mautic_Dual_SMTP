# Dual SMTP Bundle

This repository contains a Mautic plugin that switches to a secondary SMTP


When an email is sent, the plugin inspects the contact's `smtp` field:

- Value `2` switches the transport to the custom SMTP DSN configured for the


## Installation

1. Copy the `DualSmtpBundle` directory to your Mautic installation's `plugins/` folder.
2. Clear the cache with `php bin/console cache:clear`.
3. Add a contact custom field named `smtp` with values `1` or `2`.

## Usage

Creating or updating a contact's `smtp` custom field will determine which SMTP server is used when emails are sent to that contact.

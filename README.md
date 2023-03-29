# Post Samachar

Post Samachar is a WordPress plugin that sends the admin daily post details via email at 6:30 pm IST. Simply install the plugin and you'll start receiving emails every day. Currently, there is no customization available for email timing.

## Installation

1. Download the plugin as a .zip file.
2. Go to Plugins > Add New in your WordPress dashboard.
3. Click on "Upload Plugin" and select the .zip file.
4. Click "Install Now" and then "Activate Plugin."

## Usage

After installing the plugin, add the following lines to your wp-config.php file:

    define( 'SMTP_USER', 'dev-email@wpengine.local' );

    define( 'SMTP_HOST', 'localhost' );

    define( 'SMTP_FROM', 'dev-email@wpengine.local' );

    define( 'SMTP_NAME', 'admin' );

    define( 'SMTP_PORT', '587' );

    define( 'SMTP_SECURE', 'tls' );

    define( 'SMTP_AUTH', true );


You will need to replace the values with your own SMTP server settings. 

Additionally, you will need to add the following line to your task scheduler to ensure that WordPress's cron system runs regularly:

For Windows, add the following PowerShell script to your task scheduler:

    powershell "Invoke-WebRequest http://YOUR_SITE_URL/wp-cron.php"

## For Ubuntu or MacOS, refer to this documentation:

https://developer.wordpress.org/plugins/cron/hooking-wp-cron-into-the-system-task-scheduler/


## Update

Search for $Custom in files for custom code.

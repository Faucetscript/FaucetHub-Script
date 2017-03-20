# FaucetHub-Script
FaucetScript is a brand new faucet script made with simplicity and security in mind. Your user will claim and collect their satoshis on a site balance. They then can withdraw their balance, if they have at least the withdraw threshold (if set). 


# System Requirements

- Webserver
- PHP >= 5.5
- MySQL database

# How to install?

1. Download the files
2. Upload the files to your webserver (using FTP for instance)
3. Import the database.sql using PHPMyAdmin
4. Go to the faucet_settings table and set your reCaptcha keys (THIS IS MANDATORY, since you require a account to become a site admin)
4. Change includes/config.php accordingly with your MySQL credentials.
5. Go to http://www.yoursite.nl/ and register. After registration go back to PhpMyAdmin and in table faucet_user_list set admin = 1 at your user row.
6. Now go to http://www.yoursite.nl/index.php?route=admin/home and configure your faucet. Make sure you are logged in before browsing to mentioned page.
7. You're done. Good luck!

# Demo

This faucet script is used on:
- http://www.coinfaucet.space

If you want to have your faucet added to this list, contact bitcoinniels at bitcointalk.org

# Fee

To support my work, at each claim a small fee of up to 5 satoshi will be sent to me. If you really require this fee to be removed, contact us to get a quote on a paid version.
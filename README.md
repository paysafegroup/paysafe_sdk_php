# Paysafe PHP SDK

---

## Installation

### Windows

On Windows, you will be required set the following environment variable that points to a valid CA certificate on your system in order to perform the https operations:

    SSL_CERT_FILE

Alternatively, you can make a call in your code to the following static method using the path to your CA certificate:

    \Paysafe\PaysafeApiClient::setCACertPath(_PATH_TO_CERTIFICATE_);

This SDK requires PHP >= 5.3 and cURL to be installed.

This SDK requires that you can complete an SSL connection using cURL to the API endpoints from within your hosting environment . Any cURL errors returned will require you to complete connectivity troubleshooting within your hosting environment. See cURL error codes for assistance: http://curl.haxx.se/libcurl/c/libcurl-errors.html

## Usage

### Running Sample Code

Update the following file with your credentials and account number:

> /sample/config.php

#### PHP 5.3

Create a new virtual host in your local web server with the sample directory within your SDK directory as the webroot. Open your web browser and navigate to the URL specified in the virtual host configuration.

#### PHP 5.4+

In your command-line interface, navigate to the /sample directory inside of the SDK directory and type the following command:

    php -S localhost:8081
    
Open your web browser and navigate to the following URL: 

[http://localhost:8081](http://localhost:8081)
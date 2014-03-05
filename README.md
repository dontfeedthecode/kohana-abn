# ABN lookup module for Kohana 3.3.

This beta module takes advantage of ABR Web Services (http://abr.business.gov.au/Webservices.aspx) to request business information using an Australian ABN. To use this service you must have a GUID from ABR which you can register for at https://abr.business.gov.au/RegisterAgreement.aspx - this usually takes a day or two to receive.

## Requirements
This module uses [NuSOAP] (http://sourceforge.net/projects/nusoap/) to connect to the ABR Web Services, version 0.9.5 comes bundled with this module in the vendor folder.

## Configuration

First you must enable the kohana-abn module in your `application/bootstrap.php` file, finally update the `$guid` property in `classes/Controller/Abn.php`.

## Usage

Once the module is enabled you can simply visit `yoursite.com/abn/abn_number`, it will return the business entity information (if available) in JSON format.
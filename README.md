# ABN lookup module for Kohana 3.3.

This beta module takes advantage of ABR Web Services (http://abr.business.gov.au/Webservices.aspx) to request business information using an Australian ABN. To use this service you must have a GUID from ABR which you can register for at https://abr.business.gov.au/RegisterAgreement.aspx - this usually takes a day or two to receive.

## Configuration

First you must enable the kohana-abn module in your `application/bootstrap.php` file, finally update the $guid property in the Abn.php controller.

## Usage

Once the module is enabled you can simply visit `yoursite.com/abn/abn_number`, it will return the business entity information (if available) in JSON format.
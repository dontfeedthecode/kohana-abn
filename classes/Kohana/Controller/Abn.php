<?php defined('SYSPATH') or die('No direct script access.');

/*
 * @package		Kohana ABN Lookup
 * @author      Tim Sheehan
 * @copyright   (c) 2014-2015 Tim Sheehan
 * @website		https://github.com/dontfeedthecode/kohana_abn
 * @license		http://opensource.org/licenses/MIT
 *
 */
class Kohana_Controller_Abn extends Controller {
	
    /**
     * nuSOAP Client
     *
     * @var soapclient
     */
	protected $_client;
	
    /**
     * ABR GUID 
	 * https://abr.business.gov.au/RegisterAgreement.aspx
	 * Required to use ABR Web Services
     *
     * @var string
     */
	public $guid = '';
	
    /**
     * Results array from ABR
	 * https://abr.business.gov.au/Downloads/AbnLookupSchema.zip
     *
     * @var array
     */
	public $result = array();
	
    /**
     * Option proxy connection information
     *
     * @var mixed
     */
	public $proxy_host = '';
	public $proxy_port = '';
	public $proxy_username = '';
	public $proxy_password = '';
	
	/**
	 * ABN Lookup Index Action
	 * 
	 * @access	public
	 * @todo    proper error catching
	 */
	public function action_index()
	{
		// Quick check for missing GUID
		if($this->guid == '')
			die('You must set your ABR GUID, if you do not have one visit https://abr.business.gov.au/RegisterAgreement.aspx');

		// Check for ABN in URL parameters
		if($abn = $this->request->param('abn')) {
			
			// Load nusoap
			require Kohana::find_file('vendor', 'nusoap-0.9.5/lib/nusoap');
			
			// Set up ABR client
			$this->_client = new soapclient(
				'http://abr.business.gov.au/abrxmlsearch/ABRXMLSearch.asmx?WSDL',
				true,
				$this->proxy_host, 
				$this->proxy_port, 
				$this->proxy_username,
				$this->proxy_password
			);
			
			// Check for client errors
			$this->_checkClientError();
			
			// Retrieve ABN search results
			$this->result = $this->_client->call(
				'ABRSearchByABN',
				array(
					'parameters' => array(
						'searchString' => $abn,
						'includeHistoricalDetails' => 'N',
						'authenticationGuid' => $this->guid
					)
				), '', '', false, true
			);
			
			// Check for result errors
			$this->_checkClientError();
			
			// Check for client faults, again...
			if($this->_client->fault) {
				die('There was a fault');
			}
			else {
				// If all is good, return the JSON formatted response
				$this->response->headers('Content-Type','application/json');
				$this->response->body(
					json_encode(
						array($this->result['ABRPayloadSearchResults']['response']['businessEntity'])
					)
				);
			}
		}
		// Shouldn't happen
		else die('No ABN detected.');
	}

	/**
	 * Check for client error
	 * 
	 * @access	protected
	 */
	protected function _checkClientError()
	{
		if($err = $this->_client->getError()) {
			die(print_r($err));
		}
	}
}
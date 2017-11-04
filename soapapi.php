<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
# need to include
require('vendor/zendframework/zend-server/src/Client.php');
require('vendor/zendframework/zend-soap/src/Client.php');
require('vendor/zendframework/zend-soap/src/Client/Common.php');

# Need to create user from admin and assign them role. Goto Admin menu System->Alluser over there create a user. Once the user is created then goto System->user role and assign role over there.

$request = new \SoapClient("http://127.0.0.1/magento2.2/index.php/soap/?wsdl&services=integrationAdminTokenServiceV1", array("soap_version" => SOAP_1_2));

# Need to use 'integrationAdminTokenServiceV1' service for getting token.

$token = $request->integrationAdminTokenServiceV1CreateAdminAccessToken(array("username"=>"admin", "password"=>"java@123"));

# In 'integrationAdminTokenServiceV1CreateAdminAccessToken' function we need to pass username and pass that we have assign to user while creating from admin.

$token =  (array) $token;

$wsdlurl = 'http://127.0.0.1/magento2.2/index.php/soap/default?wsdl&services=customerCustomerRepositoryV1';

#we need to create wsdlurl so that we can call the fucntion customerCustomerRepositoryV1GetById. For getting customer info we have to use service 'customerCustomerRepositoryV1' which is passed in wsdlurl.

$opts = ['http' => ['header' => "Authorization: Bearer ".$token['result']]];
$context = stream_context_create($opts);
$soapClient = new \Zend\Soap\Client($wsdlurl);
$soapClient->setSoapVersion(SOAP_1_2);
$soapClient->setStreamContext($context);

# pass customer id that we want to access information

$result = $soapClient->customerCustomerRepositoryV1GetById(array('customerId' => 1));

echo "<pre>"; print_r($result); 
?>
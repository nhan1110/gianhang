<?php
require __DIR__ . '/bootstrap.php';
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use PayPal\Api\ExecutePayment;
use PayPal\Api\PaymentExecution;

class Paypal
{
	private $clientId;
    private $clientSecret;
	private $apiContext;
	private $cart  = array();
	public function Paypal($cart = null,$clientId = null,$clientSecret = null) {
		$this->cart = $cart; 
		$this->clientId = $clientId;
		$this->clientSecret = $clientSecret;
		$this->apiContext = $this->getApiContext($this->clientId,$this->clientSecret);
	}
	private function getApiContext($clientId, $clientSecret) {
	    $apiContext = new ApiContext(new OAuthTokenCredential($clientId,$clientSecret));
	    $apiContext->setConfig(
	        array(
	            'mode' => 'sandbox',
	            'log.LogEnabled' => true,
	            'log.FileName' => '../PayPal.log',
	            'log.LogLevel' => 'DEBUG',
	            'cache.enabled' => true,
	            //'service.EndPoint'=> "https://test-api.sandbox.paypal.com"  
	        )
	    );
	    return $apiContext;
	}
	public function CreatePaymentUsingPayPal($return_url="",$cancel_url = ""){
		$total = $this->cart["Number_Month"] * $this->cart["Price_One_Month"];
		$payer = new Payer();
		$payer->setPaymentMethod("paypal");
		$item1 = new Item();
		$item1->setName('Nâng cấp tài khoản ' .$this->cart["Number_Month"] . ' tháng')
		    ->setCurrency('USD')
		    ->setQuantity(1)
		    ->setSku("123123") 
		    ->setPrice($total);
		$itemList = new ItemList();
		$itemList->setItems(array($item1));
		$details = new Details();
		$details->setShipping(0)->setTax(0)->setSubtotal($total);
		$amount = new Amount();
		$amount->setCurrency("USD")->setTotal($total)->setDetails($details);
		$transaction = new Transaction();
		$transaction->setAmount($amount)
		    ->setItemList($itemList)
		    ->setDescription($this->cart["Number_Month"])
		    ->setInvoiceNumber(uniqid());
		$baseUrl = getBaseUrl();
		$redirectUrls = new RedirectUrls();
		$redirectUrls->setReturnUrl($return_url)->setCancelUrl($cancel_url);
		$payment = new Payment();
		$payment->setIntent("sale")
		    ->setPayer($payer)
		    ->setRedirectUrls($redirectUrls)
		    ->setTransactions(array($transaction));
		$request = clone $payment;
		try {
		    $payment->create($this->apiContext);
		} catch (Exception $ex) { 
		 	die($ex);
		}
		$data["approvalUrl"] = $payment->getApprovalLink();
		$data["payment"] = json_decode($payment,true);
		return $data;
	}
	public function ExecutePayment() {
	    if (isset($_GET['success']) && $_GET['success'] == 'true') {
	    	$total = $this->cart["Number_Month"] * $this->cart["Price_One_Month"];
		    $paymentId = $_GET['paymentId'];
		    $payment = Payment::get($paymentId, $this->apiContext);
		    $execution = new PaymentExecution();
		    $execution->setPayerId($_GET['PayerID']);
		    $transaction = new Transaction();
		    $amount = new Amount();
		    $details = new Details();
		    $details->setShipping(0)
		        ->setTax(0)
		        ->setSubtotal($total);
		    $amount->setCurrency('USD');
		    $amount->setTotal($total);
		    $amount->setDetails($details);
		    $transaction->setAmount($amount);
		    $execution->addTransaction($transaction);
		    try {
		        $result = $payment->execute($execution, $this->apiContext);
		        try {
		            $payment = Payment::get($paymentId, $this->apiContext);
		        } catch (Exception $ex) { 
		            return $ex;
		        }
		    } catch (Exception $ex) {
		        return $ex;
		    }
		    if($payment != null){
		    	return json_decode($payment,true);
		    }else{
		    	return array();
		    }
		    

		} else {
		    return "error";
		}
	}
	
}
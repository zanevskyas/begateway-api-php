<?php
require_once __DIR__ . '/../lib/beGateway.php';
require_once __DIR__ . '/test_shop_data.php';

beGateway_Logger::getInstance()->setLogLevel(beGateway_Logger::DEBUG);

$transaction = new beGateway_Authorization;

$amount = rand(100, 10000);

$transaction->money->setAmount($amount);
$transaction->money->setCurrency('EUR');
$transaction->setDescription('test');
$transaction->setTrackingId('my_custom_variable');

$transaction->card->setCardNumber('4200000000000000');
$transaction->card->setCardHolder('John Doe');
$transaction->card->setCardExpMonth(1);
$transaction->card->setCardExpYear(2030);
$transaction->card->setCardCvc('123');

$transaction->customer->setFirstName('John');
$transaction->customer->setLastName('Doe');
$transaction->customer->setCountry('LV');
$transaction->customer->setAddress('Demo str 12');
$transaction->customer->setCity('Riga');
$transaction->customer->setZip('LV-1082');
$transaction->customer->setIp('127.0.0.1');
$transaction->customer->setEmail('john@example.com');

$response = $transaction->submit();

print("Transaction message: " . $response->getMessage() . PHP_EOL);
print("Transaction status: " . $response->getStatus(). PHP_EOL);

if ($response->isSuccess() ) {
  print("Transaction UID: " . $response->getUid() . PHP_EOL);
  print("Trying to Void transaction " . $response->getUid() . PHP_EOL);

  $void = new beGateway_Void;
  $void->setParentUid($response->getUid());
  $void->money->setAmount($transaction->money->getAmount());

  $void_response = $void->submit();

  if ($void_response->isSuccess()) {
    print("Voided successfuly. Void transaction UID " . $void_response->getUid() . PHP_EOL);
  }else{
    print("Problem to void" . PHP_EOL);
    print("Void message: " . $void_response->getMessage() . PHP_EOL);
  }
}
?>

<?php

    $paysafeApiKeyId = 'your-key-id';
    $paysafeApiKeySecret = 'your-key-secret';
    $paysafeAccountNumber = 'your-account-number';
// The currencyCode should match the currency of your Paysafe account.
// The currencyBaseUnitsMultipler should in turn match the currencyCode.
// Since the API accepts only integer values, the currencyBaseUnitMultiplier is used convert the decimal amount into the accepted base units integer value.
    $currencyCode = 'your-account-currency-code'; // for example: CAD
    $currencyBaseUnitsMultiplier = 'currency-base-units-multiplier'; // for example: 100

    require_once('../source/paysafe.php');
    
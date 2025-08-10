<?php

namespace App\Services;

class RobokassaService
{
    protected $login;
    protected $password1;
    protected $password2;
    protected $testMode;
    
    public function __construct()
    {
        $this->login = config('services.robokassa.login');
        $this->password1 = config('services.robokassa.password1');
        $this->password2 = config('services.robokassa.password2');
        $this->testMode = config('services.robokassa.test_mode');
    }
    
    public function generatePaymentUrl($amount, $invId, $description = 'Платеж системы Textile', $email = null)
    {
        $signature = md5("{$this->login}:{$amount}:{$invId}:{$this->password1}");
        
        $params = [
            'MerchantLogin' => $this->login,
            'OutSum' => $amount,
            'InvId' => $invId,
            'Description' => $description,
            'SignatureValue' => $signature,
            'IsTest' => $this->testMode ? 1 : 0,
        ];
        
        if ($email) {
            $params['Email'] = $email;
        }
        
        return 'https://auth.robokassa.ru/Merchant/Index.aspx?' . http_build_query($params);
    }
    
    public function validateSuccessSignature($outSum, $invId, $signature)
    {
        $expected = strtoupper(md5("{$outSum}:{$invId}:{$this->password1}"));
        return strtoupper($signature) === $expected;
    }
    
    public function validateResultSignature($outSum, $invId, $signature)
    {
        $expected = strtoupper(md5("{$outSum}:{$invId}:{$this->password2}"));
        return strtoupper($signature) === $expected;
    }
}
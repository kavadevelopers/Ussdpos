<?php
class Stripelib{ 
    var $CI; 
    var $api_error; 
     
    public function __construct(){ 
        $this->api_error = ''; 
        $this->CI =& get_instance();
        require APPPATH .'third_party/stripe-php/init.php'; 
        $setting = get_setting();
        \Stripe\Stripe::setApiKey($setting['stripe_sk']); 
    } 

    public function chargeClient($amount,$customerId,$source,$currency = 'USD')
    {
        try { 
            $charge = \Stripe\Charge::create([
                'amount'        =>      $amount * 100,
                'currency'      =>      $currency,
                'customer'      =>      $customerId,
                'source'        =>      $source,
                'description'   =>      'Payment For Order',   
            ]); 
            return $charge; 
        }catch(Exception $e) { 
            $this->api_error = $e->getMessage(); 
            return false; 
        } 
    }

    public function changeDefaultCard($customerId,$cardId)
    {
        try { 
            $card = \Stripe\Customer::update(
                $customerId,
                [
                    'invoice_settings' => [
                        'default_payment_method' => $cardId
                    ]
                ]
            ); 
            return $card; 
        }catch(Exception $e) { 
            $this->api_error = $e->getMessage(); 
            return false; 
        } 
    }

    public function deleteCard($customerId,$cardId)
    {
        try { 
            $card = \Stripe\Customer::deleteSource(
                $customerId,
                $cardId,
                []
            ); 
            return $card; 
        }catch(Exception $e) { 
            $this->api_error = $e->getMessage(); 
            return false; 
        } 
    }

    public function getCards($customerId)
    {
        try { 
            $cards = \Stripe\Customer::allSources(
                $customerId,
                ['object' => 'card']
            ); 
            return $cards; 
        }catch(Exception $e) { 
            $this->api_error = $e->getMessage(); 
            return false; 
        } 
    }

    public function assignCard($customerId,$cardToken)
    {
        try { 
            $card = \Stripe\Customer::createSource(
                $customerId,
                ['source' => $cardToken]
            ); 
            return $card; 
        }catch(Exception $e) { 
            $this->api_error = $e->getMessage(); 
            return false; 
        } 
    }

    public function createCardToken($number,$month,$year,$cvc)
    {
        try { 
            $token = \Stripe\Token::Create([
                'card' => [
                    'number'    => $number,
                    'exp_month' => $month,
                    'exp_year'  => $year,
                    'cvc'       => $cvc,
                ],
            ]); 
            return $token; 
        }catch(Exception $e) { 
            $this->api_error = $e->getMessage(); 
            return false; 
        } 
    }

    public function createCustomer($name,$email,$street,$post,$city,$state,$country)
    {
        try { 
            $customer = \Stripe\Customer::create(array( 
                'email' => $email,
                'name'  => $name,
                'address' => [
                    'line1'         => $street,
                    'city'          => $city,
                    'state'         => $state,
                    'country'       => "US"
                ],
                'shipping' => [
                    'name'  => $name,
                    'address'   => [
                        'line1'         => $street,
                        'city'          => $city,
                        'state'         => $state,
                        'country'       => "US"
                    ] 
                ]
            )); 
            return $customer; 
        }catch(Exception $e) { 
            $this->api_error = $e->getMessage(); 
            return false; 
        } 
    }
     
    public function getCustomer($customerId)
    {
        try { 
            $customer = \Stripe\Customer::Retrieve(
                $customerId,
                []
            ); 
            return $customer; 
        }catch(Exception $e) { 
            $this->api_error = $e->getMessage(); 
            return false; 
        } 
    }
}
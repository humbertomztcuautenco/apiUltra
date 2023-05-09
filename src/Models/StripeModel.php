<?php
namespace App\Models;

use App\Models\BdModel,
    App\Lib\Response,
    App\Lib\Codigos,
    App\Lib\HasPass;


use Stripe\Charge;
use Stripe\PaymentMethod;
use Stripe\PaymentIntent;
use Stripe\Exception\ApiErrorException;
use Stripe\StripeClient;
use Stripe\Stripe;



    class StripeModel{
        private $db=null;
        private $response;

        public function __construct(){
            $db = new DbModel();
            $this->db=$db->sqlPDO;
            $this->response=new Response();
        }


        public function crearCargo($parametros) {
            //el dinero llega a mi cuenta
            Stripe::setApiKey($_ENV['CLAVE_S']);

            $stripe = new StripeClient($_ENV['CLAVE_S']);

            try {
                $charge = $stripe->charges->create($parametros);
                return [
                    'status' => 'success',
                    'message' => 'Charge created successfully.',
                    'charge' => $charge
                    
                ];
                
            } catch (ApiErrorException $e) {
                return [
                    'status' => 'error',
                    'message' => 'Error creating charge.'
                ];
            }
        }

       

        public function cargoCuenta($parametros) {
            //para hacer pago de un cliente a un socio
            Stripe::setApiKey($_ENV['CLAVE_S']);

            $stripe = new StripeClient($_ENV['CLAVE_S']);
            try {
                $charge = $stripe->charges->create([
                    'source' => $parametros->source, 
                    'description' => $parametros -> description,
                    'application_fee_amount' => $parametros->application_fee_amount,
                    'transfer_data' => [
                        'destination' => $parametros->destination,
                        'on_behalf_of' => $parametros->destination
                    ],
                    'amount' => $parametros->amount,
                    'currency' => $parametros->currency,
                    'customer' => $parametros -> customer
                    ]);
                    
                return [
                    'status' => 'success',
                    'message' => 'Charge created successfully.',
                    'charge' => $charge
                ];
            } catch (ApiErrorException $e) {
                return [
                    'status' => 'error',
                    'message' => 'Error creating charge.'
                ];
            }
        }


        public function pago($parametros){
            //para hacer un pago por cliente
            Stripe::setApiKey($_ENV['CLAVE_S']);

            $stripe = new StripeClient($_ENV['CLAVE_S']);

            $customer = $parametros->customer;
            $amount = $parametros->amount;
            $currency = $parametros->currency;
            $description = $parametros-> description;
            $source = $parametros->source;
            $email=$parametros->email;

                

                try {
                    // Obtener el objeto Customer desde Stripe
        
                    // Hacer el cargo al método de pago del cliente
                    $charge = Charge::create([
                        'customer' => $customer,
                        'source' => $source, 
                        'description' => $description,
                        'amount' => $amount,
                        'currency' => $currency
                    ]);
        
                    return [
                        'status' => 'success',
                        'message' => 'Charge created successfully.',
                        'charge' => $charge,
                        true
                    ];

                } catch (ApiErrorException $e) {
                    return [
                        'status' => 'error',
                        'message' => 'Error creating charge.'
                    ];
                }

            
        }

        public function crearCustomer($parametros){

           
            try{
                Stripe::setApiKey($_ENV['CLAVE_S']);
                $stripe = new StripeClient($_ENV['CLAVE_S']);

                $customer = $stripe->customers->create([
                    'email' => $parametros-> email,
                    'name' => $parametros -> name,
                    'description' => $parametros -> description,
                    'metadata' => ['code' => $parametros -> customerCode]
                ]);

                return [
                    'status' => 'success',
                    'message' => 'Charge created successfully.',
                    'customer' => $customer,
                    true
                ];

            } catch (ApiErrorException $e) {
                return [
                    'status' => 'error',
                    'message' => 'Error creando cliente.'
                ];
            }
            

        }

        public function metodoPago($parametros){
            Stripe::setApiKey($_ENV['CLAVE_S']);
            $stripe = new StripeClient($_ENV['CLAVE_S']);
            try{
                


                $payM = PaymentMethod::create([
                    'type' => 'card',
                    'card' => [
                        'number' => $parametros->number,
                        'exp_month' => $parametros->month,
                        'exp_year' => $parametros-> year,
                        'cvc' => $parametros->cvc]
                ]); 
            
                    $paymentMethod = PaymentMethod::retrieve($payM->id);
                    $paymentMethod->attach(['customer' => $customer=$parametros->customer]);
                
                  

                return [
                    'status' => 'success',
                    'message' => 'Metodo de pago confirmado',
                    'metodo de pago' => $paymentMethod
                ];
            }  catch (ApiErrorException $e) {
                return [
                    'status' => 'error',
                    'message' => 'Error creando metodo de pago.'
                ];
            }
        }

        public function crearSocio($parametros){
            Stripe::setApiKey($_ENV['CLAVE_S']);
            $stripe = new StripeClient($_ENV['CLAVE_S']);

            try{
                $crear= $stripe->accounts->create([
                    
                ]);

            }catch(ApiErrorException $e){
                return [
                    'status' => 'error',
                    'message' => 'Error creando cliente.'
                ];
            }


            

        }

        /*public function payment ($parametros){

            $stripe = new StripeClient($_ENV['CLAVE_S']);
            Stripe::setApiKey($_ENV['CLAVE_S']);

            try{
                 $payment_intent = PaymentIntent::create([
                    'payment_method'=> $parametros -> paymethod,
                    'description' => $parametros -> description,
                    'amount' => $parametros->amount,
                    'currency' => $parametros-> currency,
                    'customer' => $parametros -> customer,

                    'application_fee_amount' => $parametros->fee_amount],
                        
                    [
                    'stripe_account' => $parametros->destination,
                    ]);

                    $payment_intent->confirm();


                return [
                    'status' => 'success',
                    'message' => 'Charge created successfully.',
                    'payment' => $payment_intent,
                    true
                ];

            }catch (ApiErrorException $e) {
                return [
                    'status' => 'error',
                    'message' => 'Error creating charge.'
                ];
            }
           
        }*/


        /*public function payment($parametros) {
            //para hacer pago de un cliente a un socio
            Stripe::setApiKey($_ENV['CLAVE_S']);

            $stripe = new StripeClient($_ENV['CLAVE_S']);
            try {
                //$stripeFee = round($parametros->amount * 0.029 + 30);
                $charge = $stripe->charges->create([
                    'source' => $parametros->source, 
                    'description' => $parametros -> description,
                    'application_fee_amount' =>$parametros->fee_amount, //$stripeFee,
                    'destination' => [
                        'account' => $parametros->destination,
                        'on_behalf_of' => $parametros->on_behalf_of
                      ],
                      
                    'amount' => $parametros->amount,
                    'currency' => $parametros->currency,
                    'customer' => $parametros -> customer
                    ]);

              
                    
                return [
                    'status' => 'success',
                    'message' => 'Charge created successfully.',
                    'charge' => $charge
                ];
            } catch (ApiErrorException $e) {
                return [
                    'status' => 'error',
                    'message' => 'Error creating charge.'
                ];
            }
        }*/

        function createSetupIntent($customer_id, $connect_id) {
            $stripe = new StripeClient($_ENV['CLAVE_S']);
            $setupIntent = $stripe->setupIntents->create([
              'payment_method_types' => ['card'],
              'customer' => $customer_id, // ID del customer en la plataforma
              'on_behalf_of' => $connect_id // ID de la cuenta Connect
            ]);
            return $setupIntent;
          }
          
          function createPaymentMethod($customer_id, $connect_id) {
            $setupIntent = self::createSetupIntent($customer_id, $connect_id);
            $stripe = new StripeClient($_ENV['CLAVE_S']);
            $paymentMethod = $stripe->paymentMethods->create([
              'type' => 'card',
              'card' => [
                'number' => '4242424242424242',
                'exp_month' => 10,
                'exp_year' => 2024,
                'cvc' => '314'
              ],
              'customer' => $customer_id, // ID del customer en la plataforma
              'setup_intent' => $setupIntent->id
            ]);
            return $paymentMethod;
          }
          
          function attachPaymentMethodToConnect($customer_id, $connect_id) {
            $paymentMethod = self::createPaymentMethod($customer_id, $connect_id);
            $stripe = new StripeClient($_ENV['CLAVE_S']);
            $stripe->paymentMethods->attach(
              $paymentMethod->id,
              ['customer' => null],
              ['stripe_account' => $connect_id]
            );
            return $paymentMethod->id;
          }
          
          function createPaymentIntentOnConnect($parametros) {
            $customer_id=$parametros->customer;
            $connect_id=$parametros->connect;
            $idPayment= self::attachPaymentMethodToConnect($customer_id, $connect_id);
            $connectStripe = new StripeClient($_ENV['CLAVE_S']);
            $connectStripe->paymentIntents->create([
              'payment_method' => $idPayment,
              'amount' => $parametros->amount,
              'currency' => $parametros->currency
            ]);
          }
    }
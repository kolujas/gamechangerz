<?php
    namespace App\Models;

    use Illuminate\Http\Request;
    use MercadoPago\Item;
    use MercadoPago\MerchantOrder;
    use MercadoPago\Payer;
    use MercadoPago\Payment;
    use MercadoPago\Preference;
    use MercadoPago\SDK;

    class MercadoPago {
        public $preference;

        /**
         * * Creates an instance of MercadoPago.
         * @param array $attributes
         */
        public function __construct (array $attributes = array()) {
            parent::__construct($attributes);

            // * Set the MercadoPago access token
            SDK::setAccessToken(config("services.mercadopago.token"));

            // * Create a Preference
            $this->preference = new Preference();
        }

        static public function createPreference ($data) {
            $instance = new this();

            // * Set the Preference Item
            $item = new Item();
            $item->id = $data->id;
            $item->title = $data->title;
            $item->quantity = 1;
            $item->currency_id = 'ARS';
            $item->unit_price = $data->price;

            $instance->preference->items = [$item];

            // * Set the Preference URLs
            $instance->preference->back_urls = [
                "success" => route('lesson.checkout.status', [
                    'id_lesson' => $data->id,
                    'status' => 2,
                ]),
                "pending" => route('lesson.checkout.status', [
                    'id_lesson' => $data->id,
                    'status' => 1,
                ]),
                "failure" => route('lesson.checkout.status', [
                    'id_lesson' => $data->id,
                    'status' => 0,
                ]),
            ];
            $instance->preference->auto_return = "approved";

            // * Save & send the Preference init point
            $instance->preference->save();
            return $instance->preference->init_point;
        }

        static public function getDataID ($id) {
            // * Set the MercadoPago access token
            SDK::setAccessToken(config("services.mercadopago.token"));

            // * Get the Merchant order
            $merchant_order = null;
            switch ($topic) {
                case "payment":
                    $payment = Payment::find_by_id($id);
                    // Get the payment and the corresponding merchant_order reported by the IPN.
                    $merchant_order = MerchantOrder::find_by_id($payment->order->id);
                    break;
                case "merchant_order":
                    $merchant_order = MerchantOrder::find_by_id($id);
                    break;
            }

            // * Set the paid amount
            $paid_amount = 0;
            foreach ($merchant_order->payments as $payment) {
                if ($payment['status'] == 'approved') {
                    $paid_amount += $payment['transaction_amount'];
                }
            }

            // * If the payment's transaction amount is tinier than the merchant_order's amount you can release your items
            if ($paid_amount < $merchant_order->total_amount) {
                // * Not paid yet. Do not release your item
                return 500;
            }
            
            if (count($merchant_order->shipments) > 0) { // ? The Merchant order has shipments
                if ($merchant_order->shipments[0]->status == "ready_to_ship") {
                    // * Totally paid. Print the label and release your item
                    $response = Http::get("https://api.mercadopago.com/v1/payments/$id?access_token=" . config('services.mercadopago.token'));
                }
            } else { // ? The merchant_order don't has any shipments
                // * Totally paid. Release your item
                $response = Http::get("https://api.mercadopago.com/v1/payments/$id?access_token=" . config('services.mercadopago.token'));
            }
            
            // * Check the response status
            $response = json_decode($response);
            if ($response->status === 'approved') {
                // * Return the data id
            }

            // ! Throw an error
        }
    }
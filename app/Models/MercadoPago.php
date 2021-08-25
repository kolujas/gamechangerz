<?php
    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Http\Request;
    use MercadoPago\Item;
    use MercadoPago\MerchantOrder;
    use MercadoPago\Payer;
    use MercadoPago\Payment;
    use MercadoPago\Preference;
    use MercadoPago\SDK;

    class MercadoPago extends Model {
        /**
         * * Creates an instance of MercadoPago.
         * @param array $attributes
         */
        public function __construct (array $attributes = []) {
            parent::__construct();

            dd($attributes["access_token"]);

            // * Set the MercadoPago access token
            SDK::setAccessToken($attributes["access_token"]);
        }

        /**
         * * Set the MercadoPago Items.
         * @param array $array
         */
        public function items (array $array = []) {
            // * Create a array
            $items = [];

            // * Loop the array
            foreach ($array as $data) {
                // * Create a new Item
                $item = new Item();
                $item->id = $data->id;
                $item->title = $data->title;
                $item->quantity = 1;
                $item->currency_id = "ARS";
                $item->unit_price = $data->price;
                $items[] = $item;
            }
            
            // * Set the Items
            $this->items = $items;
        }

        /**
         * * Set the MercadoPago Merchant order
         * @param string $id_payment
         */
        public function merchant_order (string $id_order) {
            // * Get the payment and the corresponding merchant_order reported by the IPN.
			$this->merchant_order = MerchantOrder::find_by_id($id_order);
        }

        /**
         * * Set the MercadoPago Payment
         * @param string $id_payment
         */
        public function payment (string $id_payment) {
            // * Set the Payment
            $this->payment = Payment::find_by_id($id_payment);

            // * Get the payment and the corresponding merchant_order reported by the IPN.
            $this->merchant_order($this->payment->order->id);
        }

        /**
         * * Set the MercadoPago Preference.
         * @param mixed $data
         */
        public function preference ($data) {
            // * Create the Preference
            $this->preference = new Preference();

            // * Set the Preference Items
            $this->preference->items = $this->items;

            // * Set the Preference URL
            $this->preference->back_urls = [
                "success" => route("checkout.status", [
                    "id_lesson" => $data->id,
                    "id_status" => 2,
                ]),
                "pending" => route("checkout.status", [
                    "id_lesson" => $data->id,
                    "id_status" => 1,
                ]),
                "failure" => route("checkout.status", [
                    "id_lesson" => $data->id,
                    "id_status" => 0,
                ]),
            ];
            $this->preference->auto_return = "approved";

            // ? Set the Preference fee
            // $this->preference->application_fee = 20;

            // * Set the Preference external ID
            $this->preference->external_reference = $data->id;

            // * Set the Preference webhook route
            $this->preference->notification_url = route("checkout.notification", [
                "id_lesson" => $data->id,
                "type" => "mercadopago",
            ]);

            // * Save the Preference
            $this->preference->save();
        }
    }
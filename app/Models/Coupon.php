<?php
     namespace App\Models;

     use App\Models\Lesson;
     use Cviebrock\EloquentSluggable\Sluggable;
     use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
     use Illuminate\Database\Eloquent\Model;

     class Coupon extends Model {
          use Sluggable, SluggableScopeHelpers;

          /**
           * * Table name.
           * @var string
           */
          protected $table = "coupons";
          
          /**
           * * Table primary key name.
           * @var string
           */
          protected $primaryKey = "id_coupon";

          /**
           * * The attributes that are mass assignable.
           * @var array
           */
          protected $fillable = [
               "name", "limit", "slug", "type",
          ];

          /**
           * * Set the Coupon info. 
           * @param array [$columns]
           */
          public function and (array $columns = []) {
              foreach ($columns as $column) {
                  if (!is_array($column)) {
                      switch ($column) {
                          case "type":
                              $this->type();
                              break;
                          case "used":
                              $this->used();
                              break;
                      }
                      continue;
                  }
                  switch ($column[0]) {
                      default:
                          break;
                  }
              }
          }
        
          /**
           * * The Sluggable configuration for the Model.
           * @return array
           */
          public function sluggable (): array {
              return [
                  "slug" => [
                      "source"	=> "name",
                      "onUpdate"	=> true,
                  ]
              ];
          }

          /**
           * * Set the Coupon type.
           */
          public function type () {
              $this->type = Coupon::parse($this->type);
          }

          /**
           * * Set the Coupon used.
           */
          public function used () {
               $this->used = 0;
               foreach (Lesson::all() as $lesson) {
                    if ($lesson->id_coupon === $this->id_coupon) {
                         $this->used++;
                    }
               }
          }

          /**
           * * Get a Coupon by the name.
           * @param string $name
           * @return Coupon
           */
          static public function findByName (string $name = "") {
              $coupon = Coupon::where("name", "=", $name)->first();
  
              return $coupon;
          }

          /**
           * * Parse the Coupon type object.
           * @param string [$type] Example: "[{\"id_type\":1,\"value\":400}]"
           * @return Coupon[]
           */
          static public function parse (string $type = '') {
               $type = json_decode($type);

               $type->key = $type->id_type === 1 ? "%" : "$";
  
              return $type;
          }
  
          /**
           * * Stringify a Coupon type object.
           * @param object [$data] Example: ["type"=>"%","value"=>400]
           * @return string
           */
          static public function stringify (object $data) {  
              return json_encode([
                   "id_type" => $data->type === "%" ? 1 : 2,
                   "value" => $data->value
              ]);
          }
          
          /** @var array Validation rules & messages. */
          static $validation = [
               "create" => [
                    "rules" => [
                         "name" => "required|unique:coupons",
                         "value" => "required",
                    ], "messages" => [
                         "es" => [
                              "name.required" => "El nombre es obligatorio.",
                              "name.unique" => "Ese nombre ya esta en uso.",
                              "value.required" => "El valor es obligatorio.",
               ],],], "delete" => [
                    "rules" => [
                         "message" => "required|regex:/^BORRAR$/",
                    ], "messages" => [
                         "es" => [
                              "message.required" => "El mensaje es obligatorio.",
                              "message.regex" => "El mensaje debe decir BORRAR.",
               ],],], "update" => [
                    "rules" => [
                         "name" => "required|unique:coupons,name,{id_coupon},id_coupon",
                         "value" => "required",
                    ], "messages" => [
                         "es" => [
                              "name.required" => "El nombre es obligatorio.",
                              "name.unique" => "Ese nombre ya esta en uso.",
                              "value.required" => "El valor es obligatorio.",
          ],],],];
     }
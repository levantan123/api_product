<?php

namespace App\Models;

use App\Traits\SoftDelete\SoftDeletes;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;
use MongoDB\BSON\ObjectId;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Order extends Model implements AuthenticatableContract, AuthorizableContract, JWTSubject
{
    protected $collection = 'Orders';
    use Authenticatable, Authorizable, HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_id', 'amount', 'user_id'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function getOrder($order_id)
    {
        $options = [
            'typeMap' => [
                'array' => 'array',
                'document' => 'array',
                'root' => 'array'
            ]
        ];
        $pipeline = [
            [
                '$match' => [
                    'deleted_flag' => false,
                ]
            ],

            [
                '$lookup' => [
                    'from' => 'Products',
                    'localField' => 'product_id',
                    'foreignField' => '_id',
                    'as' => 'products'
                ],

            ],
            [
                '$lookup'=>[
                    'from'=>'Users',
                    'localField'=>'user_id',
                    'foreignField'=>'_id',
                    'as'=>'users'
                ]

            ],
            [
                '$project' => [
                    'product_id' => 1,
                    'user_id' => 1,
                    'user' => [
                        '$arrayElemAt' => ['$users', 0],
                    ],
                    'product' => [
                        '$arrayElemAt' => ['$products', 0]
                    ]
                ]
            ],
            [
                '$limit'=>2
            ]
        ];
        if (!is_null($order_id) && $order_id !=""){
            $pipeline[0]['$match']['_id'] = ['$gt'=>new ObjectId($order_id)];
        }
        $result = self::raw(function ($collection) use ($pipeline, $options) {
            return $collection->aggregate($pipeline, $options);
        });
        return $result;
    }
}

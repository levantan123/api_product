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

class Product extends Model implements AuthenticatableContract, AuthorizableContract, JWTSubject
{
    protected $collection = 'Products';
    use Authenticatable, Authorizable, HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'categories_id', 'amount'
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
//    public function setAmount($value)
//    {
//        $this->attributes['amount'] = int($value);
//    }
    public function getProduct($categories_id, $product_id)
    {
        $options = [
            'typeMap' => [
                'array' => 'array',
                'document' => 'array',
                'root' => 'array',
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
                    'from' => 'Categories',
                    'localField' => 'categories_id',
                    'foreignField' => '_id',
                    'as' => 'products'
                ]
            ],
            [
                '$project' => [
                    'title' => 1,
                    '_id' => 1,
                    'product' => [
                        '$arrayElemAt' => ['$products', 0],
                    ]

                ]
            ],
            [
                '$sort' => [
                    '_id' => -1
                ]
            ],
            [
                '$limit' => 2
            ],


        ];
        if (!is_null($categories_id) && $categories_id != "") {
            $pipeline[0]['$match']['categories_id'] = new ObjectId($categories_id);
        }
        if (!is_null($product_id) && $product_id != "") {
            $pipeline[0]['$match']['_id'] = ['$lt' => new ObjectId($product_id)];
        }
        $result = self::raw(function ($collection) use ($pipeline, $options) {
            return $collection->aggregate($pipeline, $options);
        });
        return $result;
    }
}

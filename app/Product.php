<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Kyslik\ColumnSortable\Sortable;

class Product extends Authenticatable
{
    use Notifiable;
    use Sortable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'member_id', 'product_category_id', 'product_subcategory_id', 'name', 'image_1', 'image_2', 'image_3', 'image_4', 'product_content'
    ];
    
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    protected $table = 'products';
    protected $datas = ['created_at', 'updated_at'];
    public $sortable = ['id', 'created_at'];
}

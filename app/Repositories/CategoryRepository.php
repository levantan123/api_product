<?php
namespace App\Repositories;

use App\Models\Category;
use Jenssegers\Mongodb\Eloquent\Model;

class CategoryRepository extends BaseRepository{
    public function __construct(Category $model)
    {
        parent::__construct($model);
    }
}
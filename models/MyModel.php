<?php

namespace app\models;

use yii\base\Model;

class MyModel extends Model
{
    public static function getImage()
    {
        $data = [
            'dragon.jpg',
            'dragon2.jpg',
        ];

        return $data;
    }

}
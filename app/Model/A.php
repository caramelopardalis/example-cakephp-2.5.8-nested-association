<?php

class A extends AppModel {

    public $hasMany = [
        'B',
    ];
    
    public $validate = [
        'content' => [
            'rule1' => [
                'rule' => 'alphaNumeric',
                'message' => '英数字を入力してください'
            ],
        ],
    ];
}

<?php

class B extends AppModel {

    public $belongsTo = [
        'A',
    ];

    public $hasMany = [
        'C',
    ];

    public $validate = [
        'content' => [
            'rule1' => [
                'rule' => 'boolean',
                'message' => '真偽値を入力してください',
            ],
        ],
    ];
}

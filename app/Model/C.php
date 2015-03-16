<?php

class C extends AppModel {

    public $belongsTo = [
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

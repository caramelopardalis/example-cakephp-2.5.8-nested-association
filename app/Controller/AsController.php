<?php

class AsController extends AppController {

    public $scaffold;

    public $components = ['Session'];

    public function add() {
        if (!$this->request->is('post')) {
            return;
        }

        $this->A->saveAll(
            $this->request->data['A'],
            [
                'validate' => 'only',
                'atomic' => false,
                'fieldList' => [
                    'content',
                ]
            ]
        );
        $this->loadModel('B');
        $this->B->saveAll(
            $this->request->data['B'],
            [
                'validate' => 'only',
                'atomic' => false,
                'fieldList' => [
                    'content',
                ]
            ]
        );
        $this->loadModel('C');
        $this->C->saveAll(
            $this->request->data['C'],
            [
                'validate' => 'only',
                'atomic' => false,
                'fieldList' => [
                    'content',
                ]
            ]
        );
        return;

        if (!empty(Hash::filter($this->A->validationErrors))
            || !empty(Hash::filter($this->B->validationErrors))
            || !empty(Hash::filter($this->C->validationErrors))) {
            $this->Session->setFlash('入力に間違いがあります');
            return;
        }

        $dataSource = $this->A->getDataSource();
        $dataSource->begin();
        try {
            
            $this->A->create();
            $success = $this->A->save(
                $this->request->data['A'],
                [
                    'validate' => false,
                    'atomic' => false,
                    'fieldList' => [
                        'content',
                    ]
                ]
            );
            if (!$success) {
                throw new Exception('A occured exception.');
            }

            $a_id = $this->A->id;
            $this->request->data['B'] = Hash::map(
                $this->request->data['B'],
                '{n}',
                function ($value) use ($a_id) {
                    debug($value);
                    debug($a_id);
                    $value['a_id'] = $a_id;
                    return $value;
                }
            );
            $this->loadModel('B');
            $this->B->create();
            $success = $this->B->saveMany(
                $this->request->data['B'],
                [
                    'validate' => false,
                    'atomic' => false,
                    'fieldList' => [
                        'a_id',
                        'content',
                    ]
                ]
            );
            if (!$success) {
                throw new Exception('B occured exception.');
            }

            $b_id = $this->B->id;
            $this->request->data['C'] = Hash::map(
                $this->request->data['C'],
                '{n}',
                function ($value) use ($b_id) {
                    $value['b_id'] = $b_id;
                    return $value;
                }
            );
            $this->loadModel('C');
            $this->C->create();
            $success = $this->C->saveMany(
                $this->request->data['C'],
                [
                    'validate' => false,
                    'atomic' => false,
                    'fieldList' => [
                        'b_id',
                        'content',
                    ]
                ]
            );
            if (!$success) {
                throw new Exception('C occured exception.');
            }

            $dataSource->commit();
            $this->Session->setFlash('Success');

        } catch (Exception $exception) {
            $dataSource->rollback();
            $this->Session->setFlash('Failed');
        }
    }
}

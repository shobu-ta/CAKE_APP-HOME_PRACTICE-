<?php
// src/Model/Table/ArticlesTable.php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Utility\Text;
use Cake\Event\EventInterface;

class ArticlesTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        // テーブル名（articles）を自動認識
        $this->setPrimaryKey('id');

        // タイムスタンプビヘイビア（created, modified を自動更新）
        $this->addBehavior('Timestamp');
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->notEmptyString('title', 'タイトルは必須です')
            ->notEmptyString('body', '本文は必須です');

        return $validator;
    }

    public function beforeSave(EventInterface $event, $entity, $options)
    {
        // 新規作成かつ slug が空の場合のみ生成
        if ($entity->isNew() && !$entity->slug) {
            $sluggedTitle = Text::slug($entity->title);
            // utf8mb4 の index 制限に合わせて 191 文字に調整
            $entity->slug = substr($sluggedTitle, 0, 191);
        }
    }
}
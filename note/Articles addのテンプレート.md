<!-- File: templates/Articles/add.php -->

<h1>記事の追加</h1>
<?php
    echo $this->Form->create($article);
FormHelper::create() を呼び出し、<form> タグを生成する。引数に $article エンティティを渡すことで、このエンティティに対応したフォーム（新規作成用）を作る。
add アクションにPOSTするための action 属性や method="post" などを持つ <form> が出力される。

// 今はユーザーを直接記述
    echo $this->Form->control('user_id', ['type' => 'hidden', 'value' => 1]);
user_id フィールドのフォームコントロールを生成する。'type' => 'hidden' により、画面に表示されない hidden フィールドとして出力される。'value' => 1 により、送信される user_id の値を 1 に固定している。つまり「ユーザーID = 1 のユーザーがこの記事を作成した」という形で DB に保存される。

    echo $this->Form->control('title');
title フィールド用のフォーム入力（テキストボックス）を生成する。ラベル（<label for="title">Title</label>）と入力欄（<input>）をまとめて出力する。新規作成なので初期値は空、バリデーションエラーがあればその表示もここに付く。
    echo $this->Form->control('body', ['rows' => '3']);
-body フィールド用のフォーム入力（通常は <textarea>）を生成する。'rows' => '3' により、テキストエリアの表示行数を 3 行にする。ラベルと textarea、エラー表示をまとめて自動生成する。
    echo $this->Form->button(__('Save Article'));
フォーム送信用の <button> を生成する。ボタンのラベルは __('Save Article') で、国際化対応（翻訳可能な文字列）になっている。このボタンをクリックすると、フォームの内容が POST される。

    echo $this->Form->end();
-FormHelper::end() を呼び出し、</form> タグを出力してフォームを閉じる。create() で開始したフォームブロックの終了を意味する。

?>


add.php が生成する HTML（完全版）
<h1>記事の追加</h1>

<form method="post" accept-charset="utf-8" action="/articles/add">
    <div style="display:none;">
        <input type="hidden" name="_csrfToken" value="xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx">
    </div>

    <input type="hidden" name="user_id" value="1">

    <div class="input text">
        <label for="title">Title</label>
        <input type="text" name="title" id="title">
    </div>

    <div class="input textarea">
        <label for="body">Body</label>
        <textarea name="body" rows="3" id="body"></textarea>
    </div>

    <button type="submit">Save Article</button>
</form>
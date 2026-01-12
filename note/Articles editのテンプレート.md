<h1>記事の編集</h1>
<?php
echo $this->Form->create($article);
FormHelper::create() を呼び出して <form> タグを生成する。$article エンティティを渡すことで、このエンティティの状態に応じたフォーム（編集用）を作成する。- edit アクションに対する適切な method や action 属性を持つフォームが自動で生成される。

echo $this->Form->control('user_id', ['type' => 'hidden']);
user_id フィールド用のフォームコントロールを生成する。'type' => 'hidden' により、画面には表示されない hidden フィールドとして出力される。

echo $this->Form->control('title');
title フィールド用のフォームコントロール（通常はテキスト入力）を生成する。ラベル、入力欄、バリデーションエラー表示などをまとめて自動生成する。- $article->title の値があれば初期値としてセットされる。

echo $this->Form->control('body', ['rows' => '3']);
body フィールド用のフォームコントロール（通常は <textarea>）を生成する。- 'rows' => '3' により、テキストエリアの行数（高さ）を3行に設定する。- $article->body の現在の値を初期値として表示する。

echo $this->Form->button(__('Save Article'));
フォーム送信用の <button> 要素を生成する。ボタンのラベルは __('Save Article') で、国際化対応された文字列（翻訳対象）になる。このボタンを押すとフォームが送信される。

echo $this->Form->end();
FormHelper::end() を呼び出し、</form> タグを出力してフォームを閉じる。これにより、Form::create() で開始したフォームブロックが終了する。


?>



完全なhtmlに置き換えると
<h1>記事の編集</h1>

<form method="post" accept-charset="utf-8" action="/articles/edit/first-post">
    <div style="display:none;">
        <input type="hidden" name="_method" value="PUT">
        <input type="hidden" name="_csrfToken" value="xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx">
    </div>

    <input type="hidden" name="user_id" value="1">

    <div class="input text">
        <label for="title">Title</label>
        <input type="text" name="title" value="First Post" id="title">
    </div>

    <div class="input textarea">
        <label for="body">Body</label>
        <textarea name="body" rows="3" id="body">This is the first post.</textarea>
    </div>

    <button type="submit">Save Article</button>
</form>
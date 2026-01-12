<h1>記事一覧</h1>
<p><?= $this->Html->link("記事の追加", ['action' => 'add']) ?></p>
HtmlHelper を使って 「記事の追加」ページへのリンク を作る。生成されるリンク例：/articles/add    
- 実際には <a href="/articles/add">記事の追加</a> のような HTML が出力される。

<table>
    <tr>
        <th>タイトル</th>
        <th>作成日時</th>
        <th>操作</th>
    </tr>

<!-- ここで、$articles クエリーオブジェクトを繰り返して、記事情報を出力します -->
<?php foreach ($articles as $article): ?>
 Controller からビューに渡された $articles（index() の $this->paginate($this->Articles)）をループ処理する。 $articles の各要素（Article エンティティ）を $article として1件ずつ取り出す。


    <tr>
        <td>
            <?= $this->Html->link($article->title, ['action' => 'view', $article->slug]) ?>
記事タイトルを 記事詳細ページ（view）へのリンク として表示。
        </td>
        <td>
            <?= $article->created->format(DATE_RFC850) ?>
記事の作成日時を RFC850 形式で表示。
        </td>
        <td>
            <?= $this->Html->link('編集', ['action' => 'edit', $article->slug]) ?>
            <?= $this->Form->postLink(
削除リンクを **POST メソッドで送信するフォーム** として生成  クリックすると「よろしいですか？」と確認ダイアログ  - OK を押すと削除アクションへ POST 送信

                '削除',
                ['action' => 'delete', $article->slug],
                ['confirm' => 'よろしいですか?'])
            ?>
        </td>
    </tr>
<?php endforeach; ?>

</table>
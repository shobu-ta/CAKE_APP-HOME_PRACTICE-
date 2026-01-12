<h1><?= h($article->title) ?></h1>
<p><?= h($article->body) ?></p>
h() はエスケープ関数で、$article->title を HTML エスケープしてから出力する。
- これにより、タイトルに < や & などが含まれても安全に表示でき、XSS 攻撃を防ぐ。
<p><small>作成日時: <?= $article->created->format(DATE_RFC850) ?></small></p>
<p> 内に、記事の作成日時を小さい文字（<small>）で表示する。

<p><?= $this->Html->link('Edit', ['action' => 'edit', $article->slug]) ?></p>
- リンク先：['action' => 'edit', $article->slug] → /articles/edit/{slug} の形式になる。

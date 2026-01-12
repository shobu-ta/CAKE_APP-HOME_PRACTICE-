ArticlesController = ケーキ屋さんの工場長
- Model（ArticlesTable）材料倉庫
- Entity（Article）ケーキ1個の箱
- View（テンプレート）ショーケース
- Controller（ArticlesController）工場長（司令塔）
工場長は「お客さんの注文（URL）」に応じて、
倉庫に指示を出し、ショーケースに並べるケーキを決めます。

<?php
// src/Controller/ArticlesController.php

namespace App\Controller;
use Cake\Validation\Validator;
意味:
Cake\Validation\Validator クラスを、このファイルで Validator という短い名前で使えるようにする。
下の validationDefault(Validator $validator) で使われる。

class ArticlesController extends AppController
意味:
ArticlesController クラスを定義している。
AppController を継承しているので、共通処理（認証・共通のメソッドなど）を引き継ぐ。
{
    public function index()
    {
        $articles = $this->paginate($this->Articles);
$this->Articles記事テーブル（モデル）  $this->paginateページネーション処理
 $articlesページ分割された記事データ
 📚 図書館の本棚（Articles）
Articles テーブルは「本棚」みたいなもの。
そこには記事（レコード）がたくさん並んでいる。
📖 paginate は「司書さん」
paginate は「1ページに10冊だけ机に並べてくれる司書さん」。
あなたが「Articles を paginate して」と頼むと…
- 何ページ目かを判断して
- そのページに必要な本だけを選び
- 並べて渡してくれる
その結果が $articles に入る。

        $this->set(compact('articles'));
コントローラで取得した $articles を、ビューに articles という名前で渡す

    }
    public function view($slug = null)
public function view(...)
1コントローラの アクションメソッド。
- /articles/view/... のような URL にアクセスされたときに呼ばれる。
2 $slug
- URL のパラメータとして渡される値。
- 例えば /articles/view/my-first-article の場合
→ $slug には "my-first-article" が入る。
3. = null
- デフォルト値。
- URL に slug が渡されなかった場合でもエラーにせず、$slug を null として扱う。
つまり…slug があってもなくても動くようにしているということ。


    {
        $article = $this->Articles->findBySlug($slug)->firstOrFail();
slug に一致する記事を1件だけ取得し、見つからなければ 404 エラーを出す
        $this->set(compact('article'));
    }
    public function add()
    {
        $article = $this->Articles->newEmptyEntity();
空の Article エンティティ（記事1件分の箱）を作る。  まだ中身は空っぽ。
        if ($this->request->is('post')) {
フォームから POST 送信されたときだけ、記事作成処理を実行する。
            $article = $this->Articles->patchEntity($article, $this->request->getData());
フォームから送られたデータを `$article` に流し込む。  
`$_accessible` の設定に従って安全に代入される。
            // user_id の決め打ちは一時的なもので、あとで認証を構築する際に削除されます。
            $article->user_id = 1;

            if ($this->Articles->save($article)) {
                $this->Flash->success(__('Your article has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to add your article.'));
        }
        $this->set('article', $article);
    }
    public function edit($slug)
    {
        $article = $this->Articles->findBySlug($slug)->firstOrFail();
        if ($this->request->is(['post', 'put'])) {
フォームから送信されたとき（POST または PUT のとき）だけ編集処理を実行する。
            $this->Articles->patchEntity($article, $this->request->getData());
            if ($this->Articles->save($article)) {
                $this->Flash->success(__('Your article has been updated.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to update your article.'));
        }

        $this->set('article', $article);
入力内容を保持する
エラー表示後にフォームを再表示する

    }
 POST = 新しいものを作ってください　新規記事の作成、ユーザー登録、コメント投稿
PUT = 既存のものを丸ごと作り直してください　- 既存データの“全体を更新”するときに使う

    
    public function delete($slug)
    {
        $this->request->allowMethod(['post', 'delete']);
このアクションは **POST または DELETE メソッドでしか実行できない** ように制限する。  
もし GET でアクセスされたらエラーを出す。
※GET は本来、ページを見る、情報を取得するためのメソッドです。
つまり 「副作用（データ変更）があってはいけない」 という大原則があります。


        $article = $this->Articles->findBySlug($slug)->firstOrFail();
        if ($this->Articles->delete($article)) {
            $this->Flash->success(__('The {0} article has been deleted.', 
$article->title));
削除成功メッセージをフラッシュメッセージとしてセットする。{0} の部分に記事タイトルが入る。例The First Post article has been deleted.

            return $this->redirect(['action' => 'index']);
        }
    }
    public function validationDefault(Validator $validator): Validator
- `validationDefault` というメソッドを定義している  
- 引数 `$validator` は CakePHP のバリデーション用オブジェクト  
- 戻り値も `Validator` 型であることを宣言している

    {
        $validator
            ->notEmptyString('title')
            ->minLength('title', 10)
            ->maxLength('title', 255)

            ->notEmptyString('body')
            ->minLength('body', 10);

        return $validator;
    }
}



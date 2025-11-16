## Step 1. 最小のコンテナ（手動リゾルブのみ）を作る

commit: [9541f0dc11e0df2f68d7bddc36b61d958cf2bf9f](https://github.com/programmerkoji/laravel_di_study/commit/9541f0dc11e0df2f68d7bddc36b61d958cf2bf9f)

### Point!
- set → Laravelの bind や instance() に相当
- この時点では「依存解決」なし → ただの箱
- 基本の概念を理解する

## Step 2. Closureで解決を遅延させる（基本のbind）を実装する
Laravelコンテナに近づけるため「Closure で定義して ->make() で生成」できるようにします。

commit: [db692aa11c6d76edcf18555dbe0f2b9a5db7ec0f](https://github.com/programmerkoji/laravel_di_study/commit/db692aa11c6d76edcf18555dbe0f2b9a5db7ec0f)

### Point!
- Laravelのコンテナは「遅延解決（lazy resolution）」
- $factory($this) = Laravelの $container->make() と完全に同じ構造
- Closureで依存オブジェクトを参照 → DI の基本

## Step 3. コンストラクタの依存を自動注入できるようにする（auto-wiring）
Reflection（リフレクション）を使って自動的に依存クラスを生成する仕組みを作ります。

commit: [18e86c23595ae40391480706a7e6d15b9a043cfa](https://github.com/programmerkoji/laravel_di_study/commit/18e86c23595ae40391480706a7e6d15b9a043cfa)

### Point!
- これが Laravel の make(UserService::class) と同等
- バインドしてないクラスでも解決できる（Laravelも同じ）
- 入れ子の依存関係も勝手に解決される → 便利すぎる

## Step 4. singleton（シングルトン）を作る

Laravelの singleton() と同じ機能を実装します。

commit: [a0a734eb4e59c80335f8449f796ddd4af1090652](https://github.com/programmerkoji/laravel_di_study/commit/a0a734eb4e59c80335f8449f796ddd4af1090652)

### Point!
- Laravelでは設定やDB接続など重い処理は singleton
- singleton の仕組みが DI コンテナの便利さの1つ

## Step 5. インターフェイス → 実装のマッピングを作れるようにする

commit: [6b8fcff9807137116c5f706879aae5d86badb957](https://github.com/programmerkoji/laravel_di_study/commit/6b8fcff9807137116c5f706879aae5d86badb957)

### Point!
- Laravelでの interface => class の仕組みを自作
- これで本格的なDI（疎結合な設計）が可能になる

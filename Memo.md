#　学習メモ

## posts show API

コード

```php:=
$post = Post::with('tags')->find($id);
```

Query

```bash:=
array:2 [
  0 => array:3 [
    "query" => "select * from `posts` where `posts`.`id` = ? limit 1"
    "bindings" => array:1 [
      0 => "1"
    ]
    "time" => 5.2
  ]
  1 => array:3 [
    "query" => "select `tags`.*, `taggables`.`taggable_id` as `pivot_taggable_id`, `taggables`.`tag_id` as `pivot_tag_id`, `taggables`.`taggable_type` as `pivot_taggable_type` from `tags` inner join `taggables` on `tags`.`id` = `taggables`.`tag_id` where `taggables`.`taggable_id` in (1) and `taggables`.`taggable_type` = ?"
    "bindings" => array:1 [
      0 => "App\Post"
    ]
    "time" => 2.4
  ]
]
```

レスポンス
post：１
tags：１０

```bash:=
{#2202
  +"id": 1
  +"name": "Joanny Nitzsche"
  +"created_at": "2020-06-17 14:52:49"
  +"updated_at": "2020-06-17 14:52:49"
  +"tags": array:10 [
    0 => {#2255
      +"id": 1
      +"name": "Dr. Sigurd Weber Jr."
      +"created_at": "2020-06-17 14:52:49"
      +"updated_at": "2020-06-17 14:52:49"
      +"pivot": {#2197
        +"taggable_id": 1
        +"tag_id": 1
        +"taggable_type": "App\Post"
      }
    }
    1 => {#2254
      +"id": 2
      +"name": "Jonatan Baumbach MD"
      +"created_at": "2020-06-17 14:52:49"
      +"updated_at": "2020-06-17 14:52:49"
      +"pivot": {#2253
        +"taggable_id": 1
        +"tag_id": 2
        +"taggable_type": "App\Post"
      }
    }
    2 => {#2216
      +"id": 3
      +"name": "Chaya Wiza"
      +"created_at": "2020-06-17 14:52:49"
      +"updated_at": "2020-06-17 14:52:49"
      +"pivot": {#2208
        +"taggable_id": 1
        +"tag_id": 3
        +"taggable_type": "App\Post"
      }
    }
    3 => {#2229
      +"id": 4
      +"name": "Terence Price"
      +"created_at": "2020-06-17 14:52:49"
      +"updated_at": "2020-06-17 14:52:49"
      +"pivot": {#1551
        +"taggable_id": 1
        +"tag_id": 4
        +"taggable_type": "App\Post"
      }
    }
    4 => {#1547
      +"id": 5
      +"name": "Dr. Iva Kemmer"
      +"created_at": "2020-06-17 14:52:49"
      +"updated_at": "2020-06-17 14:52:49"
      +"pivot": {#1553
        +"taggable_id": 1
        +"tag_id": 5
        +"taggable_type": "App\Post"
      }
    }
    5 => {#1548
      +"id": 6
      +"name": "Ashley Greenfelder"
      +"created_at": "2020-06-17 14:52:49"
      +"updated_at": "2020-06-17 14:52:49"
      +"pivot": {#2263
        +"taggable_id": 1
        +"tag_id": 6
        +"taggable_type": "App\Post"
      }
    }
    6 => {#1550
      +"id": 7
      +"name": "Sally Feeney"
      +"created_at": "2020-06-17 14:52:49"
      +"updated_at": "2020-06-17 14:52:49"
      +"pivot": {#1546
        +"taggable_id": 1
        +"tag_id": 7
        +"taggable_type": "App\Post"
      }
    }
    7 => {#2262
      +"id": 8
      +"name": "Prof. Salvador Feil PhD"
      +"created_at": "2020-06-17 14:52:49"
      +"updated_at": "2020-06-17 14:52:49"
      +"pivot": {#2258
        +"taggable_id": 1
        +"tag_id": 8
        +"taggable_type": "App\Post"
      }
    }
    8 => {#2260
      +"id": 9
      +"name": "Prof. Bertram Renner V"
      +"created_at": "2020-06-17 14:52:49"
      +"updated_at": "2020-06-17 14:52:49"
      +"pivot": {#2261
        +"taggable_id": 1
        +"tag_id": 9
        +"taggable_type": "App\Post"
      }
    }
    9 => {#2259
      +"id": 10
      +"name": "Earnestine Heathcote Sr."
      +"created_at": "2020-06-17 14:52:49"
      +"updated_at": "2020-06-17 14:52:49"
      +"pivot": {#2273
        +"taggable_id": 1
        +"tag_id": 10
        +"taggable_type": "App\Post"
      }
    }
  ]
}
```


## カスタム中間テーブル

Posts NN Tags の関係で、中間テーブルのカラムも引っ張ってきたい

以下ではpivotオブジェクトとして、中間テーブルの内容が入っている。
しかし、valueなどid系以外のカラムが取得できない

```php:=
// Controller
Post::with('tags')->find($params['id']);

// レスポンス内容
{#2246
  +"id": 1
  +"name": "Mittie Hilpert"
  +"created_at": "2020-06-18 03:30:38"
  +"updated_at": "2020-06-18 03:30:38"
  +"tags": array:1 [
    0 => {#2226
      +"id": 10
      +"name": "Velda Lehner I"
      +"created_at": "2020-06-18 03:30:38"
      +"updated_at": "2020-06-18 03:30:38"
      +"pivot": {#2234
        +"taggable_id": 1
        +"tag_id": 10
        +"taggable_type": "App\Post"
      }
    }
  ]
}
```

> 対策

カスタム中間テーブルを作成し、withPivotメソッドを使用して他のカラムを取得する

流れ

1. 中間テーブルのModelをpivotを継承する形で作成（ポリモーフィックの場合はMorphPivot）
2. morphToManyにusingでカスタム中間テーブルを指定、withPivotメソッドで中間テーブルのカラムを指定


### 1. 中間テーブルのModelをpivotを継承する形で作成（ポリモーフィックの場合はMorphPivot）

### 2. morphToManyにusingでカスタム中間テーブルを指定、withPivotメソッドで中間テーブルのカラムを指定


## $post = Post::find($id)->tags->first()->pivot;

```php:=
{#2246
  +"taggable_id": 1
  +"tag_id": 10
  +"taggable_type": "App\Post"
  +"value": "テスト"
}
```


















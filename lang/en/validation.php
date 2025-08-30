<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | 以下の言語行はバリデータクラスによって使用されるデフォルトの
    | エラーメッセージです。必要に応じて自由に変更できます。
    |
    */

    'accepted'             => ':attribute を承認してください。',
    'active_url'           => ':attribute は有効なURLではありません。',
    'after'                => ':attribute には :date 以降の日付を指定してください。',
    'after_or_equal'       => ':attribute には :date 以降の日付を指定してください。',
    'alpha'                => ':attribute はアルファベットのみが利用できます。',
    'alpha_dash'           => ':attribute は英数字、ダッシュ(-)、アンダースコア(_)が利用できます。',
    'alpha_num'            => ':attribute は英数字が利用できます。',
    'array'                => ':attribute は配列でなければなりません。',
    'before'               => ':attribute には :date 以前の日付を指定してください。',
    'before_or_equal'      => ':attribute には :date 以前の日付を指定してください。',
    'between'              => [
        'numeric' => ':attribute は :min から :max の間で指定してください。',
        'file'    => ':attribute は :min KBから :max KBまでのファイルでなければなりません。',
        'string'  => ':attribute は :min 文字から :max 文字でなければなりません。',
        'array'   => ':attribute は :min 個から :max 個までの要素を含まなければなりません。',
    ],
    'boolean'              => ':attribute は true または false を指定してください。',
    'confirmed'            => ':attribute と確認用の入力が一致しません。',
    'date'                 => ':attribute は有効な日付ではありません。',
    'date_format'          => ':attribute の形式が :format と一致しません。',
    'different'            => ':attribute と :other には異なる値を指定してください。',
    'digits'               => ':attribute は :digits 桁でなければなりません。',
    'digits_between'       => ':attribute は :min 桁から :max 桁でなければなりません。',
    'email'                => ':attribute は有効なメールアドレスでなければなりません。',
    'exists'               => '選択された :attribute は正しくありません。',
    'file'                 => ':attribute はファイルでなければなりません。',
    'filled'               => ':attribute は必須です。',
    'image'                => ':attribute は画像ファイルでなければなりません。',
    'in'                   => '選択された :attribute は正しくありません。',
    'integer'              => ':attribute は整数でなければなりません。',
    'ip'                   => ':attribute は有効なIPアドレスでなければなりません。',
    'json'                 => ':attribute は有効なJSON文字列でなければなりません。',
    'max'                  => [
        'numeric' => ':attribute は :max 以下でなければなりません。',
        'file'    => ':attribute は :max KB以下のファイルでなければなりません。',
        'string'  => ':attribute は :max 文字以下でなければなりません。',
        'array'   => ':attribute は :max 個以下でなければなりません。',
    ],
    'mimes'                => ':attribute は :values 形式のファイルでなければなりません。',
    'min'                  => [
        'numeric' => ':attribute は :min 以上でなければなりません。',
        'file'    => ':attribute は :min KB以上のファイルでなければなりません。',
        'string'  => ':attribute は :min 文字以上でなければなりません。',
        'array'   => ':attribute は :min 個以上でなければなりません。',
    ],
    'not_in'               => '選択された :attribute は正しくありません。',
    'numeric'              => ':attribute は数値でなければなりません。',
    'present'              => ':attribute が存在している必要があります。',
    'regex'                => ':attribute の形式が正しくありません。',
    'required'             => ':attribute は必須です。',
    'required_if'          => ':other が :value の場合、:attribute は必須です。',
    'required_unless'      => ':other が :values でない場合、:attribute は必須です。',
    'required_with'        => ':values が存在する場合、:attribute は必須です。',
    'required_with_all'    => ':values が存在する場合、:attribute は必須です。',
    'required_without'     => ':values が存在しない場合、:attribute は必須です。',
    'required_without_all' => ':values が存在しない場合、:attribute は必須です。',
    'same'                 => ':attribute と :other が一致しません。',
    'size'                 => [
        'numeric' => ':attribute は :size でなければなりません。',
        'file'    => ':attribute は :size KBでなければなりません。',
        'string'  => ':attribute は :size 文字でなければなりません。',
        'array'   => ':attribute は :size 個含まれていなければなりません。',
    ],
    'string'               => ':attribute は文字列でなければなりません。',
    'unique'               => ':attribute は既に存在しています。',
    'uploaded'             => ':attribute のアップロードに失敗しました。',
    'url'                  => ':attribute は有効なURLでなければなりません。',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | フィールド名を日本語に置き換えます。
    |
    */

    'attributes' => [
        'product_name' => '商品名',
        'company_id'   => 'メーカー名',
        'price'        => '価格',
        'stock'        => '在庫数',
        'comment'      => 'コメント',
        'image'        => '商品画像',
    ],

];

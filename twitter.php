<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>もっと読む</title>
    <script scr="http://code.jquery.com/jquery-1.10.2.min.js"></script>
</head>
<body>

<?php
// 参考URL
// http://apitip.com/twitter/38
// http://koukitips.net/twitter-api-1-1/
// http://www.tryphp.net/2012/01/05/phpapptwitter-public_timeline/
// https://dev.twitter.com/docs/api/1.1/get/search/tweets

// TwitterOAuthとはTwitterによる認証方式である。
// TwitterOAuthを使うとサイトのログインに使用できる
// ログインしたユーザーのTwitter情報を利用できる
require_once("twitteroauth/twitteroauth.php");

$consumerKey = "";
$consumerSecret = "";
$accessToken = "";
$accessTokenSecret = "";

// コンシューマキー、コンシューマシークレッ、アクセストークン、アクセスシークレットを使ってTwitterOAuthを生成する。
// TwitterOAuthクラスをnew演算子クラスでインスタンス化すして、変数$twObjに代入する
$twObj = new TwitterOAuth($consumerKey,$consumerSecret,$accessToken,$accessTokenSecret);

$keywords = '名神高速';

$param = array(
    "q"=>$keywords,                  // keyword
    "lang"=>"ja",                   // language
    "count"=>20,                   // number of tweets
    "result_type"=>"recent"       // result type
);

$json = $twObj->OAuthRequest(
    "https://api.twitter.com/1.1/search/tweets.json",
    "GET",
    $param);

$result = json_decode($json, true);

?>

<?php

if($result['statuses']){
    foreach($result['statuses'] as $tweet){
?>
        <ul>
          <li><?php echo date('Y-m-d H:i:s', strtotime($tweet['created_at'])); ?></li>
          <li><?php echo $tweet['user']['name']; ?></li>
          <li><?php echo $tweet['user']['screen_name']; ?></li>
          <li><img src="<?php echo $tweet['user']['profile_image_url']; ?>" /></li>
          <li><?php echo $tweet['text']; ?></li>
          <li><?php echo $tweet['id']; ?></li>
          <script type="text/javascript" src="//platform.twitter.com/widgets.js"></script>
            <img src="https://si0.twimg.com/images/dev/cms/intents/icons/reply_hover.png">
            <p><a href="https://twitter.com/intent/tweet?in_reply_to= <?php echo $tweet['id']; ?>" target="_blank">Reply</a></p>
            <img src="https://si0.twimg.com/images/dev/cms/intents/icons/favorite_on.png">
            <p><a href="https://twitter.com/intent/retweet?tweet_id= <?php echo $tweet['id']; ?>" target="_blank">Retweet</a></p>
            <img src="https://si0.twimg.com/images/dev/cms/intents/icons/retweet_on.png">
            <p><a href="https://twitter.com/intent/favorite?tweet_id= <?php echo $tweet['id']; ?>" target="_blank">Favorite</a></p>
        </ul>
  <?php } ?>
    <?php }else{ ?>
    <div class="twi_box">
        <p class="twi_tweet">関連したつぶやきがありません。</p>
    </div>
<?php } ?>

</body>
</html>
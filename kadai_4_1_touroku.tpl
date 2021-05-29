<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>本登録</title>
</head>
<body>
  ユーザーID :  {if isset($userid)}{$userid}{/if} <br>
  メールアドレス : {if isset($mail)}{$mail}{/if}<br>
 <form action='' method='post'>
    名前<br>
    <input type='text' name='name'><br>
    パスワード<br>
    <input type='password' name='pw'><br>
    <input type='submit' name='send' value='登録'>
  </form>

</body>
</html>

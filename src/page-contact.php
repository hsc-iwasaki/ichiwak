<?php
session_start();

/* 初期設定
==================================================================================== */

$text  = array();
$error = array();
$blank = true;
$items = $_SESSION["items"];

$client_name    = '求人サイトいちワク';
// $client_address = "ichihara@wm-club.com";
$client_address = "saiyo@ichiwak.com";


/* 連続送信対策
==================================================================================== */
if (isset($_POST['check']) || isset($_POST['send'])) {
  if (!$_SERVER['HTTP_REFERER']) die();
  if (!strpos($_SERVER['HTTP_REFERER'], $_SERVER['HTTP_HOST'])) die();
}
if (isset($_POST['send'])) {
  $file = 'contactlog.txt';
  if (!file_exists($file)) touch($file);
  if (intval(date('Ymd')) - intval(date('Ymd', filemtime($file))) > 1)
    file_put_contents($file, '');
  $log = file_get_contents($file);

  $ip = $_SERVER["REMOTE_ADDR"];
  file_put_contents($file, $log . "," . $ip);

  $overlap = array_count_values(explode(',', $log));

  if ($overlap[$ip] > 3)
    die('<!DOCTYPE html><meta charset="utf-8">お手数ですが時間を空けて再度送信ください');
}


/* 必須項目が入力されているかのチェック
==================================================================================== */
if (isset($_POST['check'])) {
  $items = $_POST['items'];
  $blank = false;

  if (!$items['name']) $blank = $error['name'] = 'お名前が入力されていません';
  if (!$items['ruby']) $blank = $error['ruby'] = 'ふりがなが入力されていません';

  if (!$items['address']) $blank = $error['address'] = 'ご住所を入力してください';

  if (!preg_match("/^[^@]+@[^@]+$/", $items['mail01'])) $blank = $error['mail01'] = '正しい形式のメールアドレスをご入力ください';
  if (!$items['mail01']) $blank = $error['mail01'] = 'メールアドレスが入力されていません';
  if (!$items['mail02']) $blank = $error['mail02'] = 'メールアドレスが入力されていません';
  if ($items['mail01'] !== $items['mail02']) $blank = $error['mail02'] = '上記メールアドレスと異なります';

  if (!preg_match("/^[0-9]+$/", $items['tel01'])) $blank = $error['tel'] = '正しい電話番号をご入力ください';
  if (!$items['comment']) $blank = $error['comment'] = 'お問い合わせ内容をご入力ください';

  $_SESSION["items"] = $items;
}

/* メールを送信
==================================================================================== */
if (isset($_POST['send'])) {

  setcookie(session_name(), '', time() - 42000, '/');
  session_destroy();
  $_SESSION['send_num'] = $send_num;

  $message = <<<EOT

■ お名前
  $items[name]

■ ふりがな
  $items[ruby]

■ お名前
  $items[coname]

■ ふりがな
  $items[coruby]

■ メールアドレス
  $items[mail01]

■ 電話番号
  $items[tel01] - $items[tel02] - $items[tel03]

■ ご住所
  $items[pc01] - $items[pc02]
  $items[address]

■ お問い合わせ内容
  $items[comment]
EOT;
  $client_message = <<<EOT

ホームページからお問い合わせがありました。
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

$message

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
$home_url
EOT;
  $user_message = <<<EOT

$items[name] 様

このたびは、 $client_name にお問い合わせいただき、ありがとうございます。
近日担当者よりご連絡を差し上げますので、しばらくお待ちくださいませ。


◆お客さま情報◆
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

$message

◆◇◆◇◆◇◆◇◆◇◆◇◆◇◆◇◆◇◆◇◆◇◆

$client_name

URL https://ichiwak.com/

◆◇◆◇◆◇◆◇◆◇◆◇◆◇◆◇◆◇◆◇◆◇◆
EOT;

  mb_language("japanese");
  mb_internal_encoding("UTF-8");
  mb_convert_encoding($client_address, "UTF-8");
  mb_convert_encoding($client_message, "UTF-8");
  $user_message = mb_convert_encoding($user_message, "UTF-8");

  if (!mb_send_mail($client_address, "ホームページよりお問い合わせがありました", $client_message, "From: " . $client_address)) {
    exit("e");
  }
  if (!mb_send_mail($items['mail01'], "お問い合わせありがとうございました", $user_message, "From:" . mb_encode_mimeheader($client_name) . "<" . $client_address . ">")) {
    exit("e");
  }

  $sent = true;
  $blank = false;
}
?>

<?php get_header(); ?>
<script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
<main class="low page-contact">
  <div class="contact-form-wrap inner fadeup">
    <?php if ($blank) { ?>
      <div>
        <p class="plz-fillin">
          下記フォームよりお問い合わせください。<br>
          後日、担当者よりご連絡をさせていただきます。<br>
          <br>
          *印は必須項目となりますので、必ずご入力ください
        </p>
      </div>
    <?php } elseif (!isset($sent)) { ?>
      <div>
        <p class="plz-fillin">
          以下の内容でよろしければ「送信する」ボタンを押して下さい
        </p>
      </div>
    <?php } else { ?>
      <div>
        <p class="plz-fillin">
          送信が完了しました。<br>
          このたびはお問い合わせいただき、ありがとうございます。<br>
          近日担当者よりご連絡を差し上げますので、しばらくお待ちくださいませ。
        </p>
      </div>
    <?php } ?>
    <form action="#anc-contact" method="post" class="contact-form">

      <?php if ($blank) { ?>

        <table class="contact-form-table">
          <tr>
            <th><label for="name">お名前（全角）</label><span>*</span></th>
            <td>
              <?php if ($error['name']) echo '<p class="error-text">' . $error['name'] . '</p>'; ?>
              <input type="text" name="items[name]" value="<?php echo $items['name']; ?>" id="name" class="input-mid" placeholder="例) 山田　太郎">
            </td>
          </tr>
          <tr>
            <th><label for="ruby">フリガナ</label><span>*</span></th>
            <td>
              <?php if ($error['ruby']) echo '<p class="error-text">' . $error['ruby'] . '</p>'; ?>
              <input type="text" name="items[ruby]" value="<?php echo $items['ruby']; ?>" id="ruby" class="input-mid" placeholder="例) ヤマダ　タロウ">
            </td>
          </tr>
          <tr>
            <th><label for="name">会社名</label>
            <td>
              <?php if ($error['coname']) echo '<p class="error-text">' . $error['coname'] . '</p>'; ?>
              <input type="text" name="items[coname]" value="<?php echo $items['coname']; ?>" id="coname" class="input-mid" placeholder="例) 株式会社会社名">
            </td>
          </tr>
          <tr>
            <th><label for="name">会社名フリガナ</label></th>
            <td>
              <?php if ($error['coruby']) echo '<p class="error-text">' . $error['coruby'] . '</p>'; ?>
              <input type="text" name="items[coruby]" value="<?php echo $items['coname']; ?>" id="coname" class="input-mid" placeholder="例)カブシキガイシャカイシャメイ">
            </td>
          </tr>
          <tr>
            <th><label for="mail01">メールアドレス（半角）</label><span>*</span></th>
            <td>
              <?php if ($error['mail01']) echo '<p class="error-text">' . $error['mail01'] . '</p>'; ?>
              <input type="email" name="items[mail01]" value="<?php echo $items['mail01']; ?>" id="mail01" class="input-big" placeholder="例) xxxxxx@example.com">
            </td>
          </tr>
          <tr>
            <th><label for="mail02">確認用メールアドレス（半角）</label><span>*</span></th>
            <td>
              <?php if ($error['mail02']) echo '<p class="error-text">' . $error['mail02'] . '</p>'; ?>
              <input type="email" name="items[mail02]" value="<?php echo $items['mail02']; ?>" id="mail02" class="input-big" placeholder="例) xxxxxx@example.com">
            </td>
          </tr>
          <tr>
            <th><label for="tel">電話番号（半角）</label></th>
            <td>
              <?php if ($error['tel']) echo '<p class="error-text">' . $error['tel'] . '</p>'; ?>
              <input type="tel" name="items[tel01]" value="<?php echo $items['tel01']; ?>" id="tel">
            </td>
          </tr>
          <tr style="margin-bottom:17px;">
            <th><label for="pc01">郵便番号</label></th>
            <td>
              〒 <input type="tel" name="items[pc01]" value="<?php echo $items['pc01']; ?>" id="pc01" class="input-min">-<input type="tel" name="items[pc02]" value="<?php echo $items['pc02']; ?>" class="input-min">
              <input class="post-button post-code" type="button" value="郵便番号から自動入力" onclick="AjaxZip3.zip2addr('items[pc01]','items[pc02]','items[address]','items[address]');">
            </td>
          </tr>
          <tr>
            <th><label for="pc01">ご住所</label><span>*</span></th>
            <td>
              <?php if ($error['address']) echo '<p class="error-text">' . $error['address'] . '</p>'; ?>
              <input type="text" name="items[address]" value="<?php echo $items['address']; ?>" class="input-big mt5">
            </td>
          </tr>
          <tr>
            <th><label for="comment">お問い合わせ内容</label></th>
            <td>
              <?php if ($error['comment']) echo '<p class="error-text">' . $error['comment'] . '</p>'; ?>
              <textarea name="items[comment]" cols="45" rows="10" id="comment" class="input-big" placeholder="お問い合わせ内容をご入力ください"><?php echo $items['comment']; ?></textarea>
            </td>
          </tr>
        </table>
        <div class="submits"><input class="submit-button" type="submit" value="入力内容を確認する" name="check"><span></span><span></span></div>
      <?php } elseif (!isset($sent)) { ?>

        <table class="contact-form-table">
          <tr>
            <th>お名前</th>
            <td><?php echo $items['name']; ?></td>
          </tr>
          <tr>
            <th>フリガナ</th>
            <td><?php echo $items['ruby']; ?></td>
          </tr>
          <tr>
            <th>会社名</th>
            <td><?php echo $items['coname']; ?></td>
          </tr>
          <tr>
            <th>会社名フリガナ</th>
            <td><?php echo $items['coruby']; ?></td>
          </tr>
          <tr>
            <th>メールアドレス</th>
            <td><?php echo $items['mail01']; ?></td>
          </tr>
          <tr>
            <th>電話番号</th>
            <td><?php echo $items['tel01']; ?></td>
          </tr>
          <tr>
            <th>郵便番号</th>
            <td><?php echo $items['pc01']; ?>-<?php echo $items['pc02']; ?></td>
          </tr>
          <tr>
            <th>ご住所</th>
            <td><?php echo $items['address']; ?></td>
          </tr>
          <tr>
            <th>会社名</th>
            <td><?php echo $items['coname']; ?></td>
          </tr>
          <tr>
            <th>お問い合わせ内容</th>
            <td><?php echo $items['comment']; ?></td>
          </tr>
        </table>
        <div class="submits"><input class="submit-button" type="submit" value="内容を修正する" name="return"><span></span><span></span></div>
        <div class="submits"><input class="submit-button" type="submit" value="送信する" name="send"><span></span><span></span></div>
      <?php } ?>
    </form>
  </div>
  </section>
</main>
<?php get_footer(); ?>
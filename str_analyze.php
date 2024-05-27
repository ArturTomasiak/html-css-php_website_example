<?php
if (isset($_POST['submit']) && !empty($_POST['text'])) {
  $str        = $_POST['text'];
  $text       = strtolower(preg_replace("/[^a-zA-Z\s]/", "", $str));
  $operation  = $_POST['choice'];
  $sortchoice = $_POST['sortchoice'];
  if ($operation == 'list') {
    $sortedtext = NULL;
    $wordcount   = [];
    $textarr    = explode(" ", $text);
    foreach ($textarr as $word) {
      if (array_key_exists($word, $wordcount))
        $wordcount[$word]++;
      else
        $wordcount[$word] = 1;
    }
    arsort($wordcount);
  }
  if ($operation == 'sort_ascending') {
    $wordcount = NULL;
    switch ($sortchoice) {
      case 'php':
        $textarr = explode(" ", $text);
        sort($textarr);
        $sortedtext = implode(" ", $textarr);
        break;
      case 'insertion_sort':
        $textarr = explode(" ", $text);
        $textarr = insertion_sort($textarr);
        $sortedtext = implode(" ", $textarr);
        break;
    }
  }
  if ($operation == 'sort_descending') {
    $wordcount = NULL;
    switch ($sortchoice) {
      case 'php':
        $textarr = explode(" ", $text);
        rsort($textarr);
        $sortedtext = implode(" ", $textarr);
        break;
      case 'insertion_sort':
        $textarr = explode(" ", $text);
        $textarr = insertion_sort($textarr);
        $textarr = array_reverse($textarr);
        $sortedtext = implode(" ", $textarr);
        break;
    }
  }
}
function insertion_sort($array)
{
  $length = count($array);
  for ($i = 1; $i < $length; $i++) {
    $temp = $array[$i];
    $j = $i - 1;
    while ($j > -1 && $array[$j] > $temp) {
      $array[$j + 1] = $array[$j];
      $j--;
    }
    $array[$j + 1] = $temp;
  }
  return $array;
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8" lang="en" />
  <title>string analyzer</title>
  <link rel="stylesheet" href="str_analyze.css">
</head>
<script>
  function hide_unhide() {
    let value = document.getElementById("choice").value;
    let hidden = document.getElementById("hideme");
    if (value == "sort_ascending" || value == "sort_descending")
      hidden.style.display = "block";
    else
      hidden.style.display = "none";
  }
</script>
<body onload="hide_unhide()">
  <div class="container">
    <form action="str_analyze.php" method="POST">
      <div class="title item"><a>String analyzer</a></div>
      <div class="item-1 item"><a>Input text:</a></div>
      <div class="item-2 item"><input type="text" name="text" placeholder="" value="<?php if (isset($str)) { echo "$str"; } ?>"></div>
      <div class="item-3 item"><a>Choose operation:</a></div>
      <div class="item-4 item">
      <select name="choice" id="choice" onchange="hide_unhide()">
        <option <?php if (isset($operation)) { if ($operation == "list") { echo "selected=\"selected\""; } } ?> value="list">list the quantity of each word</option>
        <option <?php if (isset($operation)) { if ($operation == "sort_ascending") { echo "selected=\"selected\""; } } ?> value="sort_ascending">sort ascending</option>
        <option <?php if (isset($operation)) { if ($operation == "sort_descending") { echo "selected=\"selected\""; } } ?> value="sort_descending">sort descending</option>
      </select>
      </div>
      <div class="item-5 item" id="hideme">
      <select name="sortchoice" id="sortchoice">
        <option <?php if (isset($sortchoice)) { if ($sortchoice == "php") { echo "selected=\"selected\""; } } ?> value="php">default php sort</option>
        <option <?php if (isset($sortchoice)) { if ($sortchoice == "insertion_sort") { echo "selected=\"selected\""; } } ?> value="insertion_sort">insertion sort</option>
      </select>
      </div>
      <div class="item-6 item"><input type="submit" name="submit" value="execute"></div>
    </form>
    <?php if (isset($sortedtext)) : ?>
      <div class="item-7 item">
      <p><?php echo $sortedtext; ?></p>
      </div>
    <?php endif; ?>
    <?php if (isset($wordcount)) : ?>
      <div class="item-7 item">
      <table>
        <tr>
          <th>word</th>
          <th>quantity</th>
        </tr>
        <?php foreach ($wordcount as $word => $count): ?>
        <tr>
          <td><?php echo $word; ?></td>
          <td><?php echo $count; ?></td>
        </tr>
        <?php endforeach; ?>
      </table>
      </div>
    <?php endif; ?>
  </div>
</body>
</html>
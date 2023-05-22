<?php
const ALPHABET = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
$a = str_split(ALPHABET);

var_dump($a);


$tgl = (int) date('j');
$bln = (int) date('n');
$thn = (int) date('y');

echo $a[$tgl-1].$a[$bln-1].$thn.str_pad(7, 5, '0', STR_PAD_LEFT);

echo '<hr><br>';
$tgl = (int) date('j', strtotime('2022-12-31'));
$bln = (int) date('n', strtotime('2022-12-31'));
$thn = (int) date('y', strtotime('2022-12-31'));

echo $a[$tgl-1].$a[$bln-1].$thn.str_pad(7, 5, '0', STR_PAD_LEFT);

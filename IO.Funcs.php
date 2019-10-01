<?php
/**************************************************************************************************\
|* PHP FileStream Beta (0.1a) By Jed Harlen Hall (Hect0r Xorius)                                  *|
|* Contact:                                                                                       *|
|* - Twitter: @JedHarlenHall                                                                      *|
|* - Email: jedhall9@gmail.com                                                                    *|
|* License:                                                                                       *|
|* - Free to use, you can make money out of this if you wish, you are not allowed to sell the io  *|
|*   only, you have to write a project containing the io to sell, thats the rule, all I require   *|
|*   is a shout out to me as Jed or Hect0r and this header remains in the io files without        *|
|*   removal.                                                                                     *|
|* - If I find any implementations without the license and no shout I will not be very happy and  *|
|*   I'll send you a very nasty letter, mmmmkay :)                                                *|
|* Shouts:                                                                                        *|
|* Ayrus                                                                                          *|
\**************************************************************************************************/

// Get Machine Endian, Gets the current machines endian type.
function getMachineEndian() {
    $testint = 0x00FF;
    $p = pack('S', $testint);
    return $testint===current(unpack('v', $p)) ? Endian::LOW:Endian::HIGH;
}
// To Byte Array, Converts a hexadecimal string to a byte array (ints).
function toByteArray($str) {
    $output = array();
    
    for($i = 0; $i < strlen($str) / 2; $i+=2) {
        $output[] = hexdec(substr($str, $i, 2));
    }
    
    return $output;
}
// Hex To String, Converts a hexadecimal string to a ascii string.
function hexToStr($hex) {
    $str = '';
    for($i=0;$i<strlen($hex);$i+=2) { $str .= chr(hexdec(substr($hex,$i,2))); }
    return $str;
}
// Reverse String, Reverses a hexadecimal string.
function reverseStr($bytes_str) {
    $str = "";
    for($i = 0; $i < strlen($bytes_str) / 2; $i++) {
        $str = substr($bytes_str, ($i * 2), 2) . $str;
    }
    return $str;
}
// Reverse Unicode String, Reverses a unicode hexadecimal string.
function reverseUnicodeStr($bytes_str) {
    $str = "";
    for($i = 0; $i < strlen($bytes_str) / 2; $i++) {
        $str .= substr($bytes_str, ($i * 2), 1) . substr($bytes_str, ($i * 2) - 1, 1);
    }
    return $str;
}

?>

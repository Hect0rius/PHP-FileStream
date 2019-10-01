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

// Decimal Hexadecimal UInt16, Converts a UInt16 value to its correct hexadecimal representation, along with selected endian.
function decHexUInt16($in, $endian) {
    if((int)$in >= 0 && (int)$in <= 65535) {
        
        $val = 0;
        while(strlen($val) !== 4) {
            if((int)$endian === (int)Endian::HIGH) { $val = pack('n', (int)$in); }
            else { $val = pack('v', (int)$in); }
        }
        return $val;
    }
    throw new Exception('decHexUInt16: value < 0 || value > 65535...');
}
function decHexInt16($in, $endian) {
    if((int)$in > -32768 && (int)$in < 32767) {
        $val = dechex((int)$in);
        return ((int)$endian === (int) Endian::HIGH) ? substr($val, 12, 4):reverseStr(substr($val, 12, 4));
    }
    throw new Exception('decHexInt16: value < -32768 || value > 32767...');
}
// Decimal Hexadecimal UInt32, Converts a UInt32 value to its correct hexadecimal representation, along with selected endian.
function decHexUInt32($in, $endian) {
    if((int)$in >= 0 && (int)$in <= 4294967295) {
        $val = 0;
        while(strlen($val) !== 8) {
            if((int)$endian === (int)Endian::HIGH) { $val = pack('N', (int)$in); }
            else { $val = pack('V', (int)$in); }
        }
        return $val;
    }
    throw new Exception('decHexUInt32: value < 0 || value > 4294967295...');
}
function decHexInt32($in, $endian) {
    if((int)$in > -2147483646 && (int)$in < 2147483647) {
        $val = dechex((int)$in);
        return ((int)$endian === (int) Endian::HIGH) ? substr($val, 8, 8):reverseStr(substr($val, 8, 8));
    }
    throw new Exception('decHexInt16: value < -2147483646 || value > 2147483647...');
}
// Decimal Hexadecimal UInt64, Converts a UInt64 value to its correct hexadecimal representation, along with selected endian.
function decHexUInt64($in, $endian) {
    if((int)$in >= 0 && (int)$in <= 9223372036854775807) {
        $val = 0;
        while(strlen($val) !== 16) {
            if((int)$endian === (int)Endian::HIGH) { $val = pack('J', (int)$in); }
            else { $val = pack('P', (int)$in); }
        }
        
        return $val;
    }
    throw new Exception('Invalid Unsigned Integer (Size 64 Bits)');
}
function decHexInt64($in, $endian) {
    if((int)$in > -9223372036854775806 && (int)$in < 9223372036854775807) {
        $val = dechex((int)$in);
        return ((int)$endian === (int) Endian::HIGH) ? $val:reverseStr($val);
    }
    throw new Exception('decHexInt16: value < -9223372036854775806 || value > 9223372036854775807...');
}

?>

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

require('Endian.php');
require('IO.Funcs.php');
require('Numeric.Funcs.php');

class FileStream {
    private $filename = ''; // Input/Output File Location.
    private $handle = null; // The resource/pointer we're writing to.
    private $pos = 0; // The current position in the stream.
    private $open = false; // private to set if open or closed.
    
    // Checks boolean "open" for true = open, false = closed.
    public function isOpen() { return (bool)$this->open; }
    
    // Construction of the class deals with opening the pointer/resource to the stream.
    public function __construct($file, $perms) {
        $this->filename = $file;
        $this->handle = fopen($file, $perms);
        if(is_resource($this->handle)) {
            $this->open = true;
        }
    }
    
    // Set Position, sets the position in the stream, this is a static value it will go to.
    public function setPosition($pos) {
        $this->pos = (int)$pos;
        fseek($this->handle, (int)$this->pos, SEEK_SET);
    }
    
    // Append Position, takes current stream location and adds whatever static value you give it.
    public function appendPosition($pos) {
        $this->pos += (int)$pos;
        fseek($this->handle, (int)$pos, SEEK_SET);
    }
    
    // Get Position, takes the current position of the stream.
    public function getPosition() { return (int)$this->pos; }
    
    // Read Bytes String, reads a chunk of data into a hexadecimal string.
    public function readBytesStr($len) {
        $str = bin2hex(fread($this->handle, (int)$len));
        $this->pos += (int)$len;
        return $str;
    }
    
    // Read Byte, Reads a Int/UInt8 variable from the stream.
    public function readByte() {
        $str = bin2hex(fread($this->handle, 1));
        return hexdec($str);
    }
    // Read Bytes, reads a chunk of data into a integer array (like byte[] / uint8_t[]).
    public function readBytes($len) {
        $str = bin2hex(fread($this->handle, (int)$len));
        $this->pos += (int)$len;
        return toByteArray($str);
    }
    
    // Read UInt16, reads a unsigned integer of 16 bits and switches for selected endian.
    public function readUInt16($endian = Endian::LOW) {
        $str = bin2hex(fread($this->handle, 2));
        $this->pos += 2;
        return hexdec(((int)getMachineEndian() !== (int)$endian) ? reverseStr($str):$str);
    }
    
    // Read Int16, reads a integer of 16 bits and switches for selected endian.
    public function readInt16($endian = Endian::LOW) {
        $buf = fread($this->handle, 2);
        $this->pos += 2;
        $buf = ((int)$endian !== (int)getMachineEndian() ? hex2bin(reverseStr(bin2hex($buf))) : $buf);
        return unpack('s', $buf)[1];
    }
    
    // Read UInt32, reads a unsigned integer of 32 bits and switches for selected endian.
    public function readUInt32($endian = Endian::LOW) {
        $str = bin2hex(fread($this->handle, 4));
        $this->pos += 4;
        return hexdec(((int)getMachineEndian() !== (int)$endian) ? reverseStr($str):$str);
    }
    
    // Read Int32, reads a integer of 32 bits and switches for selected endian.
    public function readInt32($endian = Endian::LOW) {
        $buf = fread($this->handle, 4);
        $this->pos += 4;
        $buf = ((int)$endian !== (int)getMachineEndian() ? hex2bin(reverseStr(bin2hex($buf))) : $buf);
        return unpack('l', $buf)[1];
    }
    
    // Read UInt64, reads a unsigned integer of 64 bits and switches for the selected endian.
    public function readUInt64($endian = Endian::LOW) {
        $str = bin2hex(fread($this->handle, 8));
        $this->pos += 8;
        return hexdec(((int)getMachineEndian() !== (int)$endian) ? reverseStr($str):$str);
    }
    
    // Read UInt64, reads a integer of 64 bits and switches for the selected endian.
    public function readInt64($endian = Endian::LOW) {
        $buf = fread($this->handle, 8);
        $this->pos += 8;
        return unpack((int)$endian === (int)Endian::HIGH ? 'J':'P', $buf)[1];
    }
    
    // Read Float, reads a floating point number.
    public function readFloat($endian = Endian::LOW) {
        $buf = fread($this->handle, 4);
        $this->pos += 4;
        $buf = ((int)$endian !== (int)getMachineEndian() ? hex2bin(reverseStr(bin2hex($buf))) : $buf);
        return (float)unpack('f', (float)$buf);
    }
    
    // Read Ascii String, reads a ascii string (unsigned 8) to a string value.
    public function readAsciiString($len) {
        $str = fread($this->handle, (int)$len);
        $this->pos += (int)$len;
        return $str;
    }
    
    // Write Byte, Writes a byte to the stream.
    public function writeByte($byte) {
        fwrite($this->handle, hex2bin(decHexUInt8((int)$byte)), 1);
        $this->pos++;
    }
    
    // Write Bytes, Writes a hexadecimal string to the stream.
    public function writeBytes($bytesStr) {
        fwrite($this->handle, hex2bin($bytesStr), 1);
        $this->pos += strlen($bytesStr) / 2;
    }
    
    // Write UInt16, Writes a UInt16 to the stream.
    public function writeUInt16($int, $endian) {
        fwrite($this->handle, hex2bin(decHexUInt16((int)$int, (int)$endian)), 2);
        $this->pos += 2;
    }
    
    // Write Int16, Writes a Int16 to the stream.
    public function writeInt16($int, $endian) {
        fwrite($this->handle, hex2bin(decHexInt16((int)$int, (int)$endian)), 2);
        $this->pos += 2;
    }
    
    // Write UInt32, Writes a UInt32 to the stream.
    public function writeUInt32($int, $endian) {
        fwrite($this->handle, hex2bin(decHexUInt32((int)$int, (int)$endian)), 4);
        $this->pos += 4;
    }
    
    // Write Int32, Writes a Int32 to the stream.
    public function writeInt32($int, $endian) {
        fwrite($this->handle, hex2bin(decHexInt32((int)$int, (int)$endian)), 4);
        $this->pos += 4;
    }
    
    // Write UInt64, Writes a UInt64 to the stream.
    public function writeUInt64($int, $endian) {
        fwrite($this->handle, hex2bin(decHexUInt64((int)$int, (int)$endian)), 8);
        $this->pos += 8;
    }
    
    // Write Int64, Writes a Int64 to the stream.
    public function writeInt64($int, $endian) {
        fwrite($this->handle, hex2bin(decHexInt64((int)$int, (int)$endian)), 8);
        $this->pos += 8;
    }
    public function writeFloat($float) {
        fwrite(pack('f', (float)$float));
        $this->pos += 4;
    }
    public function writeAsciiString($str) {
        fwrite($this->handle, $str, strlen($str));
        $this->pos += (int)strlen($str);
    }
    
    // Closes the resource/stream.
    public function close() {
        if(is_resource($this->handle)) {
            fclose($this->handle);
            $this->open = false;
        }
    }
}
?>

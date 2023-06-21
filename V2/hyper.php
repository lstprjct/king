<?php

namespace Hyper;

class dom
{
    public function create_notice_bar($config =  array("ele" => "p", "text" => "some text", "css" => null))
    {
        return  '<' . $config['ele'] . ' class="' . $config['css'] . '">' . $config['text'] . '</' . $config['ele'] . '>';
    }
    public function session($session)
    {
        if (isset($_SESSION[$session])) {
            return true;
        } else {
            return false;
        }
    }
    public function sw_string($string, $startString)
    {
        $len = strlen($startString);
        return (substr($string, 0, $len) === $startString);
    }
    public function redirect_to($path)
    {
        return header("location:" . $path . "");
    }
    public function ip_range($ip)
    {;

        if (strlen($ip) > 20) {
            $ip = substr($ip, 0, 20);
        } elseif (strlen($ip) > 10) {
            $ip = substr($ip, 0, 10);
        } elseif (strlen($ip) > 8) {
            $ip = substr($ip, 0, 8);
        }
        return $ip;
    }
    public function genPhoneNum($country_code = "", $limit = 1, $reqLength = 7, $highLen = 8)
    {
        $appendNum = '';
        for ($i = 0; $i < $reqLength; ++$i) {
            $appendNum .= mt_rand(0, $highLen);
        }
        $areaCodes = ['512', '319', '201', '737'];
        for ($i = 0; $i < $limit; ++$i) {
            if ($country_code !== "") {
                echo $areaCodes[array_rand($areaCodes)], $appendNum, "\n";
            } else {
                echo $country_code . $areaCodes[array_rand($areaCodes)], $appendNum, "\n";
            }
        }
    }
    public function get_parameter($key, $value)
    {
        if (isset($_GET[$key])) {
            if ($_GET[$key] == $value) {
                return True;
            } else {
                return False;
            }
        }
    }
}

class Hyper extends dom
{
    public $connect;
    public $dbtype;


    public function __construct($connect, $dbtype)
    {
        $this->connect = $connect;
        $this->dbtype = $dbtype;
    }

    public function gen_tok($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    public function get_user_ip()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    public function toLowercase($text = "")
    {
        return strtolower($text);
    }
    public function encode($encode = "")
    {
        $ciphering = "AES-128-CTR";

        $iv_length = openssl_cipher_iv_length($ciphering);
        $options = 0;

        $encryption_iv = '0486299622685486';

        $encryption_key = "kingencrypt";

        $encryption = openssl_encrypt(
            $encode,
            $ciphering,
            $encryption_key,
            $options,
            $encryption_iv
        );
        return  $encryption;
    }

    public function decode($decode)
    {
        $ciphering = "AES-128-CTR";

        // Use OpenSSl Encryption method
        $iv_length = openssl_cipher_iv_length($ciphering);
        $decryption_iv = '0486299622685486';
        $options = 0;
        $decryption_key = "kingencrypt";

        $decryption = openssl_decrypt(
            $decode,
            $ciphering,
            $decryption_key,
            $options,
            $decryption_iv
        );

        return $decryption;
    }
}

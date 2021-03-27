<?php

namespace app\common\library\qrcode;

use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;

class QrcodeLib
{

    public static $config = [
        'width' => 30,
        'height' => 30,
    ];
   public static function generator($url = '', $config = [])
   {
//       $config = self::$config + $config;

//       $logoPath = public_path('qrcode') . 'symfony.png';
       $logoPath = __DIR__.'/assets/symfony.png';
       $writer = new PngWriter();

// Create QR code
       $qrCode = QrCode::create($url)
           ->setEncoding(new Encoding('UTF-8'))
           ->setErrorCorrectionLevel(new ErrorCorrectionLevelLow())
           ->setSize(300)
           ->setMargin(10)
           ->setRoundBlockSizeMode(new RoundBlockSizeModeMargin())
           ->setForegroundColor(new Color(0, 0, 0))
           ->setBackgroundColor(new Color(255, 255, 255));


       $label = Label::create('Label')
           ->setTextColor(new Color(255, 0, 0))
           ->setBackgroundColor(new Color(0, 0, 0));

       $label = null;
       $result = $writer->write($qrCode, null, $label);
       header('Content-Type: '.$result->getMimeType());
       echo $result->getString();
       dd($result);

   }

   public static function down()
   {

   }
}

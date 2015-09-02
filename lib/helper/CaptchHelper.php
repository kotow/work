<?php

class Captcha
{
	private function generateCode($characters)
	{
		$possible = '23456789bcdfghjkmnpqrstvwxyz';
		$code = '';

		$i = 0;
		while ($i < $characters)
		{
			$code .= substr($possible, mt_rand(0, strlen($possible)-1), 1);
			$i++;
		}
		return $code;
	}

	public function Captcha($width='90',$height='40',$characters='4')
	{
		$fontLocation = sfConfig::get('sf_symfony_lib_dir')."/data/font/monofont.ttf";
		$code = $this->generateCode($characters);
		$font_size = $height * 0.85;
		$image = imagecreate($width, $height) or die('Cannot initialize new GD image stream');
		
		$background_color = imagecolorallocate($image, 255, 255, 255);

		$text_color = imagecolorallocate($image, 80, 90, 140);
		$noise_color = imagecolorallocate($image, 110, 130, 170);

		for( $i=0; $i<($width*$height)/3; $i++ )
		{
			imagefilledellipse($image, mt_rand(0,$width), mt_rand(0,$height), 1, 1, $noise_color);
		}

		for( $i=0; $i<($width*$height)/150; $i++ )
		{
			imageline($image, mt_rand(0,$width), mt_rand(0,$height), mt_rand(0,$width), mt_rand(0,$height), $noise_color);
		}

		$textbox = imagettfbbox($font_size, 0, $fontLocation, $code) or die('Error in imagettfbbox function');
		$x = ($width - $textbox[4])/2;
		$y = ($height - $textbox[5])/2;

		imagettftext($image, $font_size, 0, $x, $y, $text_color, $fontLocation, $code) or die('Error in imagettftext function');
		
		sfContext::getInstance()->getUser()->setAttribute('captcha_code', $code);
		
		header('Content-Type: image/jpeg');
		header('Cache-Control: no-cache, must-revalidate');

		imagejpeg($image);
		imagedestroy($image);
	}
}
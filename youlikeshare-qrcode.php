<?php
/*
Plugin Name: YouLikeShare QRCode
Plugin URI: http://wordpress.org/plugins/youlikeshare-qrcode/
Description: QRCode Image Generator. This plugin allowing you to create QRCode image in different qrcode type, error correction level, pixel, forecolor and backcolor.
Version: 1.0
Author: youlikeshare
Author URI: http://www.youlikeshare.com/
Contributors: youlikeshare
*/

function youlikeshare_qrcode_shortcode($attr) {
	extract(shortcode_atts(array(
		'type' => 'text', 
		'text' => '', 
		'ecl' => 'H', 
		'pixel' => '4', 
		'forecolor' => '#000000', 
		'backcolor' => '#ffffff', 
		'alt' => '', 
		'align' => 'left', 
		'inline' => 'true'
		), $attr, 'youlikeshare-qrcode'));
	
	//Contruct the parameter
	$type = in_array($type, array('text','url','tel','sms','email')) ? $type : 'text';
	$text = rawurlencode($text);
	$ecl= rawurlencode($ecl);
	$pixel = rawurlencode($pixel);
	$forecolor = rawurlencode(str_replace("#", "", $forecolor));
	$backcolor = rawurlencode(str_replace("#", "", $backcolor));
	$align = in_array($align, array('left', 'right', 'center', 'none')) ? $align : 'left';
	$inline = in_array($inline, array('true', 'false')) ? $inline : 'true';
	
	//Get the qrcode
	$qrcode_url = "http://qrcode.youlikeshare.com/api?type=$type&text=$text&ecl=$ecl&pixel=$pixel&forecolor=$forecolor&backcolor=$backcolor";
	$result = file_get_contents($qrcode_url);
	
	//Create the output image
	if ($inline == 'true'){
		$output = '<img src="' . $result . '" alt="' . $alt  . '" style="float:' . $align . '" />';
	}
	else{
		$output = '<div style="clear:both;"></div>';
		$output .= '<div style="display:block;width:100%;text-align:' . $align . '">';
		$output .= '<img src="' . $result . '" alt="' . $alt  . '" />';
		$output .= '</div>';
	}
	
	return $output;
}
add_shortcode('youlikeshare-qrcode', 'youlikeshare_qrcode_shortcode');
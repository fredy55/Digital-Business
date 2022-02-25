<?php

namespace App\Traits;

trait Codegen{
    public function idGenerate(){
		// six (6) digit user ID
		$today = date("Gis");
		$rand = sprintf("%04d", rand(0,999));
		$user_id = $rand.$today;
		return $user_id;
	}
	
	public function serialNum(){
		// six (6) digit user ID
		$today = date("Gsi");
		$rand = sprintf("%03d", rand(0,999));
		$sn = $today.$rand;
		return $sn;
	}
	
	//GENERATE CODE
	public function uniqCodeGen($length){      
		$chars = 'X3Bfhsed4bK29cJK65EGbv665VfKJ776ttg76HG6tr7090hgg9112gfTT43HH6hjgEW55TG78N9d6Zgh4j1ED73SGl8m54nKp123rsHt5E45W45GVes765GsCe43J0221K41abW43Emn79877kDR900ES46KS82zaeiou01U34TR2j345TRe56ds6789';
		$result = '';

		for ($p = 0; $p < $length; $p++){
			$result .= ($p%2) ? $chars[mt_rand(19, 23)] : $chars[mt_rand(0, 18)];
		}
		return $result;
	}
}
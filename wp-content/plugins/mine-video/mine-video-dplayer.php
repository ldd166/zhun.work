<?php
if(!defined('ABSPATH'))exit;

define('MINEVIDEODPLAYER_URL', plugins_url('', __FILE__));
define('MINEVIDEODPLAYER_VERSION', '1.0.0');

//dplayer
function mine_video_jxapistr_dplayer($jxapistr_cur, $typearr, $jxapi_cur, $r, $ti){
	$mine_video_dplayer_config = json_decode(get_option('mine_video_dplayer_config'), true);
	$mine_dplayerconfig = '';
	foreach($mine_video_dplayer_config as $k=>$v){
		if(in_array($k, array('autoplay','loop','screenshot','hotkey','contextmenu','mutex')))
			$mine_dplayerconfig .= $k.':'.$v.',';
		else
			$mine_dplayerconfig .= $k.':\''.$v.'\',';
	}
	if(strtolower($jxapi_cur) == 'dplayer'){
		wp_enqueue_script('mine_dplayer_hls', MINEVIDEODPLAYER_URL.'/dplayer/hls.min.js',  MINEVIDEODPLAYER_URL, MINEVIDEODPLAYER_VERSION , false );
		wp_enqueue_script('mine_dplayer_2', MINEVIDEODPLAYER_URL.'/dplayer/DPlayer.min.js',  MINEVIDEODPLAYER_URL, MINEVIDEODPLAYER_VERSION , false );
		wp_add_inline_script('mine_dplayer_2','
		var dplayerconfig_'.$r.'={'.$mine_dplayerconfig.'};
		var dplayer_'.$r.';
		function mine_dplayer(pid,cur){
			if(!window.dplayer_'.$r.'){
			document.getElementById(\'playleft_\'+pid).innerHTML = \'\';
			window.dplayerconfig_'.$r.'.container = document.getElementById("playleft_"+pid);
			window.dplayerconfig_'.$r.'.video = {url:unescape(cur.video)};
			window.dplayer_'.$r.' = new DPlayer(window.dplayerconfig_'.$r.');
			window.dplayer_'.$r.'.play();
		}else{
			window.dplayer_'.$r.'.switchVideo({url:unescape(cur.video)});
			window.dplayer_'.$r.'.play();
		}}');
		return '<input type="hidden" id="mine_ifr_'.$typearr[$ti].'_'.$r.'" value=\''.$jxapi_cur.'\'/>';
	}
	return $jxapistr_cur;
}
add_filter('mine_video_jxapistr', 'mine_video_jxapistr_dplayer', 10, 5);

//dplayer_live
function mine_video_jxapistr_dplayer_live($jxapistr_cur, $typearr, $jxapi_cur, $r, $ti){
	$mine_video_dplayer_config = json_decode(get_option('mine_video_dplayer_config'), true);
	$mine_dplayerconfig = '';
	foreach($mine_video_dplayer_config as $k=>$v){
		if(in_array($k, array('autoplay','loop','screenshot','hotkey','contextmenu','mutex')))
			$mine_dplayerconfig .= $k.':'.$v.',';
		else
			$mine_dplayerconfig .= $k.':\''.$v.'\',';
	}
	if(strtolower($jxapi_cur) == 'dplayer_live'){
		wp_enqueue_script('mine_dplayer_hls', MINEVIDEODPLAYER_URL.'/dplayer/hls.min.js',  MINEVIDEODPLAYER_URL, MINEVIDEODPLAYER_VERSION , false );
		wp_enqueue_script('mine_dplayer_2', MINEVIDEODPLAYER_URL.'/dplayer/DPlayer.min.js',  MINEVIDEODPLAYER_URL, MINEVIDEODPLAYER_VERSION , false );
		wp_add_inline_script('mine_dplayer_2','
		var dplayerconfig_'.$r.'={'.$mine_dplayerconfig.'};
		var dplayer_'.$r.';
		function mine_dplayer_live(pid,cur){
			if(!window.dplayer_'.$r.'){
			document.getElementById(\'playleft_\'+pid).innerHTML = \'\';
			window.dplayerconfig_'.$r.'.live = true;;
			window.dplayerconfig_'.$r.'.container = document.getElementById("playleft_"+pid);
			window.dplayerconfig_'.$r.'.video = {url:unescape(cur.video)};
			window.dplayer_'.$r.' = new DPlayer(window.dplayerconfig_'.$r.');
			window.dplayer_'.$r.'.play();
		}else{
			window.dplayer_'.$r.'.switchVideo({url:unescape(cur.video)});
			window.dplayer_'.$r.'.play();
		}}');
		return '<input type="hidden" id="mine_ifr_'.$typearr[$ti].'_'.$r.'" value=\''.$jxapi_cur.'\'/>';
	}
	return $jxapistr_cur;
}
add_filter('mine_video_jxapistr', 'mine_video_jxapistr_dplayer_live', 10, 5);

function mine_video_setting_tab_item_dplayer($item){
	return $item.'<div class="layui-tab-item">
			<div class="layui-form-item layui-form-text">
				<label class="layui-form-label">DPlayer配置</label>
				<div class="layui-input-block">
					<textarea placeholder="请输入内容" class="layui-textarea" name="mine_video_dplayer_config" style="min-height:200px;">'.get_option('mine_video_dplayer_config').'</textarea>
				</div>
			</div>
		</div>';
}
add_filter('mine_video_setting_tab_item', 'mine_video_setting_tab_item_dplayer', 10, 1);
function mine_video_setting_tab_title_dplayer($title){
	return $title.'<li>DPlayer配置</li>';
}
add_filter('mine_video_setting_tab_title', 'mine_video_setting_tab_title_dplayer', 10, 1);

function mine_video_options_save_dplayer(){
	$mine_video_dplayer_config =	sanitize_textarea_field(stripslashes($_POST['mine_video_dplayer_config']));
	update_option('mine_video_dplayer_config', $mine_video_dplayer_config);
}
add_action('mine_video_options_save', 'mine_video_options_save_dplayer');

function mine_video_dplayer_init(){
	if(!get_option('mine_video_dplayer_config') || get_option('mine_video_dplayer_config')=='')update_option('mine_video_dplayer_config','{
		"autoplay":"false"
		,"theme":"#b7daff"
		,"logo":"'.MINEVIDEO_URL.'/images/logo.png"
		,"loop":"true"
		,"lang":"zh-cn"
		,"hotkey":"true"
		,"preload":"auto"
		,"volume":"0.7"
		,"contextmenu":"[{text: \'custom link\',link: \'https://www.zwtt8.com/\'},{text: \'mine video player\',link: \'https://www.zwtt8.com/\'}]"
		,"mutex":"true"
	}');
}
register_activation_hook(__FILE__,	'mine_video_dplayer_init');
?>
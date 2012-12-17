<?php
/**
 * @package sourceforge-email-configure
 * @version 1.0.1
 */
/*
Plugin Name: SourceForge Project Web Email Configuration
Plugin URI: http://opoo.org/sourceforge-wordpress-email-configuration/
Description: This plugin help you configure the email(smtp) functions for your WordPress hosted on SourceForge.net Project Web. 在SourceForge的<a href="http://sourceforge.net/apps/trac/sourceforge/wiki/Project%20web">Project Web</a>或User Web中安装WordPress时，无法通过WordPress默认的方法发送邮件，但可以通过SourceForge提供的方法发送邮件（<a href="http://sourceforge.net/apps/trac/sourceforge/wiki/Project%20Web%20Email%20Configuration">Project Web Email Configuration</a>）。插件将SourceForge提供的Email配置HOOK到WordPress的wp_mail()函数里，使得邮件功能在SourceForge空间下也可以正常工作。在启用插件后，可到选项配置界面进行参数设置。
Author: Alex Lin
Version: 1.0.1
Author URI: http://opoo.org/about/
*/
//如果觉得插件名称太长，可以修改Plugin Name为: SourceForge邮件配置
//Name is too long? change it to 'SourceForge email configure'


//启用插件时
function sec_plugin_activate(){
	if(!get_option('sec_plugin_clean_option')) {
		update_option("sec_plugin_clean_option", 'no');
	}
	if(!get_option('sec_plugin_smtp_secure')) {
		update_option("sec_plugin_smtp_secure", 'tls');
	}
	if(!get_option('sec_plugin_from_name')) {
		update_option("sec_plugin_from_name", get_option('blogname'));
	}
	if(!get_option('sec_plugin_from')) {
		update_option("sec_plugin_from", trim(get_bloginfo('admin_email')));
	}
}

//禁用插件时
function sec_plugin_deactivate(){
	if(get_option('sec_plugin_clean_option') == 'yes'){
		delete_option('sec_plugin_clean_option');
		delete_option('sec_plugin_smtp_secure');
		delete_option('sec_plugin_project_name');
		delete_option('sec_plugin_project_web_password');
		delete_option('sec_plugin_from');
		delete_option('sec_plugin_from_name');
	}
}

//菜单
function sec_plugin_menu() {
    if (function_exists('add_options_page')) {
		add_options_page('SourceForge Email Configure', 'SourceForge Email Configure', 8,  basename(__FILE__), 'sec_plugin_options_page');
		add_filter('plugin_action_links', 'sec_plugin_actions_links', 10, 2);
    }
}

//设置按钮
function sec_plugin_actions_links($links, $file){
	static $this_plugin;

	if( !$this_plugin ) $this_plugin = plugin_basename(__FILE__);

	if( $file == $this_plugin ){
		$settings_link = '<a href="options-general.php?page=sourceforge-email-configure.php">设置</a>';
		$links = array_merge( array($settings_link), $links); // before other links
	}
	return $links;
}


//插件选项页
function sec_plugin_options_page() {

	$message_update = '';
	
	if ( isset($_POST['stage']) && ('update' == $_POST['stage']) ) {
		update_option('sec_plugin_clean_option',	$_POST['clean_option']);
		update_option('sec_plugin_smtp_secure',		$_POST['smtp_secure']);
		update_option('sec_plugin_project_name',	$_POST['project_name']);
		update_option('sec_plugin_project_web_password', $_POST['project_web_password']);
		update_option('sec_plugin_from',			$_POST['from']);
		update_option('sec_plugin_from_name',		$_POST['from_name']);

		$message_update = '<br class="clear"><div class="updated"><p>';
		$message_update.= 'SourceForge Email Configuration updated. 邮件配置已经更新！ ';
		$message_update.= '</p></div>';
	}

	$sf_clean_option		= get_option('sec_plugin_clean_option');
	$sf_smtp_secure			= get_option('sec_plugin_smtp_secure');
	$sf_project_name		= get_option('sec_plugin_project_name');
	$sf_project_web_password = get_option('sec_plugin_project_web_password');
	$sf_from				= get_option('sec_plugin_from');
	$sf_from_name			= get_option('sec_plugin_from_name');

?>


<div class="wrap">
	<div id="icon-options-general" class="icon32"><br /></div>
	<h2>SourceForge Project Web Email Configuration</h2>
	<?php echo $message_update; ?>

	<div class="widget"><div style="margin:12px;line-height: 1.6em;">
	<p>This plugin help you configure the email(smtp) functions for your WordPress that hosted on SourceForge.net Project Web. </p>
	<p>以下选项用于配置在SourceForge Project Web空间安装的
	WordPress的邮件发送功能。如果您正在使用SourceForge Project Web空间，那么您一定有自己的项目，下面需要填写项目名称（Project Name）
	和您在SourceForge设置的项目网站密码（Project Web Password），SourceForge空间将使用这些参数发送邮件。<a href="http://sourceforge.net/apps/trac/sourceforge/wiki/Project%20Web%20Email%20Configuration">配置请参考这里</a>。</p>
	<p><b>项目网站密码</b>的设置方式是：登录<a href="http://sourceforge.net" target="_blank">SourceForge.net</a>，打开您的项目，切到菜单"Project Admin" -> "Features"，
	在Project Web的那行后面点击"Manage"，在出来的界面中设置一个项目网站密码，点击"Set Passwords"按钮保存密码。
	这个密码就是要填写在下表的密码。</p>
	<p>更多内容请阅读<a href="http://opoo.org/sourceforge-wordpress-email-configuration/" target="_blank">插件主页</a>。</p>
	</div></div>

	
	<form name="form1" method="post" action="">
		<input type='hidden' name='stage' value='update' />
		
		<h3>Base Settings(基本配置)</h3>
		<table class="form-table">
			<tr>
				<th scope="row"><label for="smtp_secure">SMTP Secure:</label></th>
				<td><select name="smtp_secure" id="smtp_secure">
					<option value='tls' <?php echo ($sf_smtp_secure === "tls") ? 'selected' : ''; ?>>TLS</option>
					<option value='ssl' <?php echo ($sf_smtp_secure === "ssl") ? 'selected' : ''; ?>>SSL</option></select> 
					<span class="description">&nbsp;</span>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="project_name">Project Name(项目名称):</label></th>
				<td><input name="project_name" type="text" id="project_name" value="<?php echo $sf_project_name; ?>" class="regular-text" /><br>
				<span class="description">The name of your project that hosted on SourceForge.net. 您在SourceForge上的项目名称。</span></td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="project_web_password">Project Web Password(项目网站密码):</label></th>
				<td><input name="project_web_password" type="text" id="project_web_password" value="<?php echo $sf_project_web_password; ?>" class="regular-text" /><br>
				<span class="description">The password you configured for your project, See <a href="http://sourceforge.net/apps/trac/sourceforge/wiki/Project%20Web%20Email%20Configuration">Project Web Email Configuration</a> . 您在SourceForge的Project Web上设置的密码，见SourceForge上的相关文档。</span></td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="from">From(发送地址):</label></th>
				<td><input name="from" type="text" id="from" value="<?php echo $sf_from; ?>" class="regular-text" /><br>
				<span class="description">Could be your Sourceforge.net mail alias, sush as <code>yourname@users.sourceforge.net</code>. <a href="https://sourceforge.net/account/mailings" target="_blank">This page</a> show your SourceForge.net mail alias. 可以使用SourceForge提供的邮件别名，例如<code>yourname@users.sourceforge.net</code>。</span></td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="from_name">From Name(发件人):</label></th>
				<td><input name="from_name" type="text" id="from_name" value="<?php echo $sf_from_name; ?>" class="regular-text" /><br>
				<span class="description">Default value is your blog name, you can change it. 默认是是你的博客名称，可修改，比如“WordPress”。</span></td>
			</tr>
		</table>

		<h3>Delete Settings(删除配置)</h3>
		<table class="form-table">
			<tr>
				<th scope="row"><label for="clean_option">Delete plugin options after deactivate</label></th>
				<td valign="middle">
				<span><input type="checkbox" name="clean_option" id="clean_option" value="yes" <?php if ($sf_clean_option === 'yes') { ?> checked="checked"<?php } ?>/></span>
				<span><label for="clean_option">check this if you want to delete all plugin options after deactivate this plugin。
				如果想要在禁用插件后删除配置, 请在这里打勾。</label></span>
				</td>
			</tr>
		</table>

		<p class="submit"><input type="submit" name="submit" id="submit" class="button-primary" value="保存更改"/></p>
	</form>


	<div class="widget"><p style="margin:15px;">
	<strong>Links</strong>
	<ul style="padding-left:40px;">
	<li><a href="http://opoo.org/sourceforge-wordpress-email-configuration/" title="SourceForge Project Web Email Configuration for WordPress">Plugin Homepage</a></li>
	<li><a href="http://sourceforge.net/apps/trac/sourceforge/wiki/Project%20web" title="SourceForge Project Web">SourceForge Project Web</a></li>
	<li><a href="http://sourceforge.net/apps/trac/sourceforge/wiki/Project%20Web%20Email%20Configuration" title="SourceForge Project Web Email Configuration">SourceForge Project Web Email Configuration</a></li>

	</ul>
	</p></div>
</div>

<?php
}



//使用SourceForge的Email配置来初始化PHPMailer对象
function phpmailer_init_sourceforge($phpmailer) {
	$sf_smtp_secure			= get_option('sec_plugin_smtp_secure');
	$sf_project_name		= get_option('sec_plugin_project_name');
	$sf_project_web_password = get_option('sec_plugin_project_web_password');
	$sf_from				= get_option('sec_plugin_from');
	$sf_from_name			= get_option('sec_plugin_from_name');
	
	//error_log($sf_smtp_secure . ' ' . $sf_project_name . ' ' . $sf_project_web_password . ' ' . $sf_from . ' ' . $sf_from_name);

	if(!($sf_project_name) || !($sf_project_web_password) || !($sf_from)){
		//error_log('SourceForge Email Configure options missing, please check!');	
		return;
	}

	if($sf_smtp_secure === 'ssl'){
		//$phpmailer->Host = 'ssl://prwebmail';
		$phpmailer->Port = 465;
		$phpmailer->SMTPSecure = 'ssl';
	}else{
		//$phpmailer->Host = 'prwebmail';	
		$phpmailer->Port = 25;
		$phpmailer->SMTPSecure = 'tls';
	}

	$phpmailer->Host = 'prwebmail';	
	$phpmailer->Username = $sf_project_name;
	$phpmailer->Password = $sf_project_web_password;
	$phpmailer->From = $sf_from;

	if($sf_from_name){
		$phpmailer->FromName = $sf_from_name;
	}else{
		$phpmailer->FromName = 'WordPress';
	}
	
	$phpmailer->SMTPAuth = true;
	$phpmailer->IsSMTP();


	/*
	//$phpmailer->FromName = 'WordPress';
	$phpmailer->Host = 'prwebmail';				//host: prwebmail (or ssl://prwebmail)
	//$phpmailer->Port = 25;					//port: 25 (or 465 for ssl)
	$phpmailer->Username = 'YOUR_PROJECT_NAME';	//user: YOUR_PROJECT_NAME
	$phpmailer->Password = 'PASSWORD';			//password: THE_PASSWORD_YOU_CONFIGURED_FOR_YOUR_PROJECT, As set on your project's config page;
	$phpmailer->From = 'someone@example.com';	//eg. yourname@users.sourceforge.net
	$phpmailer->SMTPAuth = true;
	$phpmailer->SMTPSecure = 'tls';				//tls or ssl
	$phpmailer->IsSMTP();
	*/
}

//参考wp_mail()函数中的代码: do_action_ref_array( 'phpmailer_init', array( &$phpmailer ) );
add_action( 'phpmailer_init', 'phpmailer_init_sourceforge');

//菜单
add_action('admin_menu', 'sec_plugin_menu');

//启用时
register_activation_hook( __FILE__, 'sec_plugin_activate' );

//禁用时
register_deactivation_hook( __FILE__, 'sec_plugin_deactivate' );
?>

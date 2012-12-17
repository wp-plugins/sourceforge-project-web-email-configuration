=== SourceForge Project Web Email Configuration ===
Contributors: opoo.org
Tags: sourceforge, email, smtp, 邮件配置
Requires at least: 3.0
Tested up to: 3.5
Stable tag: trunk
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Donate link: http://opoo.org/

This plugin help you configure the email(smtp) functions for your WordPress hosted on SourceForge.net Project Web.

== Description ==

This plugin help you configure the email(smtp) functions for your WordPress hosted on SourceForge.net Project Web. 
在SourceForge的Project Web或User Web中安装WordPress时，无法通过WordPress默认的方法发送邮件，但可以通过SourceForge提供的方法发送邮件。插件将SourceForge提供的Email配置HOOK到WordPress的wp_mail()函数里，使得邮件功能在SourceForge空间下也可以正常工作。

= !PLEASE NOTE!  注意！ =
* This plugin is **ONLY** for the WordPress installed in (hosted on) SourceForge.net Project Web space.
* 这个插件**仅用于**安装在SourceForge.net的Project Web空间中的WordPress。

= Related Links =

* <a href="http://opoo.org/sourceforge-wordpress-email-configuration/" title="SourceForge Project Web Email Configuration for WordPress">Plugin Homepage（插件主页）</a>
* <a href="http://sourceforge.net/apps/trac/sourceforge/wiki/Project%20web" title="SourceForge Project Web">SourceForge Project Web</a>
* <a href="http://sourceforge.net/apps/trac/sourceforge/wiki/Project%20Web%20Email%20Configuration" title="SourceForge Project Web Email Configuration">SourceForge Project Web Email Configuration</a>


== Installation ==

1. Unzip the ZIP file and drop the folder straight into your `wp-content/plugins/` directory. 下载插件并解压至`wp-content/plugins/`目录。
2. Activate the plugin through the 'Plugins' menu in WordPress. 在WordPress的插件管理中启用该插件。
3. Configure the plugin options. 在插件选项配置页面中配置该插件。


== Changelog ==

= 1.0.1 =
* 修正了使用SSL协议无法发送邮件的问题。

= 1.0 =
* 正式版本1，带有选项配置界面。

== Screenshots ==
1. The plugin option page(插件选项页面截图): `/trunk/screenshot-1.png`

== Frequently Asked Questions ==
No content yet.

== Upgrade Notice ==
No content yet.


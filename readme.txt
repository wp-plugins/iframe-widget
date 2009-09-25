=== IFrame Widget ===
Contributors: debashish
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=P65K7JVX4EXP6&lc=IN&item_name=Wordpress%20Plugin&item_number=iframe%2dwidget&currency_code=USD&bn=PP%2dDonationsBF%3abtn_donate_SM%2egif%3aNonHosted
Tags: iframe,widget,HTML,iframe-widget
Requires at least: 2.3
Tested up to: 2.8
Stable tag: 3.0

IFrame widget can display any external HTML page inside an HTML IFrame component.

== Description ==
This simple IFrame widget can display any external HTML page inside an [HTML IFrame](http://www.htmlhelp.com/reference/html40/special/iframe.html "Know more about IFrames") component. The need came from the Hindi Tagcloud JSP that I had once created for [Chittha Vishwa](http://www.myjavaserver.com/~hindi "Chittha Vishwa, Hindi for World of Blogs, is the first ever Hindi blog aggregator") and I always thought that there should be some way to display that page on my blog (if you are as lazy to edit your blog theme files, you would agree with me).

== Installation ==

1. Download and unzip iframe-widget.zip 
1. Upload the folder containing `iframe-widget.php` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. To add an IFrame on a sidebar, browse to Design > Widgets and add the 'IFrame Widget" to desired sidebar. Configure the IFrame Title, Dimensions and URL and save your changes.
1. To add IFrames to any post or page just add the markup `[dciframe]url,width,height[/dciframe]`, for instance `[dciframe]http://www.google.com,400,250[/dciframe]`.

== Frequently Asked Questions ==

= I see a scroll-bar around the webpage on the IFrame =

If the dimension of the webpage you are trying to display within the IFrame exceeds the configured dimension of the IFrame it will automatically add scrollbars. Try to include a webpage that could fit within the IFrame.

= I don't see any border around my IFrame =

Borders have been deliberately turned off in the plugin. If you want to get rid of this you may edit the `iframe-widget.php` and remove all occurances of the HTML code `frameborder="0"`.

= How do I add an IFrame to a blog-post =

To add IFrames to any post or page just add the markup `[dciframe]url,width,height[/dciframe]`, for instance `[dciframe]http://www.google.com,400,250[/dciframe]`. Note that supplying the URL is mandatory while the width and height parameters are optional. Which means that you may specify only the URL or only the URL & width. Therefore, `[dciframe]http://www.google.com,400[/dciframe]` and `[dciframe]http://www.google.com[/dciframe]` are valid tags. Also note that the order of width & height is important and URL, Width and Height must be separated with commas. Lastly, the closing tag `[/dciframe]` is mandatory.

= Can I add multiple IFrames on a Post or Page? =

Yes you can. Just add multiple `[dciframe]` tags where required. All of these can be configured independently.

= Can I add multiple IFrame Widgets on sidebar? =

Unfortunately no. As of now you can only add one instance of IFrame Widget on sidebar.

== Screenshots ==

1. Configure your IFrame. 
2. This is how the widget looks like on sidebar after configuration. 

== Changelog ==

*	**3.0**: Bug fix: is_nan changed to is_numeric (Thanks eddan). Paypal link corrected. Tested on Wordpress 2.8.
*	**2.0**: New feature: Multiple IFrames can now be added on Wordpress Posts and Pages.
*	**1.0**: Initial public release.
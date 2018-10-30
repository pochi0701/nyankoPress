NyankoPress
=============

Nanko Press is CMS written in PHP. I used one line template engine. The one line template engine is function using "include"  like below.

```php
$header  = function_name($param){global $theme;extract($param);include "themes/{$theme}/header.php";};
```

This is function for theme.The theme is change using global variable {$theme}.

Functions
===========
1. using bootstrap
   All codes are written by Bootstrap. So you can use bootstrap code in article.
2. snippet
   Suppot bootstrap snippets. I imported BootstrapSnippets from VisualStudiCode and change XML format to php format.
   You can use snippets in blog editor and fixed page editor.(Eg carousel,form inline ...)
3. themes
   Themes are enabled. Theme A theme is made from 4 parts.main index(blog top),main(each blog),header,footer.very simple.
   Now standard(white base),ver001(black base, fixed top menu) are avaiable.
4. widgets
   A widget can be arranged in main index, main, the right and the left.
   Youtube widget, calendar widget, back to top icon widget are avaiable.
5. php native mode
   You can write native php in article. Just check php enable in editor.

//Note:If you use english, copy xxx_eng.php to xxx.php.

## installation
I recommend you PHP version more than 5.
Copy all source to some folder. Then chmod 644 to db folder,/system/settings.php and /widget/xxx/settings.php.Other files are 640. 
First time access /index/system/login.php. Change tab to Account. And enter your Email, name(as author), password. 
Anyone can access login.php, so must set your account first.

## themes
To add theme, Just add programs to /themes/"YOUR THEME". At least mainidx.php(blog top),main.php,header.php,footer.php,settings.php are required.See /themes/standard/.
Now standard and ver001 are avaiable.

## widget
And can use global variable $_widgets['your widget'].To make widget, write index.php and settings.php to /widget/"widget name"/. settings.php is data for settings.$settings are each data. and $attirbutes are edit information.
$attibute['field name'] = array('description'=>'field type');
T means Text. C means CheckBox. A means Array. R means Requied. So 'TA' means text array. 'TR' means text required.
```php
<?php
$settings=array();
$settings['name'] = array('EUmW4FblppU','3SEXokSxZBI');
$settings['width'] = '100%';
$settings['height'] = '256px';
$settings['allowfullscreen'] = 'on';
$settings['autoplay'] = '';
$attribute=array();
$attribute['name'] = array('YoutubeID'=>'TA');
$attribute['width'] = array('display width'=>'T');
$attribute['height'] = array('display height'=>'T');
$attribute['allowfullscreen'] = array('fullscreen'=>'C');
$attribute['autoplay'] = array('autoplay'=>'C');
```
Now new type widget avarable. BACK2TOP displays Icon back to top. This program consists of as follows.
You can insert code into header(bottom of header),top(top of body),bottom(bottom of body),footer(top of footer);

```php
    if       ( $location=='header'){
    ...
    }else if ( $location=='top'){
    ...
    }else if ( $location=='bottom'){
    ...
    }else if ( $location=='footer'){
    ...
    }

```

## database
No database used.Articles are saved as JSON.

## snippets
Snippets are some function of Bootstrap( or html or Javascript).
Avarable snippets are bellow.

```
accordion.snippet
alert.snippet
badge.snippet
blockquote.snippet
breadcrumb.snippet
btn-dropdown.snippet
btn-dropdown-split.snippet
btn-group.snippet
btn-toolbar.snippet
carousel.snippet
collapse.snippet
form-group-checkbox.snippet
form-group-horizontal-checkbox.snippet
form-group-horizontal.snippet
form-group-inline.snippet
form-group-radio.snippet
form-group-select.snippet
form-group.snippet
form-horizontal.snippet
form-inline.snippet
form.snippet
glyphicon.snippet
input-group.snippet
jumbotron.snippet
label.snippet
list-group.snippet
media-list.snippet
media-object.snippet
modal-lg.snippet
modal-sm.snippet
modal.snippet
navbar.snippet
nav-pills.snippet
nav-tabs.snippet
page-header.snippet
pager.snippet
pagination.snippet
panel.snippet
popover.snippet
progress-bar.snippet
template.snippet
thumbnail.snippet
tooltip.snippet
```
See Microsoft snippet version 1.0.0.
you can convert xml to snippet.

## misc
Native flag enable php codes.Just check native check box in editor.
and p tag checkbox quote paragraph in p tag.(bugly) 

Demo site.(Japanese) http://neon.cx


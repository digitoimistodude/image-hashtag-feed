| :bangbang: | **This repository is no longer actively maintained. The plugin still works, but does not receive any further updates other than community contributed fixes.**  |
|:------------:|:------------------------------------------------------------------------------------------------------------------------------------------------------------------------|

# Image hashtag feed
WordPress plugin to get Instagram hashtag feeds working again by bypassing the API. Handcrafted with love at [Digitoimisto Dude Oy](http://dude.fi), a Finnish boutique digital agency in the center of Jyväskylä.

The Instagram fetcher is based on [Instagram-Hashtag-Grabber](https://github.com/Bolandish/Instagram-Hashtag-Grabber) from [Thomas Bolander](https://github.com/Bolandish) and settings page is made with excellent [Simple Admin Pages](https://github.com/NateWr/simple-admin-pages) library made by [Nate Wright](https://github.com/NateWr).

## Table of contents
1. [Please note before using](#please-note-before-using)
2. [License](#license)
    1. [Legal](#legal)
3. [Usage](#usage)
    1. [Settings](#settings)
    2. [Functions](#functions)
    3. [Hooks](#hooks)
4. [Composer](#composer)
5. [Contributing](#contributing)

### Please note before using
Image hashtag feed plugin is not meant to be "plugin for everyone", it needs at least some basic knowledge about php and css to add it to your site and making it look beautiful.

This is a plugin in development for now, so it may update very often because new features and changes in Instagram's end. By using this plugin, you agree that the anything can change to a different direction without a warning.

#### Legal
Please be aware that Instagram prohibits crawling, scraping and caching in their [TOC](https://help.instagram.com/478745558852511). This plugin uses same endpoint that Instagram is using in their own site, so it's arguable if TOC can prohibit the use of openly available information.

There has been few [court cases in United States](https://en.wikipedia.org/wiki/Web_scraping#Legal_issues), where the court has ruled that scraping is illegal. In Europe, there have been also few similar cases. None of these cases have had Instagram involved.

**This being said, use your own consideration whether you wan't to use this plugin.**

### License
Image hashtag feed is released under the GNU GPL 2 or later.

### Usage
#### Settings
Settings page can be found from `Settings` -> `Image hashtag feed`.

From settings page you can set which hashtag to use and check when the last fetch from Instagram was made. Hashtag can be also set dynamically from functions described below.

#### Functions
Plugin brings few functions to use in your site.

##### `get_the_dude_img_hashfeed_raw`
Returns array of objects received from Instagram. Object contains all basic details about the image; timestamp, comment and like counts, caption, author information and src to use when displaying image. These can be changed with [filter](#hooks).

```
object(stdClass)#1211 (10) {
    ["code"]=>
    string(11) "BGY_ICpOF0S"
    ["date"]=>
    int(1465382279)
    ["comments"]=>
    object(stdClass)#1212 (1) {
      ["count"]=>
      int(0)
    }
    ["caption"]=>
    string(80) "Some new swag arrived from @digitalocean sticker department <3 #digitoimistodude"
    ["likes"]=>
    object(stdClass)#1213 (1) {
      ["count"]=>
      int(0)
    }
    ["owner"]=>
    object(stdClass)#1214 (2) {
      ["username"]=>
      string(9) "wahalahti"
      ["id"]=>
      string(10) "3038518606"
    }
    ["thumbnail_src"]=>
    string(161) "https://scontent-arn2-1.cdninstagram.com/t51.2885-15/s640x640/sh0.08/e35/13397680_922638724525249_472586061_n.jpg?ig_cache_key=MTI2ODA0MDkyNDYyOTg1MTQxMA%3D%3D.2"
    ["is_video"]=>
    bool(false)
    ["id"]=>
    string(19) "1268040924629851410"
    ["display_src"]=>
    string(145) "https://scontent-arn2-1.cdninstagram.com/t51.2885-15/e35/13397680_922638724525249_472586061_n.jpg?ig_cache_key=MTI2ODA0MDkyNDYyOTg1MTQxMA%3D%3D.2"
  }
 ```

##### `get_the_dude_img_hashfeed_thumbnails`
Returns string containing all images in html img -tag, `<img src='thumbnail_src' alt='caption' />`.

##### `the_dude_img_hashfeed_thumbnails`
Displays all images in html img -tag, `<img src='thumbnail_src' alt='caption' />`.

#### Hooks
There are few filters where you can hook and change functionality of plugin.

##### `dude_img_hashfeed_insta_count`
Change amount of images to fetch and store. Default value is 10.

Usage is simple; add `add_filter( 'dude_img_hashfeed_insta_count', function() { return 2; } );` to your theme functions.php file.

##### `dude_img_hashfeed_insta_count_{$hashtag}`
Change amount of images to fetch and store by hashtag. Defaults to `dude_img_hashfeed_insta_count` value.

##### `dude_img_hashfeed_insta_transient_lifetime`
Images are stored to transient in favor of caching and reducing page load time. By default, lifetime is five minutes and after that new images are fetched from Instagram when calling one of previously listed functions.

Use [WordPress transient expiration syntax](http://codex.wordpress.org/Transients_API#Using_Time_Constants).

##### `dude_img_hashfeed_insta_fetch_parameters`
By default we are asking instagram to return timestamp, comment and like counts, caption, author information, image addresses and possible video address. This can be changed, but be aware that `$hashtag` and `$count` are mandatory.

```
ig_hashtag($hashtag) { media.first($count) { count, nodes { caption, code, comments { count }, date, display_src, id, is_video, likes { count }, owner { id, username }, thumbnail_src, video_views, video_url }, page_info } }
```

### Composer

To use with composer, run `composer require digitoimistodude/image-hashtag-feed dev-master` in your project directory or add `"digitoimistodude/image-hashtag-feed":"dev-master"` to your composer.json require.

### Contributing
If you have ideas about the theme or spot an issue, please let us know. Before contributing ideas or reporting an issue about "missing" features or things regarding to the nature of that matter, please read [Please note section](#please-note-before-using). Thank you very much.

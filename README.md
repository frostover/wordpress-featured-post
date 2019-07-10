WPEngine Featured Posts w/ REST
============

Contributors: [Nathan Corbin](http://nathanonline.us)

Requires Wordpress: ![5.2.2](https://wordpress.org/download)

Tested up to: 5.2.2

License: GPLv2 or later

License URI: http://www.gnu.org/licenses/gpl-2.0.html

Description
============

Enables users to define Posts that will be labeled as 'Featured on WPEngine Blog' which will enable them to be accessed through a REST API.

**No dependencies or third party plugins are required**

Screenshots
============

Post List Filtering
------------
![Post list filtering](https://puu.sh/DQSwQ/5966f256fe.png)

Edit Post - WPEngine Featured Post
------------
![wpengine featured post option](https://puu.sh/DQSwA/5d2038f73d.png)


Installation
============

This section describes how to install the plugin and get it working.

1. Upload `wpengine-featured-post-rest.zip` via the Plugin menu (Add New).
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Select posts that should be considered featured, that's it.

REST API
============

**URL:** ``/wp-json/wp/v2/posts/wpengine-featured``

**Method:** ``GET``

**Response**
```
[
  {
    "ID": 9,
    "post_author": "1",
    "post_date": "2019-07-09 01:52:09",
    "post_date_gmt": "2019-07-09 01:52:09",
    "post_content": "<!-- wp:paragraph -->\n<p>test</p>\n<!-- /wp:paragraph -->",
    "post_title": "Featured Post Sample",
    "post_excerpt": "",
    "post_status": "publish",
    "comment_status": "open",
    "ping_status": "open",
    "post_password": "",
    "post_name": "featured-post-sample",
    "to_ping": "",
    "pinged": "",
    "post_modified": "2019-07-09 16:28:41",
    "post_modified_gmt": "2019-07-09 16:28:41",
    "post_content_filtered": "",
    "post_parent": 0,
    "guid": "https://wpengine.nathanonline.us/?p=9",
    "menu_order": 0,
    "post_type": "post",
    "post_mime_type": "",
    "comment_count": "0",
    "filter": "raw"
  }
]
```

Improvements
============

- Could use JSX and SCSS

Frequently Asked Questions
============

What is this plugin for?
------------

This plugin adds a simple meta field to the `posts` page that allows users to note featured posts that are displayed via WP REST API.

Does this use any third party plugins?
------------

No.

Will this interfere with any other plugins?
------------

Highly unlikely this will cause any issues with other plugins.

Changelog
============

### 1.0
* Plugin creation.

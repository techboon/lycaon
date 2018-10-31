# Lycaon rss/atom reader

[![Build Status](https://travis-ci.org/techboon/lycaon.svg?branch=master)](https://travis-ci.org/techboon/lycaon)

## usage
```
$ git clone git@github.com:techboon/lycaon.git
$ cd lycaon/
$ php -a
Interactive shell

php > require_once('vendor/autoload.php');
php > $feed = Lycaon\Lycaon::url('RSS/ATOM FEED URL');
php > echo $feed->site()->title();
[FEED TITLE]
php > foreach($lycaon->posts() as $post) { echo $post->title() . "\n"; }
[POST 1]
[POST 2]
[POST 3]
```

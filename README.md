# sitemap

[![Build Status](https://magnum.travis-ci.com/refinery29/sitemap.svg?token=WxyzZysW5QK9hWX3J4Yg&branch=master)](https://magnum.travis-ci.com/refinery29/sitemap)
[![Code Climate](https://codeclimate.com/repos/56097df9e30ba0204400134a/badges/20b2bfd26b3fe961243f/gpa.svg)](https://codeclimate.com/repos/56097df9e30ba0204400134a/feed)
[![Test Coverage](https://codeclimate.com/repos/56097df9e30ba0204400134a/badges/20b2bfd26b3fe961243f/coverage.svg)](https://codeclimate.com/repos/56097df9e30ba0204400134a/coverage)

This repository provides components for building and writing XML sitemaps, following Google recommendations.

## Installation

Add this to your `composer.json`:

```json
{
    "repositories": [
        {
            "type": "vcs",
            "url": "git@github.com:refinery29/sitemap"
        }
    ]
}
```

Run:

```
$ composer require refinery29/sitemap
```

## Usage

You probably want to do one of these things

* create a sitemap
* create a sitemap index

and with `refinery29/sitemap`, you can do both.

### Creating a Sitemap

#### `UrlSet`

A sitemap is a set of URLs, so here's how you start:


```php
use Refinery29\Sitemap\Component;

$urlSet = new Component\UrlSet();
```

#### `Url`

To a `UrlSet`, you can add `Url`s, so let's do it:

```php
use Refinery29\Sitemap\Component;

$url = new Component\Url(
    'http://www.example.org/foo/bar.html',
    new DateTime(),
    Component\Url::CHANGE_FREQUENCY_MONTHLY,
    0.8
);

$urlSet->add($url);
```

:bulb: Careful with adding too many URLs, Google imposes a limit to the number of URLs.
 
#### `Image`

You may want to add an image to a `Url` so let's do it:
 
```php
use Refinery29\Sitemap\Component;

$image = new Component\Image\Image(
    'http://www.example.org/img/beach.jpg',
    'Our day at the beach',
    'Here we are sitting at the bar, enjoying our drinks',
    'Majorca, Canyamel'
);

$url->addImage($image);
```

:bulb: You can add up to 1.000 images to a `Url`.

#### `News`

You may want to add news to a `Url`, if the URL identifies a news article, for example, so let's do this, too:
 
```php
use Refinery29\Sitemap\Component;

$publication = new Component\News\Publication(
    'The Example Times',
    'en'
);

$news = new Component\News\News(
    $publication,
    new DateTime(),
    'Something happened and you should know about it',
);

$url->addNews($news);
```

:bulb: `News` has many more options, have a look at the source!

#### `Video`

You may want to add video to a `Url`, if the URL identifies a page where you can watch a video, so let's also do this:
 
```php
use Refinery29\Sitemap\Component;

$video = new Component\Video\Video(
    'http://www.example.org/img/funny-video-thumbnail.gif',
    'Jerry dropped his lemonade',
    'Here you can see how Jerry dropped his lemonade and everyone laughs, it is really funny!',
    'http://www.example.org/img/funny-video.mov',
);

$url->addNews($news);
```

:bulb: `Video` has many more options, have a look at the source!


### Writing a Sitemap

When you're finished building your `UrlSet`, you probably want to write it, right, so let's do it:

```php
use Refinery29\Sitemap\Writer;

$urlSetWriter = new Writer\UrlSet();

$xml = $urlSetWriter->write($urlSet);
```

### Creating a Sitemap Index

If you have many URLs, you may want to spread your sitemaps across multiple files and index them

#### `SitemapIndex`

Let's create a `SitemapIndex` first:
 
```php
use Refinery29\Sitemap\Component;

$sitemapIndex = new Component\SitemapIndex();
```

#### `Sitemap`

Now, let's add a bunch of `Sitemap`s to the `SitemapIndex`:


```php
use Refinery29\Sitemap\Component;

$lastModified = new DateTime();

$sitemap = new Component\Sitemap(
    'http://www.example.org/funny.xml',
    $lastModified
);

$anotherSitemap = new Component\Sitemap(
    'http://www.example.org/news.xml',
    $lastModified
);

$sitemapIndex->add($sitemap);
$sitemapIndex->add($anotherSitemap);
```

### Writing a Sitemap

When you're finished building your `SitemapIndex`, you should write it like this:

```php
use Refinery29\Sitemap\Writer;

$sitemapIndexWriter = new Writer\SitemapIndex();

$xml = $sitemapIndexWriter->write($sitemapIndex);
```



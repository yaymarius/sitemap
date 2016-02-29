# sitemap

[![Build Status](https://travis-ci.org/refinery29/sitemap.svg?branch=master)](https://travis-ci.org/refinery29/sitemap)
[![Code Climate](https://codeclimate.com/github/refinery29/sitemap/badges/gpa.svg)](https://codeclimate.com/github/refinery29/sitemap)
[![Test Coverage](https://codeclimate.com/github/refinery29/sitemap/badges/coverage.svg)](https://codeclimate.com/github/refinery29/sitemap/coverage)

This repository provides components for building and writing XML sitemaps, following Google recommendations.

## Installation

Run:

```
$ composer require refinery29/sitemap
```

## Creating a Sitemap

### `UrlSet`

A sitemap is a set of URLs, so here's how you start:


```php
use Refinery29\Sitemap\Component;

$urlSet = new Component\UrlSet();
```

### `Url`

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

:bulb: Google imposes a limit of 50,000 URLs that can be added to any sitemap..
 
### `Image`

You may want to add images to a `Url` so let's do it:
 
```php
use Refinery29\Sitemap\Component;

$image = new Component\Image\Image('http://www.example.org/img/beach.jpg');

$image = $image
    ->withTitle('Our day at the beach')
    ->withCaption('Here we are sitting at the bar, enjoying our drinks')
    ->withGeoLocation('Majorca, Canyamel')
;

$url = $url->withImages([
    $image,
]);
```

:bulb: You can add up to 1.000 images to a `Url`.

### `News`

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

$url = $url->withNews([
    $news,
]);
```

:bulb: `News` has many more options, have a look at the source!

### `Video`

You may want to add video to a `Url`, if the URL identifies a page where you can watch a video, so let's also do this:
 
```php
use Refinery29\Sitemap\Component;

$video = new Component\Video\Video(
    'http://www.example.org/img/funny-video-thumbnail.gif',
    'Jerry dropped his lemonade',
    'Here you can see how Jerry dropped his lemonade and everyone laughs, it is really funny!',
    'http://www.example.org/img/funny-video.mov',
);

$url = $url->withVideos([
    $video,
]);
```

:bulb: `Video` has many more options, have a look at the source!


## Writing a Sitemap

When you're finished building your `UrlSet`, you probably want to write it, right, so let's do it:

```php
use Refinery29\Sitemap\Writer;

$urlSetWriter = new Writer\UrlSet();

$xml = $urlSetWriter->write($urlSet);
```

## Creating a Sitemap Index

If you have many URLs, you may want to spread your sitemaps across multiple files and index them

### `SitemapIndex`

Let's create a `SitemapIndex` first:
 
```php
use Refinery29\Sitemap\Component;

$sitemapIndex = new Component\SitemapIndex();
```

### `Sitemap`

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

### Writing a Sitemap Index

When you're finished building your `SitemapIndex`, you should write it like this:

```php
use Refinery29\Sitemap\Writer;

$sitemapIndexWriter = new Writer\SitemapIndex();

$xml = $sitemapIndexWriter->write($sitemapIndex);
```

## Contributing

Please refer to [`CONTRIBUTING.md`](.github/CONTRIBUTING.md).

## Code of Conduct

Please have a look at [`CONDUCT.md`](.github/CONDUCT.md).

## License

This package is licensed using the MIT License.

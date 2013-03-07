# The Blog


## About

This is the source code to my blog, usually located at [http://pedrogilcandeias.com](http://pedrogilcandeias.com).

When Posterous announced it was to shut down, I decided it was time to move on to a lighter, simpler (there's a trend here) blogging system that let me write in Markdown. So I made this one.


## Tech

It runs on custom php code, similar in form to microframeworks like Slim or Silex but with no unused features. It's little more than a routing system and a thin wrapper around MongoDB. It's lightweight and very fast.


## On the lack of file structure

I originally coded this in around 10hrs over the course of a week as a rolling experiment, giving very little thought to file structure. As a result, files look like they were machine gunned into the source. However, the code itself is considerably tidier.


## Semantic woes

Markup semantics were inicially not a concern, something I'd like to address.


## Requirements

* PHP 5.3
* MongoDB

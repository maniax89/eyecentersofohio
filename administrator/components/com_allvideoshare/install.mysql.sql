CREATE TABLE IF NOT EXISTS `#__allvideoshare_players` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `loop` tinyint(4) NOT NULL,
  `autostart` tinyint(4) NOT NULL,
  `buffer` int(2) NOT NULL,
  `volumelevel` int(2) NOT NULL,
  `stretch` varchar(10) NOT NULL,
  `controlbar` tinyint(4) NOT NULL,
  `playlist` tinyint(4) NOT NULL,
  `durationdock` tinyint(4) NOT NULL,
  `timerdock` tinyint(4) NOT NULL,
  `fullscreendock` tinyint(4) NOT NULL,
  `hddock` tinyint(4) NOT NULL,  
  `embeddock` tinyint(4) NOT NULL,
  `facebookdock` tinyint(4) NOT NULL,
  `twitterdock` tinyint(4) NOT NULL,
  `controlbaroutlinecolor` varchar(10) NOT NULL,
  `controlbarbgcolor` varchar(10) NOT NULL,
  `controlbaroverlaycolor` varchar(10) NOT NULL,
  `controlbaroverlayalpha` int(3) NOT NULL,
  `iconcolor` varchar(10) NOT NULL,
  `progressbarbgcolor` varchar(10) NOT NULL,
  `progressbarbuffercolor` varchar(10) NOT NULL,
  `progressbarseekcolor` varchar(10) NOT NULL,
  `volumebarbgcolor` varchar(10) NOT NULL,
  `volumebarseekcolor` varchar(10) NOT NULL,
  `playlistbgcolor` varchar(10) NOT NULL,
  `customplayerpage` varchar(255) NOT NULL,
  `preroll` tinyint(4) NOT NULL,
  `postroll` tinyint(4) NOT NULL,
  `published` tinyint(4) NOT NULL,
  `type` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__allvideoshare_categories` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `parent` int(10) NOT NULL,
  `type` varchar(255) NOT NULL,
  `thumb` varchar(255) NOT NULL,
  `access` varchar(25) NOT NULL,
  `ordering` int(5) NOT NULL,
  `metakeywords` text NOT NULL,
  `metadescription` text NOT NULL,
  `published` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__allvideoshare_videos` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `user` varchar(255) NOT NULL,
  `type` varchar(20) NOT NULL,
  `streamer` varchar(255) NOT NULL,
  `dvr` tinyint(4) NOT NULL,
  `token` varchar(255) NOT NULL,
  `video` varchar(255) NOT NULL,
  `hd` varchar(255) NOT NULL,
  `hls` varchar(255) NOT NULL,  
  `thumb` varchar(255) NOT NULL,
  `preview` varchar(255) NOT NULL,
  `thirdparty` text NOT NULL,
  `category` varchar(255) NOT NULL,
  `featured` tinyint(4) NOT NULL,
  `description` text NOT NULL,  
  `tags` varchar(255) NOT NULL,
  `metadescription` text NOT NULL,
  `views` int(5) NOT NULL,
  `access` varchar(25) NOT NULL,
  `ordering` int(5) NOT NULL,
  `published` tinyint(4) NOT NULL,
  `created_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__allvideoshare_config` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `rows` int(3) NOT NULL,
  `cols` int(3) NOT NULL,
  `playerid` int(10) NOT NULL,
  `layout` varchar(30) NOT NULL,
  `relatedvideoslimit` int(3) NOT NULL,
  `title` tinyint(4) NOT NULL,
  `description` tinyint(4) NOT NULL,
  `category` tinyint(4) NOT NULL,
  `views` tinyint(4) NOT NULL,
  `search` tinyint(4) NOT NULL,
  `comments_type` varchar(50) NOT NULL,
  `fbappid` VARCHAR(25) NOT NULL,
  `comments_posts` int(3) NOT NULL,
  `comments_color` varchar(20) NOT NULL,
  `auto_approval` tinyint(4) NOT NULL,
  `type_youtube` tinyint(4) NOT NULL,
  `type_vimeo` tinyint(4) NOT NULL,
  `type_rtmp` tinyint(4) NOT NULL,
  `type_hls` tinyint(4) NOT NULL,
  `load_bootstrap_css` tinyint(4) NOT NULL,
  `load_icomoon_font` tinyint(4) NOT NULL,
  `custom_css` text NOT NULL,
  `show_feed` TINYINT(4) NOT NULL,
  `feed_limit` INT(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__allvideoshare_licensing` (
  `id` int(5) NOT NULL AUTO_INCREMENT,  
  `licensekey` varchar(50) NOT NULL,
  `type` varchar(20) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `logoposition` varchar(15) NOT NULL,
  `logoalpha` int(3) NOT NULL,
  `logotarget` varchar(255) NOT NULL,
  `displaylogo` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__allvideoshare_adverts` (
  `id` int(5) NOT NULL AUTO_INCREMENT,  
  `title` varchar(255) NOT NULL,
  `type` varchar(25) NOT NULL,
  `method` varchar(25) NOT NULL,
  `video` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `impressions` int(10) NOT NULL,
  `clicks` int(10) NOT NULL,
  `published` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
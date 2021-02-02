CREATE TABLE tad_rss (
  `rss_sn` smallint(5) unsigned NOT NULL  auto_increment,
  `title` varchar(255) NOT NULL default '' ,
  `url` varchar(255) NOT NULL  default '' ,
  `enable` enum('1','0') NOT NULL default '1' ,
  PRIMARY KEY  (`rss_sn`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



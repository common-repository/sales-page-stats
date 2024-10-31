CREATE TABLE IF NOT EXISTS `wp_page_stats` (
  `row_id` int(220) NOT NULL AUTO_INCREMENT,
  `post_id` int(220) NOT NULL,
  `doc_height` varchar(220) NOT NULL,
  `wheight` varchar(220) NOT NULL,
  `scroll_top` varchar(220) NOT NULL,
  `time_on_page` varchar(220) NOT NULL,
  `page_county` varchar(220) NOT NULL,
  `page_city` varchar(220) NOT NULL,
  `page_lati` varchar(220) NOT NULL,
  `page_langi` varchar(220) NOT NULL,
  `created_dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`row_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
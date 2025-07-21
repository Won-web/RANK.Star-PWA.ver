-- phpMyAdmin SQL Dump
-- version 3.4.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 10, 2020 at 03:46 PM
-- Server version: 5.0.96
-- PHP Version: 5.6.40

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `test3`
--

-- --------------------------------------------------------

--
-- Table structure for table `g5_auth`
--

CREATE TABLE IF NOT EXISTS `g5_auth` (
  `mb_id` varchar(20) NOT NULL default '',
  `au_menu` varchar(20) NOT NULL default '',
  `au_auth` set('r','w','d') NOT NULL default '',
  PRIMARY KEY  (`mb_id`,`au_menu`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `g5_autosave`
--

CREATE TABLE IF NOT EXISTS `g5_autosave` (
  `as_id` int(11) NOT NULL auto_increment,
  `mb_id` varchar(20) NOT NULL,
  `as_uid` bigint(20) unsigned NOT NULL,
  `as_subject` varchar(255) NOT NULL,
  `as_content` text NOT NULL,
  `as_datetime` datetime NOT NULL,
  PRIMARY KEY  (`as_id`),
  UNIQUE KEY `as_uid` (`as_uid`),
  KEY `mb_id` (`mb_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `g5_board`
--

CREATE TABLE IF NOT EXISTS `g5_board` (
  `bo_table` varchar(20) NOT NULL default '',
  `gr_id` varchar(255) NOT NULL default '',
  `bo_subject` varchar(255) NOT NULL default '',
  `bo_mobile_subject` varchar(255) NOT NULL default '',
  `bo_device` enum('both','pc','mobile') NOT NULL default 'both',
  `bo_admin` varchar(255) NOT NULL default '',
  `bo_list_level` tinyint(4) NOT NULL default '0',
  `bo_read_level` tinyint(4) NOT NULL default '0',
  `bo_write_level` tinyint(4) NOT NULL default '0',
  `bo_reply_level` tinyint(4) NOT NULL default '0',
  `bo_comment_level` tinyint(4) NOT NULL default '0',
  `bo_upload_level` tinyint(4) NOT NULL default '0',
  `bo_download_level` tinyint(4) NOT NULL default '0',
  `bo_html_level` tinyint(4) NOT NULL default '0',
  `bo_link_level` tinyint(4) NOT NULL default '0',
  `bo_count_delete` tinyint(4) NOT NULL default '0',
  `bo_count_modify` tinyint(4) NOT NULL default '0',
  `bo_read_point` int(11) NOT NULL default '0',
  `bo_write_point` int(11) NOT NULL default '0',
  `bo_comment_point` int(11) NOT NULL default '0',
  `bo_download_point` int(11) NOT NULL default '0',
  `bo_use_category` tinyint(4) NOT NULL default '0',
  `bo_category_list` text NOT NULL,
  `bo_use_sideview` tinyint(4) NOT NULL default '0',
  `bo_use_file_content` tinyint(4) NOT NULL default '0',
  `bo_use_secret` tinyint(4) NOT NULL default '0',
  `bo_use_dhtml_editor` tinyint(4) NOT NULL default '0',
  `bo_use_rss_view` tinyint(4) NOT NULL default '0',
  `bo_use_good` tinyint(4) NOT NULL default '0',
  `bo_use_nogood` tinyint(4) NOT NULL default '0',
  `bo_use_name` tinyint(4) NOT NULL default '0',
  `bo_use_signature` tinyint(4) NOT NULL default '0',
  `bo_use_ip_view` tinyint(4) NOT NULL default '0',
  `bo_use_list_view` tinyint(4) NOT NULL default '0',
  `bo_use_list_file` tinyint(4) NOT NULL default '0',
  `bo_use_list_content` tinyint(4) NOT NULL default '0',
  `bo_table_width` int(11) NOT NULL default '0',
  `bo_subject_len` int(11) NOT NULL default '0',
  `bo_mobile_subject_len` int(11) NOT NULL default '0',
  `bo_page_rows` int(11) NOT NULL default '0',
  `bo_mobile_page_rows` int(11) NOT NULL default '0',
  `bo_new` int(11) NOT NULL default '0',
  `bo_hot` int(11) NOT NULL default '0',
  `bo_image_width` int(11) NOT NULL default '0',
  `bo_skin` varchar(255) NOT NULL default '',
  `bo_mobile_skin` varchar(255) NOT NULL default '',
  `bo_include_head` varchar(255) NOT NULL default '',
  `bo_include_tail` varchar(255) NOT NULL default '',
  `bo_content_head` text NOT NULL,
  `bo_mobile_content_head` text NOT NULL,
  `bo_content_tail` text NOT NULL,
  `bo_mobile_content_tail` text NOT NULL,
  `bo_insert_content` text NOT NULL,
  `bo_gallery_cols` int(11) NOT NULL default '0',
  `bo_gallery_width` int(11) NOT NULL default '0',
  `bo_gallery_height` int(11) NOT NULL default '0',
  `bo_mobile_gallery_width` int(11) NOT NULL default '0',
  `bo_mobile_gallery_height` int(11) NOT NULL default '0',
  `bo_upload_size` int(11) NOT NULL default '0',
  `bo_reply_order` tinyint(4) NOT NULL default '0',
  `bo_use_search` tinyint(4) NOT NULL default '0',
  `bo_order` int(11) NOT NULL default '0',
  `bo_count_write` int(11) NOT NULL default '0',
  `bo_count_comment` int(11) NOT NULL default '0',
  `bo_write_min` int(11) NOT NULL default '0',
  `bo_write_max` int(11) NOT NULL default '0',
  `bo_comment_min` int(11) NOT NULL default '0',
  `bo_comment_max` int(11) NOT NULL default '0',
  `bo_notice` text NOT NULL,
  `bo_upload_count` tinyint(4) NOT NULL default '0',
  `bo_use_email` tinyint(4) NOT NULL default '0',
  `bo_use_cert` enum('','cert','adult','hp-cert','hp-adult') NOT NULL default '',
  `bo_use_sns` tinyint(4) NOT NULL default '0',
  `bo_use_captcha` tinyint(4) NOT NULL default '0',
  `bo_sort_field` varchar(255) NOT NULL default '',
  `bo_1_subj` varchar(255) NOT NULL default '',
  `bo_2_subj` varchar(255) NOT NULL default '',
  `bo_3_subj` varchar(255) NOT NULL default '',
  `bo_4_subj` varchar(255) NOT NULL default '',
  `bo_5_subj` varchar(255) NOT NULL default '',
  `bo_6_subj` varchar(255) NOT NULL default '',
  `bo_7_subj` varchar(255) NOT NULL default '',
  `bo_8_subj` varchar(255) NOT NULL default '',
  `bo_9_subj` varchar(255) NOT NULL default '',
  `bo_10_subj` varchar(255) NOT NULL default '',
  `bo_1` varchar(255) NOT NULL default '',
  `bo_2` varchar(255) NOT NULL default '',
  `bo_3` varchar(255) NOT NULL default '',
  `bo_4` varchar(255) NOT NULL default '',
  `bo_5` varchar(255) NOT NULL default '',
  `bo_6` varchar(255) NOT NULL default '',
  `bo_7` varchar(255) NOT NULL default '',
  `bo_8` varchar(255) NOT NULL default '',
  `bo_9` varchar(255) NOT NULL default '',
  `bo_10` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`bo_table`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `g5_board`
--

INSERT INTO `g5_board` (`bo_table`, `gr_id`, `bo_subject`, `bo_mobile_subject`, `bo_device`, `bo_admin`, `bo_list_level`, `bo_read_level`, `bo_write_level`, `bo_reply_level`, `bo_comment_level`, `bo_upload_level`, `bo_download_level`, `bo_html_level`, `bo_link_level`, `bo_count_delete`, `bo_count_modify`, `bo_read_point`, `bo_write_point`, `bo_comment_point`, `bo_download_point`, `bo_use_category`, `bo_category_list`, `bo_use_sideview`, `bo_use_file_content`, `bo_use_secret`, `bo_use_dhtml_editor`, `bo_use_rss_view`, `bo_use_good`, `bo_use_nogood`, `bo_use_name`, `bo_use_signature`, `bo_use_ip_view`, `bo_use_list_view`, `bo_use_list_file`, `bo_use_list_content`, `bo_table_width`, `bo_subject_len`, `bo_mobile_subject_len`, `bo_page_rows`, `bo_mobile_page_rows`, `bo_new`, `bo_hot`, `bo_image_width`, `bo_skin`, `bo_mobile_skin`, `bo_include_head`, `bo_include_tail`, `bo_content_head`, `bo_mobile_content_head`, `bo_content_tail`, `bo_mobile_content_tail`, `bo_insert_content`, `bo_gallery_cols`, `bo_gallery_width`, `bo_gallery_height`, `bo_mobile_gallery_width`, `bo_mobile_gallery_height`, `bo_upload_size`, `bo_reply_order`, `bo_use_search`, `bo_order`, `bo_count_write`, `bo_count_comment`, `bo_write_min`, `bo_write_max`, `bo_comment_min`, `bo_comment_max`, `bo_notice`, `bo_upload_count`, `bo_use_email`, `bo_use_cert`, `bo_use_sns`, `bo_use_captcha`, `bo_sort_field`, `bo_1_subj`, `bo_2_subj`, `bo_3_subj`, `bo_4_subj`, `bo_5_subj`, `bo_6_subj`, `bo_7_subj`, `bo_8_subj`, `bo_9_subj`, `bo_10_subj`, `bo_1`, `bo_2`, `bo_3`, `bo_4`, `bo_5`, `bo_6`, `bo_7`, `bo_8`, `bo_9`, `bo_10`) VALUES
('notice', 'shop', '공지사항', '', 'both', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, -1, 5, 1, -20, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 100, 60, 30, 15, 15, 24, 100, 835, 'basic', 'basic', '_head.php', '_tail.php', '', '', '', '', '', 4, 202, 150, 125, 100, 1048576, 1, 0, 0, 0, 0, 0, 0, 0, 0, '', 2, 0, '', 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('qa', 'shop', '질문답변', '', 'both', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, -1, 5, 1, -20, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 100, 60, 30, 15, 15, 24, 100, 835, 'basic', 'basic', '_head.php', '_tail.php', '', '', '', '', '', 4, 202, 150, 125, 100, 1048576, 1, 0, 0, 0, 0, 0, 0, 0, 0, '', 2, 0, '', 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('free', 'shop', '자유게시판', '', 'both', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, -1, 5, 1, -20, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 100, 60, 30, 15, 15, 24, 100, 835, 'basic', 'basic', '_head.php', '_tail.php', '', '', '', '', '', 4, 202, 150, 125, 100, 1048576, 1, 0, 0, 0, 0, 0, 0, 0, 0, '', 2, 0, '', 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('gallery', 'shop', '갤러리', '', 'both', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, -1, 5, 1, -20, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 100, 60, 30, 15, 15, 24, 100, 835, 'gallery', 'gallery', '_head.php', '_tail.php', '', '', '', '', '', 4, 202, 150, 125, 100, 1048576, 1, 0, 0, 0, 0, 0, 0, 0, 0, '', 2, 0, '', 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `g5_board_file`
--

CREATE TABLE IF NOT EXISTS `g5_board_file` (
  `bo_table` varchar(20) NOT NULL default '',
  `wr_id` int(11) NOT NULL default '0',
  `bf_no` int(11) NOT NULL default '0',
  `bf_source` varchar(255) NOT NULL default '',
  `bf_file` varchar(255) NOT NULL default '',
  `bf_download` int(11) NOT NULL,
  `bf_content` text NOT NULL,
  `bf_fileurl` varchar(255) NOT NULL default '',
  `bf_thumburl` varchar(255) NOT NULL default '',
  `bf_storage` varchar(50) NOT NULL default '',
  `bf_filesize` int(11) NOT NULL default '0',
  `bf_width` int(11) NOT NULL default '0',
  `bf_height` smallint(6) NOT NULL default '0',
  `bf_type` tinyint(4) NOT NULL default '0',
  `bf_datetime` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`bo_table`,`wr_id`,`bf_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `g5_board_good`
--

CREATE TABLE IF NOT EXISTS `g5_board_good` (
  `bg_id` int(11) NOT NULL auto_increment,
  `bo_table` varchar(20) NOT NULL default '',
  `wr_id` int(11) NOT NULL default '0',
  `mb_id` varchar(20) NOT NULL default '',
  `bg_flag` varchar(255) NOT NULL default '',
  `bg_datetime` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`bg_id`),
  UNIQUE KEY `fkey1` (`bo_table`,`wr_id`,`mb_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `g5_board_new`
--

CREATE TABLE IF NOT EXISTS `g5_board_new` (
  `bn_id` int(11) NOT NULL auto_increment,
  `bo_table` varchar(20) NOT NULL default '',
  `wr_id` int(11) NOT NULL default '0',
  `wr_parent` int(11) NOT NULL default '0',
  `bn_datetime` datetime NOT NULL default '0000-00-00 00:00:00',
  `mb_id` varchar(20) NOT NULL default '',
  PRIMARY KEY  (`bn_id`),
  KEY `mb_id` (`mb_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `g5_cert_history`
--

CREATE TABLE IF NOT EXISTS `g5_cert_history` (
  `cr_id` int(11) NOT NULL auto_increment,
  `mb_id` varchar(20) NOT NULL default '',
  `cr_company` varchar(255) NOT NULL default '',
  `cr_method` varchar(255) NOT NULL default '',
  `cr_ip` varchar(255) NOT NULL default '',
  `cr_date` date NOT NULL default '0000-00-00',
  `cr_time` time NOT NULL default '00:00:00',
  PRIMARY KEY  (`cr_id`),
  KEY `mb_id` (`mb_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `g5_config`
--

CREATE TABLE IF NOT EXISTS `g5_config` (
  `cf_title` varchar(255) NOT NULL default '',
  `cf_theme` varchar(100) NOT NULL default '',
  `cf_admin` varchar(100) NOT NULL default '',
  `cf_admin_email` varchar(100) NOT NULL default '',
  `cf_admin_email_name` varchar(100) NOT NULL default '',
  `cf_add_script` text NOT NULL,
  `cf_use_point` tinyint(4) NOT NULL default '0',
  `cf_point_term` int(11) NOT NULL default '0',
  `cf_use_copy_log` tinyint(4) NOT NULL default '0',
  `cf_use_email_certify` tinyint(4) NOT NULL default '0',
  `cf_login_point` int(11) NOT NULL default '0',
  `cf_cut_name` tinyint(4) NOT NULL default '0',
  `cf_nick_modify` int(11) NOT NULL default '0',
  `cf_new_skin` varchar(50) NOT NULL default '',
  `cf_new_rows` int(11) NOT NULL default '0',
  `cf_search_skin` varchar(50) NOT NULL default '',
  `cf_connect_skin` varchar(50) NOT NULL default '',
  `cf_faq_skin` varchar(50) NOT NULL default '',
  `cf_read_point` int(11) NOT NULL default '0',
  `cf_write_point` int(11) NOT NULL default '0',
  `cf_comment_point` int(11) NOT NULL default '0',
  `cf_download_point` int(11) NOT NULL default '0',
  `cf_write_pages` int(11) NOT NULL default '0',
  `cf_mobile_pages` int(11) NOT NULL default '0',
  `cf_link_target` varchar(50) NOT NULL default '',
  `cf_bbs_rewrite` tinyint(4) NOT NULL default '0',
  `cf_delay_sec` int(11) NOT NULL default '0',
  `cf_filter` text NOT NULL,
  `cf_possible_ip` text NOT NULL,
  `cf_intercept_ip` text NOT NULL,
  `cf_analytics` text NOT NULL,
  `cf_add_meta` text NOT NULL,
  `cf_syndi_token` varchar(255) NOT NULL,
  `cf_syndi_except` text NOT NULL,
  `cf_member_skin` varchar(50) NOT NULL default '',
  `cf_use_homepage` tinyint(4) NOT NULL default '0',
  `cf_req_homepage` tinyint(4) NOT NULL default '0',
  `cf_use_tel` tinyint(4) NOT NULL default '0',
  `cf_req_tel` tinyint(4) NOT NULL default '0',
  `cf_use_hp` tinyint(4) NOT NULL default '0',
  `cf_req_hp` tinyint(4) NOT NULL default '0',
  `cf_use_addr` tinyint(4) NOT NULL default '0',
  `cf_req_addr` tinyint(4) NOT NULL default '0',
  `cf_use_signature` tinyint(4) NOT NULL default '0',
  `cf_req_signature` tinyint(4) NOT NULL default '0',
  `cf_use_profile` tinyint(4) NOT NULL default '0',
  `cf_req_profile` tinyint(4) NOT NULL default '0',
  `cf_register_level` tinyint(4) NOT NULL default '0',
  `cf_register_point` int(11) NOT NULL default '0',
  `cf_icon_level` tinyint(4) NOT NULL default '0',
  `cf_use_recommend` tinyint(4) NOT NULL default '0',
  `cf_recommend_point` int(11) NOT NULL default '0',
  `cf_leave_day` int(11) NOT NULL default '0',
  `cf_search_part` int(11) NOT NULL default '0',
  `cf_email_use` tinyint(4) NOT NULL default '0',
  `cf_email_wr_super_admin` tinyint(4) NOT NULL default '0',
  `cf_email_wr_group_admin` tinyint(4) NOT NULL default '0',
  `cf_email_wr_board_admin` tinyint(4) NOT NULL default '0',
  `cf_email_wr_write` tinyint(4) NOT NULL default '0',
  `cf_email_wr_comment_all` tinyint(4) NOT NULL default '0',
  `cf_email_mb_super_admin` tinyint(4) NOT NULL default '0',
  `cf_email_mb_member` tinyint(4) NOT NULL default '0',
  `cf_email_po_super_admin` tinyint(4) NOT NULL default '0',
  `cf_prohibit_id` text NOT NULL,
  `cf_prohibit_email` text NOT NULL,
  `cf_new_del` int(11) NOT NULL default '0',
  `cf_memo_del` int(11) NOT NULL default '0',
  `cf_visit_del` int(11) NOT NULL default '0',
  `cf_popular_del` int(11) NOT NULL default '0',
  `cf_optimize_date` date NOT NULL default '0000-00-00',
  `cf_use_member_icon` tinyint(4) NOT NULL default '0',
  `cf_member_icon_size` int(11) NOT NULL default '0',
  `cf_member_icon_width` int(11) NOT NULL default '0',
  `cf_member_icon_height` int(11) NOT NULL default '0',
  `cf_member_img_size` int(11) NOT NULL default '0',
  `cf_member_img_width` int(11) NOT NULL default '0',
  `cf_member_img_height` int(11) NOT NULL default '0',
  `cf_login_minutes` int(11) NOT NULL default '0',
  `cf_image_extension` varchar(255) NOT NULL default '',
  `cf_flash_extension` varchar(255) NOT NULL default '',
  `cf_movie_extension` varchar(255) NOT NULL default '',
  `cf_formmail_is_member` tinyint(4) NOT NULL default '0',
  `cf_page_rows` int(11) NOT NULL default '0',
  `cf_mobile_page_rows` int(11) NOT NULL default '0',
  `cf_visit` varchar(255) NOT NULL default '',
  `cf_max_po_id` int(11) NOT NULL default '0',
  `cf_stipulation` text NOT NULL,
  `cf_privacy` text NOT NULL,
  `cf_open_modify` int(11) NOT NULL default '0',
  `cf_memo_send_point` int(11) NOT NULL default '0',
  `cf_mobile_new_skin` varchar(50) NOT NULL default '',
  `cf_mobile_search_skin` varchar(50) NOT NULL default '',
  `cf_mobile_connect_skin` varchar(50) NOT NULL default '',
  `cf_mobile_faq_skin` varchar(50) NOT NULL default '',
  `cf_mobile_member_skin` varchar(50) NOT NULL default '',
  `cf_captcha_mp3` varchar(255) NOT NULL default '',
  `cf_editor` varchar(50) NOT NULL default '',
  `cf_cert_use` tinyint(4) NOT NULL default '0',
  `cf_cert_ipin` varchar(255) NOT NULL default '',
  `cf_cert_hp` varchar(255) NOT NULL default '',
  `cf_cert_kcb_cd` varchar(255) NOT NULL default '',
  `cf_cert_kcp_cd` varchar(255) NOT NULL default '',
  `cf_lg_mid` varchar(100) NOT NULL default '',
  `cf_lg_mert_key` varchar(100) NOT NULL default '',
  `cf_cert_limit` int(11) NOT NULL default '0',
  `cf_cert_req` tinyint(4) NOT NULL default '0',
  `cf_sms_use` varchar(255) NOT NULL default '',
  `cf_sms_type` varchar(10) NOT NULL default '',
  `cf_icode_id` varchar(255) NOT NULL default '',
  `cf_icode_pw` varchar(255) NOT NULL default '',
  `cf_icode_server_ip` varchar(50) NOT NULL default '',
  `cf_icode_server_port` varchar(50) NOT NULL default '',
  `cf_googl_shorturl_apikey` varchar(50) NOT NULL default '',
  `cf_social_login_use` tinyint(4) NOT NULL default '0',
  `cf_social_servicelist` varchar(255) NOT NULL default '',
  `cf_payco_clientid` varchar(100) NOT NULL default '',
  `cf_payco_secret` varchar(100) NOT NULL default '',
  `cf_facebook_appid` varchar(100) NOT NULL,
  `cf_facebook_secret` varchar(100) NOT NULL,
  `cf_twitter_key` varchar(100) NOT NULL,
  `cf_twitter_secret` varchar(100) NOT NULL,
  `cf_google_clientid` varchar(100) NOT NULL default '',
  `cf_google_secret` varchar(100) NOT NULL default '',
  `cf_naver_clientid` varchar(100) NOT NULL default '',
  `cf_naver_secret` varchar(100) NOT NULL default '',
  `cf_kakao_rest_key` varchar(100) NOT NULL default '',
  `cf_kakao_client_secret` varchar(100) NOT NULL default '',
  `cf_kakao_js_apikey` varchar(100) NOT NULL,
  `cf_captcha` varchar(100) NOT NULL default '',
  `cf_recaptcha_site_key` varchar(100) NOT NULL default '',
  `cf_recaptcha_secret_key` varchar(100) NOT NULL default '',
  `cf_1_subj` varchar(255) NOT NULL default '',
  `cf_2_subj` varchar(255) NOT NULL default '',
  `cf_3_subj` varchar(255) NOT NULL default '',
  `cf_4_subj` varchar(255) NOT NULL default '',
  `cf_5_subj` varchar(255) NOT NULL default '',
  `cf_6_subj` varchar(255) NOT NULL default '',
  `cf_7_subj` varchar(255) NOT NULL default '',
  `cf_8_subj` varchar(255) NOT NULL default '',
  `cf_9_subj` varchar(255) NOT NULL default '',
  `cf_10_subj` varchar(255) NOT NULL default '',
  `cf_1` varchar(255) NOT NULL default '',
  `cf_2` varchar(255) NOT NULL default '',
  `cf_3` varchar(255) NOT NULL default '',
  `cf_4` varchar(255) NOT NULL default '',
  `cf_5` varchar(255) NOT NULL default '',
  `cf_6` varchar(255) NOT NULL default '',
  `cf_7` varchar(255) NOT NULL default '',
  `cf_8` varchar(255) NOT NULL default '',
  `cf_9` varchar(255) NOT NULL default '',
  `cf_10` varchar(255) NOT NULL default ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `g5_config`
--

INSERT INTO `g5_config` (`cf_title`, `cf_theme`, `cf_admin`, `cf_admin_email`, `cf_admin_email_name`, `cf_add_script`, `cf_use_point`, `cf_point_term`, `cf_use_copy_log`, `cf_use_email_certify`, `cf_login_point`, `cf_cut_name`, `cf_nick_modify`, `cf_new_skin`, `cf_new_rows`, `cf_search_skin`, `cf_connect_skin`, `cf_faq_skin`, `cf_read_point`, `cf_write_point`, `cf_comment_point`, `cf_download_point`, `cf_write_pages`, `cf_mobile_pages`, `cf_link_target`, `cf_bbs_rewrite`, `cf_delay_sec`, `cf_filter`, `cf_possible_ip`, `cf_intercept_ip`, `cf_analytics`, `cf_add_meta`, `cf_syndi_token`, `cf_syndi_except`, `cf_member_skin`, `cf_use_homepage`, `cf_req_homepage`, `cf_use_tel`, `cf_req_tel`, `cf_use_hp`, `cf_req_hp`, `cf_use_addr`, `cf_req_addr`, `cf_use_signature`, `cf_req_signature`, `cf_use_profile`, `cf_req_profile`, `cf_register_level`, `cf_register_point`, `cf_icon_level`, `cf_use_recommend`, `cf_recommend_point`, `cf_leave_day`, `cf_search_part`, `cf_email_use`, `cf_email_wr_super_admin`, `cf_email_wr_group_admin`, `cf_email_wr_board_admin`, `cf_email_wr_write`, `cf_email_wr_comment_all`, `cf_email_mb_super_admin`, `cf_email_mb_member`, `cf_email_po_super_admin`, `cf_prohibit_id`, `cf_prohibit_email`, `cf_new_del`, `cf_memo_del`, `cf_visit_del`, `cf_popular_del`, `cf_optimize_date`, `cf_use_member_icon`, `cf_member_icon_size`, `cf_member_icon_width`, `cf_member_icon_height`, `cf_member_img_size`, `cf_member_img_width`, `cf_member_img_height`, `cf_login_minutes`, `cf_image_extension`, `cf_flash_extension`, `cf_movie_extension`, `cf_formmail_is_member`, `cf_page_rows`, `cf_mobile_page_rows`, `cf_visit`, `cf_max_po_id`, `cf_stipulation`, `cf_privacy`, `cf_open_modify`, `cf_memo_send_point`, `cf_mobile_new_skin`, `cf_mobile_search_skin`, `cf_mobile_connect_skin`, `cf_mobile_faq_skin`, `cf_mobile_member_skin`, `cf_captcha_mp3`, `cf_editor`, `cf_cert_use`, `cf_cert_ipin`, `cf_cert_hp`, `cf_cert_kcb_cd`, `cf_cert_kcp_cd`, `cf_lg_mid`, `cf_lg_mert_key`, `cf_cert_limit`, `cf_cert_req`, `cf_sms_use`, `cf_sms_type`, `cf_icode_id`, `cf_icode_pw`, `cf_icode_server_ip`, `cf_icode_server_port`, `cf_googl_shorturl_apikey`, `cf_social_login_use`, `cf_social_servicelist`, `cf_payco_clientid`, `cf_payco_secret`, `cf_facebook_appid`, `cf_facebook_secret`, `cf_twitter_key`, `cf_twitter_secret`, `cf_google_clientid`, `cf_google_secret`, `cf_naver_clientid`, `cf_naver_secret`, `cf_kakao_rest_key`, `cf_kakao_client_secret`, `cf_kakao_js_apikey`, `cf_captcha`, `cf_recaptcha_site_key`, `cf_recaptcha_secret_key`, `cf_1_subj`, `cf_2_subj`, `cf_3_subj`, `cf_4_subj`, `cf_5_subj`, `cf_6_subj`, `cf_7_subj`, `cf_8_subj`, `cf_9_subj`, `cf_10_subj`, `cf_1`, `cf_2`, `cf_3`, `cf_4`, `cf_5`, `cf_6`, `cf_7`, `cf_8`, `cf_9`, `cf_10`) VALUES
('랭킹스타', 'basic', 'admin', 'admin@domain.com', '랭킹스타', '', 1, 0, 1, 0, 0, 15, 60, 'basic', 15, 'basic', 'basic', 'basic', 0, 0, 0, 0, 10, 5, '_blank', 0, 30, '18아,18놈,18새끼,18뇬,18노,18것,18넘,개년,개놈,개뇬,개새,개색끼,개세끼,개세이,개쉐이,개쉑,개쉽,개시키,개자식,개좆,게색기,게색끼,광뇬,뇬,눈깔,뉘미럴,니귀미,니기미,니미,도촬,되질래,뒈져라,뒈진다,디져라,디진다,디질래,병쉰,병신,뻐큐,뻑큐,뽁큐,삐리넷,새꺄,쉬발,쉬밸,쉬팔,쉽알,스패킹,스팽,시벌,시부랄,시부럴,시부리,시불,시브랄,시팍,시팔,시펄,실밸,십8,십쌔,십창,싶알,쌉년,썅놈,쌔끼,쌩쑈,썅,써벌,썩을년,쎄꺄,쎄엑,쓰바,쓰발,쓰벌,쓰팔,씨8,씨댕,씨바,씨발,씨뱅,씨봉알,씨부랄,씨부럴,씨부렁,씨부리,씨불,씨브랄,씨빠,씨빨,씨뽀랄,씨팍,씨팔,씨펄,씹,아가리,아갈이,엄창,접년,잡놈,재랄,저주글,조까,조빠,조쟁이,조지냐,조진다,조질래,존나,존니,좀물,좁년,좃,좆,좇,쥐랄,쥐롤,쥬디,지랄,지럴,지롤,지미랄,쫍빱,凸,퍽큐,뻑큐,빠큐,ㅅㅂㄹㅁ', '', '', '', '', '', '', 'theme/basic', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2, 1000, 2, 0, 0, 30, 10000, 1, 0, 0, 0, 0, 0, 0, 0, 0, 'admin,administrator,관리자,운영자,어드민,주인장,webmaster,웹마스터,sysop,시삽,시샵,manager,매니저,메니저,root,루트,su,guest,방문객', '', 30, 180, 180, 180, '2020-03-10', 2, 5000, 22, 22, 50000, 60, 60, 10, 'gif|jpg|jpeg|png', 'swf', 'asx|asf|wmv|wma|mpg|mpeg|mov|avi|mp3', 1, 15, 15, '오늘:2,어제:1,최대:7,전체:20', 0, '해당 홈페이지에 맞는 회원가입약관을 입력합니다.', '해당 홈페이지에 맞는 개인정보처리방침을 입력합니다.', 0, 0, 'basic', 'basic', 'basic', 'basic', 'theme/basic', 'basic', 'smarteditor2', 0, '', '', '', '', '', '', 2, 0, '', '', '', '', '211.172.232.124', '7295', '', 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'kcaptcha', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `g5_content`
--

CREATE TABLE IF NOT EXISTS `g5_content` (
  `co_id` varchar(20) NOT NULL default '',
  `co_html` tinyint(4) NOT NULL default '0',
  `co_subject` varchar(255) NOT NULL default '',
  `co_content` longtext NOT NULL,
  `co_seo_title` varchar(255) NOT NULL default '',
  `co_mobile_content` longtext NOT NULL,
  `co_skin` varchar(255) NOT NULL default '',
  `co_mobile_skin` varchar(255) NOT NULL default '',
  `co_tag_filter_use` tinyint(4) NOT NULL default '0',
  `co_hit` int(11) NOT NULL default '0',
  `co_include_head` varchar(255) NOT NULL,
  `co_include_tail` varchar(255) NOT NULL,
  PRIMARY KEY  (`co_id`),
  KEY `co_seo_title` (`co_seo_title`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `g5_content`
--

INSERT INTO `g5_content` (`co_id`, `co_html`, `co_subject`, `co_content`, `co_seo_title`, `co_mobile_content`, `co_skin`, `co_mobile_skin`, `co_tag_filter_use`, `co_hit`, `co_include_head`, `co_include_tail`) VALUES
('company', 1, '회사소개', '<p align=center><b>회사소개에 대한 내용을 입력하십시오.</b></p>', '', '', 'basic', 'basic', 0, 0, '', ''),
('privacy', 1, '개인정보 처리방침', '<p align=center><b>개인정보 처리방침에 대한 내용을 입력하십시오.</b></p>', '', '', 'basic', 'basic', 0, 0, '', ''),
('provision', 1, '서비스 이용약관', '<p align=center><b>서비스 이용약관에 대한 내용을 입력하십시오.</b></p>', '', '', 'basic', 'basic', 0, 0, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `g5_faq`
--

CREATE TABLE IF NOT EXISTS `g5_faq` (
  `fa_id` int(11) NOT NULL auto_increment,
  `fm_id` int(11) NOT NULL default '0',
  `fa_subject` text NOT NULL,
  `fa_content` text NOT NULL,
  `fa_order` int(11) NOT NULL default '0',
  PRIMARY KEY  (`fa_id`),
  KEY `fm_id` (`fm_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `g5_faq_master`
--

CREATE TABLE IF NOT EXISTS `g5_faq_master` (
  `fm_id` int(11) NOT NULL auto_increment,
  `fm_subject` varchar(255) NOT NULL default '',
  `fm_head_html` text NOT NULL,
  `fm_tail_html` text NOT NULL,
  `fm_mobile_head_html` text NOT NULL,
  `fm_mobile_tail_html` text NOT NULL,
  `fm_order` int(11) NOT NULL default '0',
  PRIMARY KEY  (`fm_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `g5_faq_master`
--

INSERT INTO `g5_faq_master` (`fm_id`, `fm_subject`, `fm_head_html`, `fm_tail_html`, `fm_mobile_head_html`, `fm_mobile_tail_html`, `fm_order`) VALUES
(1, '자주하시는 질문', '', '', '', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `g5_group`
--

CREATE TABLE IF NOT EXISTS `g5_group` (
  `gr_id` varchar(10) NOT NULL default '',
  `gr_subject` varchar(255) NOT NULL default '',
  `gr_device` enum('both','pc','mobile') NOT NULL default 'both',
  `gr_admin` varchar(255) NOT NULL default '',
  `gr_use_access` tinyint(4) NOT NULL default '0',
  `gr_order` int(11) NOT NULL default '0',
  `gr_1_subj` varchar(255) NOT NULL default '',
  `gr_2_subj` varchar(255) NOT NULL default '',
  `gr_3_subj` varchar(255) NOT NULL default '',
  `gr_4_subj` varchar(255) NOT NULL default '',
  `gr_5_subj` varchar(255) NOT NULL default '',
  `gr_6_subj` varchar(255) NOT NULL default '',
  `gr_7_subj` varchar(255) NOT NULL default '',
  `gr_8_subj` varchar(255) NOT NULL default '',
  `gr_9_subj` varchar(255) NOT NULL default '',
  `gr_10_subj` varchar(255) NOT NULL default '',
  `gr_1` varchar(255) NOT NULL default '',
  `gr_2` varchar(255) NOT NULL default '',
  `gr_3` varchar(255) NOT NULL default '',
  `gr_4` varchar(255) NOT NULL default '',
  `gr_5` varchar(255) NOT NULL default '',
  `gr_6` varchar(255) NOT NULL default '',
  `gr_7` varchar(255) NOT NULL default '',
  `gr_8` varchar(255) NOT NULL default '',
  `gr_9` varchar(255) NOT NULL default '',
  `gr_10` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`gr_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `g5_group`
--

INSERT INTO `g5_group` (`gr_id`, `gr_subject`, `gr_device`, `gr_admin`, `gr_use_access`, `gr_order`, `gr_1_subj`, `gr_2_subj`, `gr_3_subj`, `gr_4_subj`, `gr_5_subj`, `gr_6_subj`, `gr_7_subj`, `gr_8_subj`, `gr_9_subj`, `gr_10_subj`, `gr_1`, `gr_2`, `gr_3`, `gr_4`, `gr_5`, `gr_6`, `gr_7`, `gr_8`, `gr_9`, `gr_10`) VALUES
('shop', '쇼핑몰', 'both', '', 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `g5_group_member`
--

CREATE TABLE IF NOT EXISTS `g5_group_member` (
  `gm_id` int(11) NOT NULL auto_increment,
  `gr_id` varchar(255) NOT NULL default '',
  `mb_id` varchar(20) NOT NULL default '',
  `gm_datetime` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`gm_id`),
  KEY `gr_id` (`gr_id`),
  KEY `mb_id` (`mb_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `g5_login`
--

CREATE TABLE IF NOT EXISTS `g5_login` (
  `lo_ip` varchar(100) NOT NULL default '',
  `mb_id` varchar(20) NOT NULL default '',
  `lo_datetime` datetime NOT NULL default '0000-00-00 00:00:00',
  `lo_location` text NOT NULL,
  `lo_url` text NOT NULL,
  PRIMARY KEY  (`lo_ip`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `g5_login`
--

INSERT INTO `g5_login` (`lo_ip`, `mb_id`, `lo_datetime`, `lo_location`, `lo_url`) VALUES
('14.6.171.34', '', '2020-03-10 15:45:54', '랭킹스타', '/');

-- --------------------------------------------------------

--
-- Table structure for table `g5_mail`
--

CREATE TABLE IF NOT EXISTS `g5_mail` (
  `ma_id` int(11) NOT NULL auto_increment,
  `ma_subject` varchar(255) NOT NULL default '',
  `ma_content` mediumtext NOT NULL,
  `ma_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `ma_ip` varchar(255) NOT NULL default '',
  `ma_last_option` text NOT NULL,
  PRIMARY KEY  (`ma_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `g5_member`
--

CREATE TABLE IF NOT EXISTS `g5_member` (
  `mb_no` int(11) NOT NULL auto_increment,
  `mb_id` varchar(20) NOT NULL default '',
  `mb_password` varchar(255) NOT NULL default '',
  `mb_name` varchar(255) NOT NULL default '',
  `mb_nick` varchar(255) NOT NULL default '',
  `mb_nick_date` date NOT NULL default '0000-00-00',
  `mb_email` varchar(255) NOT NULL default '',
  `mb_homepage` varchar(255) NOT NULL default '',
  `mb_level` tinyint(4) NOT NULL default '0',
  `mb_sex` char(1) NOT NULL default '',
  `mb_birth` varchar(255) NOT NULL default '',
  `mb_tel` varchar(255) NOT NULL default '',
  `mb_hp` varchar(255) NOT NULL default '',
  `mb_certify` varchar(20) NOT NULL default '',
  `mb_adult` tinyint(4) NOT NULL default '0',
  `mb_dupinfo` varchar(255) NOT NULL default '',
  `mb_zip1` char(3) NOT NULL default '',
  `mb_zip2` char(3) NOT NULL default '',
  `mb_addr1` varchar(255) NOT NULL default '',
  `mb_addr2` varchar(255) NOT NULL default '',
  `mb_addr3` varchar(255) NOT NULL default '',
  `mb_addr_jibeon` varchar(255) NOT NULL default '',
  `mb_signature` text NOT NULL,
  `mb_recommend` varchar(255) NOT NULL default '',
  `mb_point` int(11) NOT NULL default '0',
  `mb_today_login` datetime NOT NULL default '0000-00-00 00:00:00',
  `mb_login_ip` varchar(255) NOT NULL default '',
  `mb_datetime` datetime NOT NULL default '0000-00-00 00:00:00',
  `mb_ip` varchar(255) NOT NULL default '',
  `mb_leave_date` varchar(8) NOT NULL default '',
  `mb_intercept_date` varchar(8) NOT NULL default '',
  `mb_email_certify` datetime NOT NULL default '0000-00-00 00:00:00',
  `mb_email_certify2` varchar(255) NOT NULL default '',
  `mb_memo` text NOT NULL,
  `mb_lost_certify` varchar(255) NOT NULL,
  `mb_mailling` tinyint(4) NOT NULL default '0',
  `mb_sms` tinyint(4) NOT NULL default '0',
  `mb_open` tinyint(4) NOT NULL default '0',
  `mb_open_date` date NOT NULL default '0000-00-00',
  `mb_profile` text NOT NULL,
  `mb_memo_call` varchar(255) NOT NULL default '',
  `mb_memo_cnt` int(11) NOT NULL default '0',
  `mb_scrap_cnt` int(11) NOT NULL default '0',
  `mb_1` varchar(255) NOT NULL default '',
  `mb_2` varchar(255) NOT NULL default '',
  `mb_3` varchar(255) NOT NULL default '',
  `mb_4` varchar(255) NOT NULL default '',
  `mb_5` varchar(255) NOT NULL default '',
  `mb_6` varchar(255) NOT NULL default '',
  `mb_7` varchar(255) NOT NULL default '',
  `mb_8` varchar(255) NOT NULL default '',
  `mb_9` varchar(255) NOT NULL default '',
  `mb_10` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`mb_no`),
  UNIQUE KEY `mb_id` (`mb_id`),
  KEY `mb_today_login` (`mb_today_login`),
  KEY `mb_datetime` (`mb_datetime`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `g5_member`
--

INSERT INTO `g5_member` (`mb_no`, `mb_id`, `mb_password`, `mb_name`, `mb_nick`, `mb_nick_date`, `mb_email`, `mb_homepage`, `mb_level`, `mb_sex`, `mb_birth`, `mb_tel`, `mb_hp`, `mb_certify`, `mb_adult`, `mb_dupinfo`, `mb_zip1`, `mb_zip2`, `mb_addr1`, `mb_addr2`, `mb_addr3`, `mb_addr_jibeon`, `mb_signature`, `mb_recommend`, `mb_point`, `mb_today_login`, `mb_login_ip`, `mb_datetime`, `mb_ip`, `mb_leave_date`, `mb_intercept_date`, `mb_email_certify`, `mb_email_certify2`, `mb_memo`, `mb_lost_certify`, `mb_mailling`, `mb_sms`, `mb_open`, `mb_open_date`, `mb_profile`, `mb_memo_call`, `mb_memo_cnt`, `mb_scrap_cnt`, `mb_1`, `mb_2`, `mb_3`, `mb_4`, `mb_5`, `mb_6`, `mb_7`, `mb_8`, `mb_9`, `mb_10`) VALUES
(1, 'admin', 'sha256:12000:+Vl7OCXz17IeoQO3lgSo8Ievu54lp9CC:fcYQQFObR+lgl/B+WUkR7LuAHFqeq6l4', '최고관리자', '최고관리자', '0000-00-00', 'admin@domain.com', '', 10, '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', 148699, '2020-03-10 03:21:19', '118.223.133.118', '2020-02-27 19:21:28', '222.102.192.114', '', '', '2020-02-27 19:21:28', '', '', '', 1, 0, 1, '0000-00-00', '', '', 0, 0, '', '', '', '', '', '', '', '', '', ''),
(2, 'test', 'sha256:12000:tyNP4tIqnYBIV6C7EWg3StXDduRc/H8K:r29CwRIN/R1r0JqA5vdQEs5sRNWlWRnf', 'cxxx', 'cxxxp', '2020-03-02', 'dhdhsh@gmail.cjn', '', 2, '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', 1000, '2020-03-02 19:02:46', '14.6.171.34', '2020-03-02 19:02:46', '14.6.171.34', '', '', '2020-03-02 19:02:46', '', '', '', 1, 0, 1, '2020-03-02', '', '', 0, 0, '', '', '', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `g5_member_social_profiles`
--

CREATE TABLE IF NOT EXISTS `g5_member_social_profiles` (
  `mp_no` int(11) NOT NULL auto_increment,
  `mb_id` varchar(255) NOT NULL default '',
  `provider` varchar(50) NOT NULL default '',
  `object_sha` varchar(45) NOT NULL default '',
  `identifier` varchar(255) NOT NULL default '',
  `profileurl` varchar(255) NOT NULL default '',
  `photourl` varchar(255) NOT NULL default '',
  `displayname` varchar(150) NOT NULL default '',
  `description` varchar(255) NOT NULL default '',
  `mp_register_day` datetime NOT NULL default '0000-00-00 00:00:00',
  `mp_latest_day` datetime NOT NULL default '0000-00-00 00:00:00',
  UNIQUE KEY `mp_no` (`mp_no`),
  KEY `mb_id` (`mb_id`),
  KEY `provider` (`provider`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `g5_memo`
--

CREATE TABLE IF NOT EXISTS `g5_memo` (
  `me_id` int(11) NOT NULL auto_increment,
  `me_recv_mb_id` varchar(20) NOT NULL default '',
  `me_send_mb_id` varchar(20) NOT NULL default '',
  `me_send_datetime` datetime NOT NULL default '0000-00-00 00:00:00',
  `me_read_datetime` datetime NOT NULL default '0000-00-00 00:00:00',
  `me_memo` text NOT NULL,
  `me_send_id` int(11) NOT NULL default '0',
  `me_type` enum('send','recv') NOT NULL default 'recv',
  `me_send_ip` varchar(100) NOT NULL default '',
  PRIMARY KEY  (`me_id`),
  KEY `me_recv_mb_id` (`me_recv_mb_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `g5_menu`
--

CREATE TABLE IF NOT EXISTS `g5_menu` (
  `me_id` int(11) NOT NULL auto_increment,
  `me_code` varchar(255) NOT NULL default '',
  `me_name` varchar(255) NOT NULL default '',
  `me_link` varchar(255) NOT NULL default '',
  `me_target` varchar(255) NOT NULL default '',
  `me_order` int(11) NOT NULL default '0',
  `me_use` tinyint(4) NOT NULL default '0',
  `me_mobile_use` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`me_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `g5_new_win`
--

CREATE TABLE IF NOT EXISTS `g5_new_win` (
  `nw_id` int(11) NOT NULL auto_increment,
  `nw_division` varchar(10) NOT NULL default 'both',
  `nw_device` varchar(10) NOT NULL default 'both',
  `nw_begin_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `nw_end_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `nw_disable_hours` int(11) NOT NULL default '0',
  `nw_left` int(11) NOT NULL default '0',
  `nw_top` int(11) NOT NULL default '0',
  `nw_height` int(11) NOT NULL default '0',
  `nw_width` int(11) NOT NULL default '0',
  `nw_subject` text NOT NULL,
  `nw_content` text NOT NULL,
  `nw_content_html` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`nw_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `g5_point`
--

CREATE TABLE IF NOT EXISTS `g5_point` (
  `po_id` int(11) NOT NULL auto_increment,
  `mb_id` varchar(20) NOT NULL default '',
  `po_datetime` datetime NOT NULL default '0000-00-00 00:00:00',
  `po_content` varchar(255) NOT NULL default '',
  `po_point` int(11) NOT NULL default '0',
  `po_use_point` int(11) NOT NULL default '0',
  `po_expired` tinyint(4) NOT NULL default '0',
  `po_expire_date` date NOT NULL default '0000-00-00',
  `po_mb_point` int(11) NOT NULL default '0',
  `po_rel_table` varchar(20) NOT NULL default '',
  `po_rel_id` varchar(20) NOT NULL default '',
  `po_rel_action` varchar(100) NOT NULL default '',
  PRIMARY KEY  (`po_id`),
  KEY `index1` (`mb_id`,`po_rel_table`,`po_rel_id`,`po_rel_action`),
  KEY `index2` (`po_expire_date`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=38 ;

--
-- Dumping data for table `g5_point`
--

INSERT INTO `g5_point` (`po_id`, `mb_id`, `po_datetime`, `po_content`, `po_point`, `po_use_point`, `po_expired`, `po_expire_date`, `po_mb_point`, `po_rel_table`, `po_rel_id`, `po_rel_action`) VALUES
(1, 'admin', '2020-02-27 19:21:41', '2020-02-27 첫로그인', 100, 0, 0, '9999-12-31', 100, '@login', 'admin', '2020-02-27'),
(2, 'admin', '2020-02-28 12:11:46', '2020-02-28 첫로그인', 100, 0, 0, '9999-12-31', 200, '@login', 'admin', '2020-02-28'),
(3, 'admin', '2020-03-02 11:56:17', '2020-03-02 첫로그인', 100, 0, 0, '9999-12-31', 300, '@login', 'admin', '2020-03-02'),
(4, 'test', '2020-03-02 19:02:46', '회원가입 축하', 1000, 0, 0, '9999-12-31', 1000, '@member', 'test', '회원가입'),
(5, 'admin', '2020-03-02 19:38:03', '무료충전 포인트', 99, 0, 0, '9999-12-31', 399, '', '', ''),
(6, 'admin', '2020-03-02 19:38:18', '무료충전 포인트', 99, 0, 0, '9999-12-31', 498, '', '', ''),
(7, 'admin', '2020-03-02 19:41:25', '무료충전(한화생명과 함께하세요) 포인트 지급', 100, 0, 0, '9999-12-31', 598, '', '', ''),
(8, 'admin', '2020-03-02 19:42:36', '무료충전(test) 포인트 지급', 10000, 0, 0, '9999-12-31', 10598, '', '', ''),
(9, 'admin', '2020-03-02 19:44:42', '무료충전(asdf) 포인트 지급', 1, 0, 0, '9999-12-31', 10599, '', '', ''),
(11, 'admin', '2020-03-02 20:42:33', '주문번호 2020030220410459 (6) 배송완료', 1000, 0, 0, '9999-12-31', 11599, '@delivery', 'admin', '2020030220410459,6'),
(12, 'admin', '2020-03-03 11:41:40', '2020-03-03 첫로그인', 100, 0, 0, '9999-12-31', 11699, '@login', 'admin', '2020-03-03'),
(13, 'admin', '2020-03-04 12:18:40', '2020-03-04 첫로그인', 100, 0, 0, '9999-12-31', 11799, '@login', 'admin', '2020-03-04'),
(14, 'admin', '2020-03-04 12:18:43', '무료충전(test) 포인트 지급', 10000, 0, 0, '9999-12-31', 21799, '', '', ''),
(15, 'admin', '2020-03-04 12:19:00', '무료충전(한화생명과 함께하세요) 포인트 지급', 100, 0, 0, '9999-12-31', 21899, '', '', ''),
(19, 'admin', '2020-03-04 16:47:04', '주문번호 2020030416124889 (37) 쿠폰구매지급', 50000, 0, 0, '9999-12-31', 71899, '@delivery', 'admin', '2020030416124889,37'),
(20, 'admin', '2020-03-04 16:48:14', '주문번호 2020030416475211 (38) 쿠폰구매지급', 800, 0, 0, '9999-12-31', 72699, '@delivery', 'admin', '2020030416475211,38'),
(21, 'admin', '2020-03-04 16:49:45', '주문번호 2020030416492743 (39) 배송완료', 800, 0, 0, '9999-12-31', 73499, '@delivery', 'admin', '2020030416492743,39'),
(23, 'admin', '2020-03-04 16:57:36', '주문번호 2020030416500088 (40) 쿠폰구매지급', 50000, 0, 0, '9999-12-31', 123499, '@delivery', 'admin', '2020030416500088,40'),
(24, 'admin', '2020-03-04 16:58:19', '주문번호 2020030416575457 (41) 배송완료', 800, 0, 0, '9999-12-31', 124299, '@delivery', 'admin', '2020030416575457,41'),
(25, 'admin', '2020-03-04 17:01:06', '무료충전(ㅅㄷㄴㅅㅅㄷㄴ) 포인트 지급', 99, 0, 0, '9999-12-31', 124398, '', '', ''),
(26, 'admin', '2020-03-06 12:34:18', '2020-03-06 첫로그인', 100, 0, 0, '9999-12-31', 124498, '@login', 'admin', '2020-03-06'),
(27, 'admin', '2020-03-06 15:16:47', '포인트', 1000, 0, 0, '9999-12-31', 125498, '쿠폰사용', '', ''),
(28, 'admin', '2020-03-06 15:17:11', '쿠폰사용', 1000, 0, 0, '9999-12-31', 126498, '', '', ''),
(29, 'admin', '2020-03-06 15:17:40', '9S4D-2S-XL97쿠폰사용', 1000, 0, 0, '9999-12-31', 127498, '', '', ''),
(30, 'admin', '2020-03-06 15:19:44', 'CA6U-TU-BE3X - 쿠폰사용', 1000, 0, 0, '9999-12-31', 128498, '', '', ''),
(31, 'admin', '2020-03-06 15:22:25', 'EJX1-H7-FNVA - 쿠폰사용', 5000, 0, 0, '9999-12-31', 133498, '', '', ''),
(32, 'admin', '2020-03-06 15:29:35', 'CZCB-3R-AYAJ - 쿠폰사용', 5000, 0, 0, '9999-12-31', 138498, '', '', ''),
(33, 'admin', '2020-03-06 15:31:11', 'DZWJ-JZ-VEZB - 쿠폰사용', 1, 0, 0, '9999-12-31', 138499, '', '', ''),
(34, 'admin', '2020-03-06 15:44:15', 'LEYR-B4-QNJ7 - 쿠폰사용', 1, 0, 0, '9999-12-31', 138500, '', '', ''),
(35, 'admin', '2020-03-06 15:51:25', '무료충전(test) 포인트 지급', 10000, 0, 0, '9999-12-31', 148500, '', '', ''),
(36, 'admin', '2020-03-06 15:53:38', '무료충전(한화생명과 함께하세요) 포인트 지급', 100, 0, 0, '9999-12-31', 148600, '', '', ''),
(37, 'admin', '2020-03-06 21:42:00', '무료충전(ㅅㄷㄴㅅㅅㄷㄴ) 포인트 지급', 99, 0, 0, '9999-12-31', 148699, '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `g5_poll`
--

CREATE TABLE IF NOT EXISTS `g5_poll` (
  `po_id` int(11) NOT NULL auto_increment,
  `po_subject` varchar(255) NOT NULL default '',
  `po_poll1` varchar(255) NOT NULL default '',
  `po_poll2` varchar(255) NOT NULL default '',
  `po_poll3` varchar(255) NOT NULL default '',
  `po_poll4` varchar(255) NOT NULL default '',
  `po_poll5` varchar(255) NOT NULL default '',
  `po_poll6` varchar(255) NOT NULL default '',
  `po_poll7` varchar(255) NOT NULL default '',
  `po_poll8` varchar(255) NOT NULL default '',
  `po_poll9` varchar(255) NOT NULL default '',
  `po_cnt1` int(11) NOT NULL default '0',
  `po_cnt2` int(11) NOT NULL default '0',
  `po_cnt3` int(11) NOT NULL default '0',
  `po_cnt4` int(11) NOT NULL default '0',
  `po_cnt5` int(11) NOT NULL default '0',
  `po_cnt6` int(11) NOT NULL default '0',
  `po_cnt7` int(11) NOT NULL default '0',
  `po_cnt8` int(11) NOT NULL default '0',
  `po_cnt9` int(11) NOT NULL default '0',
  `po_etc` varchar(255) NOT NULL default '',
  `po_level` tinyint(4) NOT NULL default '0',
  `po_point` int(11) NOT NULL default '0',
  `po_date` date NOT NULL default '0000-00-00',
  `po_ips` mediumtext NOT NULL,
  `mb_ids` text NOT NULL,
  PRIMARY KEY  (`po_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `g5_poll_etc`
--

CREATE TABLE IF NOT EXISTS `g5_poll_etc` (
  `pc_id` int(11) NOT NULL default '0',
  `po_id` int(11) NOT NULL default '0',
  `mb_id` varchar(20) NOT NULL default '',
  `pc_name` varchar(255) NOT NULL default '',
  `pc_idea` varchar(255) NOT NULL default '',
  `pc_datetime` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`pc_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `g5_popular`
--

CREATE TABLE IF NOT EXISTS `g5_popular` (
  `pp_id` int(11) NOT NULL auto_increment,
  `pp_word` varchar(50) NOT NULL default '',
  `pp_date` date NOT NULL default '0000-00-00',
  `pp_ip` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`pp_id`),
  UNIQUE KEY `index1` (`pp_date`,`pp_word`,`pp_ip`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `g5_qa_config`
--

CREATE TABLE IF NOT EXISTS `g5_qa_config` (
  `qa_title` varchar(255) NOT NULL default '',
  `qa_category` varchar(255) NOT NULL default '',
  `qa_skin` varchar(255) NOT NULL default '',
  `qa_mobile_skin` varchar(255) NOT NULL default '',
  `qa_use_email` tinyint(4) NOT NULL default '0',
  `qa_req_email` tinyint(4) NOT NULL default '0',
  `qa_use_hp` tinyint(4) NOT NULL default '0',
  `qa_req_hp` tinyint(4) NOT NULL default '0',
  `qa_use_sms` tinyint(4) NOT NULL default '0',
  `qa_send_number` varchar(255) NOT NULL default '0',
  `qa_admin_hp` varchar(255) NOT NULL default '',
  `qa_admin_email` varchar(255) NOT NULL default '',
  `qa_use_editor` tinyint(4) NOT NULL default '0',
  `qa_subject_len` int(11) NOT NULL default '0',
  `qa_mobile_subject_len` int(11) NOT NULL default '0',
  `qa_page_rows` int(11) NOT NULL default '0',
  `qa_mobile_page_rows` int(11) NOT NULL default '0',
  `qa_image_width` int(11) NOT NULL default '0',
  `qa_upload_size` int(11) NOT NULL default '0',
  `qa_insert_content` text NOT NULL,
  `qa_include_head` varchar(255) NOT NULL default '',
  `qa_include_tail` varchar(255) NOT NULL default '',
  `qa_content_head` text NOT NULL,
  `qa_content_tail` text NOT NULL,
  `qa_mobile_content_head` text NOT NULL,
  `qa_mobile_content_tail` text NOT NULL,
  `qa_1_subj` varchar(255) NOT NULL default '',
  `qa_2_subj` varchar(255) NOT NULL default '',
  `qa_3_subj` varchar(255) NOT NULL default '',
  `qa_4_subj` varchar(255) NOT NULL default '',
  `qa_5_subj` varchar(255) NOT NULL default '',
  `qa_1` varchar(255) NOT NULL default '',
  `qa_2` varchar(255) NOT NULL default '',
  `qa_3` varchar(255) NOT NULL default '',
  `qa_4` varchar(255) NOT NULL default '',
  `qa_5` varchar(255) NOT NULL default ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `g5_qa_config`
--

INSERT INTO `g5_qa_config` (`qa_title`, `qa_category`, `qa_skin`, `qa_mobile_skin`, `qa_use_email`, `qa_req_email`, `qa_use_hp`, `qa_req_hp`, `qa_use_sms`, `qa_send_number`, `qa_admin_hp`, `qa_admin_email`, `qa_use_editor`, `qa_subject_len`, `qa_mobile_subject_len`, `qa_page_rows`, `qa_mobile_page_rows`, `qa_image_width`, `qa_upload_size`, `qa_insert_content`, `qa_include_head`, `qa_include_tail`, `qa_content_head`, `qa_content_tail`, `qa_mobile_content_head`, `qa_mobile_content_tail`, `qa_1_subj`, `qa_2_subj`, `qa_3_subj`, `qa_4_subj`, `qa_5_subj`, `qa_1`, `qa_2`, `qa_3`, `qa_4`, `qa_5`) VALUES
('1:1문의', '회원|포인트', 'basic', 'basic', 1, 0, 1, 0, 0, '0', '', '', 1, 60, 30, 15, 15, 600, 1048576, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `g5_qa_content`
--

CREATE TABLE IF NOT EXISTS `g5_qa_content` (
  `qa_id` int(11) NOT NULL auto_increment,
  `qa_num` int(11) NOT NULL default '0',
  `qa_parent` int(11) NOT NULL default '0',
  `qa_related` int(11) NOT NULL default '0',
  `mb_id` varchar(20) NOT NULL default '',
  `qa_name` varchar(255) NOT NULL default '',
  `qa_email` varchar(255) NOT NULL default '',
  `qa_hp` varchar(255) NOT NULL default '',
  `qa_type` tinyint(4) NOT NULL default '0',
  `qa_category` varchar(255) NOT NULL default '',
  `qa_email_recv` tinyint(4) NOT NULL default '0',
  `qa_sms_recv` tinyint(4) NOT NULL default '0',
  `qa_html` tinyint(4) NOT NULL default '0',
  `qa_subject` varchar(255) NOT NULL default '',
  `qa_content` text NOT NULL,
  `qa_status` tinyint(4) NOT NULL default '0',
  `qa_file1` varchar(255) NOT NULL default '',
  `qa_source1` varchar(255) NOT NULL default '',
  `qa_file2` varchar(255) NOT NULL default '',
  `qa_source2` varchar(255) NOT NULL default '',
  `qa_ip` varchar(255) NOT NULL default '',
  `qa_datetime` datetime NOT NULL default '0000-00-00 00:00:00',
  `qa_1` varchar(255) NOT NULL default '',
  `qa_2` varchar(255) NOT NULL default '',
  `qa_3` varchar(255) NOT NULL default '',
  `qa_4` varchar(255) NOT NULL default '',
  `qa_5` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`qa_id`),
  KEY `qa_num_parent` (`qa_num`,`qa_parent`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `g5_scrap`
--

CREATE TABLE IF NOT EXISTS `g5_scrap` (
  `ms_id` int(11) NOT NULL auto_increment,
  `mb_id` varchar(20) NOT NULL default '',
  `bo_table` varchar(20) NOT NULL default '',
  `wr_id` varchar(15) NOT NULL default '',
  `ms_datetime` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`ms_id`),
  KEY `mb_id` (`mb_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `g5_shop_banner`
--

CREATE TABLE IF NOT EXISTS `g5_shop_banner` (
  `bn_id` int(11) NOT NULL auto_increment,
  `bn_url` varchar(255) NOT NULL default '',
  `bn_begin_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `bn_end_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `bn_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `bn_hit` int(11) NOT NULL default '0',
  `bn_order` int(11) NOT NULL default '0',
  `bn_subject` varchar(255) NOT NULL,
  `bn_desc` varchar(255) NOT NULL,
  `bn_company` varchar(255) NOT NULL,
  PRIMARY KEY  (`bn_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `g5_shop_banner`
--

INSERT INTO `g5_shop_banner` (`bn_id`, `bn_url`, `bn_begin_time`, `bn_end_time`, `bn_time`, `bn_hit`, `bn_order`, `bn_subject`, `bn_desc`, `bn_company`) VALUES
(1, 'http://', '2020-03-02 00:00:00', '2020-04-02 23:59:59', '0000-00-00 00:00:00', 0, 50, '', '', ''),
(2, 'http://', '2020-03-02 00:00:00', '2020-04-02 00:00:00', '0000-00-00 00:00:00', 0, 50, '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `g5_shop_cart`
--

CREATE TABLE IF NOT EXISTS `g5_shop_cart` (
  `ct_id` int(11) NOT NULL auto_increment,
  `od_id` bigint(20) unsigned NOT NULL,
  `mb_id` varchar(255) NOT NULL default '',
  `it_id` varchar(20) NOT NULL default '',
  `it_name` varchar(255) NOT NULL default '',
  `it_sc_type` tinyint(4) NOT NULL default '0',
  `it_sc_method` tinyint(4) NOT NULL default '0',
  `it_sc_price` int(11) NOT NULL default '0',
  `it_sc_minimum` int(11) NOT NULL default '0',
  `it_sc_qty` int(11) NOT NULL default '0',
  `ct_status` varchar(255) NOT NULL default '',
  `ct_history` text NOT NULL,
  `ct_price` int(11) NOT NULL default '0',
  `ct_point` int(11) NOT NULL default '0',
  `cp_price` int(11) NOT NULL default '0',
  `ct_point_use` tinyint(4) NOT NULL default '0',
  `ct_stock_use` tinyint(4) NOT NULL default '0',
  `ct_option` varchar(255) NOT NULL default '',
  `ct_qty` int(11) NOT NULL default '0',
  `ct_notax` tinyint(4) NOT NULL default '0',
  `io_id` varchar(255) NOT NULL default '',
  `io_type` tinyint(4) NOT NULL default '0',
  `io_price` int(11) NOT NULL default '0',
  `ct_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `ct_ip` varchar(25) NOT NULL default '',
  `ct_send_cost` tinyint(4) NOT NULL default '0',
  `ct_direct` tinyint(4) NOT NULL default '0',
  `ct_select` tinyint(4) NOT NULL default '0',
  `ct_select_time` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`ct_id`),
  KEY `od_id` (`od_id`),
  KEY `it_id` (`it_id`),
  KEY `ct_status` (`ct_status`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=43 ;

--
-- Dumping data for table `g5_shop_cart`
--

INSERT INTO `g5_shop_cart` (`ct_id`, `od_id`, `mb_id`, `it_id`, `it_name`, `it_sc_type`, `it_sc_method`, `it_sc_price`, `it_sc_minimum`, `it_sc_qty`, `ct_status`, `ct_history`, `ct_price`, `ct_point`, `cp_price`, `ct_point_use`, `ct_stock_use`, `ct_option`, `ct_qty`, `ct_notax`, `io_id`, `io_type`, `io_price`, `ct_time`, `ct_ip`, `ct_send_cost`, `ct_direct`, `ct_select`, `ct_select_time`) VALUES
(1, 2020030220202009, 'admin', '1583147875', 'test', 0, 0, 0, 0, 0, '완료', '\n완료|admin|2020-03-02 20:21:48|14.6.171.34\n완료|admin|2020-03-02 20:22:21|14.6.171.34\n완료|admin|2020-03-02 20:23:18|14.6.171.34', 10000, 1000, 0, 1, 1, 'test', 1, 0, '', 0, 0, '2020-03-02 20:20:19', '14.6.171.34', 0, 1, 1, '2020-03-02 20:20:19'),
(2, 2020030220234571, 'admin', '1583147875', 'test', 0, 0, 0, 0, 0, '완료', '\n완료|admin|2020-03-02 20:24:14|14.6.171.34\n완료|admin|2020-03-02 20:24:49|14.6.171.34', 10000, 1000, 0, 1, 1, 'test', 1, 0, '', 0, 0, '2020-03-02 20:23:45', '14.6.171.34', 0, 1, 1, '2020-03-02 20:23:45'),
(3, 2020030220245701, 'admin', '1583147875', 'test', 0, 0, 0, 0, 0, '완료', '\n완료|admin|2020-03-02 20:25:22|14.6.171.34', 10000, 1000, 0, 1, 1, 'test', 1, 0, '', 0, 0, '2020-03-02 20:24:56', '14.6.171.34', 0, 1, 1, '2020-03-02 20:24:56'),
(4, 2020030220280615, 'admin', '1583147875', 'test', 0, 0, 0, 0, 0, '완료', '\n완료|admin|2020-03-02 20:29:09|14.6.171.34\n입금|admin|2020-03-02 20:29:20|14.6.171.34\n배송|admin|2020-03-02 20:29:25|14.6.171.34\n완료|admin|2020-03-02 20:29:28|14.6.171.34\n완료|admin|2020-03-02 20:29:56|14.6.171.34\n완료|admin|2020-03-02 20:32:16|14.6.171.34\n완료|admin|2020-03-02 20:35:05|14.6.171.34', 10000, 0, 0, 1, 1, 'test', 1, 0, '', 0, 0, '2020-03-02 20:28:05', '14.6.171.34', 0, 1, 1, '2020-03-02 20:28:05'),
(5, 2020030220324665, 'admin', '1583147875', 'test', 0, 0, 0, 0, 0, '완료', '\n완료|admin|2020-03-02 20:33:12|14.6.171.34\n배송|admin|2020-03-02 20:35:39|14.6.171.34\n완료|admin|2020-03-02 20:37:19|14.6.171.34\n취소|admin|2020-03-04 16:47:27|14.6.171.34\n완료|admin|2020-03-04 16:47:30|14.6.171.34', 10000, 0, 0, 1, 1, 'test', 1, 0, '', 0, 0, '2020-03-02 20:32:46', '14.6.171.34', 0, 1, 1, '2020-03-02 20:32:46'),
(6, 2020030220410459, 'admin', '1583147875', 'test', 0, 0, 0, 0, 0, '완료', '\n완료|admin|2020-03-02 20:41:37|14.6.171.34\n반품|admin|2020-03-02 20:42:05|14.6.171.34\n완료|admin|2020-03-02 20:42:33|14.6.171.34', 10000, 1000, 0, 1, 1, 'test', 1, 0, '', 0, 0, '2020-03-02 20:41:04', '14.6.171.34', 0, 1, 1, '2020-03-02 20:41:04'),
(7, 2020030220581230, 'test', '1583150102', '상품명', 0, 0, 0, 0, 0, '주문', '', 0, 0, 0, 0, 0, '상품명', 1, 0, '', 0, 0, '2020-03-02 20:58:12', '14.6.171.34', 0, 1, 1, '2020-03-02 20:58:12'),
(27, 2020030414580969, 'admin', '1583297332', '쿠폰입니다', 0, 0, 0, 0, 0, '주문', '', 50000, 50000, 0, 0, 0, '쿠폰입니다', 1, 0, '', 0, 0, '2020-03-04 14:27:40', '14.6.171.34', 0, 1, 1, '2020-03-04 14:27:40'),
(28, 2020030415011874, 'admin', '1583297332', '쿠폰입니다', 0, 0, 0, 0, 0, '주문', '', 50000, 50000, 0, 0, 0, '쿠폰입니다', 1, 0, '', 0, 0, '2020-03-04 14:59:20', '14.6.171.34', 0, 1, 1, '2020-03-04 14:59:20'),
(29, 2020030415093783, 'admin', '1583297332', '쿠폰입니다', 0, 0, 0, 0, 0, '주문', '', 50000, 50000, 0, 0, 0, '쿠폰입니다', 1, 0, '', 0, 0, '2020-03-04 15:02:14', '14.6.171.34', 0, 1, 1, '2020-03-04 15:02:14'),
(30, 2020030415103355, 'admin', '1583297332', '쿠폰입니다', 0, 0, 0, 0, 0, '주문', '', 50000, 50000, 0, 0, 0, '쿠폰입니다', 1, 0, '', 0, 0, '2020-03-04 15:09:59', '14.6.171.34', 0, 1, 1, '2020-03-04 15:09:59'),
(31, 2020030415110478, 'admin', '1583297332', '쿠폰입니다', 0, 0, 0, 0, 0, '주문', '', 50000, 50000, 0, 0, 0, '쿠폰입니다', 1, 0, '', 0, 0, '2020-03-04 15:10:44', '14.6.171.34', 0, 1, 1, '2020-03-04 15:10:44'),
(32, 2020030415114193, 'admin', '1583297332', '쿠폰입니다', 0, 0, 0, 0, 0, '주문', '', 50000, 50000, 0, 0, 0, '쿠폰입니다', 1, 0, '', 0, 0, '2020-03-04 15:11:41', '14.6.171.34', 0, 1, 1, '2020-03-04 15:11:41'),
(33, 2020030415115511, 'admin', '1583297332', '쿠폰입니다', 0, 0, 0, 0, 0, '주문', '', 50000, 50000, 0, 0, 0, '쿠폰입니다', 1, 0, '', 0, 0, '2020-03-04 15:11:54', '14.6.171.34', 0, 1, 1, '2020-03-04 15:11:54'),
(34, 2020030415124156, 'admin', '1583297332', '쿠폰입니다', 0, 0, 0, 0, 0, '주문', '', 50000, 50000, 0, 0, 0, '쿠폰입니다', 1, 0, '', 0, 0, '2020-03-04 15:12:41', '14.6.171.34', 0, 1, 1, '2020-03-04 15:12:41'),
(35, 2020030415132002, 'admin', '1583297332', '쿠폰입니다', 0, 0, 0, 0, 0, '주문', '', 50000, 50000, 0, 0, 0, '쿠폰입니다', 1, 0, '', 0, 0, '2020-03-04 15:13:19', '14.6.171.34', 0, 1, 1, '2020-03-04 15:13:19'),
(36, 2020030415142253, 'admin', '1583297332', '쿠폰입니다', 0, 0, 0, 0, 0, '주문', '', 50000, 50000, 0, 0, 0, '쿠폰입니다', 1, 0, '', 0, 0, '2020-03-04 15:14:22', '14.6.171.34', 0, 1, 1, '2020-03-04 15:14:22'),
(37, 2020030416124889, 'admin', '1583297332', '쿠폰입니다', 0, 0, 0, 0, 0, '완료', '\n배송|admin|2020-03-04 16:15:40|14.6.171.34\n완료|admin|2020-03-04 16:21:05|14.6.171.34\n완료|admin|2020-03-04 16:22:23|14.6.171.34\n배송|admin|2020-03-04 16:22:33|14.6.171.34\n완료|admin|2020-03-04 16:31:49|14.6.171.34\n배송|admin|2020-03-04 16:47:01|14.6.171.34\n완료|admin|2020-03-04 16:47:04|14.6.171.34', 50000, 50000, 0, 1, 1, '쿠폰입니다', 1, 0, '', 0, 0, '2020-03-04 16:10:38', '14.6.171.34', 0, 1, 1, '2020-03-04 16:10:38'),
(38, 2020030416475211, 'admin', '1583150102', '상품명', 0, 0, 0, 0, 0, '완료', '\n완료|admin|2020-03-04 16:48:14|14.6.171.34', 0, 800, 0, 1, 1, '상품명', 1, 0, '', 0, 0, '2020-03-04 16:47:51', '14.6.171.34', 0, 1, 1, '2020-03-04 16:47:51'),
(39, 2020030416492743, 'admin', '1583150102', '상품명', 0, 0, 0, 0, 0, '완료', '\n완료|admin|2020-03-04 16:49:45|14.6.171.34', 0, 800, 0, 1, 1, '상품명', 1, 0, '', 0, 0, '2020-03-04 16:49:27', '14.6.171.34', 0, 1, 1, '2020-03-04 16:49:27'),
(40, 2020030416500088, 'admin', '1583297332', '쿠폰입니다', 0, 0, 0, 0, 0, '완료', '\n완료|admin|2020-03-04 16:50:10|14.6.171.34\n준비|admin|2020-03-04 16:57:22|14.6.171.34\n완료|admin|2020-03-04 16:57:35|14.6.171.34', 50000, 50000, 0, 1, 1, '쿠폰입니다', 1, 0, '', 0, 0, '2020-03-04 16:50:00', '14.6.171.34', 0, 1, 1, '2020-03-04 16:50:00'),
(41, 2020030416575457, 'admin', '1583150102', '상품명', 0, 0, 0, 0, 0, '완료', '\n완료|admin|2020-03-04 16:58:19|14.6.171.34', 0, 800, 0, 1, 1, '상품명', 1, 0, '', 0, 0, '2020-03-04 16:57:54', '14.6.171.34', 0, 1, 1, '2020-03-04 16:57:54'),
(42, 2020030615492354, 'admin', '1583150102', '상품명', 0, 0, 0, 0, 0, '주문', '', 0, 800, 0, 0, 0, '상품명', 1, 0, '', 0, 0, '2020-03-06 15:49:23', '14.6.171.34', 0, 1, 1, '2020-03-06 15:49:23');

-- --------------------------------------------------------

--
-- Table structure for table `g5_shop_category`
--

CREATE TABLE IF NOT EXISTS `g5_shop_category` (
  `ca_id` varchar(10) NOT NULL default '0',
  `ca_name` varchar(255) NOT NULL default '',
  `ca_order` int(11) NOT NULL default '0',
  `ca_skin_dir` varchar(255) NOT NULL default '',
  `ca_mobile_skin_dir` varchar(255) NOT NULL default '',
  `ca_skin` varchar(255) NOT NULL default '',
  `ca_mobile_skin` varchar(255) NOT NULL default '',
  `ca_img_width` int(11) NOT NULL default '0',
  `ca_img_height` int(11) NOT NULL default '0',
  `ca_mobile_img_width` int(11) NOT NULL default '0',
  `ca_mobile_img_height` int(11) NOT NULL default '0',
  `ca_sell_email` varchar(255) NOT NULL default '',
  `ca_use` tinyint(4) NOT NULL default '0',
  `ca_stock_qty` int(11) NOT NULL default '0',
  `ca_explan_html` tinyint(4) NOT NULL default '0',
  `ca_head_html` text NOT NULL,
  `ca_tail_html` text NOT NULL,
  `ca_mobile_head_html` text NOT NULL,
  `ca_mobile_tail_html` text NOT NULL,
  `ca_list_mod` int(11) NOT NULL default '0',
  `ca_list_row` int(11) NOT NULL default '0',
  `ca_mobile_list_mod` int(11) NOT NULL default '0',
  `ca_mobile_list_row` int(11) NOT NULL default '0',
  `ca_include_head` varchar(255) NOT NULL default '',
  `ca_include_tail` varchar(255) NOT NULL default '',
  `ca_mb_id` varchar(255) NOT NULL default '',
  `ca_cert_use` tinyint(4) NOT NULL default '0',
  `ca_adult_use` tinyint(4) NOT NULL default '0',
  `ca_nocoupon` tinyint(4) NOT NULL default '0',
  `ca_1_subj` varchar(255) NOT NULL default '',
  `ca_2_subj` varchar(255) NOT NULL default '',
  `ca_3_subj` varchar(255) NOT NULL default '',
  `ca_4_subj` varchar(255) NOT NULL default '',
  `ca_5_subj` varchar(255) NOT NULL default '',
  `ca_6_subj` varchar(255) NOT NULL default '',
  `ca_7_subj` varchar(255) NOT NULL default '',
  `ca_8_subj` varchar(255) NOT NULL default '',
  `ca_9_subj` varchar(255) NOT NULL default '',
  `ca_10_subj` varchar(255) NOT NULL default '',
  `ca_1` varchar(255) NOT NULL default '',
  `ca_2` varchar(255) NOT NULL default '',
  `ca_3` varchar(255) NOT NULL default '',
  `ca_4` varchar(255) NOT NULL default '',
  `ca_5` varchar(255) NOT NULL default '',
  `ca_6` varchar(255) NOT NULL default '',
  `ca_7` varchar(255) NOT NULL default '',
  `ca_8` varchar(255) NOT NULL default '',
  `ca_9` varchar(255) NOT NULL default '',
  `ca_10` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`ca_id`),
  KEY `ca_order` (`ca_order`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `g5_shop_category`
--

INSERT INTO `g5_shop_category` (`ca_id`, `ca_name`, `ca_order`, `ca_skin_dir`, `ca_mobile_skin_dir`, `ca_skin`, `ca_mobile_skin`, `ca_img_width`, `ca_img_height`, `ca_mobile_img_width`, `ca_mobile_img_height`, `ca_sell_email`, `ca_use`, `ca_stock_qty`, `ca_explan_html`, `ca_head_html`, `ca_tail_html`, `ca_mobile_head_html`, `ca_mobile_tail_html`, `ca_list_mod`, `ca_list_row`, `ca_mobile_list_mod`, `ca_mobile_list_row`, `ca_include_head`, `ca_include_tail`, `ca_mb_id`, `ca_cert_use`, `ca_adult_use`, `ca_nocoupon`, `ca_1_subj`, `ca_2_subj`, `ca_3_subj`, `ca_4_subj`, `ca_5_subj`, `ca_6_subj`, `ca_7_subj`, `ca_8_subj`, `ca_9_subj`, `ca_10_subj`, `ca_1`, `ca_2`, `ca_3`, `ca_4`, `ca_5`, `ca_6`, `ca_7`, `ca_8`, `ca_9`, `ca_10`) VALUES
('10', '랭킹스타', 0, '', 'theme/basic', 'list.10.skin.php', 'list.10.skin.php', 500, 500, 500, 300, '', 1, 99999, 1, '', '', '', '', 1, 5, 1, 5, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `g5_shop_charging`
--

CREATE TABLE IF NOT EXISTS `g5_shop_charging` (
  `bn_id` int(11) NOT NULL auto_increment,
  `bn_alt` varchar(255) NOT NULL default '',
  `bn_url` varchar(255) NOT NULL default '',
  `bn_device` varchar(10) NOT NULL default '',
  `bn_position` varchar(255) NOT NULL default '',
  `bn_border` tinyint(4) NOT NULL default '0',
  `bn_new_win` tinyint(4) NOT NULL default '0',
  `bn_begin_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `bn_end_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `bn_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `bn_hit` int(11) NOT NULL default '0',
  `bn_order` int(11) NOT NULL default '0',
  `bn_company` varchar(255) NOT NULL,
  `bn_subject` varchar(255) NOT NULL,
  `bn_desc` varchar(255) NOT NULL,
  `bn_point` int(11) NOT NULL,
  PRIMARY KEY  (`bn_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `g5_shop_charging`
--

INSERT INTO `g5_shop_charging` (`bn_id`, `bn_alt`, `bn_url`, `bn_device`, `bn_position`, `bn_border`, `bn_new_win`, `bn_begin_time`, `bn_end_time`, `bn_time`, `bn_hit`, `bn_order`, `bn_company`, `bn_subject`, `bn_desc`, `bn_point`) VALUES
(1, '', 'http://naver.com', '', '', 0, 0, '2020-03-02 00:00:00', '2020-04-02 00:00:00', '0000-00-00 00:00:00', 0, 50, '(주)랭킹스타', '구강건강을 위한 구강위생용품의 선두주자', '예방치과의 수호천사엔젤', 123),
(3, '', 'http://naver.com', '', '', 0, 0, '2020-03-02 00:00:00', '2020-04-02 00:00:00', '0000-00-00 00:00:00', 0, 50, 'test', 'test', 'test', 500),
(4, '', 'http://news.nate.com', '', '', 0, 0, '2020-03-02 00:00:00', '2020-04-02 00:00:00', '0000-00-00 00:00:00', 0, 50, 'ㅅㄷㄴㅅㅅㄷㄴㅅㅅㄷㄴㅅ', 'ㅅㄷㄴㅅㅅㄷㄴ', 'ㅅㄷㄴㅅ', 99),
(5, '', 'http://dm-primeloan.com/?n_media=27758&n_query=대부중개&n_rank=10&n_ad_group=grp-a001-01-000000008961924&n_ad=nad-a001-01-000000048151218&n_keyword_id=nkw-a001-01-000001665907479&n_keyword=대부중개&n_campaign_type=1&NaPm=ct%3Dk7fto154%7Cci%3D0zi0001bWQ5sdesOkL0h%', '', '', 0, 0, '2020-03-02 00:00:00', '2020-04-02 00:00:00', '0000-00-00 00:00:00', 0, 50, '한화', '한화생명과 함께하세요', 'ㅁㄴㅇㄹㄴㅁㅇㄹㅁㄴㅇㄹ', 100),
(6, '', 'http://dm-primeloan.com/?n_media=27758&n_query=대부중개&n_rank=10&n_ad_group=grp-a001-01-000000008961924&n_ad=nad-a001-01-000000048151218&n_keyword_id=nkw-a001-01-000001665907479&n_keyword=대부중개&n_campaign_type=1&NaPm=ct%3Dk7fto154%7Cci%3D0zi0001bWQ5sdesOkL0h%', '', '', 0, 0, '2020-03-02 00:00:00', '2020-04-02 00:00:00', '0000-00-00 00:00:00', 0, 50, 'test', 'test', 'test', 10000),
(7, '', 'http://', '', '', 0, 0, '2020-02-02 00:00:00', '2020-02-22 00:00:00', '0000-00-00 00:00:00', 0, 50, 'adsf', 'asdf', 'asdf', 1);

-- --------------------------------------------------------

--
-- Table structure for table `g5_shop_charging_check`
--

CREATE TABLE IF NOT EXISTS `g5_shop_charging_check` (
  `cid` int(11) NOT NULL auto_increment,
  `datetime` datetime NOT NULL default '0000-00-00 00:00:00',
  `mb_id` varchar(255) NOT NULL,
  `bn_id` int(11) NOT NULL,
  PRIMARY KEY  (`cid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=70 ;

--
-- Dumping data for table `g5_shop_charging_check`
--

INSERT INTO `g5_shop_charging_check` (`cid`, `datetime`, `mb_id`, `bn_id`) VALUES
(25, '2020-03-02 19:03:02', 'test', 1),
(24, '2020-03-02 19:01:25', 'admin', 3),
(23, '2020-03-02 19:00:25', 'admin', 2),
(22, '2020-03-02 18:59:08', 'admin', 1),
(26, '2020-03-02 19:03:17', 'test', 3),
(27, '2020-03-02 19:03:26', 'test', 2),
(28, '2020-03-02 19:24:17', 'admin', 4),
(29, '2020-03-02 19:24:36', 'admin', 4),
(30, '2020-03-02 19:24:42', '', 4),
(31, '2020-03-02 19:25:25', 'admin', 4),
(32, '2020-03-02 19:25:55', 'admin', 4),
(33, '2020-03-02 19:26:02', 'admin', 4),
(34, '2020-03-02 19:26:48', 'admin', 4),
(35, '2020-03-02 19:26:58', 'admin', 1),
(36, '2020-03-02 19:26:59', 'admin', 1),
(37, '2020-03-02 19:26:59', 'admin', 1),
(38, '2020-03-02 19:27:50', 'admin', 4),
(39, '2020-03-02 19:27:51', 'admin', 4),
(40, '2020-03-02 19:28:03', 'admin', 4),
(41, '2020-03-02 19:28:53', 'admin', 4),
(42, '2020-03-02 19:29:22', 'admin', 4),
(43, '2020-03-02 19:29:35', 'admin', 4),
(44, '2020-03-02 19:29:50', 'admin', 4),
(45, '2020-03-02 19:30:09', 'admin', 4),
(46, '2020-03-02 19:30:21', 'admin', 4),
(47, '2020-03-02 19:30:46', 'admin', 4),
(48, '2020-03-02 19:31:11', 'admin', 4),
(49, '2020-03-02 19:31:16', 'admin', 4),
(50, '2020-03-02 19:31:35', 'admin', 4),
(51, '2020-03-02 19:32:05', 'admin', 4),
(52, '2020-03-02 19:32:24', 'admin', 4),
(53, '2020-03-02 19:32:50', 'admin', 4),
(54, '2020-03-02 19:33:23', 'admin', 4),
(55, '2020-03-02 19:33:50', 'admin', 4),
(56, '2020-03-02 19:34:26', 'admin', 4),
(57, '2020-03-02 19:35:03', 'admin', 4),
(58, '2020-03-02 19:38:03', 'admin', 4),
(59, '2020-03-02 19:38:18', 'admin', 4),
(60, '2020-03-02 19:41:25', 'admin', 5),
(61, '2020-03-02 19:42:36', 'admin', 6),
(62, '2020-03-02 19:44:42', 'admin', 7),
(63, '2020-03-04 12:18:43', 'admin', 6),
(64, '2020-03-04 12:19:00', 'admin', 5),
(65, '2020-03-04 17:01:06', 'admin', 4),
(66, '2020-03-06 15:51:25', 'admin', 6),
(67, '2020-03-06 15:53:38', 'admin', 5),
(68, '2020-03-06 16:51:11', '', 6),
(69, '2020-03-06 21:42:00', 'admin', 4);

-- --------------------------------------------------------

--
-- Table structure for table `g5_shop_coupon`
--

CREATE TABLE IF NOT EXISTS `g5_shop_coupon` (
  `cp_no` int(11) NOT NULL auto_increment,
  `cp_id` varchar(100) NOT NULL default '',
  `cp_subject` varchar(255) NOT NULL default '',
  `cp_method` tinyint(4) NOT NULL default '0',
  `cp_target` varchar(255) NOT NULL default '',
  `mb_id` varchar(255) NOT NULL default '',
  `cz_id` int(11) NOT NULL default '0',
  `cp_start` date NOT NULL default '0000-00-00',
  `cp_end` date NOT NULL default '0000-00-00',
  `cp_price` int(11) NOT NULL default '0',
  `cp_type` tinyint(4) NOT NULL default '0',
  `cp_trunc` int(11) NOT NULL default '0',
  `cp_minimum` int(11) NOT NULL default '0',
  `cp_maximum` int(11) NOT NULL default '0',
  `od_id` bigint(20) unsigned NOT NULL,
  `cp_datetime` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`cp_no`),
  UNIQUE KEY `cp_id` (`cp_id`),
  KEY `mb_id` (`mb_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `g5_shop_coupon`
--

INSERT INTO `g5_shop_coupon` (`cp_no`, `cp_id`, `cp_subject`, `cp_method`, `cp_target`, `mb_id`, `cz_id`, `cp_start`, `cp_end`, `cp_price`, `cp_type`, `cp_trunc`, `cp_minimum`, `cp_maximum`, `od_id`, `cp_datetime`) VALUES
(1, '4123-6KJQ-6GUN-AAJX', 'test', 0, '1583147875', '전체회원', 0, '2020-03-06', '2020-03-13', 1, 1, 1, 1, 1, 0, '2020-03-06 13:41:27');

-- --------------------------------------------------------

--
-- Table structure for table `g5_shop_coupon_log`
--

CREATE TABLE IF NOT EXISTS `g5_shop_coupon_log` (
  `cl_id` int(11) NOT NULL auto_increment,
  `cp_id` varchar(100) NOT NULL default '',
  `mb_id` varchar(100) NOT NULL default '',
  `od_id` bigint(20) NOT NULL,
  `cp_price` int(11) NOT NULL default '0',
  `cl_datetime` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`cl_id`),
  KEY `mb_id` (`mb_id`),
  KEY `od_id` (`od_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `g5_shop_coupon_zone`
--

CREATE TABLE IF NOT EXISTS `g5_shop_coupon_zone` (
  `cz_id` int(11) NOT NULL auto_increment,
  `cz_type` tinyint(4) NOT NULL default '0',
  `cz_subject` varchar(255) NOT NULL default '',
  `cz_start` date NOT NULL default '0000-00-00',
  `cz_end` date NOT NULL default '0000-00-00',
  `cz_file` varchar(255) NOT NULL default '',
  `cz_period` int(11) NOT NULL default '0',
  `cz_point` int(11) NOT NULL default '0',
  `cp_method` tinyint(4) NOT NULL default '0',
  `cp_target` varchar(255) NOT NULL default '',
  `cp_price` int(11) NOT NULL default '0',
  `cp_type` tinyint(4) NOT NULL default '0',
  `cp_trunc` int(11) NOT NULL default '0',
  `cp_minimum` int(11) NOT NULL default '0',
  `cp_maximum` int(11) NOT NULL default '0',
  `cz_download` int(11) NOT NULL default '0',
  `cz_datetime` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`cz_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `g5_shop_cp`
--

CREATE TABLE IF NOT EXISTS `g5_shop_cp` (
  `cp_id` int(11) NOT NULL auto_increment,
  `cp_number` varchar(255) NOT NULL,
  `cp_using` int(11) NOT NULL default '0',
  `cp_mb_id` varchar(255) NOT NULL,
  `cp_point` int(11) NOT NULL default '0',
  `cp_datetime` varchar(255) NOT NULL default '0000-00-00 00:00:00',
  `cp_use_date` varchar(255) NOT NULL,
  PRIMARY KEY  (`cp_id`),
  UNIQUE KEY `cp_number` (`cp_number`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=57 ;

--
-- Dumping data for table `g5_shop_cp`
--

INSERT INTO `g5_shop_cp` (`cp_id`, `cp_number`, `cp_using`, `cp_mb_id`, `cp_point`, `cp_datetime`, `cp_use_date`) VALUES
(1, 'SF69-VP-HZAU', 0, '', 5000, '2020-03-06 15:22:17', ''),
(2, 'M7HS-R2-5MGG', 0, '', 5000, '2020-03-06 15:22:17', ''),
(3, '8FJZ-MU-UPKF', 0, '', 5000, '2020-03-06 15:22:17', ''),
(4, 'SQTL-MB-5FSR', 0, '', 5000, '2020-03-06 15:22:17', ''),
(5, 'ZDNW-GR-2GGR', 0, '', 5000, '2020-03-06 15:22:17', ''),
(6, 'H65K-9X-ADHX', 0, '', 5000, '2020-03-06 15:22:17', ''),
(7, '5EVF-VH-Y3ME', 0, '', 5000, '2020-03-06 15:22:17', ''),
(8, 'Y7R2-C5-95M6', 0, '', 5000, '2020-03-06 15:22:17', ''),
(9, 'KSR5-DP-X7FH', 0, '', 5000, '2020-03-06 15:22:17', ''),
(10, 'Z65Q-SN-RMZJ', 0, '', 5000, '2020-03-06 15:22:17', ''),
(11, 'Z4LJ-AP-VLM8', 0, '', 5000, '2020-03-06 15:22:17', ''),
(12, '7SDT-9Q-PJ6P', 0, '', 5000, '2020-03-06 15:22:17', ''),
(13, 'B63A-J3-W3WU', 0, '', 5000, '2020-03-06 15:22:17', ''),
(14, 'BJZZ-H6-3H3W', 0, '', 5000, '2020-03-06 15:22:17', ''),
(15, 'FFS4-1L-CX5D', 0, '', 5000, '2020-03-06 15:22:17', ''),
(16, 'SG31-1V-QEYG', 0, '', 5000, '2020-03-06 15:22:17', ''),
(17, 'DD14-3X-WXKE', 0, '', 5000, '2020-03-06 15:22:17', ''),
(18, 'N27N-RP-YD7D', 0, '', 5000, '2020-03-06 15:22:17', ''),
(19, 'EEX7-5P-AP6M', 0, '', 5000, '2020-03-06 15:22:17', ''),
(20, '4JE2-NW-79L2', 0, '', 5000, '2020-03-06 15:22:17', ''),
(21, 'D92J-DH-B3RT', 0, '', 5000, '2020-03-06 15:22:17', ''),
(22, '3A5X-6C-DYQN', 0, '', 5000, '2020-03-06 15:22:17', ''),
(23, 'X542-N1-W7NP', 0, '', 5000, '2020-03-06 15:22:17', ''),
(24, '3GZU-HV-HV13', 0, '', 5000, '2020-03-06 15:22:17', ''),
(25, '678X-WL-7NWX', 0, '', 5000, '2020-03-06 15:22:17', ''),
(26, 'QSXA-Y6-W9XY', 0, '', 5000, '2020-03-06 15:22:17', ''),
(27, '29V1-DL-MFFC', 0, '', 5000, '2020-03-06 15:22:17', ''),
(28, 'U8M3-Y7-QWHU', 0, '', 5000, '2020-03-06 15:22:17', ''),
(29, '2ERL-Q5-RLVZ', 0, '', 5000, '2020-03-06 15:22:17', ''),
(30, 'Y13S-CJ-FZXH', 0, '', 5000, '2020-03-06 15:22:17', ''),
(31, 'P8K7-S9-MJCW', 0, '', 5000, '2020-03-06 15:22:17', ''),
(32, '2EH6-9W-77JW', 0, '', 5000, '2020-03-06 15:22:17', ''),
(33, 'HJCS-AU-XVDT', 0, '', 5000, '2020-03-06 15:22:17', ''),
(34, '7ZAA-9R-QRMT', 0, '', 5000, '2020-03-06 15:22:17', ''),
(35, 'N1DB-FR-8J8Y', 0, '', 5000, '2020-03-06 15:22:17', ''),
(36, 'A7GF-SQ-ANSB', 0, '', 5000, '2020-03-06 15:22:17', ''),
(37, 'WPB7-7F-W737', 0, '', 5000, '2020-03-06 15:22:17', ''),
(38, 'YRV8-DT-RQGR', 0, '', 5000, '2020-03-06 15:22:17', ''),
(39, 'Y8EM-QC-8HUX', 0, '', 5000, '2020-03-06 15:22:17', ''),
(40, 'Y34S-QJ-MSSG', 0, '', 5000, '2020-03-06 15:22:17', ''),
(41, '8VYW-QQ-TML5', 0, '', 5000, '2020-03-06 15:22:17', ''),
(42, 'E7FK-AA-ARJE', 0, '', 5000, '2020-03-06 15:22:17', ''),
(43, '11EA-4S-43L6', 0, '', 5000, '2020-03-06 15:22:17', ''),
(44, '1FUQ-CE-A3DQ', 0, '', 5000, '2020-03-06 15:22:17', ''),
(45, 'P73X-UX-FCHT', 0, '', 5000, '2020-03-06 15:22:17', ''),
(46, 'U42T-XX-QYLR', 0, '', 5000, '2020-03-06 15:22:17', ''),
(47, 'XRNA-M8-N4AV', 0, '', 5000, '2020-03-06 15:22:17', ''),
(48, 'D66B-WF-ZKX3', 0, '', 5000, '2020-03-06 15:22:17', ''),
(49, 'CZCB-3R-AYAJ', 1, 'admin', 5000, '2020-03-06 15:22:17', '2020-03-06 15:29:35'),
(50, 'EJX1-H7-FNVA', 1, 'admin', 5000, '2020-03-06 15:22:17', '2020-03-06 15:22:25'),
(51, 'DZWJ-JZ-VEZB', 1, 'admin', 1, '2020-03-06 15:31:03', '2020-03-06 15:31:11'),
(52, '81YP-EL-ZFRY', 0, '', 1, '2020-03-06 15:31:03', ''),
(53, 'XRWD-LA-L9TB', 0, '', 1, '2020-03-06 15:31:03', ''),
(54, 'JVR7-R5-RNXJ', 0, '', 1, '2020-03-06 15:31:03', ''),
(55, 'LEYR-B4-QNJ7', 1, 'admin', 1, '2020-03-06 15:31:03', '2020-03-06 15:44:15'),
(56, 'ZXYX-DQ-ST7W', 0, '', 1, '2020-03-06 17:25:31', '');

-- --------------------------------------------------------

--
-- Table structure for table `g5_shop_default`
--

CREATE TABLE IF NOT EXISTS `g5_shop_default` (
  `de_admin_company_owner` varchar(255) NOT NULL default '',
  `de_admin_company_name` varchar(255) NOT NULL default '',
  `de_admin_company_saupja_no` varchar(255) NOT NULL default '',
  `de_admin_company_tel` varchar(255) NOT NULL default '',
  `de_admin_company_fax` varchar(255) NOT NULL default '',
  `de_admin_tongsin_no` varchar(255) NOT NULL default '',
  `de_admin_company_zip` varchar(255) NOT NULL default '',
  `de_admin_company_addr` varchar(255) NOT NULL default '',
  `de_admin_info_name` varchar(255) NOT NULL default '',
  `de_admin_info_email` varchar(255) NOT NULL default '',
  `de_shop_skin` varchar(255) NOT NULL default '',
  `de_shop_mobile_skin` varchar(255) NOT NULL default '',
  `de_type1_list_use` tinyint(4) NOT NULL default '0',
  `de_type1_list_skin` varchar(255) NOT NULL default '',
  `de_type1_list_mod` int(11) NOT NULL default '0',
  `de_type1_list_row` int(11) NOT NULL default '0',
  `de_type1_img_width` int(11) NOT NULL default '0',
  `de_type1_img_height` int(11) NOT NULL default '0',
  `de_type2_list_use` tinyint(4) NOT NULL default '0',
  `de_type2_list_skin` varchar(255) NOT NULL default '',
  `de_type2_list_mod` int(11) NOT NULL default '0',
  `de_type2_list_row` int(11) NOT NULL default '0',
  `de_type2_img_width` int(11) NOT NULL default '0',
  `de_type2_img_height` int(11) NOT NULL default '0',
  `de_type3_list_use` tinyint(4) NOT NULL default '0',
  `de_type3_list_skin` varchar(255) NOT NULL default '',
  `de_type3_list_mod` int(11) NOT NULL default '0',
  `de_type3_list_row` int(11) NOT NULL default '0',
  `de_type3_img_width` int(11) NOT NULL default '0',
  `de_type3_img_height` int(11) NOT NULL default '0',
  `de_type4_list_use` tinyint(4) NOT NULL default '0',
  `de_type4_list_skin` varchar(255) NOT NULL default '',
  `de_type4_list_mod` int(11) NOT NULL default '0',
  `de_type4_list_row` int(11) NOT NULL default '0',
  `de_type4_img_width` int(11) NOT NULL default '0',
  `de_type4_img_height` int(11) NOT NULL default '0',
  `de_type5_list_use` tinyint(4) NOT NULL default '0',
  `de_type5_list_skin` varchar(255) NOT NULL default '',
  `de_type5_list_mod` int(11) NOT NULL default '0',
  `de_type5_list_row` int(11) NOT NULL default '0',
  `de_type5_img_width` int(11) NOT NULL default '0',
  `de_type5_img_height` int(11) NOT NULL default '0',
  `de_mobile_type1_list_use` tinyint(4) NOT NULL default '0',
  `de_mobile_type1_list_skin` varchar(255) NOT NULL default '',
  `de_mobile_type1_list_mod` int(11) NOT NULL default '0',
  `de_mobile_type1_list_row` int(11) NOT NULL default '0',
  `de_mobile_type1_img_width` int(11) NOT NULL default '0',
  `de_mobile_type1_img_height` int(11) NOT NULL default '0',
  `de_mobile_type2_list_use` tinyint(4) NOT NULL default '0',
  `de_mobile_type2_list_skin` varchar(255) NOT NULL default '',
  `de_mobile_type2_list_mod` int(11) NOT NULL default '0',
  `de_mobile_type2_list_row` int(11) NOT NULL default '0',
  `de_mobile_type2_img_width` int(11) NOT NULL default '0',
  `de_mobile_type2_img_height` int(11) NOT NULL default '0',
  `de_mobile_type3_list_use` tinyint(4) NOT NULL default '0',
  `de_mobile_type3_list_skin` varchar(255) NOT NULL default '',
  `de_mobile_type3_list_mod` int(11) NOT NULL default '0',
  `de_mobile_type3_list_row` int(11) NOT NULL default '0',
  `de_mobile_type3_img_width` int(11) NOT NULL default '0',
  `de_mobile_type3_img_height` int(11) NOT NULL default '0',
  `de_mobile_type4_list_use` tinyint(4) NOT NULL default '0',
  `de_mobile_type4_list_skin` varchar(255) NOT NULL default '',
  `de_mobile_type4_list_mod` int(11) NOT NULL default '0',
  `de_mobile_type4_list_row` int(11) NOT NULL default '0',
  `de_mobile_type4_img_width` int(11) NOT NULL default '0',
  `de_mobile_type4_img_height` int(11) NOT NULL default '0',
  `de_mobile_type5_list_use` tinyint(4) NOT NULL default '0',
  `de_mobile_type5_list_skin` varchar(255) NOT NULL default '',
  `de_mobile_type5_list_mod` int(11) NOT NULL default '0',
  `de_mobile_type5_list_row` int(11) NOT NULL default '0',
  `de_mobile_type5_img_width` int(11) NOT NULL default '0',
  `de_mobile_type5_img_height` int(11) NOT NULL default '0',
  `de_rel_list_use` tinyint(4) NOT NULL default '0',
  `de_rel_list_skin` varchar(255) NOT NULL default '',
  `de_rel_list_mod` int(11) NOT NULL default '0',
  `de_rel_img_width` int(11) NOT NULL default '0',
  `de_rel_img_height` int(11) NOT NULL default '0',
  `de_mobile_rel_list_use` tinyint(4) NOT NULL default '0',
  `de_mobile_rel_list_skin` varchar(255) NOT NULL default '',
  `de_mobile_rel_list_mod` int(11) NOT NULL default '0',
  `de_mobile_rel_img_width` int(11) NOT NULL default '0',
  `de_mobile_rel_img_height` int(11) NOT NULL default '0',
  `de_search_list_skin` varchar(255) NOT NULL default '',
  `de_search_list_mod` int(11) NOT NULL default '0',
  `de_search_list_row` int(11) NOT NULL default '0',
  `de_search_img_width` int(11) NOT NULL default '0',
  `de_search_img_height` int(11) NOT NULL default '0',
  `de_mobile_search_list_skin` varchar(255) NOT NULL default '',
  `de_mobile_search_list_mod` int(11) NOT NULL default '0',
  `de_mobile_search_list_row` int(11) NOT NULL default '0',
  `de_mobile_search_img_width` int(11) NOT NULL default '0',
  `de_mobile_search_img_height` int(11) NOT NULL default '0',
  `de_listtype_list_skin` varchar(255) NOT NULL default '',
  `de_listtype_list_mod` int(11) NOT NULL default '0',
  `de_listtype_list_row` int(11) NOT NULL default '0',
  `de_listtype_img_width` int(11) NOT NULL default '0',
  `de_listtype_img_height` int(11) NOT NULL default '0',
  `de_mobile_listtype_list_skin` varchar(255) NOT NULL default '',
  `de_mobile_listtype_list_mod` int(11) NOT NULL default '0',
  `de_mobile_listtype_list_row` int(11) NOT NULL default '0',
  `de_mobile_listtype_img_width` int(11) NOT NULL default '0',
  `de_mobile_listtype_img_height` int(11) NOT NULL default '0',
  `de_bank_use` int(11) NOT NULL default '0',
  `de_bank_account` text NOT NULL,
  `de_card_test` int(11) NOT NULL default '0',
  `de_card_use` int(11) NOT NULL default '0',
  `de_card_noint_use` tinyint(4) NOT NULL default '0',
  `de_card_point` int(11) NOT NULL default '0',
  `de_settle_min_point` int(11) NOT NULL default '0',
  `de_settle_max_point` int(11) NOT NULL default '0',
  `de_settle_point_unit` int(11) NOT NULL default '0',
  `de_level_sell` int(11) NOT NULL default '0',
  `de_delivery_company` varchar(255) NOT NULL default '',
  `de_send_cost_case` varchar(255) NOT NULL default '',
  `de_send_cost_limit` varchar(255) NOT NULL default '',
  `de_send_cost_list` varchar(255) NOT NULL default '',
  `de_hope_date_use` int(11) NOT NULL default '0',
  `de_hope_date_after` int(11) NOT NULL default '0',
  `de_baesong_content` text NOT NULL,
  `de_change_content` text NOT NULL,
  `de_point_days` int(11) NOT NULL default '0',
  `de_simg_width` int(11) NOT NULL default '0',
  `de_simg_height` int(11) NOT NULL default '0',
  `de_mimg_width` int(11) NOT NULL default '0',
  `de_mimg_height` int(11) NOT NULL default '0',
  `de_sms_cont1` text NOT NULL,
  `de_sms_cont2` text NOT NULL,
  `de_sms_cont3` text NOT NULL,
  `de_sms_cont4` text NOT NULL,
  `de_sms_cont5` text NOT NULL,
  `de_sms_use1` tinyint(4) NOT NULL default '0',
  `de_sms_use2` tinyint(4) NOT NULL default '0',
  `de_sms_use3` tinyint(4) NOT NULL default '0',
  `de_sms_use4` tinyint(4) NOT NULL default '0',
  `de_sms_use5` tinyint(4) NOT NULL default '0',
  `de_sms_hp` varchar(255) NOT NULL default '',
  `de_pg_service` varchar(255) NOT NULL default '',
  `de_kcp_mid` varchar(255) NOT NULL default '',
  `de_kcp_site_key` varchar(255) NOT NULL default '',
  `de_inicis_mid` varchar(255) NOT NULL default '',
  `de_inicis_admin_key` varchar(255) NOT NULL default '',
  `de_inicis_sign_key` varchar(255) NOT NULL default '',
  `de_iche_use` tinyint(4) NOT NULL default '0',
  `de_easy_pay_use` tinyint(4) NOT NULL default '0',
  `de_samsung_pay_use` tinyint(4) NOT NULL default '0',
  `de_inicis_lpay_use` tinyint(4) NOT NULL default '0',
  `de_inicis_cartpoint_use` tinyint(4) NOT NULL default '0',
  `de_item_use_use` tinyint(4) NOT NULL default '0',
  `de_item_use_write` tinyint(4) NOT NULL default '0',
  `de_code_dup_use` tinyint(4) NOT NULL default '0',
  `de_cart_keep_term` int(11) NOT NULL default '0',
  `de_guest_cart_use` tinyint(4) NOT NULL default '0',
  `de_admin_buga_no` varchar(255) NOT NULL default '',
  `de_vbank_use` varchar(255) NOT NULL default '',
  `de_taxsave_use` tinyint(4) NOT NULL,
  `de_taxsave_types` set('account','vbank','transfer') NOT NULL default 'account',
  `de_guest_privacy` text NOT NULL,
  `de_hp_use` tinyint(4) NOT NULL default '0',
  `de_escrow_use` tinyint(4) NOT NULL default '0',
  `de_tax_flag_use` tinyint(4) NOT NULL default '0',
  `de_kakaopay_mid` varchar(255) NOT NULL default '',
  `de_kakaopay_key` varchar(255) NOT NULL default '',
  `de_kakaopay_enckey` varchar(255) NOT NULL default '',
  `de_kakaopay_hashkey` varchar(255) NOT NULL default '',
  `de_kakaopay_cancelpwd` varchar(255) NOT NULL default '',
  `de_naverpay_mid` varchar(255) NOT NULL default '',
  `de_naverpay_cert_key` varchar(255) NOT NULL default '',
  `de_naverpay_button_key` varchar(255) NOT NULL default '',
  `de_naverpay_test` tinyint(4) NOT NULL default '0',
  `de_naverpay_mb_id` varchar(255) NOT NULL default '',
  `de_naverpay_sendcost` varchar(255) NOT NULL default '',
  `de_member_reg_coupon_use` tinyint(4) NOT NULL default '0',
  `de_member_reg_coupon_term` int(11) NOT NULL default '0',
  `de_member_reg_coupon_price` int(11) NOT NULL default '0',
  `de_member_reg_coupon_minimum` int(11) NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `g5_shop_default`
--

INSERT INTO `g5_shop_default` (`de_admin_company_owner`, `de_admin_company_name`, `de_admin_company_saupja_no`, `de_admin_company_tel`, `de_admin_company_fax`, `de_admin_tongsin_no`, `de_admin_company_zip`, `de_admin_company_addr`, `de_admin_info_name`, `de_admin_info_email`, `de_shop_skin`, `de_shop_mobile_skin`, `de_type1_list_use`, `de_type1_list_skin`, `de_type1_list_mod`, `de_type1_list_row`, `de_type1_img_width`, `de_type1_img_height`, `de_type2_list_use`, `de_type2_list_skin`, `de_type2_list_mod`, `de_type2_list_row`, `de_type2_img_width`, `de_type2_img_height`, `de_type3_list_use`, `de_type3_list_skin`, `de_type3_list_mod`, `de_type3_list_row`, `de_type3_img_width`, `de_type3_img_height`, `de_type4_list_use`, `de_type4_list_skin`, `de_type4_list_mod`, `de_type4_list_row`, `de_type4_img_width`, `de_type4_img_height`, `de_type5_list_use`, `de_type5_list_skin`, `de_type5_list_mod`, `de_type5_list_row`, `de_type5_img_width`, `de_type5_img_height`, `de_mobile_type1_list_use`, `de_mobile_type1_list_skin`, `de_mobile_type1_list_mod`, `de_mobile_type1_list_row`, `de_mobile_type1_img_width`, `de_mobile_type1_img_height`, `de_mobile_type2_list_use`, `de_mobile_type2_list_skin`, `de_mobile_type2_list_mod`, `de_mobile_type2_list_row`, `de_mobile_type2_img_width`, `de_mobile_type2_img_height`, `de_mobile_type3_list_use`, `de_mobile_type3_list_skin`, `de_mobile_type3_list_mod`, `de_mobile_type3_list_row`, `de_mobile_type3_img_width`, `de_mobile_type3_img_height`, `de_mobile_type4_list_use`, `de_mobile_type4_list_skin`, `de_mobile_type4_list_mod`, `de_mobile_type4_list_row`, `de_mobile_type4_img_width`, `de_mobile_type4_img_height`, `de_mobile_type5_list_use`, `de_mobile_type5_list_skin`, `de_mobile_type5_list_mod`, `de_mobile_type5_list_row`, `de_mobile_type5_img_width`, `de_mobile_type5_img_height`, `de_rel_list_use`, `de_rel_list_skin`, `de_rel_list_mod`, `de_rel_img_width`, `de_rel_img_height`, `de_mobile_rel_list_use`, `de_mobile_rel_list_skin`, `de_mobile_rel_list_mod`, `de_mobile_rel_img_width`, `de_mobile_rel_img_height`, `de_search_list_skin`, `de_search_list_mod`, `de_search_list_row`, `de_search_img_width`, `de_search_img_height`, `de_mobile_search_list_skin`, `de_mobile_search_list_mod`, `de_mobile_search_list_row`, `de_mobile_search_img_width`, `de_mobile_search_img_height`, `de_listtype_list_skin`, `de_listtype_list_mod`, `de_listtype_list_row`, `de_listtype_img_width`, `de_listtype_img_height`, `de_mobile_listtype_list_skin`, `de_mobile_listtype_list_mod`, `de_mobile_listtype_list_row`, `de_mobile_listtype_img_width`, `de_mobile_listtype_img_height`, `de_bank_use`, `de_bank_account`, `de_card_test`, `de_card_use`, `de_card_noint_use`, `de_card_point`, `de_settle_min_point`, `de_settle_max_point`, `de_settle_point_unit`, `de_level_sell`, `de_delivery_company`, `de_send_cost_case`, `de_send_cost_limit`, `de_send_cost_list`, `de_hope_date_use`, `de_hope_date_after`, `de_baesong_content`, `de_change_content`, `de_point_days`, `de_simg_width`, `de_simg_height`, `de_mimg_width`, `de_mimg_height`, `de_sms_cont1`, `de_sms_cont2`, `de_sms_cont3`, `de_sms_cont4`, `de_sms_cont5`, `de_sms_use1`, `de_sms_use2`, `de_sms_use3`, `de_sms_use4`, `de_sms_use5`, `de_sms_hp`, `de_pg_service`, `de_kcp_mid`, `de_kcp_site_key`, `de_inicis_mid`, `de_inicis_admin_key`, `de_inicis_sign_key`, `de_iche_use`, `de_easy_pay_use`, `de_samsung_pay_use`, `de_inicis_lpay_use`, `de_inicis_cartpoint_use`, `de_item_use_use`, `de_item_use_write`, `de_code_dup_use`, `de_cart_keep_term`, `de_guest_cart_use`, `de_admin_buga_no`, `de_vbank_use`, `de_taxsave_use`, `de_taxsave_types`, `de_guest_privacy`, `de_hp_use`, `de_escrow_use`, `de_tax_flag_use`, `de_kakaopay_mid`, `de_kakaopay_key`, `de_kakaopay_enckey`, `de_kakaopay_hashkey`, `de_kakaopay_cancelpwd`, `de_naverpay_mid`, `de_naverpay_cert_key`, `de_naverpay_button_key`, `de_naverpay_test`, `de_naverpay_mb_id`, `de_naverpay_sendcost`, `de_member_reg_coupon_use`, `de_member_reg_coupon_term`, `de_member_reg_coupon_price`, `de_member_reg_coupon_minimum`) VALUES
('대표자명', '회사명', '123-45-67890', '02-123-4567', '02-123-4568', '제 OO구 - 123호', '123-456', 'OO도 OO시 OO구 OO동 123-45', '정보책임자명', '정보책임자 E-mail', 'theme/basic', 'theme/basic', 0, 'main.10.skin.php', 5, 1, 160, 160, 0, 'main.20.skin.php', 4, 1, 215, 215, 0, 'main.40.skin.php', 4, 1, 215, 215, 0, 'main.50.skin.php', 5, 1, 215, 215, 0, 'main.30.skin.php', 4, 1, 215, 215, 0, 'main.30.skin.php', 1, 4, 230, 230, 0, 'main.10.skin.php', 1, 2, 230, 230, 0, 'main.10.skin.php', 2, 4, 300, 300, 0, 'main.20.skin.php', 1, 2, 80, 80, 0, 'main.10.skin.php', 1, 2, 230, 230, 0, 'relation.10.skin.php', 5, 215, 215, 0, 'relation.10.skin.php', 1, 230, 230, 'list.10.skin.php', 5, 5, 225, 225, 'list.10.skin.php', 2, 5, 230, 230, 'list.10.skin.php', 5, 5, 225, 225, 'list.10.skin.php', 2, 5, 500, 500, 1, 'OO은행 12345-67-89012 예금주명', 0, 0, 0, 1, 5000, 50000, 100, 2, '', '차등', '20000;30000;40000', '4000;3000;2000', 0, 3, '배송 안내 입력전입니다.', '교환/반품 안내 입력전입니다.', 0, 500, 500, 300, 300, '{이름}님의 회원가입을 축하드립니다.\r\nID:{회원아이디}\r\n{회사명}', '{이름}님 주문해주셔서 고맙습니다.\r\n{주문번호}\r\n{주문금액}원\r\n{회사명}', '{이름}님께서 주문하셨습니다.\r\n{주문번호}\r\n{주문금액}원\r\n{회사명}', '{이름}님 입금 감사합니다.\r\n{입금액}원\r\n주문번호:\r\n{주문번호}\r\n{회사명}', '{이름}님 배송합니다.\r\n택배:{택배회사}\r\n운송장번호:\r\n{운송장번호}\r\n{회사명}', 0, 0, 0, 0, 0, '', 'kcp', '', '', '', '', '', 0, 0, 0, 0, 0, 1, 0, 1, 15, 0, '12345호', '0', 0, 'account', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, '', '', 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `g5_shop_event`
--

CREATE TABLE IF NOT EXISTS `g5_shop_event` (
  `ev_id` int(11) NOT NULL auto_increment,
  `ev_skin` varchar(255) NOT NULL default '',
  `ev_mobile_skin` varchar(255) NOT NULL default '',
  `ev_img_width` int(11) NOT NULL default '0',
  `ev_img_height` int(11) NOT NULL default '0',
  `ev_list_mod` int(11) NOT NULL default '0',
  `ev_list_row` int(11) NOT NULL default '0',
  `ev_mobile_img_width` int(11) NOT NULL default '0',
  `ev_mobile_img_height` int(11) NOT NULL default '0',
  `ev_mobile_list_mod` int(11) NOT NULL default '0',
  `ev_mobile_list_row` int(11) NOT NULL default '0',
  `ev_subject` varchar(255) NOT NULL default '',
  `ev_subject_strong` tinyint(4) NOT NULL default '0',
  `ev_head_html` text NOT NULL,
  `ev_tail_html` text NOT NULL,
  `ev_use` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`ev_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1583119630 ;

--
-- Dumping data for table `g5_shop_event`
--

INSERT INTO `g5_shop_event` (`ev_id`, `ev_skin`, `ev_mobile_skin`, `ev_img_width`, `ev_img_height`, `ev_list_mod`, `ev_list_row`, `ev_mobile_img_width`, `ev_mobile_img_height`, `ev_mobile_list_mod`, `ev_mobile_list_row`, `ev_subject`, `ev_subject_strong`, `ev_head_html`, `ev_tail_html`, `ev_use`) VALUES
(1583119629, 'list.10.skin.php', 'list.10.skin.php', 230, 230, 3, 5, 230, 230, 3, 5, 'ㅅㄷㄴㅅ', 0, '', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `g5_shop_event_item`
--

CREATE TABLE IF NOT EXISTS `g5_shop_event_item` (
  `ev_id` int(11) NOT NULL default '0',
  `it_id` varchar(20) NOT NULL default '',
  PRIMARY KEY  (`ev_id`,`it_id`),
  KEY `it_id` (`it_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `g5_shop_inicis_log`
--

CREATE TABLE IF NOT EXISTS `g5_shop_inicis_log` (
  `oid` bigint(20) unsigned NOT NULL,
  `P_TID` varchar(255) NOT NULL default '',
  `P_MID` varchar(255) NOT NULL default '',
  `P_AUTH_DT` varchar(255) NOT NULL default '',
  `P_STATUS` varchar(255) NOT NULL default '',
  `P_TYPE` varchar(255) NOT NULL default '',
  `P_OID` varchar(255) NOT NULL default '',
  `P_FN_NM` varchar(255) NOT NULL default '',
  `P_AUTH_NO` varchar(255) NOT NULL default '',
  `P_AMT` int(11) NOT NULL default '0',
  `P_RMESG1` varchar(255) NOT NULL default '',
  `post_data` text NOT NULL,
  `is_mail_send` tinyint(4) NOT NULL default '1',
  PRIMARY KEY  (`oid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `g5_shop_item`
--

CREATE TABLE IF NOT EXISTS `g5_shop_item` (
  `it_id` varchar(20) NOT NULL default '',
  `ca_id` varchar(10) NOT NULL default '0',
  `ca_id2` varchar(255) NOT NULL default '',
  `ca_id3` varchar(255) NOT NULL default '',
  `it_skin` varchar(255) NOT NULL default '',
  `it_mobile_skin` varchar(255) NOT NULL default '',
  `it_name` varchar(255) NOT NULL default '',
  `it_seo_title` varchar(200) NOT NULL default '',
  `it_maker` varchar(255) NOT NULL default '',
  `it_origin` varchar(255) NOT NULL default '',
  `it_brand` varchar(255) NOT NULL default '',
  `it_model` varchar(255) NOT NULL default '',
  `it_option_subject` varchar(255) NOT NULL default '',
  `it_supply_subject` varchar(255) NOT NULL default '',
  `it_type1` tinyint(4) NOT NULL default '0',
  `it_type2` tinyint(4) NOT NULL default '0',
  `it_type3` tinyint(4) NOT NULL default '0',
  `it_type4` tinyint(4) NOT NULL default '0',
  `it_type5` tinyint(4) NOT NULL default '0',
  `it_basic` text NOT NULL,
  `it_explan` mediumtext NOT NULL,
  `it_explan2` mediumtext NOT NULL,
  `it_mobile_explan` mediumtext NOT NULL,
  `it_cust_price` int(11) NOT NULL default '0',
  `it_price` int(11) NOT NULL default '0',
  `it_point` int(11) NOT NULL default '0',
  `it_point_type` tinyint(4) NOT NULL default '0',
  `it_supply_point` int(11) NOT NULL default '0',
  `it_notax` tinyint(4) NOT NULL default '0',
  `it_sell_email` varchar(255) NOT NULL default '',
  `it_use` tinyint(4) NOT NULL default '0',
  `it_nocoupon` tinyint(4) NOT NULL default '0',
  `it_soldout` tinyint(4) NOT NULL default '0',
  `it_stock_qty` int(11) NOT NULL default '0',
  `it_stock_sms` tinyint(4) NOT NULL default '0',
  `it_noti_qty` int(11) NOT NULL default '0',
  `it_sc_type` tinyint(4) NOT NULL default '0',
  `it_sc_method` tinyint(4) NOT NULL default '0',
  `it_sc_price` int(11) NOT NULL default '0',
  `it_sc_minimum` int(11) NOT NULL default '0',
  `it_sc_qty` int(11) NOT NULL default '0',
  `it_buy_min_qty` int(11) NOT NULL default '0',
  `it_buy_max_qty` int(11) NOT NULL default '0',
  `it_head_html` text NOT NULL,
  `it_tail_html` text NOT NULL,
  `it_mobile_head_html` text NOT NULL,
  `it_mobile_tail_html` text NOT NULL,
  `it_hit` int(11) NOT NULL default '0',
  `it_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `it_update_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `it_ip` varchar(25) NOT NULL default '',
  `it_order` int(11) NOT NULL default '0',
  `it_tel_inq` tinyint(4) NOT NULL default '0',
  `it_info_gubun` varchar(50) NOT NULL default '',
  `it_info_value` text NOT NULL,
  `it_sum_qty` int(11) NOT NULL default '0',
  `it_use_cnt` int(11) NOT NULL default '0',
  `it_use_avg` decimal(2,1) NOT NULL,
  `it_shop_memo` text NOT NULL,
  `ec_mall_pid` varchar(255) NOT NULL default '',
  `it_img1` varchar(255) NOT NULL default '',
  `it_img2` varchar(255) NOT NULL default '',
  `it_img3` varchar(255) NOT NULL default '',
  `it_img4` varchar(255) NOT NULL default '',
  `it_img5` varchar(255) NOT NULL default '',
  `it_img6` varchar(255) NOT NULL default '',
  `it_img7` varchar(255) NOT NULL default '',
  `it_img8` varchar(255) NOT NULL default '',
  `it_img9` varchar(255) NOT NULL default '',
  `it_img10` varchar(255) NOT NULL default '',
  `it_1_subj` varchar(255) NOT NULL default '',
  `it_2_subj` varchar(255) NOT NULL default '',
  `it_3_subj` varchar(255) NOT NULL default '',
  `it_4_subj` varchar(255) NOT NULL default '',
  `it_5_subj` varchar(255) NOT NULL default '',
  `it_6_subj` varchar(255) NOT NULL default '',
  `it_7_subj` varchar(255) NOT NULL default '',
  `it_8_subj` varchar(255) NOT NULL default '',
  `it_9_subj` varchar(255) NOT NULL default '',
  `it_10_subj` varchar(255) NOT NULL default '',
  `it_1` varchar(255) NOT NULL default '',
  `it_2` varchar(255) NOT NULL default '',
  `it_3` varchar(255) NOT NULL default '',
  `it_4` varchar(255) NOT NULL default '',
  `it_5` varchar(255) NOT NULL default '',
  `it_6` varchar(255) NOT NULL default '',
  `it_7` varchar(255) NOT NULL default '',
  `it_8` varchar(255) NOT NULL default '',
  `it_9` varchar(255) NOT NULL default '',
  `it_10` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`it_id`),
  KEY `ca_id` (`ca_id`),
  KEY `it_name` (`it_name`),
  KEY `it_seo_title` (`it_seo_title`),
  KEY `it_order` (`it_order`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `g5_shop_item`
--

INSERT INTO `g5_shop_item` (`it_id`, `ca_id`, `ca_id2`, `ca_id3`, `it_skin`, `it_mobile_skin`, `it_name`, `it_seo_title`, `it_maker`, `it_origin`, `it_brand`, `it_model`, `it_option_subject`, `it_supply_subject`, `it_type1`, `it_type2`, `it_type3`, `it_type4`, `it_type5`, `it_basic`, `it_explan`, `it_explan2`, `it_mobile_explan`, `it_cust_price`, `it_price`, `it_point`, `it_point_type`, `it_supply_point`, `it_notax`, `it_sell_email`, `it_use`, `it_nocoupon`, `it_soldout`, `it_stock_qty`, `it_stock_sms`, `it_noti_qty`, `it_sc_type`, `it_sc_method`, `it_sc_price`, `it_sc_minimum`, `it_sc_qty`, `it_buy_min_qty`, `it_buy_max_qty`, `it_head_html`, `it_tail_html`, `it_mobile_head_html`, `it_mobile_tail_html`, `it_hit`, `it_time`, `it_update_time`, `it_ip`, `it_order`, `it_tel_inq`, `it_info_gubun`, `it_info_value`, `it_sum_qty`, `it_use_cnt`, `it_use_avg`, `it_shop_memo`, `ec_mall_pid`, `it_img1`, `it_img2`, `it_img3`, `it_img4`, `it_img5`, `it_img6`, `it_img7`, `it_img8`, `it_img9`, `it_img10`, `it_1_subj`, `it_2_subj`, `it_3_subj`, `it_4_subj`, `it_5_subj`, `it_6_subj`, `it_7_subj`, `it_8_subj`, `it_9_subj`, `it_10_subj`, `it_1`, `it_2`, `it_3`, `it_4`, `it_5`, `it_6`, `it_7`, `it_8`, `it_9`, `it_10`) VALUES
('1583147875', '10', '', '', 'theme/basic', 'theme/basic', 'test', 'test', '', '', '', '', '', '', 0, 0, 0, 0, 0, 'test', '<p>test</p>', 'test', '<p>testtest</p>', 10000, 10000, 1000, 0, 0, 0, '', 1, 0, 0, 99993, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', 4, '2020-03-02 20:18:47', '2020-03-02 20:18:47', '14.6.171.34', 0, 0, 'wear', 'a:8:{s:8:"material";s:22:"상품페이지 참고";s:5:"color";s:22:"상품페이지 참고";s:4:"size";s:22:"상품페이지 참고";s:5:"maker";s:22:"상품페이지 참고";s:7:"caution";s:22:"상품페이지 참고";s:16:"manufacturing_ym";s:22:"상품페이지 참고";s:8:"warranty";s:22:"상품페이지 참고";s:2:"as";s:22:"상품페이지 참고";}', 6, 0, 0.0, '', '', '1583147875/a1.jpg', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('1583150102', '10', '', '', '', '', '상품명', '상품명', '', '', '', '', '', '', 0, 0, 0, 0, 0, '기본설명', '<p style="margin-left:40px;">ㅁㄴㅇㄹㅁㅁㅇ</p>', 'ㅁㄴㅇㄹㅁㅁㅇ', '<p>ㅁㄴㅇㄹㅁㄴㅇㄹ</p>', 0, 0, 800, 0, 0, 0, '', 1, 0, 0, 99996, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', 10, '2020-03-02 20:56:00', '2020-03-03 11:48:14', '14.6.171.34', 0, 0, 'wear', 'a:8:{s:8:"material";s:22:"상품페이지 참고";s:5:"color";s:22:"상품페이지 참고";s:4:"size";s:22:"상품페이지 참고";s:5:"maker";s:22:"상품페이지 참고";s:7:"caution";s:22:"상품페이지 참고";s:16:"manufacturing_ym";s:22:"상품페이지 참고";s:8:"warranty";s:22:"상품페이지 참고";s:2:"as";s:22:"상품페이지 참고";}', 3, 0, 0.0, '', '', '1583150102/test.jpg', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('1583297332', '10', '', '', '', '', '쿠폰입니다', '쿠폰입니다', '', '', '', '', '', '', 0, 0, 0, 0, 0, '쿠폰입니다쿠폰입니다쿠폰입니다', '', '', '<p>ㅁㄴㅇㄹㅁㄴㅇㄹ</p>', 50000, 50000, 50000, 0, 0, 0, '', 1, 0, 0, 99997, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', 10, '2020-03-04 13:49:44', '2020-03-04 14:03:27', '14.6.171.34', 0, 0, 'wear', 'a:8:{s:8:"material";s:22:"상품페이지 참고";s:5:"color";s:22:"상품페이지 참고";s:4:"size";s:22:"상품페이지 참고";s:5:"maker";s:22:"상품페이지 참고";s:7:"caution";s:22:"상품페이지 참고";s:16:"manufacturing_ym";s:22:"상품페이지 참고";s:8:"warranty";s:22:"상품페이지 참고";s:2:"as";s:22:"상품페이지 참고";}', 2, 0, 0.0, '', '', '1583297332/unnamed.png', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '1', '', '', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `g5_shop_item_option`
--

CREATE TABLE IF NOT EXISTS `g5_shop_item_option` (
  `io_no` int(11) NOT NULL auto_increment,
  `io_id` varchar(255) NOT NULL default '0',
  `io_type` tinyint(4) NOT NULL default '0',
  `it_id` varchar(20) NOT NULL default '',
  `io_price` int(11) NOT NULL default '0',
  `io_stock_qty` int(11) NOT NULL default '0',
  `io_noti_qty` int(11) NOT NULL default '0',
  `io_use` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`io_no`),
  KEY `io_id` (`io_id`),
  KEY `it_id` (`it_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `g5_shop_item_qa`
--

CREATE TABLE IF NOT EXISTS `g5_shop_item_qa` (
  `iq_id` int(11) NOT NULL auto_increment,
  `it_id` varchar(20) NOT NULL default '',
  `mb_id` varchar(255) NOT NULL default '',
  `iq_secret` tinyint(4) NOT NULL default '0',
  `iq_name` varchar(255) NOT NULL default '',
  `iq_email` varchar(255) NOT NULL default '',
  `iq_hp` varchar(255) NOT NULL default '',
  `iq_password` varchar(255) NOT NULL default '',
  `iq_subject` varchar(255) NOT NULL default '',
  `iq_question` text NOT NULL,
  `iq_answer` text NOT NULL,
  `iq_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `iq_ip` varchar(25) NOT NULL default '',
  PRIMARY KEY  (`iq_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `g5_shop_item_relation`
--

CREATE TABLE IF NOT EXISTS `g5_shop_item_relation` (
  `it_id` varchar(20) NOT NULL default '',
  `it_id2` varchar(20) NOT NULL default '',
  `ir_no` int(11) NOT NULL default '0',
  PRIMARY KEY  (`it_id`,`it_id2`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `g5_shop_item_stocksms`
--

CREATE TABLE IF NOT EXISTS `g5_shop_item_stocksms` (
  `ss_id` int(11) NOT NULL auto_increment,
  `it_id` varchar(20) NOT NULL default '',
  `ss_hp` varchar(255) NOT NULL default '',
  `ss_send` tinyint(4) NOT NULL default '0',
  `ss_send_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `ss_datetime` datetime NOT NULL default '0000-00-00 00:00:00',
  `ss_ip` varchar(25) NOT NULL default '',
  PRIMARY KEY  (`ss_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `g5_shop_item_use`
--

CREATE TABLE IF NOT EXISTS `g5_shop_item_use` (
  `is_id` int(11) NOT NULL auto_increment,
  `it_id` varchar(20) NOT NULL default '0',
  `mb_id` varchar(255) NOT NULL default '',
  `is_name` varchar(255) NOT NULL default '',
  `is_password` varchar(255) NOT NULL default '',
  `is_score` tinyint(4) NOT NULL default '0',
  `is_subject` varchar(255) NOT NULL default '',
  `is_content` text NOT NULL,
  `is_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `is_ip` varchar(25) NOT NULL default '',
  `is_confirm` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`is_id`),
  KEY `index1` (`it_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `g5_shop_order`
--

CREATE TABLE IF NOT EXISTS `g5_shop_order` (
  `od_id` bigint(20) unsigned NOT NULL,
  `mb_id` varchar(255) NOT NULL default '',
  `od_name` varchar(20) NOT NULL default '',
  `od_email` varchar(100) NOT NULL default '',
  `od_tel` varchar(20) NOT NULL default '',
  `od_hp` varchar(20) NOT NULL default '',
  `od_zip1` char(3) NOT NULL default '',
  `od_zip2` char(3) NOT NULL default '',
  `od_addr1` varchar(100) NOT NULL default '',
  `od_addr2` varchar(100) NOT NULL default '',
  `od_addr3` varchar(255) NOT NULL default '',
  `od_addr_jibeon` varchar(255) NOT NULL default '',
  `od_deposit_name` varchar(20) NOT NULL default '',
  `od_b_name` varchar(20) NOT NULL default '',
  `od_b_tel` varchar(20) NOT NULL default '',
  `od_b_hp` varchar(20) NOT NULL default '',
  `od_b_zip1` char(3) NOT NULL default '',
  `od_b_zip2` char(3) NOT NULL default '',
  `od_b_addr1` varchar(100) NOT NULL default '',
  `od_b_addr2` varchar(100) NOT NULL default '',
  `od_b_addr3` varchar(255) NOT NULL default '',
  `od_b_addr_jibeon` varchar(255) NOT NULL default '',
  `od_memo` text NOT NULL,
  `od_cart_count` int(11) NOT NULL default '0',
  `od_cart_price` int(11) NOT NULL default '0',
  `od_cart_coupon` int(11) NOT NULL default '0',
  `od_send_cost` int(11) NOT NULL default '0',
  `od_send_cost2` int(11) NOT NULL default '0',
  `od_send_coupon` int(11) NOT NULL default '0',
  `od_receipt_price` int(11) NOT NULL default '0',
  `od_cancel_price` int(11) NOT NULL default '0',
  `od_receipt_point` int(11) NOT NULL default '0',
  `od_refund_price` int(11) NOT NULL default '0',
  `od_bank_account` varchar(255) NOT NULL default '',
  `od_receipt_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `od_coupon` int(11) NOT NULL default '0',
  `od_misu` int(11) NOT NULL default '0',
  `od_shop_memo` text NOT NULL,
  `od_mod_history` text NOT NULL,
  `od_status` varchar(255) NOT NULL default '',
  `od_hope_date` date NOT NULL default '0000-00-00',
  `od_settle_case` varchar(255) NOT NULL default '',
  `od_test` tinyint(4) NOT NULL default '0',
  `od_mobile` tinyint(4) NOT NULL default '0',
  `od_pg` varchar(255) NOT NULL default '',
  `od_tno` varchar(255) NOT NULL default '',
  `od_app_no` varchar(20) NOT NULL default '',
  `od_escrow` tinyint(4) NOT NULL default '0',
  `od_casseqno` varchar(255) NOT NULL default '',
  `od_tax_flag` tinyint(4) NOT NULL default '0',
  `od_tax_mny` int(11) NOT NULL default '0',
  `od_vat_mny` int(11) NOT NULL default '0',
  `od_free_mny` int(11) NOT NULL default '0',
  `od_delivery_company` varchar(255) NOT NULL default '0',
  `od_invoice` varchar(255) NOT NULL default '',
  `od_invoice_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `od_cash` tinyint(4) NOT NULL,
  `od_cash_no` varchar(255) NOT NULL,
  `od_cash_info` text NOT NULL,
  `od_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `od_pwd` varchar(255) NOT NULL default '',
  `od_ip` varchar(25) NOT NULL default '',
  PRIMARY KEY  (`od_id`),
  KEY `index2` (`mb_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `g5_shop_order`
--

INSERT INTO `g5_shop_order` (`od_id`, `mb_id`, `od_name`, `od_email`, `od_tel`, `od_hp`, `od_zip1`, `od_zip2`, `od_addr1`, `od_addr2`, `od_addr3`, `od_addr_jibeon`, `od_deposit_name`, `od_b_name`, `od_b_tel`, `od_b_hp`, `od_b_zip1`, `od_b_zip2`, `od_b_addr1`, `od_b_addr2`, `od_b_addr3`, `od_b_addr_jibeon`, `od_memo`, `od_cart_count`, `od_cart_price`, `od_cart_coupon`, `od_send_cost`, `od_send_cost2`, `od_send_coupon`, `od_receipt_price`, `od_cancel_price`, `od_receipt_point`, `od_refund_price`, `od_bank_account`, `od_receipt_time`, `od_coupon`, `od_misu`, `od_shop_memo`, `od_mod_history`, `od_status`, `od_hope_date`, `od_settle_case`, `od_test`, `od_mobile`, `od_pg`, `od_tno`, `od_app_no`, `od_escrow`, `od_casseqno`, `od_tax_flag`, `od_tax_mny`, `od_vat_mny`, `od_free_mny`, `od_delivery_company`, `od_invoice`, `od_invoice_time`, `od_cash`, `od_cash_no`, `od_cash_info`, `od_time`, `od_pwd`, `od_ip`) VALUES
(2020030220202009, 'admin', '최고관리자', 'admin@domain.com', '01012341234', '', '061', '12', '서울 강남구 논현로123길 4-1', '123123', ' (논현동)', 'R', '최고관리자', '최고관리자', '01012341234', '', '061', '12', '서울 강남구 논현로123길 4-1', '123123', ' (논현동)', 'R', '', 1, 10000, 0, 4000, 0, 0, 0, 0, 0, 0, 'OO은행 12345-67-89012 예금주명', '0000-00-00 00:00:00', 0, 14000, '', '', '완료', '0000-00-00', '무통장', 1, 0, 'kcp', '', '', 0, '', 0, 12727, 1273, 0, '0', '', '0000-00-00 00:00:00', 0, '', '', '2020-03-02 20:20:53', 'sha256:12000:+Vl7OCXz17IeoQO3lgSo8Ievu54lp9CC:fcYQQFObR+lgl/B+WUkR7LuAHFqeq6l4', '14.6.171.34'),
(2020030220234571, 'admin', '최고관리자', 'admin@domain.com', '123123', '', '061', '12', '서울 강남구 논현로123길 4-1', '123', ' (논현동)', 'R', '최고관리자', '최고관리자', '123123', '', '061', '12', '서울 강남구 논현로123길 4-1', '123', ' (논현동)', 'R', '', 1, 10000, 0, 4000, 0, 0, 0, 0, 0, 0, 'OO은행 12345-67-89012 예금주명', '0000-00-00 00:00:00', 0, 14000, '', '', '완료', '0000-00-00', '무통장', 0, 0, 'kcp', '', '', 0, '', 0, 12727, 1273, 0, '0', '', '0000-00-00 00:00:00', 0, '', '', '2020-03-02 20:24:00', 'sha256:12000:+Vl7OCXz17IeoQO3lgSo8Ievu54lp9CC:fcYQQFObR+lgl/B+WUkR7LuAHFqeq6l4', '14.6.171.34'),
(2020030220245701, 'admin', '최고관리자', 'admin@domain.com', '123', '', '061', '12', '서울 강남구 논현로123길 4-1', '123', ' (논현동)', 'R', '최고관리자', '최고관리자', '123', '', '061', '12', '서울 강남구 논현로123길 4-1', '123', ' (논현동)', 'R', '', 1, 10000, 0, 4000, 0, 0, 0, 0, 0, 0, 'OO은행 12345-67-89012 예금주명', '0000-00-00 00:00:00', 0, 14000, '', '', '완료', '0000-00-00', '무통장', 0, 0, 'kcp', '', '', 0, '', 0, 12727, 1273, 0, '0', '', '0000-00-00 00:00:00', 0, '', '', '2020-03-02 20:25:08', 'sha256:12000:+Vl7OCXz17IeoQO3lgSo8Ievu54lp9CC:fcYQQFObR+lgl/B+WUkR7LuAHFqeq6l4', '14.6.171.34'),
(2020030220280615, 'admin', '최고관리자', 'admin@domain.com', '123', '', '061', '12', '서울 강남구 논현로123길 4-1', '', ' (논현동)', 'R', '최고관리자', '최고관리자', '123', '', '061', '12', '서울 강남구 논현로123길 4-1', '', ' (논현동)', 'R', '', 1, 10000, 0, 4000, 0, 0, 14000, 0, 0, 0, 'OO은행 12345-67-89012 예금주명', '0000-00-00 00:00:00', 0, 0, '', '', '완료', '0000-00-00', '무통장', 0, 0, 'kcp', '', '', 0, '', 0, 12727, 1273, 0, '0', '', '0000-00-00 00:00:00', 0, '', '', '2020-03-02 20:28:20', 'sha256:12000:+Vl7OCXz17IeoQO3lgSo8Ievu54lp9CC:fcYQQFObR+lgl/B+WUkR7LuAHFqeq6l4', '14.6.171.34'),
(2020030220324665, 'admin', '최고관리자', 'admin@domain.com', '123', '', '053', '15', '서울 강동구 양재대로123길 7', '', ' (천호동, 강동그랑시아)', 'R', '최고관리자', '최고관리자', '123', '', '053', '15', '서울 강동구 양재대로123길 7', '', ' (천호동, 강동그랑시아)', 'R', '', 1, 10000, 0, 4000, 0, 0, 0, 0, 0, 0, 'OO은행 12345-67-89012 예금주명', '0000-00-00 00:00:00', 0, 14000, '', '2020-03-04 16:47:27 admin 주문취소 처리\n', '완료', '0000-00-00', '무통장', 0, 0, 'kcp', '', '', 0, '', 0, 12727, 1273, 0, '0', '', '0000-00-00 00:00:00', 0, '', '', '2020-03-02 20:32:56', 'sha256:12000:+Vl7OCXz17IeoQO3lgSo8Ievu54lp9CC:fcYQQFObR+lgl/B+WUkR7LuAHFqeq6l4', '14.6.171.34'),
(2020030220410459, 'admin', '최고관리자', 'admin@domain.com', '123', '', '061', '12', '서울 강남구 논현로123길 4-3', '', ' (논현동)', 'R', '최고관리자', '최고관리자', '123', '', '061', '12', '서울 강남구 논현로123길 4-3', '', ' (논현동)', 'R', '', 1, 10000, 0, 4000, 0, 0, 0, 0, 0, 0, 'OO은행 12345-67-89012 예금주명', '0000-00-00 00:00:00', 0, 14000, '', '2020-03-02 20:42:05 admin 주문반품 처리\n', '완료', '0000-00-00', '무통장', 0, 0, 'kcp', '', '', 0, '', 0, 12727, 1273, 0, '0', '', '0000-00-00 00:00:00', 0, '', '', '2020-03-02 20:41:13', 'sha256:12000:+Vl7OCXz17IeoQO3lgSo8Ievu54lp9CC:fcYQQFObR+lgl/B+WUkR7LuAHFqeq6l4', '14.6.171.34'),
(2020030220581230, 'test', 'cxxx', 'dhdhsh@gmail.cjn', '1245', '', '010', '12', '서울 강북구 4.19로12길 5', 'gg', ' (수유동)', 'R', 'cxxx', 'cxxx', '1245', '', '010', '12', '서울 강북구 4.19로12길 5', 'gg', ' (수유동)', 'R', '', 1, 0, 0, 4000, 0, 0, 0, 0, 0, 0, 'OO은행 12345-67-89012 예금주명', '0000-00-00 00:00:00', 0, 4000, '', '', '주문', '0000-00-00', '무통장', 0, 1, 'kcp', '', '', 0, '', 0, 3636, 364, 0, '0', '', '0000-00-00 00:00:00', 0, '', '', '2020-03-02 20:58:36', 'sha256:12000:tyNP4tIqnYBIV6C7EWg3StXDduRc/H8K:r29CwRIN/R1r0JqA5vdQEs5sRNWlWRnf', '14.6.171.34'),
(2020030414580969, 'admin', '최고관리자', 'admin@domain.com', '', '', '', '', '', '', '', '', '최고관리자', '', '', '', '', '', '', '', '', '', '', 1, 50000, 0, 0, 0, 0, 0, 0, 0, 0, 'OO은행 12345-67-89012 예금주명', '0000-00-00 00:00:00', 0, 50000, '', '', '주문', '0000-00-00', '무통장', 0, 0, 'kcp', '', '', 0, '', 0, 45455, 4545, 0, '0', '', '0000-00-00 00:00:00', 0, '', '', '2020-03-04 14:58:15', 'sha256:12000:+Vl7OCXz17IeoQO3lgSo8Ievu54lp9CC:fcYQQFObR+lgl/B+WUkR7LuAHFqeq6l4', '14.6.171.34'),
(2020030415011874, 'admin', '최고관리자', 'admin@domain.com', '', '', '', '', '', '', '', '', '최고관리자', '', '', '', '', '', '', '', '', '', '', 1, 50000, 0, 0, 0, 0, 0, 0, 0, 0, 'OO은행 12345-67-89012 예금주명', '0000-00-00 00:00:00', 0, 50000, '', '', '주문', '0000-00-00', '무통장', 0, 0, 'kcp', '', '', 0, '', 0, 45455, 4545, 0, '0', '', '0000-00-00 00:00:00', 0, '', '', '2020-03-04 15:01:21', 'sha256:12000:+Vl7OCXz17IeoQO3lgSo8Ievu54lp9CC:fcYQQFObR+lgl/B+WUkR7LuAHFqeq6l4', '14.6.171.34'),
(2020030415093783, 'admin', '최고관리자', 'admin@domain.com', '', '', '', '', '', '', '', '', '최고관리자', '', '', '', '', '', '', '', '', '', '', 1, 50000, 0, 0, 0, 0, 0, 0, 0, 0, 'OO은행 12345-67-89012 예금주명', '0000-00-00 00:00:00', 0, 50000, '', '', '주문', '0000-00-00', '무통장', 0, 0, 'kcp', '', '', 0, '', 0, 45455, 4545, 0, '0', '', '0000-00-00 00:00:00', 0, '', '', '2020-03-04 15:09:42', 'sha256:12000:+Vl7OCXz17IeoQO3lgSo8Ievu54lp9CC:fcYQQFObR+lgl/B+WUkR7LuAHFqeq6l4', '14.6.171.34'),
(2020030415103355, 'admin', '최고관리자', 'admin@domain.com', '', '', '', '', '', '', '', '', '최고관리자', '', '', '', '', '', '', '', '', '', '', 1, 50000, 0, 0, 0, 0, 0, 0, 0, 0, 'OO은행 12345-67-89012 예금주명', '0000-00-00 00:00:00', 0, 50000, '', '', '주문', '0000-00-00', '무통장', 0, 0, 'kcp', '', '', 0, '', 0, 45455, 4545, 0, '0', '', '0000-00-00 00:00:00', 0, '', '', '2020-03-04 15:10:36', 'sha256:12000:+Vl7OCXz17IeoQO3lgSo8Ievu54lp9CC:fcYQQFObR+lgl/B+WUkR7LuAHFqeq6l4', '14.6.171.34'),
(2020030415110478, 'admin', '최고관리자', 'admin@domain.com', '', '', '', '', '', '', '', '', '최고관리자', '', '', '', '', '', '', '', '', '', '', 1, 50000, 0, 0, 0, 0, 0, 0, 0, 0, 'OO은행 12345-67-89012 예금주명', '0000-00-00 00:00:00', 0, 50000, '', '', '주문', '0000-00-00', '무통장', 0, 0, 'kcp', '', '', 0, '', 0, 45455, 4545, 0, '0', '', '0000-00-00 00:00:00', 0, '', '', '2020-03-04 15:11:07', 'sha256:12000:+Vl7OCXz17IeoQO3lgSo8Ievu54lp9CC:fcYQQFObR+lgl/B+WUkR7LuAHFqeq6l4', '14.6.171.34'),
(2020030415114193, 'admin', '최고관리자', 'admin@domain.com', '', '', '', '', '', '', '', '', '최고관리자', '', '', '', '', '', '', '', '', '', '', 1, 50000, 0, 0, 0, 0, 0, 0, 0, 0, 'OO은행 12345-67-89012 예금주명', '0000-00-00 00:00:00', 0, 50000, '', '', '주문', '0000-00-00', '무통장', 0, 0, 'kcp', '', '', 0, '', 0, 45455, 4545, 0, '0', '', '0000-00-00 00:00:00', 0, '', '', '2020-03-04 15:11:45', 'sha256:12000:+Vl7OCXz17IeoQO3lgSo8Ievu54lp9CC:fcYQQFObR+lgl/B+WUkR7LuAHFqeq6l4', '14.6.171.34'),
(2020030415115511, 'admin', '최고관리자', 'admin@domain.com', '', '', '', '', '', '', '', '', '최고관리자', '', '', '', '', '', '', '', '', '', '', 1, 50000, 0, 0, 0, 0, 0, 0, 0, 0, 'OO은행 12345-67-89012 예금주명', '0000-00-00 00:00:00', 0, 50000, '', '', '주문', '0000-00-00', '무통장', 0, 0, 'kcp', '', '', 0, '', 0, 45455, 4545, 0, '0', '', '0000-00-00 00:00:00', 0, '', '', '2020-03-04 15:11:58', 'sha256:12000:+Vl7OCXz17IeoQO3lgSo8Ievu54lp9CC:fcYQQFObR+lgl/B+WUkR7LuAHFqeq6l4', '14.6.171.34'),
(2020030415124156, 'admin', '최고관리자', 'admin@domain.com', '', '', '', '', '', '', '', '', '최고관리자', '', '', '', '', '', '', '', '', '', '', 1, 50000, 0, 0, 0, 0, 0, 0, 0, 0, 'OO은행 12345-67-89012 예금주명', '0000-00-00 00:00:00', 0, 50000, '', '', '주문', '0000-00-00', '무통장', 0, 0, 'kcp', '', '', 0, '', 0, 45455, 4545, 0, '0', '', '0000-00-00 00:00:00', 0, '', '', '2020-03-04 15:12:55', 'sha256:12000:+Vl7OCXz17IeoQO3lgSo8Ievu54lp9CC:fcYQQFObR+lgl/B+WUkR7LuAHFqeq6l4', '14.6.171.34'),
(2020030415132002, 'admin', '최고관리자', 'admin@domain.com', '', '', '', '', '', '', '', '', '최고관리자', '', '', '', '', '', '', '', '', '', '', 1, 50000, 0, 0, 0, 0, 0, 0, 0, 0, 'OO은행 12345-67-89012 예금주명', '0000-00-00 00:00:00', 0, 50000, '', '', '주문', '0000-00-00', '무통장', 0, 0, 'kcp', '', '', 0, '', 0, 45455, 4545, 0, '0', '', '0000-00-00 00:00:00', 0, '', '', '2020-03-04 15:13:23', 'sha256:12000:+Vl7OCXz17IeoQO3lgSo8Ievu54lp9CC:fcYQQFObR+lgl/B+WUkR7LuAHFqeq6l4', '14.6.171.34'),
(2020030415142253, 'admin', '최고관리자', 'admin@domain.com', '', '', '', '', '', '', '', '', '최고관리자', '', '', '', '', '', '', '', '', '', '', 1, 50000, 0, 0, 0, 0, 0, 0, 0, 0, 'OO은행 12345-67-89012 예금주명', '0000-00-00 00:00:00', 0, 50000, '', '', '주문', '0000-00-00', '무통장', 0, 0, 'kcp', '', '', 0, '', 0, 45455, 4545, 0, '0', '', '0000-00-00 00:00:00', 0, '', '', '2020-03-04 15:14:26', 'sha256:12000:+Vl7OCXz17IeoQO3lgSo8Ievu54lp9CC:fcYQQFObR+lgl/B+WUkR7LuAHFqeq6l4', '14.6.171.34'),
(2020030416124889, 'admin', '최고관리자', 'admin@domain.com', '', '', '', '', '', '', '', '', '최고관리자', '', '', '', '', '', '', '', '', '', '', 1, 50000, 0, 0, 0, 0, 0, 0, 0, 0, 'OO은행 12345-67-89012 예금주명', '0000-00-00 00:00:00', 0, 50000, '', '', '완료', '0000-00-00', '무통장', 0, 0, 'kcp', '', '', 0, '', 0, 45455, 4545, 0, '0', '', '0000-00-00 00:00:00', 0, '', '', '2020-03-04 16:12:52', 'sha256:12000:+Vl7OCXz17IeoQO3lgSo8Ievu54lp9CC:fcYQQFObR+lgl/B+WUkR7LuAHFqeq6l4', '14.6.171.34'),
(2020030416475211, 'admin', '최고관리자', 'admin@domain.com', '123123', '', '061', '12', '서울 강남구 논현로123길 4-1', '123', ' (논현동)', 'R', '최고관리자', '최고관리자', '123123', '', '061', '12', '서울 강남구 논현로123길 4-1', '123', ' (논현동)', 'R', '', 1, 0, 0, 4000, 0, 0, 0, 0, 0, 0, 'OO은행 12345-67-89012 예금주명', '0000-00-00 00:00:00', 0, 4000, '', '', '완료', '0000-00-00', '무통장', 0, 0, 'kcp', '', '', 0, '', 0, 3636, 364, 0, '0', '', '0000-00-00 00:00:00', 0, '', '', '2020-03-04 16:48:06', 'sha256:12000:+Vl7OCXz17IeoQO3lgSo8Ievu54lp9CC:fcYQQFObR+lgl/B+WUkR7LuAHFqeq6l4', '14.6.171.34'),
(2020030416492743, 'admin', '최고관리자', 'admin@domain.com', '123', '', '061', '12', '서울 강남구 논현로123길 4-1', '123', ' (논현동)', 'R', '최고관리자', '최고관리자', '123', '', '061', '12', '서울 강남구 논현로123길 4-1', '123', ' (논현동)', 'R', '', 1, 0, 0, 4000, 0, 0, 0, 0, 0, 0, 'OO은행 12345-67-89012 예금주명', '0000-00-00 00:00:00', 0, 4000, '', '', '완료', '0000-00-00', '무통장', 0, 0, 'kcp', '', '', 0, '', 0, 3636, 364, 0, '0', '', '0000-00-00 00:00:00', 0, '', '', '2020-03-04 16:49:37', 'sha256:12000:+Vl7OCXz17IeoQO3lgSo8Ievu54lp9CC:fcYQQFObR+lgl/B+WUkR7LuAHFqeq6l4', '14.6.171.34'),
(2020030416500088, 'admin', '최고관리자', 'admin@domain.com', '', '', '', '', '', '', '', '', '최고관리자', '', '', '', '', '', '', '', '', '', '', 1, 50000, 0, 0, 0, 0, 0, 0, 0, 0, 'OO은행 12345-67-89012 예금주명', '0000-00-00 00:00:00', 0, 50000, '', '', '완료', '0000-00-00', '무통장', 0, 0, 'kcp', '', '', 0, '', 0, 45455, 4545, 0, '0', '', '0000-00-00 00:00:00', 0, '', '', '2020-03-04 16:50:03', 'sha256:12000:+Vl7OCXz17IeoQO3lgSo8Ievu54lp9CC:fcYQQFObR+lgl/B+WUkR7LuAHFqeq6l4', '14.6.171.34'),
(2020030416575457, 'admin', '최고관리자', 'admin@domain.com', '1212', '', '010', '12', '서울 강북구 4.19로12길 5', '12', ' (수유동)', 'R', '최고관리자', '최고관리자', '1212', '', '010', '12', '서울 강북구 4.19로12길 5', '12', ' (수유동)', 'R', '', 1, 0, 0, 4000, 0, 0, 0, 0, 0, 0, 'OO은행 12345-67-89012 예금주명', '0000-00-00 00:00:00', 0, 4000, '', '', '완료', '0000-00-00', '무통장', 0, 0, 'kcp', '', '', 0, '', 0, 3636, 364, 0, '0', '', '0000-00-00 00:00:00', 0, '', '', '2020-03-04 16:58:07', 'sha256:12000:+Vl7OCXz17IeoQO3lgSo8Ievu54lp9CC:fcYQQFObR+lgl/B+WUkR7LuAHFqeq6l4', '14.6.171.34'),
(2020030615492354, 'admin', '최고관리자', 'admin@domain.com', '1235', '', '010', '12', '서울 강북구 4.19로12길 5', '', ' (수유동)', 'R', '최고관리자', '최고관리자', '1235', '', '010', '12', '서울 강북구 4.19로12길 5', '', ' (수유동)', 'R', '', 1, 0, 0, 4000, 0, 0, 0, 0, 0, 0, 'OO은행 12345-67-89012 예금주명', '0000-00-00 00:00:00', 0, 4000, '', '', '주문', '0000-00-00', '무통장', 0, 1, 'kcp', '', '', 0, '', 0, 3636, 364, 0, '0', '', '0000-00-00 00:00:00', 0, '', '', '2020-03-06 15:49:59', 'sha256:12000:+Vl7OCXz17IeoQO3lgSo8Ievu54lp9CC:fcYQQFObR+lgl/B+WUkR7LuAHFqeq6l4', '14.6.171.34');

-- --------------------------------------------------------

--
-- Table structure for table `g5_shop_order_address`
--

CREATE TABLE IF NOT EXISTS `g5_shop_order_address` (
  `ad_id` int(11) NOT NULL auto_increment,
  `mb_id` varchar(255) NOT NULL default '',
  `ad_subject` varchar(255) NOT NULL default '',
  `ad_default` tinyint(4) NOT NULL default '0',
  `ad_name` varchar(255) NOT NULL default '',
  `ad_tel` varchar(255) NOT NULL default '',
  `ad_hp` varchar(255) NOT NULL default '',
  `ad_zip1` char(3) NOT NULL default '',
  `ad_zip2` char(3) NOT NULL default '',
  `ad_addr1` varchar(255) NOT NULL default '',
  `ad_addr2` varchar(255) NOT NULL default '',
  `ad_addr3` varchar(255) NOT NULL default '',
  `ad_jibeon` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`ad_id`),
  KEY `mb_id` (`mb_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `g5_shop_order_address`
--

INSERT INTO `g5_shop_order_address` (`ad_id`, `mb_id`, `ad_subject`, `ad_default`, `ad_name`, `ad_tel`, `ad_hp`, `ad_zip1`, `ad_zip2`, `ad_addr1`, `ad_addr2`, `ad_addr3`, `ad_jibeon`) VALUES
(1, 'admin', '', 0, '최고관리자', '01012341234', '', '061', '12', '서울 강남구 논현로123길 4-1', '123123', ' (논현동)', 'R'),
(2, 'admin', '', 0, '최고관리자', '123123', '', '061', '12', '서울 강남구 논현로123길 4-1', '123', ' (논현동)', 'R'),
(3, 'admin', '', 0, '최고관리자', '123', '', '061', '12', '서울 강남구 논현로123길 4-1', '123', ' (논현동)', 'R'),
(4, 'admin', '', 0, '최고관리자', '123', '', '061', '12', '서울 강남구 논현로123길 4-1', '', ' (논현동)', 'R'),
(5, 'admin', '', 0, '최고관리자', '123', '', '053', '15', '서울 강동구 양재대로123길 7', '', ' (천호동, 강동그랑시아)', 'R'),
(6, 'admin', '', 0, '최고관리자', '123', '', '061', '12', '서울 강남구 논현로123길 4-3', '', ' (논현동)', 'R'),
(7, 'test', '', 0, 'cxxx', '1245', '', '010', '12', '서울 강북구 4.19로12길 5', 'gg', ' (수유동)', 'R'),
(8, 'admin', '', 0, '', '', '', '', '', '', '', '', ''),
(9, 'admin', '', 0, '최고관리자', '1212', '', '010', '12', '서울 강북구 4.19로12길 5', '12', ' (수유동)', 'R'),
(10, 'admin', '', 0, '최고관리자', '1235', '', '010', '12', '서울 강북구 4.19로12길 5', '', ' (수유동)', 'R');

-- --------------------------------------------------------

--
-- Table structure for table `g5_shop_order_data`
--

CREATE TABLE IF NOT EXISTS `g5_shop_order_data` (
  `od_id` bigint(20) unsigned NOT NULL,
  `cart_id` bigint(20) unsigned NOT NULL,
  `mb_id` varchar(20) NOT NULL default '',
  `dt_pg` varchar(255) NOT NULL default '',
  `dt_data` text NOT NULL,
  `dt_time` datetime NOT NULL default '0000-00-00 00:00:00',
  KEY `od_id` (`od_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `g5_shop_order_delete`
--

CREATE TABLE IF NOT EXISTS `g5_shop_order_delete` (
  `de_id` int(11) NOT NULL auto_increment,
  `de_key` varchar(255) NOT NULL default '',
  `de_data` longtext NOT NULL,
  `mb_id` varchar(20) NOT NULL default '',
  `de_ip` varchar(255) NOT NULL default '',
  `de_datetime` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`de_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `g5_shop_order_post_log`
--

CREATE TABLE IF NOT EXISTS `g5_shop_order_post_log` (
  `oid` bigint(20) unsigned NOT NULL,
  `mb_id` varchar(255) NOT NULL default '',
  `post_data` text NOT NULL,
  `ol_code` varchar(255) NOT NULL default '',
  `ol_msg` varchar(255) NOT NULL default '',
  `ol_datetime` datetime NOT NULL default '0000-00-00 00:00:00',
  `ol_ip` varchar(25) NOT NULL default '',
  PRIMARY KEY  (`oid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `g5_shop_personalpay`
--

CREATE TABLE IF NOT EXISTS `g5_shop_personalpay` (
  `pp_id` bigint(20) unsigned NOT NULL,
  `od_id` bigint(20) unsigned NOT NULL,
  `pp_name` varchar(255) NOT NULL default '',
  `pp_email` varchar(255) NOT NULL default '',
  `pp_hp` varchar(255) NOT NULL default '',
  `pp_content` text NOT NULL,
  `pp_use` tinyint(4) NOT NULL default '0',
  `pp_price` int(11) NOT NULL default '0',
  `pp_pg` varchar(255) NOT NULL default '',
  `pp_tno` varchar(255) NOT NULL default '',
  `pp_app_no` varchar(20) NOT NULL default '',
  `pp_casseqno` varchar(255) NOT NULL default '',
  `pp_receipt_price` int(11) NOT NULL default '0',
  `pp_settle_case` varchar(255) NOT NULL default '',
  `pp_bank_account` varchar(255) NOT NULL default '',
  `pp_deposit_name` varchar(255) NOT NULL default '',
  `pp_receipt_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `pp_receipt_ip` varchar(255) NOT NULL default '',
  `pp_shop_memo` text NOT NULL,
  `pp_cash` tinyint(4) NOT NULL default '0',
  `pp_cash_no` varchar(255) NOT NULL default '',
  `pp_cash_info` text NOT NULL,
  `pp_ip` varchar(255) NOT NULL default '',
  `pp_time` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`pp_id`),
  KEY `od_id` (`od_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `g5_shop_sendcost`
--

CREATE TABLE IF NOT EXISTS `g5_shop_sendcost` (
  `sc_id` int(11) NOT NULL auto_increment,
  `sc_name` varchar(255) NOT NULL default '',
  `sc_zip1` varchar(10) NOT NULL default '',
  `sc_zip2` varchar(10) NOT NULL default '',
  `sc_price` int(11) NOT NULL default '0',
  PRIMARY KEY  (`sc_id`),
  KEY `sc_zip1` (`sc_zip1`),
  KEY `sc_zip2` (`sc_zip2`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `g5_shop_wish`
--

CREATE TABLE IF NOT EXISTS `g5_shop_wish` (
  `wi_id` int(11) NOT NULL auto_increment,
  `mb_id` varchar(255) NOT NULL default '',
  `it_id` varchar(20) NOT NULL default '0',
  `wi_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `wi_ip` varchar(25) NOT NULL default '',
  PRIMARY KEY  (`wi_id`),
  KEY `index1` (`mb_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `g5_uniqid`
--

CREATE TABLE IF NOT EXISTS `g5_uniqid` (
  `uq_id` bigint(20) unsigned NOT NULL,
  `uq_ip` varchar(255) NOT NULL,
  PRIMARY KEY  (`uq_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `g5_uniqid`
--

INSERT INTO `g5_uniqid` (`uq_id`, `uq_ip`) VALUES
(2020022719214138, '222.102.192.114'),
(2020030211563793, '14.6.171.34'),
(2020030215270140, '223.39.151.37'),
(2020030220201995, '14.6.171.34'),
(2020030220202009, '14.6.171.34'),
(2020030220234561, '14.6.171.34'),
(2020030220234571, '14.6.171.34'),
(2020030220245691, '14.6.171.34'),
(2020030220245701, '14.6.171.34'),
(2020030220280603, '14.6.171.34'),
(2020030220280615, '14.6.171.34'),
(2020030220324648, '14.6.171.34'),
(2020030220324665, '14.6.171.34'),
(2020030220410448, '14.6.171.34'),
(2020030220410459, '14.6.171.34'),
(2020030220581216, '14.6.171.34'),
(2020030220581230, '14.6.171.34'),
(2020030414033683, '14.6.171.34'),
(2020030414033695, '14.6.171.34'),
(2020030414051574, '14.6.171.34'),
(2020030414063266, '14.6.171.34'),
(2020030414111461, '14.6.171.34'),
(2020030414111587, '14.6.171.34'),
(2020030414120903, '14.6.171.34'),
(2020030414132780, '14.6.171.34'),
(2020030414135232, '14.6.171.34'),
(2020030414141979, '14.6.171.34'),
(2020030414144480, '14.6.171.34'),
(2020030414150267, '14.6.171.34'),
(2020030414161885, '14.6.171.34'),
(2020030414163332, '14.6.171.34'),
(2020030414164228, '14.6.171.34'),
(2020030414171219, '14.6.171.34'),
(2020030414171622, '14.6.171.34'),
(2020030414174987, '14.6.171.34'),
(2020030414180275, '14.6.171.34'),
(2020030414181387, '14.6.171.34'),
(2020030414183433, '14.6.171.34'),
(2020030414183603, '14.6.171.34'),
(2020030414184158, '14.6.171.34'),
(2020030414184540, '14.6.171.34'),
(2020030414185171, '14.6.171.34'),
(2020030414185252, '14.6.171.34'),
(2020030414185270, '14.6.171.34'),
(2020030414190282, '14.6.171.34'),
(2020030414190410, '14.6.171.34'),
(2020030414190559, '14.6.171.34'),
(2020030414190831, '14.6.171.34'),
(2020030414192100, '14.6.171.34'),
(2020030414192672, '14.6.171.34'),
(2020030414195542, '14.6.171.34'),
(2020030414210283, '14.6.171.34'),
(2020030414211546, '14.6.171.34'),
(2020030414211656, '14.6.171.34'),
(2020030414213319, '14.6.171.34'),
(2020030414232306, '14.6.171.34'),
(2020030414232644, '14.6.171.34'),
(2020030414233271, '14.6.171.34'),
(2020030414233907, '14.6.171.34'),
(2020030414234346, '14.6.171.34'),
(2020030414235057, '14.6.171.34'),
(2020030414235659, '14.6.171.34'),
(2020030414240279, '14.6.171.34'),
(2020030414240366, '14.6.171.34'),
(2020030414251375, '14.6.171.34'),
(2020030414251951, '14.6.171.34'),
(2020030414252744, '14.6.171.34'),
(2020030414254151, '14.6.171.34'),
(2020030414255329, '14.6.171.34'),
(2020030414261393, '14.6.171.34'),
(2020030414262464, '14.6.171.34'),
(2020030414265267, '14.6.171.34'),
(2020030414270994, '14.6.171.34'),
(2020030414274067, '14.6.171.34'),
(2020030414275928, '14.6.171.34'),
(2020030414280061, '14.6.171.34'),
(2020030414281551, '14.6.171.34'),
(2020030414282480, '14.6.171.34'),
(2020030414294653, '14.6.171.34'),
(2020030414551523, '14.6.171.34'),
(2020030414554384, '14.6.171.34'),
(2020030414575020, '14.6.171.34'),
(2020030414580969, '14.6.171.34'),
(2020030414592049, '14.6.171.34'),
(2020030414592065, '14.6.171.34'),
(2020030414595398, '14.6.171.34'),
(2020030414595568, '14.6.171.34'),
(2020030415000365, '14.6.171.34'),
(2020030415001457, '14.6.171.34'),
(2020030415001548, '14.6.171.34'),
(2020030415002807, '14.6.171.34'),
(2020030415003617, '14.6.171.34'),
(2020030415004670, '14.6.171.34'),
(2020030415005392, '14.6.171.34'),
(2020030415011874, '14.6.171.34'),
(2020030415021466, '14.6.171.34'),
(2020030415021483, '14.6.171.34'),
(2020030415093783, '14.6.171.34'),
(2020030415095976, '14.6.171.34'),
(2020030415095986, '14.6.171.34'),
(2020030415103355, '14.6.171.34'),
(2020030415104412, '14.6.171.34'),
(2020030415104426, '14.6.171.34'),
(2020030415104900, '14.6.171.34'),
(2020030415110478, '14.6.171.34'),
(2020030415114176, '14.6.171.34'),
(2020030415114193, '14.6.171.34'),
(2020030415115493, '14.6.171.34'),
(2020030415115511, '14.6.171.34'),
(2020030415124144, '14.6.171.34'),
(2020030415124156, '14.6.171.34'),
(2020030415131991, '14.6.171.34'),
(2020030415132002, '14.6.171.34'),
(2020030415142243, '14.6.171.34'),
(2020030415142253, '14.6.171.34'),
(2020030416103837, '14.6.171.34'),
(2020030416103851, '14.6.171.34'),
(2020030416124889, '14.6.171.34'),
(2020030416475194, '14.6.171.34'),
(2020030416475211, '14.6.171.34'),
(2020030416492729, '14.6.171.34'),
(2020030416492743, '14.6.171.34'),
(2020030416500078, '14.6.171.34'),
(2020030416500088, '14.6.171.34'),
(2020030416575446, '14.6.171.34'),
(2020030416575457, '14.6.171.34'),
(2020030615313773, '14.6.171.34'),
(2020030615354742, '14.6.171.34'),
(2020030615370001, '14.6.171.34'),
(2020030615382508, '14.6.171.34'),
(2020030615390966, '14.6.171.34'),
(2020030615404421, '14.6.171.34'),
(2020030615415669, '14.6.171.34'),
(2020030615432398, '14.6.171.34'),
(2020030615492338, '14.6.171.34'),
(2020030615492354, '14.6.171.34'),
(2020030616535951, '99.238.182.9'),
(2020030617260663, '14.6.171.34'),
(2020030618151554, '211.197.7.1'),
(2020030913171479, '99.238.182.9');

-- --------------------------------------------------------

--
-- Table structure for table `g5_visit`
--

CREATE TABLE IF NOT EXISTS `g5_visit` (
  `vi_id` int(11) NOT NULL default '0',
  `vi_ip` varchar(100) NOT NULL default '',
  `vi_date` date NOT NULL default '0000-00-00',
  `vi_time` time NOT NULL default '00:00:00',
  `vi_referer` text NOT NULL,
  `vi_agent` varchar(200) NOT NULL default '',
  `vi_browser` varchar(255) NOT NULL default '',
  `vi_os` varchar(255) NOT NULL default '',
  `vi_device` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`vi_id`),
  UNIQUE KEY `index1` (`vi_ip`,`vi_date`),
  KEY `index2` (`vi_date`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `g5_visit`
--

INSERT INTO `g5_visit` (`vi_id`, `vi_ip`, `vi_date`, `vi_time`, `vi_referer`, `vi_agent`, `vi_browser`, `vi_os`, `vi_device`) VALUES
(1, '222.102.192.114', '2020-02-27', '19:21:31', 'http://test3.stylesheet.co.kr/install/install_db.php', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_3) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.5 Safari/605.1.15', '', '', ''),
(2, '14.6.171.34', '2020-03-02', '11:56:17', 'http://test3.stylesheet.co.kr/shop/', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_3) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.5 Safari/605.1.15', '', '', ''),
(3, '223.39.151.37', '2020-03-02', '15:26:49', '', 'Mozilla/5.0 (iPhone; CPU iPhone OS 13_3_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.5 Mobile/15E148 Safari/604.1', '', '', ''),
(4, '74.125.150.10', '2020-03-02', '19:24:42', '', 'Mediapartners-Google', '', '', ''),
(5, '74.125.150.14', '2020-03-02', '19:24:42', '', 'Mediapartners-Google', '', '', ''),
(6, '148.64.56.114', '2020-03-02', '19:37:03', '', 'Mozilla/5.0 (compatible; GrapeshotCrawler/2.0; +http://www.grapeshot.co.uk/crawler.php)', '', '', ''),
(7, '74.125.150.12', '2020-03-02', '19:41:01', '', 'Mediapartners-Google', '', '', ''),
(8, '14.6.171.34', '2020-03-04', '12:18:40', 'http://test3.stylesheet.co.kr/shop/free_charging_go.php?bn_id=6', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_3) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.5 Safari/605.1.15', '', '', ''),
(9, '14.6.171.34', '2020-03-06', '12:34:18', 'http://test3.stylesheet.co.kr/adm/shop_admin/orderform.php?od_id=2020030416575457&sort1=od_id&sort2=desc&sel_field=od_id&search=&page=1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_3) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.5 Safari/605.1.15', '', '', ''),
(10, '99.238.182.9', '2020-03-06', '16:50:40', '', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.122 Safari/537.36', '', '', ''),
(11, '27.0.238.182', '2020-03-06', '16:53:24', 'http://test3.stylesheet.co.kr/adm', 'facebookexternalhit/1.1; kakaotalk-scrap/1.0; +https://devtalk.kakao.com/t/scrap/33984', '', '', ''),
(12, '211.231.103.91', '2020-03-06', '16:53:24', 'http://test3.stylesheet.co.kr/adm', 'facebookexternalhit/1.1; kakaotalk-scrap/1.0; +https://devtalk.kakao.com/t/scrap/33984', '', '', ''),
(13, '27.0.238.117', '2020-03-06', '17:57:53', 'http://test3.stylesheet.co.kr/adm', 'facebookexternalhit/1.1; kakaotalk-scrap/1.0; +https://devtalk.kakao.com/t/scrap/33984', '', '', ''),
(14, '211.197.7.1', '2020-03-06', '18:14:44', '', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.122 Safari/537.36', '', '', ''),
(15, '118.223.133.118', '2020-03-06', '21:41:45', '', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.122 Safari/537.36', '', '', ''),
(16, '14.6.171.34', '2020-03-07', '21:42:01', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; Cortana 1.13.0.18362; 10.0.0.0.18362.657) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.102 Safari/537.36 Edge/18.18362', '', '', ''),
(17, '223.39.139.186', '2020-03-08', '13:28:04', '', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_4) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.1 Mobile/15E148 Safari/604.1', '', '', ''),
(18, '99.238.182.9', '2020-03-09', '13:16:50', '', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.132 Safari/537.36', '', '', ''),
(19, '118.223.133.118', '2020-03-10', '03:21:19', '', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.122 Safari/537.36', '', '', ''),
(20, '14.6.171.34', '2020-03-10', '15:18:48', '', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_3) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.5 Safari/605.1.15', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `g5_visit_sum`
--

CREATE TABLE IF NOT EXISTS `g5_visit_sum` (
  `vs_date` date NOT NULL default '0000-00-00',
  `vs_count` int(11) NOT NULL default '0',
  PRIMARY KEY  (`vs_date`),
  KEY `index1` (`vs_count`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `g5_visit_sum`
--

INSERT INTO `g5_visit_sum` (`vs_date`, `vs_count`) VALUES
('2020-02-27', 1),
('2020-03-02', 6),
('2020-03-04', 1),
('2020-03-06', 7),
('2020-03-07', 1),
('2020-03-08', 1),
('2020-03-09', 1),
('2020-03-10', 2);

-- --------------------------------------------------------

--
-- Table structure for table `g5_write_free`
--

CREATE TABLE IF NOT EXISTS `g5_write_free` (
  `wr_id` int(11) NOT NULL auto_increment,
  `wr_num` int(11) NOT NULL default '0',
  `wr_reply` varchar(10) NOT NULL,
  `wr_parent` int(11) NOT NULL default '0',
  `wr_is_comment` tinyint(4) NOT NULL default '0',
  `wr_comment` int(11) NOT NULL default '0',
  `wr_comment_reply` varchar(5) NOT NULL,
  `ca_name` varchar(255) NOT NULL,
  `wr_option` set('html1','html2','secret','mail') NOT NULL,
  `wr_subject` varchar(255) NOT NULL,
  `wr_content` text NOT NULL,
  `wr_seo_title` varchar(255) NOT NULL default '',
  `wr_link1` text NOT NULL,
  `wr_link2` text NOT NULL,
  `wr_link1_hit` int(11) NOT NULL default '0',
  `wr_link2_hit` int(11) NOT NULL default '0',
  `wr_hit` int(11) NOT NULL default '0',
  `wr_good` int(11) NOT NULL default '0',
  `wr_nogood` int(11) NOT NULL default '0',
  `mb_id` varchar(20) NOT NULL,
  `wr_password` varchar(255) NOT NULL,
  `wr_name` varchar(255) NOT NULL,
  `wr_email` varchar(255) NOT NULL,
  `wr_homepage` varchar(255) NOT NULL,
  `wr_datetime` datetime NOT NULL default '0000-00-00 00:00:00',
  `wr_file` tinyint(4) NOT NULL default '0',
  `wr_last` varchar(19) NOT NULL,
  `wr_ip` varchar(255) NOT NULL,
  `wr_facebook_user` varchar(255) NOT NULL,
  `wr_twitter_user` varchar(255) NOT NULL,
  `wr_1` varchar(255) NOT NULL,
  `wr_2` varchar(255) NOT NULL,
  `wr_3` varchar(255) NOT NULL,
  `wr_4` varchar(255) NOT NULL,
  `wr_5` varchar(255) NOT NULL,
  `wr_6` varchar(255) NOT NULL,
  `wr_7` varchar(255) NOT NULL,
  `wr_8` varchar(255) NOT NULL,
  `wr_9` varchar(255) NOT NULL,
  `wr_10` varchar(255) NOT NULL,
  PRIMARY KEY  (`wr_id`),
  KEY `wr_seo_title` (`wr_seo_title`),
  KEY `wr_num_reply_parent` (`wr_num`,`wr_reply`,`wr_parent`),
  KEY `wr_is_comment` (`wr_is_comment`,`wr_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `g5_write_gallery`
--

CREATE TABLE IF NOT EXISTS `g5_write_gallery` (
  `wr_id` int(11) NOT NULL auto_increment,
  `wr_num` int(11) NOT NULL default '0',
  `wr_reply` varchar(10) NOT NULL,
  `wr_parent` int(11) NOT NULL default '0',
  `wr_is_comment` tinyint(4) NOT NULL default '0',
  `wr_comment` int(11) NOT NULL default '0',
  `wr_comment_reply` varchar(5) NOT NULL,
  `ca_name` varchar(255) NOT NULL,
  `wr_option` set('html1','html2','secret','mail') NOT NULL,
  `wr_subject` varchar(255) NOT NULL,
  `wr_content` text NOT NULL,
  `wr_seo_title` varchar(255) NOT NULL default '',
  `wr_link1` text NOT NULL,
  `wr_link2` text NOT NULL,
  `wr_link1_hit` int(11) NOT NULL default '0',
  `wr_link2_hit` int(11) NOT NULL default '0',
  `wr_hit` int(11) NOT NULL default '0',
  `wr_good` int(11) NOT NULL default '0',
  `wr_nogood` int(11) NOT NULL default '0',
  `mb_id` varchar(20) NOT NULL,
  `wr_password` varchar(255) NOT NULL,
  `wr_name` varchar(255) NOT NULL,
  `wr_email` varchar(255) NOT NULL,
  `wr_homepage` varchar(255) NOT NULL,
  `wr_datetime` datetime NOT NULL default '0000-00-00 00:00:00',
  `wr_file` tinyint(4) NOT NULL default '0',
  `wr_last` varchar(19) NOT NULL,
  `wr_ip` varchar(255) NOT NULL,
  `wr_facebook_user` varchar(255) NOT NULL,
  `wr_twitter_user` varchar(255) NOT NULL,
  `wr_1` varchar(255) NOT NULL,
  `wr_2` varchar(255) NOT NULL,
  `wr_3` varchar(255) NOT NULL,
  `wr_4` varchar(255) NOT NULL,
  `wr_5` varchar(255) NOT NULL,
  `wr_6` varchar(255) NOT NULL,
  `wr_7` varchar(255) NOT NULL,
  `wr_8` varchar(255) NOT NULL,
  `wr_9` varchar(255) NOT NULL,
  `wr_10` varchar(255) NOT NULL,
  PRIMARY KEY  (`wr_id`),
  KEY `wr_seo_title` (`wr_seo_title`),
  KEY `wr_num_reply_parent` (`wr_num`,`wr_reply`,`wr_parent`),
  KEY `wr_is_comment` (`wr_is_comment`,`wr_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `g5_write_notice`
--

CREATE TABLE IF NOT EXISTS `g5_write_notice` (
  `wr_id` int(11) NOT NULL auto_increment,
  `wr_num` int(11) NOT NULL default '0',
  `wr_reply` varchar(10) NOT NULL,
  `wr_parent` int(11) NOT NULL default '0',
  `wr_is_comment` tinyint(4) NOT NULL default '0',
  `wr_comment` int(11) NOT NULL default '0',
  `wr_comment_reply` varchar(5) NOT NULL,
  `ca_name` varchar(255) NOT NULL,
  `wr_option` set('html1','html2','secret','mail') NOT NULL,
  `wr_subject` varchar(255) NOT NULL,
  `wr_content` text NOT NULL,
  `wr_seo_title` varchar(255) NOT NULL default '',
  `wr_link1` text NOT NULL,
  `wr_link2` text NOT NULL,
  `wr_link1_hit` int(11) NOT NULL default '0',
  `wr_link2_hit` int(11) NOT NULL default '0',
  `wr_hit` int(11) NOT NULL default '0',
  `wr_good` int(11) NOT NULL default '0',
  `wr_nogood` int(11) NOT NULL default '0',
  `mb_id` varchar(20) NOT NULL,
  `wr_password` varchar(255) NOT NULL,
  `wr_name` varchar(255) NOT NULL,
  `wr_email` varchar(255) NOT NULL,
  `wr_homepage` varchar(255) NOT NULL,
  `wr_datetime` datetime NOT NULL default '0000-00-00 00:00:00',
  `wr_file` tinyint(4) NOT NULL default '0',
  `wr_last` varchar(19) NOT NULL,
  `wr_ip` varchar(255) NOT NULL,
  `wr_facebook_user` varchar(255) NOT NULL,
  `wr_twitter_user` varchar(255) NOT NULL,
  `wr_1` varchar(255) NOT NULL,
  `wr_2` varchar(255) NOT NULL,
  `wr_3` varchar(255) NOT NULL,
  `wr_4` varchar(255) NOT NULL,
  `wr_5` varchar(255) NOT NULL,
  `wr_6` varchar(255) NOT NULL,
  `wr_7` varchar(255) NOT NULL,
  `wr_8` varchar(255) NOT NULL,
  `wr_9` varchar(255) NOT NULL,
  `wr_10` varchar(255) NOT NULL,
  PRIMARY KEY  (`wr_id`),
  KEY `wr_seo_title` (`wr_seo_title`),
  KEY `wr_num_reply_parent` (`wr_num`,`wr_reply`,`wr_parent`),
  KEY `wr_is_comment` (`wr_is_comment`,`wr_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `g5_write_qa`
--

CREATE TABLE IF NOT EXISTS `g5_write_qa` (
  `wr_id` int(11) NOT NULL auto_increment,
  `wr_num` int(11) NOT NULL default '0',
  `wr_reply` varchar(10) NOT NULL,
  `wr_parent` int(11) NOT NULL default '0',
  `wr_is_comment` tinyint(4) NOT NULL default '0',
  `wr_comment` int(11) NOT NULL default '0',
  `wr_comment_reply` varchar(5) NOT NULL,
  `ca_name` varchar(255) NOT NULL,
  `wr_option` set('html1','html2','secret','mail') NOT NULL,
  `wr_subject` varchar(255) NOT NULL,
  `wr_content` text NOT NULL,
  `wr_seo_title` varchar(255) NOT NULL default '',
  `wr_link1` text NOT NULL,
  `wr_link2` text NOT NULL,
  `wr_link1_hit` int(11) NOT NULL default '0',
  `wr_link2_hit` int(11) NOT NULL default '0',
  `wr_hit` int(11) NOT NULL default '0',
  `wr_good` int(11) NOT NULL default '0',
  `wr_nogood` int(11) NOT NULL default '0',
  `mb_id` varchar(20) NOT NULL,
  `wr_password` varchar(255) NOT NULL,
  `wr_name` varchar(255) NOT NULL,
  `wr_email` varchar(255) NOT NULL,
  `wr_homepage` varchar(255) NOT NULL,
  `wr_datetime` datetime NOT NULL default '0000-00-00 00:00:00',
  `wr_file` tinyint(4) NOT NULL default '0',
  `wr_last` varchar(19) NOT NULL,
  `wr_ip` varchar(255) NOT NULL,
  `wr_facebook_user` varchar(255) NOT NULL,
  `wr_twitter_user` varchar(255) NOT NULL,
  `wr_1` varchar(255) NOT NULL,
  `wr_2` varchar(255) NOT NULL,
  `wr_3` varchar(255) NOT NULL,
  `wr_4` varchar(255) NOT NULL,
  `wr_5` varchar(255) NOT NULL,
  `wr_6` varchar(255) NOT NULL,
  `wr_7` varchar(255) NOT NULL,
  `wr_8` varchar(255) NOT NULL,
  `wr_9` varchar(255) NOT NULL,
  `wr_10` varchar(255) NOT NULL,
  PRIMARY KEY  (`wr_id`),
  KEY `wr_seo_title` (`wr_seo_title`),
  KEY `wr_num_reply_parent` (`wr_num`,`wr_reply`,`wr_parent`),
  KEY `wr_is_comment` (`wr_is_comment`,`wr_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `sms5_book`
--

CREATE TABLE IF NOT EXISTS `sms5_book` (
  `bk_no` int(11) NOT NULL auto_increment,
  `bg_no` int(11) NOT NULL default '0',
  `mb_no` int(11) NOT NULL default '0',
  `mb_id` varchar(20) NOT NULL default '',
  `bk_name` varchar(255) NOT NULL default '',
  `bk_hp` varchar(255) NOT NULL default '',
  `bk_receipt` tinyint(4) NOT NULL default '0',
  `bk_datetime` datetime NOT NULL default '0000-00-00 00:00:00',
  `bk_memo` text NOT NULL,
  PRIMARY KEY  (`bk_no`),
  KEY `bk_name` (`bk_name`),
  KEY `bk_hp` (`bk_hp`),
  KEY `mb_no` (`mb_no`),
  KEY `bg_no` (`bg_no`,`bk_no`),
  KEY `mb_id` (`mb_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `sms5_book_group`
--

CREATE TABLE IF NOT EXISTS `sms5_book_group` (
  `bg_no` int(11) NOT NULL auto_increment,
  `bg_name` varchar(255) NOT NULL default '',
  `bg_count` int(11) NOT NULL default '0',
  `bg_member` int(11) NOT NULL default '0',
  `bg_nomember` int(11) NOT NULL default '0',
  `bg_receipt` int(11) NOT NULL default '0',
  `bg_reject` int(11) NOT NULL default '0',
  PRIMARY KEY  (`bg_no`),
  KEY `bg_name` (`bg_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `sms5_book_group`
--

INSERT INTO `sms5_book_group` (`bg_no`, `bg_name`, `bg_count`, `bg_member`, `bg_nomember`, `bg_receipt`, `bg_reject`) VALUES
(1, '미분류', 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `sms5_config`
--

CREATE TABLE IF NOT EXISTS `sms5_config` (
  `cf_phone` varchar(255) NOT NULL default '',
  `cf_datetime` datetime NOT NULL default '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sms5_form`
--

CREATE TABLE IF NOT EXISTS `sms5_form` (
  `fo_no` int(11) NOT NULL auto_increment,
  `fg_no` tinyint(4) NOT NULL default '0',
  `fg_member` char(1) NOT NULL default '0',
  `fo_name` varchar(255) NOT NULL default '',
  `fo_content` text NOT NULL,
  `fo_datetime` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`fo_no`),
  KEY `fg_no` (`fg_no`,`fo_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `sms5_form_group`
--

CREATE TABLE IF NOT EXISTS `sms5_form_group` (
  `fg_no` int(11) NOT NULL auto_increment,
  `fg_name` varchar(255) NOT NULL default '',
  `fg_count` int(11) NOT NULL default '0',
  `fg_member` tinyint(4) NOT NULL,
  PRIMARY KEY  (`fg_no`),
  KEY `fg_name` (`fg_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `sms5_history`
--

CREATE TABLE IF NOT EXISTS `sms5_history` (
  `hs_no` int(11) NOT NULL auto_increment,
  `wr_no` int(11) NOT NULL default '0',
  `wr_renum` int(11) NOT NULL default '0',
  `bg_no` int(11) NOT NULL default '0',
  `mb_no` int(11) NOT NULL default '0',
  `mb_id` varchar(20) NOT NULL default '',
  `bk_no` int(11) NOT NULL default '0',
  `hs_name` varchar(30) NOT NULL default '',
  `hs_hp` varchar(255) NOT NULL default '',
  `hs_datetime` datetime NOT NULL default '0000-00-00 00:00:00',
  `hs_flag` tinyint(4) NOT NULL default '0',
  `hs_code` varchar(255) NOT NULL default '',
  `hs_memo` varchar(255) NOT NULL default '',
  `hs_log` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`hs_no`),
  KEY `wr_no` (`wr_no`),
  KEY `mb_no` (`mb_no`),
  KEY `bk_no` (`bk_no`),
  KEY `hs_hp` (`hs_hp`),
  KEY `hs_code` (`hs_code`),
  KEY `bg_no` (`bg_no`),
  KEY `mb_id` (`mb_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `sms5_write`
--

CREATE TABLE IF NOT EXISTS `sms5_write` (
  `wr_no` int(11) NOT NULL default '1',
  `wr_renum` int(11) NOT NULL default '0',
  `wr_reply` varchar(255) NOT NULL default '',
  `wr_message` varchar(255) NOT NULL default '',
  `wr_booking` datetime NOT NULL default '0000-00-00 00:00:00',
  `wr_total` int(11) NOT NULL default '0',
  `wr_re_total` int(11) NOT NULL default '0',
  `wr_success` int(11) NOT NULL default '0',
  `wr_failure` int(11) NOT NULL default '0',
  `wr_datetime` datetime NOT NULL default '0000-00-00 00:00:00',
  `wr_memo` text NOT NULL,
  KEY `wr_no` (`wr_no`,`wr_renum`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

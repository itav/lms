CREATE table `gponauthlog` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `time` datetime NULL default NULL,
        `onuid` int(11) NOT NULL,
        `nas` varchar(15)  COLLATE utf8_polish_ci NOT NULL default '',
        `oltport` int(11),
        `onuoltid` int(11),
        `version` varchar(20)  COLLATE utf8_polish_ci,
        PRIMARY KEY (id),
	KEY gponauthlog_onuid_time (onuid, time DESC)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- gponolt --
CREATE TABLE `gponolt` (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `snmp_version` tinyint(4) NOT NULL,
	  `snmp_description` varchar(255) COLLATE utf8_polish_ci NOT NULL,
	  `snmp_host` varchar(100) COLLATE utf8_polish_ci NOT NULL,
	  `snmp_community` varchar(100) COLLATE utf8_polish_ci NOT NULL,
	  `snmp_auth_protocol` enum('MD5','SHA','') COLLATE utf8_polish_ci NOT NULL,
	  `snmp_username` varchar(255) COLLATE utf8_polish_ci NOT NULL,
	  `snmp_password` varchar(255) COLLATE utf8_polish_ci NOT NULL,
	  `snmp_sec_level` enum('noAuthNoPriv','authNoPriv','authPriv','') COLLATE utf8_polish_ci NOT NULL,
	  `snmp_privacy_passphrase` varchar(255) COLLATE utf8_polish_ci NOT NULL,
	  `snmp_privacy_protocol` enum('DES','AES','') COLLATE utf8_polish_ci NOT NULL,
	  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- gponoltports --
CREATE TABLE `gponoltports` (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `gponoltid` int(11) NOT NULL,
	  `numport` int(11) NOT NULL,
	  `maxonu` int(11) NOT NULL,
	  PRIMARY KEY (`id`),
	  KEY `gponoltid` (`gponoltid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- gponoltprofiles --
CREATE TABLE `gponoltprofiles` (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `name` varchar(100) COLLATE utf8_polish_ci NOT NULL,
	  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- gpononu --
CREATE TABLE `gpononu` (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `name` varchar(100) COLLATE utf8_polish_ci NOT NULL,
	  `location` varchar(255) COLLATE utf8_polish_ci NOT NULL,
	  `gpononumodelsid` int(11) NOT NULL,
	  `description` text COLLATE utf8_polish_ci NOT NULL,
	  `serialnumber` varchar(32) COLLATE utf8_polish_ci NOT NULL,
	  `purchasetime` int(11) NOT NULL DEFAULT '0',
	  `guaranteeperiod` tinyint(3) unsigned NOT NULL DEFAULT '0',
	  `password` varchar(100) COLLATE utf8_polish_ci NOT NULL,
	  `onuid` smallint(11) NOT NULL,
	  `autoprovisioning` tinyint(4) DEFAULT NULL,
	  `onudescription` varchar(32) COLLATE utf8_polish_ci DEFAULT NULL,
	  `gponoltprofilesid` int(11) DEFAULT NULL,
	  `voipaccountsid1` int(11) DEFAULT NULL,
	  `voipaccountsid2` int(11) DEFAULT NULL,
	  `autoscript` tinyint(4) NOT NULL,
	  `host_id1` int(11),
	  `host_id2` int(11),
	  `creationdate` int(11)  NOT NULL DEFAULT '0',
	  `moddate` int(11)       NOT NULL DEFAULT '0',
	  `creatorid` int(11)     NOT NULL DEFAULT '0',
	  `modid` int(11)         NOT NULL DEFAULT '0',
	  PRIMARY KEY (`id`),
	  UNIQUE KEY `name` (`name`),
	  KEY `gpononumodelsid` (`gpononumodelsid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- gpononu2customers --
CREATE TABLE `gpononu2customers` (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `gpononuid` int(11) NOT NULL,
	  `customersid` int(11) NOT NULL,
	  PRIMARY KEY (`id`),
	  KEY `IXgpononuid` (`gpononuid`),
	  KEY `IXcustomersid` (`customersid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- gpononu2olt --
CREATE TABLE `gpononu2olt` (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `netdevicesid` int(11) NOT NULL,
	  `gpononuid` int(11) NOT NULL,
	  `numport` smallint(6) NOT NULL,
	  PRIMARY KEY (`id`),
	  UNIQUE KEY `gpononuid` (`gpononuid`),
	  KEY `gponoltid` (`netdevicesid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- gpononumodels --
CREATE TABLE `gpononumodels` (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `name` varchar(32) COLLATE utf8_polish_ci NOT NULL,
	  `description` text COLLATE utf8_polish_ci,
	  `producer` varchar(64) COLLATE utf8_polish_ci DEFAULT NULL,
	  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

CREATE TABLE `gpononuport` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`onuid` int(11) NOT NULL,
	`typeid` int(11) DEFAULT NULL,
	`portid` int(11) DEFAULT NULL,
	`portdisable` tinyint(4),
	PRIMARY KEY (`id`),
	UNIQUE KEY `onu_type_port` (`onuid`, `typeid`, `portid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- gpononuportstype --
CREATE TABLE `gpononuportstype` (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `name` varchar(100) COLLATE utf8_polish_ci NOT NULL,
	  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- gpononuportstype2models --
CREATE TABLE `gpononuportstype2models` (
	  `gpononuportstypeid` int(11) NOT NULL,
	  `gpononumodelsid` int(11) NOT NULL,
	  `portscount` int(11) NOT NULL,
	  KEY `gpononuportstypeid` (`gpononuportstypeid`,`gpononumodelsid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- gpononutv --
CREATE TABLE `gpononutv` (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `ipaddr` int(16) unsigned NOT NULL,
	  `canal` varchar(100) COLLATE utf8_polish_ci NOT NULL,
	  PRIMARY KEY (`id`),
	  UNIQUE KEY `ipaddr` (`ipaddr`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;


DROP PROCEDURE IF EXISTS log_onu_auth;

DELIMITER $$
CREATE PROCEDURE log_onu_auth (username varchar(100), nas_ip varchar(15), olt int(11), onu int(11), ver char(20))
    BEGIN
	DECLARE  dev_id, onu_id int ;
	SELECT netdev INTO dev_id FROM nodes n WHERE inet_ntoa(ipaddr) = nas_ip AND ownerid = 0;
	SELECT id INTO onu_id FROM gpononu WHERE name = username;
	INSERT INTO gponauthlog(time, onuid, nas, oltport, onuoltid, version) VALUES(NOW(), onu_id, nas_ip, olt, onu, ver);
	UPDATE gpononu SET onuid = onu WHERE id = onu_id;
	
	REPLACE INTO gpononu2olt(netdevicesid, gpononuid, numport) VALUES(dev_id, onu_id, olt);
    END;
$$
DELIMITER ;

-- uiconfig --
INSERT INTO `uiconfig` (`section`, `var`, `value`, `description`, `disabled`) VALUES ('phpui','gpon_max_onu_to_olt','64','GPON - Domyślna maksymalna liczba ONU przypisanych do portu OLT',0);
INSERT INTO `uiconfig` (`section`, `var`, `value`, `description`, `disabled`) VALUES ('phpui','gpon_onumodels_pagelimit','100','Limit wyświetlanych rekordów na jednej stronie listy modeli ONU.',0);
INSERT INTO `uiconfig` (`section`, `var`, `value`, `description`, `disabled`) VALUES ('phpui','gpon','1','Moduł GPON',0);
INSERT INTO `uiconfig` (`section`, `var`, `value`, `description`, `disabled`) VALUES ('phpui','gpon_onu_pagelimit','100','Limit wyświetlanych rekordów na jednej stronie listy ONU.',0);
INSERT INTO `uiconfig` (`section`, `var`, `value`, `description`, `disabled`) VALUES ('phpui','gpon_olt_pagelimit','100','Limit wyświetlanych rekordów na jednej stronie listy OLT.',0);
INSERT INTO `uiconfig` (`section`, `var`, `value`, `description`, `disabled`) VALUES ('phpui','gpon_onu_customerlimit','5','Maksymalna liczba Klientów przypisanych do ONU',0);
INSERT INTO `uiconfig` (`section`, `var`, `value`, `description`, `disabled`) VALUES ('phpui','gpon_tx_output_power_weak','-26','Niski poziom mocy optycznej RX Output Power',0);
INSERT INTO `uiconfig` (`section`, `var`, `value`, `description`, `disabled`) VALUES ('phpui','gpon_onu_autoscript_debug','1','',1);
insert into `uiconfig` (`section`, `var`, `value`, `description`) VALUES ('phpui', 'gpon_use_radius', 0, 'Czy gpon (olty) mają używać radiusa');
insert into `uiconfig` (`section`, `var`, `value`, `description`) VALUES ('phpui', 'gpon_syslog', 0, 'Jeśli mamy tabele syslog to możemy logować zdarzenia (custom lms).  syslog(time integer, userid integer, level smallint, what character varying(128), xid integer, message text, detail text)');

insert into `gpononuportstype` (`name`) values('eth');
insert into `gpononuportstype` (`name`) values('pots');
insert into `gpononuportstype` (`name`) values('ces');
insert into `gpononuportstype` (`name`) values('video');
insert into `gpononuportstype` (`name`) values('virtual-eth');
insert into `gpononuportstype` (`name`) values('wifi');

-- netdevices --
ALTER TABLE `netdevices` ADD COLUMN `gponoltid` int(11) DEFAULT NULL;
ALTER TABLE `netdevices` ADD KEY `gponoltid` (`gponoltid`);



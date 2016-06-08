-- MySQL dump 10.14  Distrib 5.5.44-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: c100_shopland
-- ------------------------------------------------------
-- Server version	5.5.44-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `commentsapi_comment`
--

DROP TABLE IF EXISTS `commentsapi_comment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `commentsapi_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cdate` datetime NOT NULL,
  `id_user` int(11) NOT NULL,
  `key` varchar(32) NOT NULL,
  `sessionid` varchar(32) NOT NULL,
  `ip` varchar(15) NOT NULL,
  `content` text NOT NULL,
  `type` enum('comment','notify','change','call','email','sms','commentresult') NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_keycdate` (`key`,`cdate`),
  KEY `index_usercdate` (`id_user`,`cdate`),
  KEY `index_type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `commentsapi_comment`
--

LOCK TABLES `commentsapi_comment` WRITE;
/*!40000 ALTER TABLE `commentsapi_comment` DISABLE KEYS */;
/*!40000 ALTER TABLE `commentsapi_comment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financeaccount`
--

DROP TABLE IF EXISTS `financeaccount`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financeaccount` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `currencyid` int(11) NOT NULL,
  `contractorid` int(11) NOT NULL,
  `balancestart` decimal(15,2) NOT NULL,
  `active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financeaccount`
--

LOCK TABLES `financeaccount` WRITE;
/*!40000 ALTER TABLE `financeaccount` DISABLE KEYS */;
/*!40000 ALTER TABLE `financeaccount` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financecategory`
--

DROP TABLE IF EXISTS `financecategory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financecategory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `fundpercent` int(11) NOT NULL,
  `fundsum` decimal(15,2) NOT NULL,
  `fundtotal` decimal(15,2) NOT NULL,
  `lastpaymentid` int(11) NOT NULL,
  `isfund` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_name` (`name`),
  KEY `index_isfund` (`isfund`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financecategory`
--

LOCK TABLES `financecategory` WRITE;
/*!40000 ALTER TABLE `financecategory` DISABLE KEYS */;
/*!40000 ALTER TABLE `financecategory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financeinvoice`
--

DROP TABLE IF EXISTS `financeinvoice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financeinvoice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cdate` datetime NOT NULL,
  `date` datetime NOT NULL,
  `userid` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `clientid` int(11) NOT NULL,
  `type` enum('in','out') NOT NULL,
  `linkkey` varchar(255) NOT NULL,
  `contractorid` int(11) NOT NULL,
  `sum` decimal(15,2) NOT NULL,
  `currencyid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financeinvoice`
--

LOCK TABLES `financeinvoice` WRITE;
/*!40000 ALTER TABLE `financeinvoice` DISABLE KEYS */;
/*!40000 ALTER TABLE `financeinvoice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financeinvoiceproduct`
--

DROP TABLE IF EXISTS `financeinvoiceproduct`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financeinvoiceproduct` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoiceid` int(11) NOT NULL,
  `productid` int(11) NOT NULL,
  `amount` decimal(15,3) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(15,2) NOT NULL,
  `currencyid` int(11) NOT NULL,
  `taxrate` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financeinvoiceproduct`
--

LOCK TABLES `financeinvoiceproduct` WRITE;
/*!40000 ALTER TABLE `financeinvoiceproduct` DISABLE KEYS */;
/*!40000 ALTER TABLE `financeinvoiceproduct` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financepayment`
--

DROP TABLE IF EXISTS `financepayment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financepayment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cdate` datetime NOT NULL,
  `pdate` datetime NOT NULL,
  `rdate` datetime NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `amountbase` decimal(15,2) NOT NULL,
  `currencyid` int(11) NOT NULL,
  `currencyrate` decimal(15,2) NOT NULL,
  `accountid` int(11) NOT NULL,
  `clientid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `categoryid` int(11) NOT NULL,
  `code` varchar(255) NOT NULL,
  `orderid` int(11) NOT NULL,
  `orderamountbase` decimal(15,2) NOT NULL,
  `linkkey` varchar(255) NOT NULL,
  `bankdetail` text NOT NULL,
  `comment` text NOT NULL,
  `invoiceid` int(11) NOT NULL,
  `file` varchar(255) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `referalprocessed` tinyint(1) NOT NULL,
  `noBalance` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_accountid` (`accountid`),
  KEY `index_orderid` (`orderid`),
  KEY `index_clientid` (`clientid`),
  KEY `index_linkkey` (`linkkey`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financepayment`
--

LOCK TABLES `financepayment` WRITE;
/*!40000 ALTER TABLE `financepayment` DISABLE KEYS */;
/*!40000 ALTER TABLE `financepayment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financeprobation`
--

DROP TABLE IF EXISTS `financeprobation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financeprobation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `orderid` int(11) NOT NULL,
  `cdate` datetime NOT NULL,
  `pdate` date NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `amountbase` decimal(15,2) NOT NULL,
  `currencyid` int(11) NOT NULL,
  `managerid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financeprobation`
--

LOCK TABLES `financeprobation` WRITE;
/*!40000 ALTER TABLE `financeprobation` DISABLE KEYS */;
/*!40000 ALTER TABLE `financeprobation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mailutils_que`
--

DROP TABLE IF EXISTS `mailutils_que`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mailutils_que` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cdate` datetime NOT NULL,
  `status` tinyint(1) NOT NULL,
  `sdate` datetime NOT NULL,
  `pdate` datetime NOT NULL,
  `ip` varchar(15) NOT NULL,
  `from` varchar(255) NOT NULL,
  `to` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `body` longtext NOT NULL,
  `bodytype` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mailutils_que`
--

LOCK TABLES `mailutils_que` WRITE;
/*!40000 ALTER TABLE `mailutils_que` DISABLE KEYS */;
/*!40000 ALTER TABLE `mailutils_que` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mailutils_queattachment`
--

DROP TABLE IF EXISTS `mailutils_queattachment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mailutils_queattachment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `queid` int(11) NOT NULL,
  `cdate` datetime NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `file` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_queid` (`queid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mailutils_queattachment`
--

LOCK TABLES `mailutils_queattachment` WRITE;
/*!40000 ALTER TABLE `mailutils_queattachment` DISABLE KEYS */;
/*!40000 ALTER TABLE `mailutils_queattachment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `novaposhtacity`
--

DROP TABLE IF EXISTS `novaposhtacity`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `novaposhtacity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `ref` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `novaposhtacity`
--

LOCK TABLES `novaposhtacity` WRITE;
/*!40000 ALTER TABLE `novaposhtacity` DISABLE KEYS */;
/*!40000 ALTER TABLE `novaposhtacity` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `novaposhtainvoice`
--

DROP TABLE IF EXISTS `novaposhtainvoice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `novaposhtainvoice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `number` int(11) NOT NULL,
  `orderid` int(11) NOT NULL,
  `ref` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `cost` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `novaposhtainvoice`
--

LOCK TABLES `novaposhtainvoice` WRITE;
/*!40000 ALTER TABLE `novaposhtainvoice` DISABLE KEYS */;
/*!40000 ALTER TABLE `novaposhtainvoice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `novaposhtaoffice`
--

DROP TABLE IF EXISTS `novaposhtaoffice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `novaposhtaoffice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `address` varchar(255) NOT NULL,
  `ref` varchar(255) NOT NULL,
  `num` int(11) NOT NULL,
  `cityName` varchar(255) NOT NULL,
  `cityRef` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `novaposhtaoffice`
--

LOCK TABLES `novaposhtaoffice` WRITE;
/*!40000 ALTER TABLE `novaposhtaoffice` DISABLE KEYS */;
/*!40000 ALTER TABLE `novaposhtaoffice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `novaposhtastatus`
--

DROP TABLE IF EXISTS `novaposhtastatus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `novaposhtastatus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `statusid` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `novaposhtastatus`
--

LOCK TABLES `novaposhtastatus` WRITE;
/*!40000 ALTER TABLE `novaposhtastatus` DISABLE KEYS */;
/*!40000 ALTER TABLE `novaposhtastatus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pricesupplierimportreport`
--

DROP TABLE IF EXISTS `pricesupplierimportreport`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pricesupplierimportreport` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dateupdate` datetime NOT NULL,
  `productid` int(11) NOT NULL,
  `productname` varchar(255) NOT NULL,
  `error` tinyint(1) NOT NULL,
  `isnew` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pricesupplierimportreport`
--

LOCK TABLES `pricesupplierimportreport` WRITE;
/*!40000 ALTER TABLE `pricesupplierimportreport` DISABLE KEYS */;
/*!40000 ALTER TABLE `pricesupplierimportreport` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pricesupplierimportstatus`
--

DROP TABLE IF EXISTS `pricesupplierimportstatus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pricesupplierimportstatus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dateupload` datetime NOT NULL,
  `supplierid` int(3) NOT NULL,
  `processed` tinyint(1) NOT NULL,
  `dateprocessed` datetime NOT NULL,
  `resultfail` int(11) NOT NULL,
  `resultsuccess` int(11) NOT NULL,
  `resultadded` int(11) NOT NULL,
  `resulttext` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pricesupplierimportstatus`
--

LOCK TABLES `pricesupplierimportstatus` WRITE;
/*!40000 ALTER TABLE `pricesupplierimportstatus` DISABLE KEYS */;
/*!40000 ALTER TABLE `pricesupplierimportstatus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product2actionset`
--

DROP TABLE IF EXISTS `product2actionset`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product2actionset` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `actionid` int(11) NOT NULL,
  `productid` int(11) NOT NULL,
  `discount` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_actionid_productid` (`actionid`,`productid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product2actionset`
--

LOCK TABLES `product2actionset` WRITE;
/*!40000 ALTER TABLE `product2actionset` DISABLE KEYS */;
/*!40000 ALTER TABLE `product2actionset` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product2orderedproduct`
--

DROP TABLE IF EXISTS `product2orderedproduct`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product2orderedproduct` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `productid` int(11) NOT NULL,
  `orderedproductid` int(11) NOT NULL,
  `orderedproductcode1c` varchar(255) NOT NULL,
  `productcount` int(11) NOT NULL,
  `deleted` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_productid` (`productid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product2orderedproduct`
--

LOCK TABLES `product2orderedproduct` WRITE;
/*!40000 ALTER TABLE `product2orderedproduct` DISABLE KEYS */;
/*!40000 ALTER TABLE `product2orderedproduct` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product2relatedproduct`
--

DROP TABLE IF EXISTS `product2relatedproduct`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product2relatedproduct` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `productid` int(11) NOT NULL,
  `relatedproductid` int(11) NOT NULL,
  `sync` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_productid` (`productid`,`relatedproductid`),
  KEY `index_sync` (`sync`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product2relatedproduct`
--

LOCK TABLES `product2relatedproduct` WRITE;
/*!40000 ALTER TABLE `product2relatedproduct` DISABLE KEYS */;
/*!40000 ALTER TABLE `product2relatedproduct` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `quiz`
--

DROP TABLE IF EXISTS `quiz`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `quiz` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cdate` datetime NOT NULL,
  `sdate` datetime NOT NULL,
  `edate` datetime NOT NULL,
  `active` tinyint(1) NOT NULL,
  `question` text NOT NULL,
  `type` enum('radio','check') NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sdate` (`sdate`,`edate`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `quiz`
--

LOCK TABLES `quiz` WRITE;
/*!40000 ALTER TABLE `quiz` DISABLE KEYS */;
/*!40000 ALTER TABLE `quiz` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `quizanswer`
--

DROP TABLE IF EXISTS `quizanswer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `quizanswer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quizid` int(11) NOT NULL,
  `answer` text NOT NULL,
  `resultamount` int(11) NOT NULL,
  `resultpercent` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `quizanswer`
--

LOCK TABLES `quizanswer` WRITE;
/*!40000 ALTER TABLE `quizanswer` DISABLE KEYS */;
/*!40000 ALTER TABLE `quizanswer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `quizuseranswer`
--

DROP TABLE IF EXISTS `quizuseranswer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `quizuseranswer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `userip` varchar(15) NOT NULL,
  `quizid` int(11) NOT NULL,
  `answerid` int(11) NOT NULL,
  `cdate` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `quizuseranswer`
--

LOCK TABLES `quizuseranswer` WRITE;
/*!40000 ALTER TABLE `quizuseranswer` DISABLE KEYS */;
/*!40000 ALTER TABLE `quizuseranswer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shocommenttemplate`
--

DROP TABLE IF EXISTS `shocommenttemplate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shocommenttemplate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `text` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shocommenttemplate`
--

LOCK TABLES `shocommenttemplate` WRITE;
/*!40000 ALTER TABLE `shocommenttemplate` DISABLE KEYS */;
/*!40000 ALTER TABLE `shocommenttemplate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shop_user_products_favorite`
--

DROP TABLE IF EXISTS `shop_user_products_favorite`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shop_user_products_favorite` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `productid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_userid` (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shop_user_products_favorite`
--

LOCK TABLES `shop_user_products_favorite` WRITE;
/*!40000 ALTER TABLE `shop_user_products_favorite` DISABLE KEYS */;
/*!40000 ALTER TABLE `shop_user_products_favorite` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopactionset`
--

DROP TABLE IF EXISTS `shopactionset`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopactionset` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `productid` int(11) NOT NULL,
  `discount` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `hidden` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_productid_hidden` (`productid`,`hidden`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopactionset`
--

LOCK TABLES `shopactionset` WRITE;
/*!40000 ALTER TABLE `shopactionset` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopactionset` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopbanner`
--

DROP TABLE IF EXISTS `shopbanner`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopbanner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `url` varchar(100) NOT NULL,
  `hidden` tinyint(1) NOT NULL,
  `place` varchar(255) NOT NULL,
  `categoryid` int(11) NOT NULL,
  `sort` int(11) NOT NULL,
  `comment` text NOT NULL,
  `linkkey` varchar(255) NOT NULL,
  `sdate` datetime NOT NULL,
  `edate` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_hidden` (`hidden`,`sort`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopbanner`
--

LOCK TABLES `shopbanner` WRITE;
/*!40000 ALTER TABLE `shopbanner` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopbanner` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopbannerstatistic`
--

DROP TABLE IF EXISTS `shopbannerstatistic`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopbannerstatistic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bannerid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `sessionid` varchar(32) NOT NULL,
  `ip` varchar(15) NOT NULL,
  `cdate` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopbannerstatistic`
--

LOCK TABLES `shopbannerstatistic` WRITE;
/*!40000 ALTER TABLE `shopbannerstatistic` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopbannerstatistic` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopbasket`
--

DROP TABLE IF EXISTS `shopbasket`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopbasket` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cdate` datetime NOT NULL,
  `sid` varchar(32) NOT NULL,
  `userid` int(11) NOT NULL,
  `productid` int(11) NOT NULL,
  `actionsetid` int(11) NOT NULL,
  `actionsetcount` int(11) NOT NULL,
  `actionsetprice` decimal(15,3) NOT NULL,
  `productcount` decimal(15,3) NOT NULL,
  `productprice` decimal(15,3) NOT NULL,
  `filter1id` int(11) NOT NULL,
  `filter1value` varchar(255) NOT NULL,
  `filter1markup` decimal(15,2) NOT NULL,
  `filter2id` int(11) NOT NULL,
  `filter2value` varchar(255) NOT NULL,
  `filter2markup` decimal(15,2) NOT NULL,
  `filter3id` int(11) NOT NULL,
  `filter3value` varchar(255) NOT NULL,
  `filter3markup` decimal(15,2) NOT NULL,
  `filter4id` int(11) NOT NULL,
  `filter4value` varchar(255) NOT NULL,
  `filter4markup` decimal(15,2) NOT NULL,
  `filter5id` int(11) NOT NULL,
  `filter5value` varchar(255) NOT NULL,
  `filter5markup` decimal(15,2) NOT NULL,
  `filter6id` int(11) NOT NULL,
  `filter6value` varchar(255) NOT NULL,
  `filter6markup` decimal(15,2) NOT NULL,
  `filter7id` int(11) NOT NULL,
  `filter7value` varchar(255) NOT NULL,
  `filter7markup` decimal(15,2) NOT NULL,
  `filter8id` int(11) NOT NULL,
  `filter8value` varchar(255) NOT NULL,
  `filter8markup` decimal(15,2) NOT NULL,
  `filter9id` int(11) NOT NULL,
  `filter9value` varchar(255) NOT NULL,
  `filter9markup` decimal(15,2) NOT NULL,
  `filter10id` int(11) NOT NULL,
  `filter10value` varchar(255) NOT NULL,
  `filter10markup` decimal(15,2) NOT NULL,
  `params` varchar(255) NOT NULL,
  `datefrom` datetime NOT NULL,
  `dateto` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_sid_userid` (`sid`,`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopbasket`
--

LOCK TABLES `shopbasket` WRITE;
/*!40000 ALTER TABLE `shopbasket` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopbasket` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopblock`
--

DROP TABLE IF EXISTS `shopblock`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopblock` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `contentid` varchar(255) NOT NULL,
  `system` tinyint(1) NOT NULL,
  `position` varchar(255) NOT NULL,
  `positionsort` int(11) NOT NULL,
  `linkkey` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_active` (`active`),
  KEY `index_linkkey` (`linkkey`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopblock`
--

LOCK TABLES `shopblock` WRITE;
/*!40000 ALTER TABLE `shopblock` DISABLE KEYS */;
INSERT INTO `shopblock` VALUES (1,'mymanager',1,'block-mymanager',1,'',0,''),(2,'productfilter',1,'block-productfilter',1,'',0,''),(3,'news',1,'block-news',1,'',0,''),(4,'guestbook',1,'block-guestbook',1,'',0,''),(5,'faq',1,'block-faq',1,'',0,''),(6,'facebook',1,'block-facebook',1,'',0,''),(7,'banner-top',1,'block-banner-top',1,'',0,''),(8,'banner-wide',1,'block-banner-wide',1,'',0,''),(9,'banner-top-index',1,'block-banner-top-index',1,'',0,''),(10,'banner-left',1,'block-banner-left',1,'',0,''),(11,'banner-right',1,'block-banner-right',1,'',0,''),(12,'banner-bottom',1,'block-banner-bottom',1,'',0,''),(13,'timework',1,'block-timework',1,'',0,''),(14,'search',1,'block-search',1,'',0,''),(15,'menu-category',1,'block-menu-category',1,'',0,''),(16,'menu-brand',1,'block-menu-brand',1,'',0,''),(17,'menu-textpage',1,'block-menu-textpage',1,'',0,''),(18,'brand-top',1,'block-brand-top',1,'',0,''),(19,'category-top',1,'block-category-top',1,'',0,''),(20,'feedback',1,'block-feedback',1,'',0,''),(21,'callback',1,'block-callback',1,'',0,''),(22,'subscribe',1,'block-subscribe',1,'',0,''),(23,'compare',1,'block-compare',1,'',0,''),(24,'footer-category',1,'block-footer-category',1,'',0,''),(25,'footer-textpage',1,'block-footer-textpage',1,'',0,''),(26,'brand-alphabet',1,'block-brand-alphabet',1,'',0,''),(27,'quiz',1,'block-quiz',0,'',0,'');
/*!40000 ALTER TABLE `shopblock` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopbrand`
--

DROP TABLE IF EXISTS `shopbrand`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopbrand` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `url` varchar(100) NOT NULL,
  `showtype` varchar(255) NOT NULL,
  `siteurl` varchar(255) NOT NULL,
  `top` tinyint(1) NOT NULL,
  `description` text NOT NULL,
  `productcount` int(11) NOT NULL,
  `seodescription` varchar(255) NOT NULL,
  `seotitle` varchar(255) NOT NULL,
  `seoh1` varchar(255) NOT NULL,
  `seocontent` text NOT NULL,
  `seokeywords` varchar(255) NOT NULL,
  `country` varchar(100) NOT NULL,
  `hidden` tinyint(1) NOT NULL,
  `linkkey` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_url` (`url`),
  KEY `index_productcount` (`productcount`),
  KEY `index_name` (`name`),
  KEY `index_linkkey` (`linkkey`),
  KEY `index_hidden` (`hidden`,`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopbrand`
--

LOCK TABLES `shopbrand` WRITE;
/*!40000 ALTER TABLE `shopbrand` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopbrand` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopcache`
--

DROP TABLE IF EXISTS `shopcache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopcache` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cdate` datetime NOT NULL,
  `edate` datetime NOT NULL,
  `key` varchar(255) NOT NULL,
  `data` longtext NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `index_key` (`key`),
  KEY `index_edate` (`edate`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopcache`
--

LOCK TABLES `shopcache` WRITE;
/*!40000 ALTER TABLE `shopcache` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopcache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopcallback`
--

DROP TABLE IF EXISTS `shopcallback`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopcallback` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `cdate` datetime NOT NULL,
  `answer` varchar(255) NOT NULL,
  `done` tinyint(1) NOT NULL,
  `userid` int(11) NOT NULL,
  `comment` text NOT NULL,
  `url` text NOT NULL,
  `linkkey` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_userid` (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopcallback`
--

LOCK TABLES `shopcallback` WRITE;
/*!40000 ALTER TABLE `shopcallback` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopcallback` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopcategory`
--

DROP TABLE IF EXISTS `shopcategory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopcategory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `nameformula` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `imagecrop` varchar(255) NOT NULL,
  `parentid` int(11) NOT NULL,
  `hidden` tinyint(1) NOT NULL,
  `hiddenold` tinyint(1) NOT NULL,
  `sort` int(11) NOT NULL,
  `showtype` varchar(255) NOT NULL,
  `url` varchar(100) NOT NULL,
  `productcount` int(11) NOT NULL,
  `code1c` varchar(255) NOT NULL,
  `codesupplier` varchar(255) NOT NULL,
  `seodescription` varchar(255) NOT NULL,
  `seotitle` varchar(255) NOT NULL,
  `seoh1` varchar(255) NOT NULL,
  `seocontent` text NOT NULL,
  `seokeywords` varchar(255) NOT NULL,
  `subdomain` varchar(100) NOT NULL,
  `sortdefault` varchar(255) NOT NULL,
  `color` varchar(16) NOT NULL,
  `linkkey` varchar(255) NOT NULL,
  `logicclass` varchar(255) NOT NULL,
  `level` int(3) NOT NULL,
  `filter1id` int(11) NOT NULL,
  `filter2id` int(11) NOT NULL,
  `filter3id` int(11) NOT NULL,
  `filter4id` int(11) NOT NULL,
  `filter5id` int(11) NOT NULL,
  `filter6id` int(11) NOT NULL,
  `filter7id` int(11) NOT NULL,
  `filter8id` int(11) NOT NULL,
  `filter9id` int(11) NOT NULL,
  `filter10id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_url` (`url`),
  KEY `index_productcount` (`productcount`),
  KEY `index_parentid` (`parentid`,`hidden`,`sort`,`name`),
  KEY `index_subdomainurl` (`subdomain`,`url`),
  KEY `index_hidden` (`hidden`),
  KEY `index_linkkey` (`linkkey`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopcategory`
--

LOCK TABLES `shopcategory` WRITE;
/*!40000 ALTER TABLE `shopcategory` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopcategory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopcompare`
--

DROP TABLE IF EXISTS `shopcompare`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopcompare` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cdate` datetime NOT NULL,
  `sid` varchar(32) NOT NULL,
  `productid` int(11) NOT NULL,
  `categoryid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_sid` (`sid`),
  KEY `index_cdate` (`cdate`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopcompare`
--

LOCK TABLES `shopcompare` WRITE;
/*!40000 ALTER TABLE `shopcompare` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopcompare` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopcontractor`
--

DROP TABLE IF EXISTS `shopcontractor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopcontractor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `details` text NOT NULL,
  `tax` float NOT NULL,
  `active` tinyint(1) NOT NULL,
  `default` tinyint(1) NOT NULL,
  `linkkey` varchar(255) NOT NULL,
  `customfield1` text NOT NULL,
  `customfield2` text NOT NULL,
  `customfield3` text NOT NULL,
  `customfield4` text NOT NULL,
  `customfield5` text NOT NULL,
  `customfield6` text NOT NULL,
  `customfield7` text NOT NULL,
  `customfield8` text NOT NULL,
  `customfield9` text NOT NULL,
  `customfield10` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopcontractor`
--

LOCK TABLES `shopcontractor` WRITE;
/*!40000 ALTER TABLE `shopcontractor` DISABLE KEYS */;
INSERT INTO `shopcontractor` VALUES (1,'Юридическое лицо','',0,1,0,'','','','','','','','','','','');
/*!40000 ALTER TABLE `shopcontractor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopcoupon`
--

DROP TABLE IF EXISTS `shopcoupon`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopcoupon` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) NOT NULL,
  `dateused` datetime NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `currencyid` int(11) NOT NULL,
  `orderid` int(11) NOT NULL,
  `comment` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopcoupon`
--

LOCK TABLES `shopcoupon` WRITE;
/*!40000 ALTER TABLE `shopcoupon` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopcoupon` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopcurrency`
--

DROP TABLE IF EXISTS `shopcurrency`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopcurrency` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `symbol` varchar(32) NOT NULL,
  `rate` float NOT NULL,
  `default` tinyint(1) NOT NULL,
  `hidden` tinyint(1) NOT NULL,
  `sort` int(11) NOT NULL,
  `logicclass` varchar(255) NOT NULL,
  `percent` decimal(15,3) NOT NULL,
  `linkkey` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_default` (`default`),
  KEY `index_linkkey` (`linkkey`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopcurrency`
--

LOCK TABLES `shopcurrency` WRITE;
/*!40000 ALTER TABLE `shopcurrency` DISABLE KEYS */;
INSERT INTO `shopcurrency` VALUES (1,'UAH','грн.',1,1,0,0,'',0.000,''),(2,'USD','$',8.78,0,0,1,'',0.000,''),(3,'RUB','р.',0.25,0,0,2,'',0.000,''),(4,'EUR','€',12,0,0,3,'',0.000,'');
/*!40000 ALTER TABLE `shopcurrency` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopcustomfield`
--

DROP TABLE IF EXISTS `shopcustomfield`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopcustomfield` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `objecttype` varchar(255) NOT NULL,
  `objectid` int(11) NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_objectid` (`objectid`),
  KEY `index_key` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopcustomfield`
--

LOCK TABLES `shopcustomfield` WRITE;
/*!40000 ALTER TABLE `shopcustomfield` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopcustomfield` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopdelivery`
--

DROP TABLE IF EXISTS `shopdelivery`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopdelivery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `price` decimal(15,2) NOT NULL,
  `currencyid` int(11) NOT NULL,
  `sort` int(11) NOT NULL,
  `default` tinyint(1) NOT NULL,
  `needcity` tinyint(1) NOT NULL,
  `needaddress` tinyint(1) NOT NULL,
  `needcountry` tinyint(1) NOT NULL,
  `paydelivery` tinyint(1) NOT NULL,
  `logicclass` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopdelivery`
--

LOCK TABLES `shopdelivery` WRITE;
/*!40000 ALTER TABLE `shopdelivery` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopdelivery` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopdiscount`
--

DROP TABLE IF EXISTS `shopdiscount`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopdiscount` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `value` decimal(15,2) NOT NULL,
  `type` enum('percent','value') NOT NULL,
  `minstartsum` int(11) NOT NULL,
  `currencyid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopdiscount`
--

LOCK TABLES `shopdiscount` WRITE;
/*!40000 ALTER TABLE `shopdiscount` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopdiscount` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopdocument`
--

DROP TABLE IF EXISTS `shopdocument`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopdocument` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `number` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `contractorid` int(11) NOT NULL,
  `templateid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `linkkey` varchar(255) NOT NULL,
  `cdate` datetime NOT NULL,
  `edate` datetime NOT NULL,
  `sdate` datetime NOT NULL,
  `bdate` datetime NOT NULL,
  `adate` datetime NOT NULL,
  `fileoriginal` varchar(255) NOT NULL,
  `file` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `deleted` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_contractorid` (`contractorid`),
  KEY `index_templateid` (`templateid`),
  KEY `index_userid` (`userid`),
  KEY `index_linkkey` (`linkkey`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopdocument`
--

LOCK TABLES `shopdocument` WRITE;
/*!40000 ALTER TABLE `shopdocument` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopdocument` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopdocumentfieldvalue`
--

DROP TABLE IF EXISTS `shopdocumentfieldvalue`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopdocumentfieldvalue` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `documentid` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_documentid` (`documentid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopdocumentfieldvalue`
--

LOCK TABLES `shopdocumentfieldvalue` WRITE;
/*!40000 ALTER TABLE `shopdocumentfieldvalue` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopdocumentfieldvalue` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopdocumenttemplate`
--

DROP TABLE IF EXISTS `shopdocumenttemplate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopdocumenttemplate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `groupname` varchar(255) NOT NULL,
  `direction` enum('in','out','our') NOT NULL,
  `content` text NOT NULL,
  `hidden` tinyint(1) NOT NULL,
  `required` tinyint(1) NOT NULL,
  `period` int(11) NOT NULL,
  `sort` int(11) NOT NULL,
  `numberprocessor` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_sort` (`sort`,`name`),
  KEY `index_groupname` (`groupname`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopdocumenttemplate`
--

LOCK TABLES `shopdocumenttemplate` WRITE;
/*!40000 ALTER TABLE `shopdocumenttemplate` DISABLE KEYS */;
INSERT INTO `shopdocumenttemplate` VALUES (1,'order-act-ukr','Акт выполненных работ (UA)','ShopOrder','','','file:/modules/document/media/shop-document-akt-ukr.html',0,0,0,0,''),(2,'invoice-ukr','Счет-фактура (UA)','ShopOrder','','','file:/modules/document/media/shop-document-invoice-ukr.html',0,0,0,0,''),(3,'salebill-ukr','Накладная заказа (UA)','ShopOrder','','','file:/modules/document/media/shop-document-salebill-ukr.html',0,0,0,0,''),(4,'order-act-ru','Акт выполненных работ (RU)','ShopOrder','','','file:/modules/document/media/shop-document-akt-ru.html',0,0,0,0,''),(5,'invoice-ru','Счет-фактура (RU)','ShopOrder','','','file:/modules/document/media/shop-document-invoice-ru.html',0,0,0,0,''),(6,'salebill-ru','Накладная заказа (RU)','ShopOrder','','','file:/modules/document/media/shop-document-salebill-ru.html',0,0,0,0,''),(7,'order-act-eng','Акт выполненных работ (EN)','ShopOrder','','','file:/modules/document/media/shop-document-akt-eng.html',0,0,0,0,''),(8,'invoice-eng','Счет-фактура (EN)','ShopOrder','','','file:/modules/document/media/shop-document-invoice-eng.html',0,0,0,0,''),(9,'salebill-eng','Накладная заказа (EN)','ShopOrder','','','file:/modules/document/media/shop-document-salebill-eng.html',0,0,0,0,''),(10,'barcodes-internal-ukr','Штрих-коды внутренние (UA)','ShopProduct','','','file:/modules/storage/media/shop-document-barcodes-internal-ukr.html',0,0,0,0,''),(11,'barcodes-external-ukr','Штрих-коды внешние (UA)','ShopProduct','','','file:/modules/storage/media/shop-document-barcodes-external-ukr.html',0,0,0,0,''),(12,'storage-salebill-ukr','Накладная заказа (UA)','ShopStorageOrder','','','file:/modules/storage/media/shop-document-salebill-ukr.html',0,0,0,0,''),(13,'storage-transaction-ukr','Перемещение (UA)','ShopStorageTransaction','','','file:/modules/storage/media/shop-document-transfer-ukr.html',0,0,0,0,''),(14,'barcodes-internal-ru','Штрих-коды внутренние (RU)','ShopProduct','','','file:/modules/storage/media/shop-document-barcodes-internal-ru.html',0,0,0,0,''),(15,'barcodes-external-ru','Штрих-коды внешние (RU)','ShopProduct','','','file:/modules/storage/media/shop-document-barcodes-external-ru.html',0,0,0,0,''),(16,'storage-salebill-ru','Накладная заказа (RU)','ShopStorageOrder','','','file:/modules/storage/media/shop-document-salebill-ru.html',0,0,0,0,''),(17,'storage-transaction-ru','Перемещение (RU)','ShopStorageTransaction','','','file:/modules/storage/media/shop-document-transfer-ru.html',0,0,0,0,''),(18,'barcodes-internal-eng','Штрих-коды внутренние (EN)','ShopProduct','','','file:/modules/storage/media/shop-document-barcodes-internal-eng.html',0,0,0,0,''),(19,'barcodes-external-eng','Штрих-коды внешние (EN)','ShopProduct','','','file:/modules/storage/media/shop-document-barcodes-external-eng.html',0,0,0,0,''),(20,'storage-salebill-eng','Накладная заказа (EN)','ShopStorageOrder','','','file:/modules/storage/media/shop-document-salebill-eng.html',0,0,0,0,''),(21,'storage-transaction-eng','Перемещение (EN)','ShopStorageTransaction','','','file:/modules/storage/media/shop-document-transfer-eng.html',0,0,0,0,'');
/*!40000 ALTER TABLE `shopdocumenttemplate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopdownloadurl`
--

DROP TABLE IF EXISTS `shopdownloadurl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopdownloadurl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file` varchar(255) NOT NULL,
  `hash` varchar(255) NOT NULL,
  `linkkey` varchar(255) NOT NULL,
  `cdate` datetime NOT NULL,
  `edate` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_linkkey` (`linkkey`),
  KEY `index_hash` (`hash`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopdownloadurl`
--

LOCK TABLES `shopdownloadurl` WRITE;
/*!40000 ALTER TABLE `shopdownloadurl` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopdownloadurl` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopevent`
--

DROP TABLE IF EXISTS `shopevent`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopevent` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` enum('call','sms','email','meeting','skype','jabber','whatsapp') NOT NULL,
  `cdate` datetime NOT NULL,
  `session` varchar(255) NOT NULL,
  `from` varchar(255) NOT NULL,
  `to` varchar(255) NOT NULL,
  `channel` varchar(255) NOT NULL,
  `sourceid` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `subjectgroup` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `file` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `duration` int(11) NOT NULL,
  `status` varchar(16) NOT NULL,
  `hidden` tinyint(1) NOT NULL,
  `hash` varchar(32) NOT NULL,
  `direction` int(2) NOT NULL,
  `replyid` int(11) NOT NULL,
  `replydate` datetime NOT NULL,
  `rating` int(3) NOT NULL,
  `fromuserid` int(11) NOT NULL,
  `touserid` int(11) NOT NULL,
  `mailbox` varchar(32) NOT NULL,
  `comment` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_cdate` (`cdate`),
  KEY `index_type` (`type`),
  KEY `index_from` (`from`,`to`,`cdate`),
  KEY `index_to` (`to`,`from`,`cdate`),
  KEY `index_subject` (`subject`,`cdate`),
  KEY `index_touserid` (`touserid`,`fromuserid`,`cdate`),
  KEY `index_fromuserid` (`fromuserid`,`touserid`,`cdate`),
  KEY `index_subjectgroup` (`subjectgroup`,`type`,`cdate`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopevent`
--

LOCK TABLES `shopevent` WRITE;
/*!40000 ALTER TABLE `shopevent` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopevent` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopeventattachment`
--

DROP TABLE IF EXISTS `shopeventattachment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopeventattachment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `eventid` int(11) NOT NULL,
  `file` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `contenttype` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_eventid` (`eventid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopeventattachment`
--

LOCK TABLES `shopeventattachment` WRITE;
/*!40000 ALTER TABLE `shopeventattachment` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopeventattachment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopeventemailuid`
--

DROP TABLE IF EXISTS `shopeventemailuid`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopeventemailuid` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `imap` varchar(255) NOT NULL,
  `uid` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopeventemailuid`
--

LOCK TABLES `shopeventemailuid` WRITE;
/*!40000 ALTER TABLE `shopeventemailuid` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopeventemailuid` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopeventignore`
--

DROP TABLE IF EXISTS `shopeventignore`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopeventignore` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `address` varchar(64) NOT NULL,
  `spam` tinyint(1) NOT NULL,
  `notify` tinyint(1) NOT NULL,
  `unknown` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopeventignore`
--

LOCK TABLES `shopeventignore` WRITE;
/*!40000 ALTER TABLE `shopeventignore` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopeventignore` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopexport`
--

DROP TABLE IF EXISTS `shopexport`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopexport` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cdate` datetime NOT NULL,
  `pdate` datetime NOT NULL,
  `userid` int(11) NOT NULL,
  `categoryid` int(11) NOT NULL,
  `comment` text NOT NULL,
  `emails` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_pdate` (`pdate`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopexport`
--

LOCK TABLES `shopexport` WRITE;
/*!40000 ALTER TABLE `shopexport` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopexport` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopexportcontacts`
--

DROP TABLE IF EXISTS `shopexportcontacts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopexportcontacts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cdate` datetime NOT NULL,
  `pdate` datetime NOT NULL,
  `userid` int(11) NOT NULL,
  `companyname` varchar(255) NOT NULL,
  `groupid` int(11) NOT NULL,
  `comment` text NOT NULL,
  `emails` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_pdate` (`pdate`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopexportcontacts`
--

LOCK TABLES `shopexportcontacts` WRITE;
/*!40000 ALTER TABLE `shopexportcontacts` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopexportcontacts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopexporttask`
--

DROP TABLE IF EXISTS `shopexporttask`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopexporttask` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cdate` datetime NOT NULL,
  `pdate` datetime NOT NULL,
  `userid` int(11) NOT NULL,
  `comment` text NOT NULL,
  `emails` text NOT NULL,
  `exportclassname` varchar(255) NOT NULL,
  `excludefields` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_pdate` (`pdate`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopexporttask`
--

LOCK TABLES `shopexporttask` WRITE;
/*!40000 ALTER TABLE `shopexporttask` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopexporttask` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopfaq`
--

DROP TABLE IF EXISTS `shopfaq`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopfaq` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question` varchar(1000) NOT NULL,
  `answer` varchar(2000) NOT NULL,
  `cdate` datetime NOT NULL,
  `userid` varchar(255) NOT NULL,
  `linkkey` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `1` (`question`(255),`answer`(255)),
  KEY `index_linkkey` (`linkkey`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopfaq`
--

LOCK TABLES `shopfaq` WRITE;
/*!40000 ALTER TABLE `shopfaq` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopfaq` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopfeedback`
--

DROP TABLE IF EXISTS `shopfeedback`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopfeedback` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `cdate` datetime NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` varchar(255) NOT NULL,
  `done` tinyint(1) NOT NULL,
  `userid` int(11) NOT NULL,
  `pageurl` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_userid` (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopfeedback`
--

LOCK TABLES `shopfeedback` WRITE;
/*!40000 ALTER TABLE `shopfeedback` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopfeedback` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopfile`
--

DROP TABLE IF EXISTS `shopfile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopfile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `file` varchar(255) NOT NULL,
  `contenttype` varchar(255) NOT NULL,
  `cdate` datetime NOT NULL,
  `userid` int(11) NOT NULL,
  `deleted` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_keydeleted` (`key`,`deleted`,`cdate`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopfile`
--

LOCK TABLES `shopfile` WRITE;
/*!40000 ALTER TABLE `shopfile` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopfile` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopgallery`
--

DROP TABLE IF EXISTS `shopgallery`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopgallery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cdate` datetime NOT NULL,
  `hidden` tinyint(1) NOT NULL,
  `name` varchar(255) NOT NULL,
  `sort` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `url` varchar(255) NOT NULL,
  `album` varchar(255) NOT NULL,
  `seodescription` varchar(255) NOT NULL,
  `seotitle` varchar(255) NOT NULL,
  `seocontent` text NOT NULL,
  `seoh1` varchar(255) NOT NULL,
  `seokeywords` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_url` (`url`),
  KEY `index_hidden` (`hidden`,`cdate`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopgallery`
--

LOCK TABLES `shopgallery` WRITE;
/*!40000 ALTER TABLE `shopgallery` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopgallery` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopguestbook`
--

DROP TABLE IF EXISTS `shopguestbook`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopguestbook` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `cdate` datetime NOT NULL,
  `text` text NOT NULL,
  `done` tinyint(1) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `linkkey` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopguestbook`
--

LOCK TABLES `shopguestbook` WRITE;
/*!40000 ALTER TABLE `shopguestbook` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopguestbook` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shophistory`
--

DROP TABLE IF EXISTS `shophistory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shophistory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `cdate` datetime NOT NULL,
  `url` varchar(255) NOT NULL,
  `ip` varchar(16) NOT NULL,
  `post` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shophistory`
--

LOCK TABLES `shophistory` WRITE;
/*!40000 ALTER TABLE `shophistory` DISABLE KEYS */;
/*!40000 ALTER TABLE `shophistory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopimage`
--

DROP TABLE IF EXISTS `shopimage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopimage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `productid` int(11) NOT NULL,
  `file` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_productid` (`productid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopimage`
--

LOCK TABLES `shopimage` WRITE;
/*!40000 ALTER TABLE `shopimage` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopimage` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopimport`
--

DROP TABLE IF EXISTS `shopimport`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopimport` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cdate` datetime NOT NULL,
  `pdate` datetime NOT NULL,
  `userid` int(11) NOT NULL,
  `file` varchar(255) NOT NULL,
  `comment` text NOT NULL,
  `trycnt` int(3) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_pdate` (`pdate`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopimport`
--

LOCK TABLES `shopimport` WRITE;
/*!40000 ALTER TABLE `shopimport` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopimport` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopimportcontacts`
--

DROP TABLE IF EXISTS `shopimportcontacts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopimportcontacts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cdate` datetime NOT NULL,
  `pdate` datetime NOT NULL,
  `userid` int(11) NOT NULL,
  `file` varchar(255) NOT NULL,
  `comment` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_pdate` (`pdate`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopimportcontacts`
--

LOCK TABLES `shopimportcontacts` WRITE;
/*!40000 ALTER TABLE `shopimportcontacts` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopimportcontacts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopimporttask`
--

DROP TABLE IF EXISTS `shopimporttask`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopimporttask` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cdate` datetime NOT NULL,
  `pdate` datetime NOT NULL,
  `userid` int(11) NOT NULL,
  `file` varchar(255) NOT NULL,
  `comment` text NOT NULL,
  `importtclassname` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_pdate` (`pdate`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopimporttask`
--

LOCK TABLES `shopimporttask` WRITE;
/*!40000 ALTER TABLE `shopimporttask` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopimporttask` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopkpi`
--

DROP TABLE IF EXISTS `shopkpi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopkpi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `logicclass` varchar(255) NOT NULL,
  `logicclassparam` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopkpi`
--

LOCK TABLES `shopkpi` WRITE;
/*!40000 ALTER TABLE `shopkpi` DISABLE KEYS */;
INSERT INTO `shopkpi` VALUES (1,'Количество звонков за день','BoxKPI_CallDay',''),(2,'Количество входящих звонков за день','BoxKPI_CallDay','1'),(3,'Количество исходящих звонков за день','BoxKPI_CallDay','-1'),(4,'Количество звонков за месяц','BoxKPI_CallMonth',''),(5,'Количество входящих звонков за месяц','BoxKPI_CallMonth','1'),(6,'Количество исходящих звонков за месяц','BoxKPI_CallMonth','-1'),(7,'Количество email за день','BoxKPI_EmailDay',''),(8,'Количество входящих email за день','BoxKPI_EmailDay','1'),(9,'Количество исходящих email за день','BoxKPI_EmailDay','-1'),(10,'Количество email за месяц','BoxKPI_EmailMonth',''),(11,'Количество входящих email за месяц','BoxKPI_EmailMonth','1'),(12,'Количество исходящих email за месяц','BoxKPI_EmailMonth','-1'),(13,'Количество активных задач на сотруднике (всего)','BoxKPI_IssueActive',''),(14,'Количество активных задач на сотруднике на день','BoxKPI_IssueActiveDay',''),(15,'Количество активных задач на сотруднике на месяц','BoxKPI_IssueActiveMonth',''),(16,'Количество закрытых задач на сотруднике за день','BoxKPI_IssueDoneDay',''),(17,'Количество закрытых задач на сотруднике за месяц','BoxKPI_IssueDoneMonth',''),(18,'Количество просроченных задач на сотруднике (всего)','BoxKPI_IssueHot',''),(19,'Количество активных заказов на сотруднике (всего)','BoxKPI_OrderActive',''),(20,'Количество активных проектов на сотруднике (всего)','BoxKPI_ProjectActive',''),(21,'Проданный продукт (количество) сотрудником за месяц','BoxKPI_OrderSaleProductCountMonth',''),(22,'Проданный продукт (сумма) сотрудником за месяц','BoxKPI_OrderSaleProductSumMonth',''),(23,'Проданный продукт (маржа) сотрудником за месяц','BoxKPI_OrderSaleProductMarginMonth',''),(24,'Проданный бренд (количество продуктов) сотрудником за месяц','BoxKPI_OrderSaleBrandCountMonth',''),(25,'Проданный бренды (сумма продуктов) сотрудником за месяц','BoxKPI_OrderSaleBrandSumMonth',''),(26,'Проданный бренды (маржа продуктов) сотрудником за месяц','BoxKPI_OrderSaleBrandMarginMonth',''),(27,'Проданная категория (количество продуктов) сотрудником за месяц','BoxKPI_OrderSaleCategoryCountMonth',''),(28,'Проданная категория (сумма продуктов) сотрудником за месяц','BoxKPI_OrderSaleCategorySumMonth',''),(29,'Проданная категория (маржа продуктов) сотрудником за месяц','BoxKPI_OrderSaleCategoryMarginMonth','');
/*!40000 ALTER TABLE `shopkpi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopkpiuser`
--

DROP TABLE IF EXISTS `shopkpiuser`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopkpiuser` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kpiid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `cdate` datetime NOT NULL,
  `value` float NOT NULL,
  `valueplan` float NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_userkpi` (`userid`,`kpiid`,`cdate`),
  KEY `index_kpi` (`kpiid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopkpiuser`
--

LOCK TABLES `shopkpiuser` WRITE;
/*!40000 ALTER TABLE `shopkpiuser` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopkpiuser` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shoplogo`
--

DROP TABLE IF EXISTS `shoplogo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shoplogo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sdate` datetime NOT NULL,
  `edate` datetime NOT NULL,
  `name` varchar(255) NOT NULL,
  `file` varchar(255) NOT NULL,
  `default` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_dates` (`sdate`,`edate`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shoplogo`
--

LOCK TABLES `shoplogo` WRITE;
/*!40000 ALTER TABLE `shoplogo` DISABLE KEYS */;
INSERT INTO `shoplogo` VALUES (1,'0000-00-00 00:00:00','0000-00-00 00:00:00','Default logo','logo.png',1);
/*!40000 ALTER TABLE `shoplogo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopmarginrule`
--

DROP TABLE IF EXISTS `shopmarginrule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopmarginrule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `pricefrom` decimal(15,2) NOT NULL,
  `priceto` decimal(15,2) NOT NULL,
  `value` decimal(15,2) NOT NULL,
  `type` enum('percent','sum') NOT NULL,
  `currencyid` int(11) NOT NULL,
  `supplierid` int(11) NOT NULL,
  `priority` int(3) NOT NULL,
  `brandid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopmarginrule`
--

LOCK TABLES `shopmarginrule` WRITE;
/*!40000 ALTER TABLE `shopmarginrule` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopmarginrule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopmarginrulelink`
--

DROP TABLE IF EXISTS `shopmarginrulelink`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopmarginrulelink` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `marginruleid` int(11) NOT NULL,
  `objecttype` varchar(255) NOT NULL,
  `objectid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_objectid` (`objectid`),
  KEY `index_objecttype` (`objecttype`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopmarginrulelink`
--

LOCK TABLES `shopmarginrulelink` WRITE;
/*!40000 ALTER TABLE `shopmarginrulelink` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopmarginrulelink` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopnews`
--

DROP TABLE IF EXISTS `shopnews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopnews` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cdate` datetime NOT NULL,
  `hidden` tinyint(1) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `contentpreview` text NOT NULL,
  `content` longtext NOT NULL,
  `productid` int(11) NOT NULL,
  `categoryid` int(11) NOT NULL,
  `brandid` int(11) NOT NULL,
  `url` varchar(255) NOT NULL,
  `seodescription` varchar(255) NOT NULL,
  `seotitle` varchar(255) NOT NULL,
  `seoh1` varchar(255) NOT NULL,
  `seocontent` text NOT NULL,
  `seokeywords` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_productid` (`productid`),
  KEY `index_hidden` (`hidden`,`cdate`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopnews`
--

LOCK TABLES `shopnews` WRITE;
/*!40000 ALTER TABLE `shopnews` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopnews` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopnotification`
--

DROP TABLE IF EXISTS `shopnotification`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopnotification` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `commentid` int(11) NOT NULL,
  `orderid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_userid` (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopnotification`
--

LOCK TABLES `shopnotification` WRITE;
/*!40000 ALTER TABLE `shopnotification` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopnotification` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shoporder`
--

DROP TABLE IF EXISTS `shoporder`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shoporder` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `number` varchar(32) NOT NULL,
  `name` varchar(255) NOT NULL,
  `userid` int(11) NOT NULL,
  `clientmanagerid` int(11) NOT NULL,
  `managerid` int(11) NOT NULL,
  `authorid` int(11) NOT NULL,
  `cdate` datetime NOT NULL,
  `udate` datetime NOT NULL,
  `uuserid` int(11) NOT NULL,
  `dateto` datetime NOT NULL,
  `statusid` int(11) NOT NULL,
  `categoryid` int(11) NOT NULL,
  `clientname` varchar(255) NOT NULL,
  `clientemail` varchar(255) NOT NULL,
  `clientphone` varchar(255) NOT NULL,
  `clientaddress` varchar(255) NOT NULL,
  `clientcontacts` text NOT NULL,
  `comments` text NOT NULL,
  `sum` decimal(15,2) NOT NULL,
  `currencyid` int(11) NOT NULL,
  `deliveryid` int(11) NOT NULL,
  `deliveryprice` decimal(15,2) NOT NULL,
  `paymentid` int(11) NOT NULL,
  `discountid` int(11) NOT NULL,
  `discountsum` decimal(15,2) NOT NULL,
  `hash` varchar(32) NOT NULL,
  `contractorid` int(11) NOT NULL,
  `deliverynote` text NOT NULL,
  `sumpaid` decimal(15,2) NOT NULL,
  `dateshipped` datetime NOT NULL,
  `dateclosed` datetime NOT NULL,
  `isshipped` tinyint(1) NOT NULL,
  `sourceid` int(11) NOT NULL,
  `issue` tinyint(1) NOT NULL,
  `outcoming` tinyint(1) NOT NULL,
  `parentid` int(11) NOT NULL,
  `parentstatusid` int(11) NOT NULL,
  `resource` text NOT NULL,
  `estimate` decimal(15,2) NOT NULL,
  `money` decimal(15,2) NOT NULL,
  `sumbase` decimal(15,2) NOT NULL,
  `linkkey` varchar(255) NOT NULL,
  `ip` varchar(15) NOT NULL,
  `forgift` tinyint(1) NOT NULL,
  `nextid` int(11) NOT NULL,
  `previd` int(11) NOT NULL,
  `send_mail_comment` tinyint(1) NOT NULL,
  `priority` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `deleted` tinyint(1) NOT NULL,
  `novaposhtastatus` varchar(255) NOT NULL,
  `utm_source` varchar(255) NOT NULL,
  `utm_medium` varchar(255) NOT NULL,
  `utm_campaign` varchar(255) NOT NULL,
  `utm_content` varchar(255) NOT NULL,
  `utm_term` varchar(255) NOT NULL,
  `utm_date` datetime NOT NULL,
  `utm_referrer` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_useridcdate` (`userid`,`cdate`),
  KEY `index_udate` (`cdate`),
  KEY `index_deleted` (`deleted`),
  KEY `index_parentstatus` (`parentid`,`parentstatusid`),
  KEY `index_type` (`type`),
  KEY `index_statusid` (`statusid`),
  KEY `index_managerid` (`managerid`),
  KEY `index_dateclosed` (`dateclosed`),
  KEY `index_priority` (`priority`),
  KEY `index_categoryid` (`categoryid`),
  KEY `index_linkkey` (`linkkey`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shoporder`
--

LOCK TABLES `shoporder` WRITE;
/*!40000 ALTER TABLE `shoporder` DISABLE KEYS */;
/*!40000 ALTER TABLE `shoporder` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopordercategory`
--

DROP TABLE IF EXISTS `shopordercategory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopordercategory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `issue` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `currencyid` int(11) NOT NULL,
  `productsDefault` varchar(255) NOT NULL,
  `default` tinyint(1) NOT NULL,
  `hidden` tinyint(1) NOT NULL,
  `noautodateto` tinyint(1) NOT NULL,
  `term` int(11) NOT NULL,
  `issuename` varchar(255) NOT NULL,
  `projectid` int(11) NOT NULL,
  `managerid` int(11) NOT NULL,
  `outcoming` tinyint(1) NOT NULL,
  `keywords` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_hiddenname` (`hidden`,`name`),
  KEY `index_name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopordercategory`
--

LOCK TABLES `shopordercategory` WRITE;
/*!40000 ALTER TABLE `shopordercategory` DISABLE KEYS */;
INSERT INTO `shopordercategory` VALUES (1,'Новый Заказ',0,'order',0,'',1,0,0,0,'',0,0,0,'');
/*!40000 ALTER TABLE `shopordercategory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shoporderchange`
--

DROP TABLE IF EXISTS `shoporderchange`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shoporderchange` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `orderid` int(11) NOT NULL,
  `cdate` datetime NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  `userid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shoporderchange`
--

LOCK TABLES `shoporderchange` WRITE;
/*!40000 ALTER TABLE `shoporderchange` DISABLE KEYS */;
/*!40000 ALTER TABLE `shoporderchange` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopordercontacts`
--

DROP TABLE IF EXISTS `shopordercontacts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopordercontacts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `orderid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `comment` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_orderuser` (`orderid`,`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopordercontacts`
--

LOCK TABLES `shopordercontacts` WRITE;
/*!40000 ALTER TABLE `shopordercontacts` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopordercontacts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shoporderemployer`
--

DROP TABLE IF EXISTS `shoporderemployer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shoporderemployer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `orderid` int(11) NOT NULL,
  `managerid` int(11) NOT NULL,
  `statusid` int(11) NOT NULL,
  `role` varchar(255) NOT NULL,
  `sum` decimal(15,2) NOT NULL,
  `percent` decimal(15,2) NOT NULL,
  `term` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_ordermanager` (`orderid`,`managerid`),
  KEY `index_managerterm` (`managerid`,`term`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shoporderemployer`
--

LOCK TABLES `shoporderemployer` WRITE;
/*!40000 ALTER TABLE `shoporderemployer` DISABLE KEYS */;
/*!40000 ALTER TABLE `shoporderemployer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shoporderlogview`
--

DROP TABLE IF EXISTS `shoporderlogview`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shoporderlogview` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `orderid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `cdate` datetime NOT NULL,
  `last` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_orderuser` (`orderid`,`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shoporderlogview`
--

LOCK TABLES `shoporderlogview` WRITE;
/*!40000 ALTER TABLE `shoporderlogview` DISABLE KEYS */;
/*!40000 ALTER TABLE `shoporderlogview` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shoporderproduct`
--

DROP TABLE IF EXISTS `shoporderproduct`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shoporderproduct` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `orderid` int(11) NOT NULL,
  `productid` int(11) NOT NULL,
  `productcount` decimal(15,3) NOT NULL,
  `productname` varchar(255) NOT NULL,
  `productprice` decimal(15,2) NOT NULL,
  `producttax` tinyint(1) NOT NULL,
  `currencyid` int(11) NOT NULL,
  `serial` varchar(255) NOT NULL,
  `warranty` varchar(255) NOT NULL,
  `categoryname` varchar(255) NOT NULL,
  `comment` text NOT NULL,
  `statusid` int(11) NOT NULL,
  `storageid` int(11) NOT NULL,
  `supplierid` int(11) NOT NULL,
  `params` varchar(255) NOT NULL,
  `datefrom` datetime NOT NULL,
  `dateto` datetime NOT NULL,
  `linkkey` varchar(255) NOT NULL,
  `sortable` int(11) NOT NULL,
  `sync` tinyint(1) NOT NULL,
  `startprice` decimal(15,2) NOT NULL,
  `storageincomingid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_orderid` (`orderid`),
  KEY `index_productid` (`productid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shoporderproduct`
--

LOCK TABLES `shoporderproduct` WRITE;
/*!40000 ALTER TABLE `shoporderproduct` DISABLE KEYS */;
/*!40000 ALTER TABLE `shoporderproduct` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shoporderproductstatus`
--

DROP TABLE IF EXISTS `shoporderproductstatus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shoporderproductstatus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `sort` int(11) NOT NULL,
  `linkkey` varchar(255) NOT NULL,
  `logicclass` varchar(255) NOT NULL,
  `logicclassparams` varchar(255) NOT NULL,
  `logicclasscron` varchar(255) NOT NULL,
  `logicclasscronparams` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_sort` (`sort`),
  KEY `index_linkkey` (`linkkey`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shoporderproductstatus`
--

LOCK TABLES `shoporderproductstatus` WRITE;
/*!40000 ALTER TABLE `shoporderproductstatus` DISABLE KEYS */;
/*!40000 ALTER TABLE `shoporderproductstatus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shoporderstatus`
--

DROP TABLE IF EXISTS `shoporderstatus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shoporderstatus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `messageadmin` text NOT NULL,
  `sms` text NOT NULL,
  `smsadmin` text NOT NULL,
  `smslogicclass` varchar(255) NOT NULL,
  `default` tinyint(1) NOT NULL,
  `payed` tinyint(1) NOT NULL,
  `saled` tinyint(1) NOT NULL,
  `downloadable` tinyint(1) NOT NULL,
  `sort` int(11) NOT NULL,
  `priority` int(11) NOT NULL,
  `linkkey` varchar(255) NOT NULL,
  `categoryid` int(11) NOT NULL,
  `content` text NOT NULL,
  `x` int(11) NOT NULL,
  `y` int(11) NOT NULL,
  `width` int(11) NOT NULL,
  `height` int(11) NOT NULL,
  `colour` varchar(7) NOT NULL,
  `term` int(11) NOT NULL,
  `termperiod` enum('hour','day','week','month','year') NOT NULL,
  `processor` varchar(255) NOT NULL,
  `processorform` varchar(255) NOT NULL,
  `roleid` int(11) NOT NULL,
  `managerid` int(11) NOT NULL,
  `cnt` int(11) NOT NULL,
  `cntlast` int(11) NOT NULL,
  `smart` varchar(255) NOT NULL,
  `onlyauto` tinyint(1) NOT NULL,
  `onlyissue` tinyint(1) NOT NULL,
  `jumpmanager` tinyint(1) NOT NULL,
  `prepayed` tinyint(1) NOT NULL,
  `notifysmsclient` tinyint(1) NOT NULL,
  `notifysmsadmin` tinyint(1) NOT NULL,
  `notifysmsmanager` tinyint(1) NOT NULL,
  `notifyemailclient` tinyint(1) NOT NULL,
  `notifyemailadmin` tinyint(1) NOT NULL,
  `notifyemailmanager` tinyint(1) NOT NULL,
  `needcontent` tinyint(1) NOT NULL,
  `needdocument` tinyint(1) NOT NULL,
  `closed` tinyint(1) NOT NULL,
  `done` tinyint(1) NOT NULL,
  `shipped` tinyint(1) NOT NULL,
  `cancelOrderSupplier` tinyint(1) NOT NULL,
  `createOrderSupplier` tinyint(1) NOT NULL,
  `createXml` tinyint(1) NOT NULL,
  `createCsv` tinyint(1) NOT NULL,
  `autorepeat` tinyint(1) NOT NULL,
  `nextworkflowid` int(11) NOT NULL,
  `nextstatusid` int(11) NOT NULL,
  `subworkflow1` int(11) NOT NULL,
  `subworkflow1name` varchar(255) NOT NULL,
  `subworkflow1date` int(3) NOT NULL,
  `subworkflow1description` text NOT NULL,
  `subworkflow2` int(11) NOT NULL,
  `subworkflow2name` varchar(255) NOT NULL,
  `subworkflow2date` int(3) NOT NULL,
  `subworkflow2description` text NOT NULL,
  `subworkflow3` int(11) NOT NULL,
  `subworkflow3name` varchar(255) NOT NULL,
  `subworkflow3date` int(3) NOT NULL,
  `subworkflow3description` text NOT NULL,
  `subworkflow4` int(11) NOT NULL,
  `subworkflow4name` varchar(255) NOT NULL,
  `subworkflow4date` int(3) NOT NULL,
  `subworkflow4description` text NOT NULL,
  `subworkflow5` int(11) NOT NULL,
  `subworkflow5name` varchar(255) NOT NULL,
  `subworkflow5date` int(3) NOT NULL,
  `subworkflow5description` text NOT NULL,
  `subworkflow6` int(11) NOT NULL,
  `subworkflow6name` varchar(255) NOT NULL,
  `subworkflow6date` int(3) NOT NULL,
  `subworkflow6description` text NOT NULL,
  `subworkflow7` int(11) NOT NULL,
  `subworkflow7name` varchar(255) NOT NULL,
  `subworkflow7date` int(3) NOT NULL,
  `subworkflow7description` text NOT NULL,
  `subworkflow8` int(11) NOT NULL,
  `subworkflow8name` varchar(255) NOT NULL,
  `subworkflow8date` int(3) NOT NULL,
  `subworkflow8description` text NOT NULL,
  `subworkflow9` int(11) NOT NULL,
  `subworkflow9name` varchar(255) NOT NULL,
  `subworkflow9date` int(3) NOT NULL,
  `subworkflow9description` text NOT NULL,
  `subworkflow10` int(11) NOT NULL,
  `subworkflow10name` varchar(255) NOT NULL,
  `subworkflow10date` int(3) NOT NULL,
  `subworkflow10description` text NOT NULL,
  `subworkflow11` int(11) NOT NULL,
  `subworkflow11name` varchar(255) NOT NULL,
  `subworkflow11date` int(3) NOT NULL,
  `subworkflow11description` text NOT NULL,
  `subworkflow12` int(11) NOT NULL,
  `subworkflow12name` varchar(255) NOT NULL,
  `subworkflow12date` int(3) NOT NULL,
  `subworkflow12description` text NOT NULL,
  `subworkflow13` int(11) NOT NULL,
  `subworkflow13name` varchar(255) NOT NULL,
  `subworkflow13date` int(3) NOT NULL,
  `subworkflow13description` text NOT NULL,
  `subworkflow14` int(11) NOT NULL,
  `subworkflow14name` varchar(255) NOT NULL,
  `subworkflow14date` int(3) NOT NULL,
  `subworkflow14description` text NOT NULL,
  `subworkflow15` int(11) NOT NULL,
  `subworkflow15name` varchar(255) NOT NULL,
  `subworkflow15date` int(3) NOT NULL,
  `subworkflow15description` text NOT NULL,
  `subworkflow16` int(11) NOT NULL,
  `subworkflow16name` varchar(255) NOT NULL,
  `subworkflow16date` int(3) NOT NULL,
  `subworkflow16description` text NOT NULL,
  `subworkflow17` int(11) NOT NULL,
  `subworkflow17name` varchar(255) NOT NULL,
  `subworkflow17date` int(3) NOT NULL,
  `subworkflow17description` text NOT NULL,
  `subworkflow18` int(11) NOT NULL,
  `subworkflow18name` varchar(255) NOT NULL,
  `subworkflow18date` int(3) NOT NULL,
  `subworkflow18description` text NOT NULL,
  `subworkflow19` int(11) NOT NULL,
  `subworkflow19name` varchar(255) NOT NULL,
  `subworkflow19date` int(3) NOT NULL,
  `subworkflow19description` text NOT NULL,
  `subworkflow20` int(11) NOT NULL,
  `subworkflow20name` varchar(255) NOT NULL,
  `subworkflow20date` int(3) NOT NULL,
  `subworkflow20description` text NOT NULL,
  `subworkflow21` int(11) NOT NULL,
  `subworkflow21name` varchar(255) NOT NULL,
  `subworkflow21date` int(3) NOT NULL,
  `subworkflow21description` text NOT NULL,
  `subworkflow22` int(11) NOT NULL,
  `subworkflow22name` varchar(255) NOT NULL,
  `subworkflow22date` int(3) NOT NULL,
  `subworkflow22description` text NOT NULL,
  `subworkflow23` int(11) NOT NULL,
  `subworkflow23name` varchar(255) NOT NULL,
  `subworkflow23date` int(3) NOT NULL,
  `subworkflow23description` text NOT NULL,
  `subworkflow24` int(11) NOT NULL,
  `subworkflow24name` varchar(255) NOT NULL,
  `subworkflow24date` int(3) NOT NULL,
  `subworkflow24description` text NOT NULL,
  `subworkflow25` int(11) NOT NULL,
  `subworkflow25name` varchar(255) NOT NULL,
  `subworkflow25date` int(3) NOT NULL,
  `subworkflow25description` text NOT NULL,
  `subworkflow26` int(11) NOT NULL,
  `subworkflow26name` varchar(255) NOT NULL,
  `subworkflow26date` int(3) NOT NULL,
  `subworkflow26description` text NOT NULL,
  `subworkflow27` int(11) NOT NULL,
  `subworkflow27name` varchar(255) NOT NULL,
  `subworkflow27date` int(3) NOT NULL,
  `subworkflow27description` text NOT NULL,
  `subworkflow28` int(11) NOT NULL,
  `subworkflow28name` varchar(255) NOT NULL,
  `subworkflow28date` int(3) NOT NULL,
  `subworkflow28description` text NOT NULL,
  `subworkflow29` int(11) NOT NULL,
  `subworkflow29name` varchar(255) NOT NULL,
  `subworkflow29date` int(3) NOT NULL,
  `subworkflow29description` text NOT NULL,
  `subworkflow30` int(11) NOT NULL,
  `subworkflow30name` varchar(255) NOT NULL,
  `subworkflow30date` int(3) NOT NULL,
  `subworkflow30description` text NOT NULL,
  `autonextstatusid` int(11) NOT NULL,
  `no_communication` int(11) NOT NULL,
  `no_communication_call` int(11) NOT NULL,
  `no_communication_email` int(11) NOT NULL,
  `nextdate` varchar(20) NOT NULL,
  `storage_incoming` tinyint(1) NOT NULL,
  `storagenameid_incoming` int(11) NOT NULL,
  `storage_sale` tinyint(1) NOT NULL,
  `storage_reserve` tinyint(1) NOT NULL,
  `storage_unreserve` tinyint(1) NOT NULL,
  `storage_return` tinyint(1) NOT NULL,
  `novaposhtastatus` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_default` (`default`),
  KEY `index_saled` (`saled`),
  KEY `index_linkkey` (`linkkey`),
  KEY `index_sort` (`sort`,`name`),
  KEY `index_categoryid` (`categoryid`,`sort`),
  KEY `index_categoryidclosed` (`categoryid`,`closed`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shoporderstatus`
--

LOCK TABLES `shoporderstatus` WRITE;
/*!40000 ALTER TABLE `shoporderstatus` DISABLE KEYS */;
INSERT INTO `shoporderstatus` VALUES (1,'Новый','Subject: Заказ #{|$orderid|} в магазине {|$shopname|}\n\nЗдравствуйте!<br />\n<br />\n\nВы оформили заказ #{|$orderid|} в нашем магазине. Спасибо за покупку,\nв ближайшее время с вами свяжутся наши менеджеры и уточнят условия\nдоставки и оплаты.\n<br />\n<br />\n\n<table cellpadding=\"5\" cellspacing=\"0\" border=\"1\" width=\"100%\">\n    <tr class=\"tab_tr_head\">\n        <td><strong>Товар</strong></td>\n        <td width=\"120\" align=\"center\"><strong>Цена</strong></td>\n        <td width=\"80\" align=\"center\"><strong>Количество</strong></td>\n        <td width=\"120\" align=\"center\"><strong>Сумма</strong></td>\n    </tr>\n    {|foreach from=$basketsArray item=\"b\"|}\n        <tr>\n            <td>\n                {|$b.name|} (код #{|$b.productid|})<br />\n                {|$b.comment|}\n            </td>\n            <td align=\"right\">\n               {|if $b.price==\'0.00\'|}\n                   Цену уточняйте у наших менеджеров.\n               {|else|}\n                   {|$b.price|} {|$ordercurrency|}\n               {|/if|}\n            </td>\n            <td align=\"center\">\n                {|$b.count|}\n            </td>\n            <td align=\"right\">\n               {|if $b.sum==\'0.00\'|}\n                   Цену уточняйте у наших менеджеров.\n               {|else|}\n                   {|$b.sum|} {|$ordercurrency|}\n               {|/if|}\n            </td>\n        </tr>\n    {|/foreach|}\n    {|foreach from=$setArray item=\"set\"|}\n        <tr>\n           <td colspan=\"4\">\n               Набор\n           </td>\n        </tr>\n        {|foreach from=$set.productArray item=\"b\"|}\n            <tr>\n                <td>\n                    {|$b.name|} (код #{|$b.productid|})\n                </td>\n                <td align=\"right\">\n                </td>\n                <td align=\"center\">\n                </td>\n                <td align=\"right\">\n                </td>\n            </tr>\n        {|/foreach|}\n        <tr>\n            <td>\n                Цена набора\n            </td>\n            <td>\n                {|$set.sum.one|} {|$ordercurrency|}\n            </td>\n            <td>\n                {|$set.count|}\n            </td>\n            <td>\n                {|$set.sum.total|} {|$ordercurrency|}\n            </td>\n        </tr>\n    {|/foreach|}\n</table>\n<br />\n{|if $discountSum > 0|}\n    Сумма скидки: <strong>-{|$discountSum|} {|$ordercurrency|}</strong><br />\n{|/if|}\n{|if $deliveryPrice > 0|}\n    Доставка: <strong>{|$deliveryPrice|} {|$ordercurrency|}</strong><br />\n{|/if|}\nОбщая сумма заказа: <strong>{|$ordersum|} {|$ordercurrency|}</strong>\n<br />\n<br />\n\nНомер заказа: {|$orderid|}<br />\nФ.И.О.: {|$clientname|}<br />\nТелефон: {|$clientphone|}<br />\nEmail: {|$clientemail|}<br />\nАдрес доставки: {|$clientaddress|}<br />\nПрочие контактные данные: {|$clientcontacts|}<br />\nКомментарий: {|$comments|}<br />\nДата оформления заказа: {|$date|}<br />\n{|if $deliveryNote|}\nНакладная доставки: {|$deliveryNote|} <br />\n{|/if|}\n<br />\nТрек-ссылка заказа: {|$trackurl|}\n<br />\n\n{|$signature|}','Subject: Заказ #{|$orderid|} в магазине {|$shopname|}\n\nЗдравствуйте!<br />\n<br />\nБыл оформлен заказ #{|$orderid|} в магазине {|$shopname|} для его редактирования можете перейти по ссылке\n<br />\nДля  редактирования этого можете перейти по ссылке\n<br />\n<a href={|$urledit|}>{|$urledit|}</a>\n<br />\n<br />\n\n<table cellpadding=\"5\" cellspacing=\"0\" border=\"1\" width=\"100%\">\n    <tr class=\"tab_tr_head\">\n        <td><strong>Товар</strong></td>\n        <td width=\"120\" align=\"center\"><strong>Цена</strong></td>\n        <td width=\"80\" align=\"center\"><strong>Количество</strong></td>\n        <td width=\"120\" align=\"center\"><strong>Сумма</strong></td>\n    </tr>\n    {|foreach from=$basketsArray item=\"b\"|}\n        <tr>\n            <td>\n                {|$b.name|} (код #{|$b.productid|})<br />\n                {|$b.comment|}\n            </td>\n            <td align=\"right\">\n               {|if $b.price==\'0.00\'|}\n                   Цену уточняйте у наших менеджеров.\n               {|else|}\n                   {|$b.price|} {|$ordercurrency|}\n               {|/if|}\n            </td>\n            <td align=\"center\">\n                {|$b.count|}\n            </td>\n            <td align=\"right\">\n               {|if $b.sum==\'0.00\'|}\n                   Цену уточняйте у наших менеджеров.\n               {|else|}\n                   {|$b.sum|} {|$ordercurrency|}\n               {|/if|}\n            </td>\n        </tr>\n    {|/foreach|}\n    {|foreach from=$setArray item=\"set\"|}\n        <tr>\n            <td colspan=\"4\">\n                Набор\n            </td>\n        </tr>\n        {|foreach from=$set.productArray item=\"b\"|}\n            <tr>\n                <td>\n                    {|$b.name|} (код #{|$b.productid|})\n                </td>\n                <td align=\"right\">\n                </td>\n                <td align=\"center\">\n                </td>\n                <td align=\"right\">\n                </td>\n            </tr>\n        {|/foreach|}\n            <tr>\n                <td>\n                    Цена набора\n                </td>\n                <td>\n                    {|$set.sum.one|} {|$ordercurrency|}\n                </td>\n                <td>\n                    {|$set.count|}\n                </td>\n                <td>\n                    {|$set.sum.total|} {|$ordercurrency|}\n                </td>\n            </tr>\n    {|/foreach|}\n</table>\n<br />\n{|if $discountSum > 0|}\n    Сумма скидки: <strong>-{|$discountSum|} {|$ordercurrency|}</strong><br />\n{|/if|}\n{|if $deliveryPrice > 0|}\n    Доставка: <strong>{|$deliveryPrice|} {|$ordercurrency|}</strong><br />\n{|/if|}\nОбщая сумма заказа: <strong>{|$ordersum|} {|$ordercurrency|}</strong>\n<br />\n<br />\n\nНомер заказа: {|$orderid|}<br />\nФ.И.О.: {|$clientname|}<br />\nТелефон: {|$clientphone|}<br />\nEmail: {|$clientemail|}<br />\nАдрес доставки: {|$clientaddress|}<br />\nПрочие контактные данные: {|$clientcontacts|}<br />\nКомментарий: {|$comments|}<br />\nДата оформления заказа: {|$date|}<br />\n{|if $deliveryNote|}\nНакладная доставки: {|$deliveryNote|} <br />\n{|/if|}\n<br />\nТрек-ссылка заказа: {|$trackurl|}\n<br />\n\n{|$signature|}','','','',1,0,0,0,0,0,'',1,'',0,0,0,0,'',0,'','','',0,0,0,0,'',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'',0,'',0,'',0,'',0,'',0,'',0,'',0,'',0,'',0,'',0,'',0,'',0,'',0,'',0,'',0,'',0,'',0,'',0,'',0,'',0,'',0,'',0,'',0,'',0,'',0,'',0,'',0,'',0,'',0,'',0,'',0,'',0,'',0,'',0,'',0,'',0,'',0,'',0,'',0,'',0,'',0,'',0,'',0,'',0,'',0,'',0,'',0,'',0,'',0,'',0,'',0,'',0,'',0,'',0,'',0,'',0,'',0,'',0,'',0,'',0,0,0,0,'',0,0,0,0,0,0,'');
/*!40000 ALTER TABLE `shoporderstatus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shoporderstatusactionblock`
--

DROP TABLE IF EXISTS `shoporderstatusactionblock`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shoporderstatusactionblock` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `contentid` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=403 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shoporderstatusactionblock`
--

LOCK TABLES `shoporderstatusactionblock` WRITE;
/*!40000 ALTER TABLE `shoporderstatusactionblock` DISABLE KEYS */;
INSERT INTO `shoporderstatusactionblock` VALUES (365,'Закрыть задачу','shop-order-status-action-block-order-closed','Считать заказ закрытым'),(366,'Ожидать проверки','shop-order-status-action-block-awaiting-verification',''),(367,'Указать срок статуса','shop-order-status-action-block-term',''),(368,'Изменить статус на','shop-order-status-action-block-status-change',''),(369,'Отправить уведомление по смс клиенту','shop-order-status-action-block-notice-client-sms',''),(370,'Отправить уведомление по смс менеджеру','shop-order-status-action-block-notice-manager-sms',''),(371,'Отправить уведомление по email клиенту','shop-order-status-action-block-notice-client-email',''),(372,'Отправить уведомление по email менеджеру','shop-order-status-action-block-notice-manager-email',''),(373,'Выгрузить заказ в CSV','shop-order-status-action-block-upload-csv',''),(374,'Выгрузить заказ в XML','shop-order-status-action-block-upload-xml',''),(375,'Продать заказ','shop-order-status-action-block-order-saled','Считать заказ проданным'),(376,'Отгрузить заказ','shop-order-status-action-block-order-shipped','Считать заказ отгруженным'),(377,'Требовать содержание','shop-order-status-action-block-content-need','Необходимо содержание'),(378,'Регистрировать финансовое обязательство на сумму заказа в виде оплаты','shop-order-status-action-block-payment-need','Стоимость заказа повлияет на баланс контакта (Требовать оплату. Должна быть оплата.)'),(379,'Регистрировать финансовое обязательство на сумму заказа в виде предоплаты','shop-order-status-action-block-prepayment-need','Стоимость заказа повлияет на баланс контакта (Требовать предоплату. Должна быть предоплата.)'),(380,'Запретить выбирать этот этап пока нет документов','shop-order-status-action-block-document-need','Необходимы документы'),(381,'Выписать документ','document-order-status-action-block-document-writing',''),(382,'Приходовать заказ на склад','storage-order-status-action-block-debit-order-auto',''),(383,'Снять резерв товара на складе','storage-order-status-action-block-reserve-unset',''),(384,'Вернуть товар на склад','storage-order-status-action-block-product-return',''),(385,'Продать заказ со склада','storage-order-status-action-block-order-sale-auto',''),(386,'Резервировать товар на складе','storage-order-status-action-block-product-reserve-auto',''),(387,'Производство','storage-order-status-action-block-production-passport',''),(388,'Указать ответственную роль','box-order-status-action-block-role',''),(389,'Изменить ответственного','box-order-status-action-block-manager-change','При переходе в этот этап менять ответственного'),(390,'Перейти на следующий этап по истечению срока этапа','box-order-status-action-block-status-change-auto','Автоматически выполнять переход на следующий этап по истечению срока этапа'),(391,'Запретить смену этапа вручную','box-order-status-action-block-status-change-by-hand','Этап нельзя выбирать вручную'),(392,'Запретить уходить с этапа, пока не решены все подзадачи','box-order-status-action-block-status-not-change','С этапа нельзя уходить пока не решены все подзадачи данного этапа'),(393,'Уведомлять, если не было связи с клиентом','box-order-status-action-block-notification-client-no-link',''),(394,'Уведомлять, если не было связи с клиентом через звонки','box-order-status-action-block-notification-client-no-link-phone',''),(395,'Уведомлять, если не было связи с клиентом через email','box-order-status-action-block-notification-client-no-link-email',''),(396,'Автоматически начинать/повторять такую-же задачу через N дней','box-order-status-action-block-auto-repeat-day',''),(397,'Автоматически начинать/повторять такую-же задачу в день недели','box-order-status-action-block-auto-repeat-week',''),(398,'Автоматически начинать/повторять такую-же задачу в день месяца','box-order-status-action-block-auto-repeat-month',''),(399,'Перенести задачу на следующий день, если она не готова','box-order-status-action-block-auto-transfer',''),(400,'Создать подзадачу','box-order-status-action-block-sub-workflow2',''),(401,'Создать заказ постащику','shop-order-status-action-block-supplier-order',''),(402,'Перевести задачу в этот этап, если статус новой почты изменился','box-admin-action-block-novaposhta-status','');
/*!40000 ALTER TABLE `shoporderstatusactionblock` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shoporderstatusactionblockstructure`
--

DROP TABLE IF EXISTS `shoporderstatusactionblockstructure`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shoporderstatusactionblockstructure` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contentid` varchar(255) NOT NULL,
  `statusid` int(11) NOT NULL,
  `sort` int(11) NOT NULL,
  `data` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shoporderstatusactionblockstructure`
--

LOCK TABLES `shoporderstatusactionblockstructure` WRITE;
/*!40000 ALTER TABLE `shoporderstatusactionblockstructure` DISABLE KEYS */;
/*!40000 ALTER TABLE `shoporderstatusactionblockstructure` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shoporderstatuschange`
--

DROP TABLE IF EXISTS `shoporderstatuschange`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shoporderstatuschange` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categoryid` int(11) NOT NULL,
  `elementfromid` int(11) NOT NULL,
  `elementtoid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_fromto` (`elementfromid`,`elementtoid`),
  KEY `index_categoryid` (`categoryid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shoporderstatuschange`
--

LOCK TABLES `shoporderstatuschange` WRITE;
/*!40000 ALTER TABLE `shoporderstatuschange` DISABLE KEYS */;
/*!40000 ALTER TABLE `shoporderstatuschange` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shoporderstatussubworkflow`
--

DROP TABLE IF EXISTS `shoporderstatussubworkflow`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shoporderstatussubworkflow` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `statusid` int(11) NOT NULL,
  `sort` int(11) NOT NULL,
  `subworkflowid` int(11) NOT NULL,
  `subworkflowname` varchar(255) NOT NULL,
  `subworkflowdate` int(3) NOT NULL,
  `subworkflowdescription` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_statusid` (`statusid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shoporderstatussubworkflow`
--

LOCK TABLES `shoporderstatussubworkflow` WRITE;
/*!40000 ALTER TABLE `shoporderstatussubworkflow` DISABLE KEYS */;
/*!40000 ALTER TABLE `shoporderstatussubworkflow` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shoppayment`
--

DROP TABLE IF EXISTS `shoppayment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shoppayment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `deliveryid` int(11) NOT NULL,
  `hidden` tinyint(1) NOT NULL,
  `default` tinyint(1) NOT NULL,
  `contentid` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shoppayment`
--

LOCK TABLES `shoppayment` WRITE;
/*!40000 ALTER TABLE `shoppayment` DISABLE KEYS */;
/*!40000 ALTER TABLE `shoppayment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shoppaymentresult`
--

DROP TABLE IF EXISTS `shoppaymentresult`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shoppaymentresult` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `amount` decimal(15,2) NOT NULL,
  `orderid` int(11) NOT NULL,
  `status` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shoppaymentresult`
--

LOCK TABLES `shoppaymentresult` WRITE;
/*!40000 ALTER TABLE `shoppaymentresult` DISABLE KEYS */;
/*!40000 ALTER TABLE `shoppaymentresult` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopplace`
--

DROP TABLE IF EXISTS `shopplace`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopplace` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `logicclass` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopplace`
--

LOCK TABLES `shopplace` WRITE;
/*!40000 ALTER TABLE `shopplace` DISABLE KEYS */;
INSERT INTO `shopplace` VALUES (1,'Яндекс.Маркет (YML)','Shop_ExportYML'),(2,'Prom.ua (YML)','Shop_ExportPromUA'),(3,'Price.ua','Shop_ExportPriceUA'),(4,'NADAVI','Shop_ExportNadavi'),(5,'Hotline','Shop_ExportHotline'),(6,'E-catalog','Shop_ExportECatalog'),(7,'FreeMarket','Shop_ExportFreemarket');
/*!40000 ALTER TABLE `shopplace` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopplacecategory`
--

DROP TABLE IF EXISTS `shopplacecategory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopplacecategory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `placeid` int(11) NOT NULL,
  `categoryid` int(11) NOT NULL,
  `productid` int(11) NOT NULL,
  `disable` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_productidplaceid` (`productid`,`placeid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopplacecategory`
--

LOCK TABLES `shopplacecategory` WRITE;
/*!40000 ALTER TABLE `shopplacecategory` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopplacecategory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shoppricesupplierconfig`
--

DROP TABLE IF EXISTS `shoppricesupplierconfig`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shoppricesupplierconfig` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `supplierid` int(3) NOT NULL,
  `suppliercurrencyid` int(3) NOT NULL,
  `filetype` varchar(55) NOT NULL,
  `fileencoding` varchar(55) NOT NULL,
  `columncode` varchar(55) NOT NULL,
  `columnname` varchar(55) NOT NULL,
  `columnarticul` varchar(55) NOT NULL,
  `columnprice` varchar(55) NOT NULL,
  `columnminretail` varchar(55) NOT NULL,
  `minretail_cur_id` int(3) NOT NULL,
  `columnrecommretail` varchar(55) NOT NULL,
  `recommretail_cur_id` int(3) NOT NULL,
  `columnavail` varchar(55) NOT NULL,
  `columncomment` varchar(55) NOT NULL,
  `columndiscount` varchar(55) NOT NULL,
  `limitfrom` varchar(55) NOT NULL,
  `limitto` varchar(55) NOT NULL,
  `issearchcode` tinyint(1) NOT NULL,
  `issearchcodethis` tinyint(1) NOT NULL,
  `issearchcodemd5` tinyint(1) NOT NULL,
  `issearchname` tinyint(1) NOT NULL,
  `issearchnameprecision` int(11) NOT NULL,
  `issearcharticul` tinyint(1) NOT NULL,
  `notimportemptyprice` tinyint(1) NOT NULL,
  `importcron` tinyint(1) NOT NULL,
  `createnewproduct` tinyint(1) NOT NULL,
  `onlyretail` tinyint(1) NOT NULL,
  `removeminretail` tinyint(1) NOT NULL,
  `removerecommretail` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_supplierid` (`supplierid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shoppricesupplierconfig`
--

LOCK TABLES `shoppricesupplierconfig` WRITE;
/*!40000 ALTER TABLE `shoppricesupplierconfig` DISABLE KEYS */;
/*!40000 ALTER TABLE `shoppricesupplierconfig` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shoppricesupplierimport`
--

DROP TABLE IF EXISTS `shoppricesupplierimport`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shoppricesupplierimport` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cdate` datetime NOT NULL,
  `pdate` datetime NOT NULL,
  `step` int(3) NOT NULL,
  `supplierid` int(3) NOT NULL,
  `suppliercurrencyid` int(3) NOT NULL,
  `file` varchar(255) NOT NULL,
  `filetype` varchar(55) NOT NULL,
  `fileencoding` varchar(55) NOT NULL,
  `columncode` varchar(55) NOT NULL,
  `columnname` varchar(55) NOT NULL,
  `columnarticul` varchar(55) NOT NULL,
  `columnprice` int(3) NOT NULL,
  `columnminretail` int(3) NOT NULL,
  `columnminretail_cur_id` int(3) NOT NULL,
  `columnrecommretail` int(3) NOT NULL,
  `columnrecommretail_cur_id` int(3) NOT NULL,
  `columnavail` varchar(55) NOT NULL,
  `columncomment` varchar(55) NOT NULL,
  `datelifeto` datetime NOT NULL,
  `columndiscount` int(3) NOT NULL,
  `optionarray` varchar(255) NOT NULL,
  `searchnameprecision` int(11) NOT NULL,
  `lastpart` tinyint(1) NOT NULL,
  `firstpart` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_pdate` (`pdate`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shoppricesupplierimport`
--

LOCK TABLES `shoppricesupplierimport` WRITE;
/*!40000 ALTER TABLE `shoppricesupplierimport` DISABLE KEYS */;
/*!40000 ALTER TABLE `shoppricesupplierimport` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shoppricesupplieruserselection`
--

DROP TABLE IF EXISTS `shoppricesupplieruserselection`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shoppricesupplieruserselection` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `productid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shoppricesupplieruserselection`
--

LOCK TABLES `shoppricesupplieruserselection` WRITE;
/*!40000 ALTER TABLE `shoppricesupplieruserselection` DISABLE KEYS */;
/*!40000 ALTER TABLE `shoppricesupplieruserselection` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopproduct`
--

DROP TABLE IF EXISTS `shopproduct`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopproduct` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `isbox` tinyint(1) NOT NULL,
  `name` varchar(255) NOT NULL,
  `name1` varchar(255) NOT NULL,
  `name2` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `tags` text NOT NULL,
  `characteristics` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `tmpimageurl` varchar(255) NOT NULL,
  `imagecrop` varchar(255) NOT NULL,
  `price` decimal(15,2) NOT NULL,
  `priceold` decimal(15,2) NOT NULL,
  `currencyid` int(11) NOT NULL,
  `categoryid` int(11) NOT NULL,
  `brandid` int(11) NOT NULL,
  `model` varchar(255) NOT NULL,
  `articul` varchar(255) NOT NULL,
  `userid` int(11) NOT NULL,
  `top` tinyint(1) NOT NULL,
  `rating` float NOT NULL,
  `ratingcount` int(11) NOT NULL,
  `ordered` int(11) NOT NULL,
  `storaged` int(11) NOT NULL,
  `lastordered` datetime NOT NULL,
  `divisibility` decimal(15,3) NOT NULL,
  `unit` varchar(32) NOT NULL,
  `barcode` varchar(13) NOT NULL,
  `warranty` varchar(255) NOT NULL,
  `hidden` tinyint(1) NOT NULL,
  `hiddenold` tinyint(1) NOT NULL,
  `deleted` tinyint(1) NOT NULL,
  `sync` tinyint(1) NOT NULL,
  `unsyncable` tinyint(1) NOT NULL,
  `avail` tinyint(1) NOT NULL,
  `suppliered` tinyint(1) NOT NULL,
  `availtext` varchar(255) NOT NULL,
  `seriesname` varchar(255) NOT NULL,
  `url` varchar(100) NOT NULL,
  `siteurl` varchar(100) NOT NULL,
  `collectionid` int(11) NOT NULL,
  `length` varchar(32) NOT NULL,
  `width` varchar(32) NOT NULL,
  `height` varchar(32) NOT NULL,
  `weight` varchar(32) NOT NULL,
  `unitbox` int(11) NOT NULL,
  `discount` int(11) NOT NULL,
  `preorderDiscount` tinyint(1) NOT NULL,
  `tax` tinyint(1) NOT NULL,
  `payment` varchar(255) NOT NULL,
  `delivery` varchar(255) NOT NULL,
  `denycomments` tinyint(1) NOT NULL,
  `descriptionshort` varchar(300) NOT NULL,
  `code1c` varchar(255) NOT NULL,
  `codesupplier` varchar(255) NOT NULL,
  `share` varchar(255) NOT NULL,
  `seodescription` varchar(255) NOT NULL,
  `seotitle` varchar(255) NOT NULL,
  `seoh1` varchar(255) NOT NULL,
  `seocontent` text NOT NULL,
  `seokeywords` varchar(255) NOT NULL,
  `iconid` int(11) NOT NULL,
  `filedownload` varchar(255) NOT NULL,
  `supplierid` int(11) NOT NULL,
  `udate` datetime NOT NULL,
  `rrc` tinyint(1) NOT NULL,
  `cdate` datetime NOT NULL,
  `price1` decimal(15,2) NOT NULL,
  `price2` decimal(15,2) NOT NULL,
  `price3` decimal(15,2) NOT NULL,
  `price4` decimal(15,2) NOT NULL,
  `price5` decimal(15,2) NOT NULL,
  `filter1id` int(11) NOT NULL,
  `filter1value` varchar(255) NOT NULL,
  `filter1actual` tinyint(1) NOT NULL,
  `filter1use` tinyint(1) NOT NULL,
  `filter1option` tinyint(1) NOT NULL,
  `filter1markup` decimal(15,2) NOT NULL,
  `filter2id` int(11) NOT NULL,
  `filter2value` varchar(255) NOT NULL,
  `filter2actual` tinyint(1) NOT NULL,
  `filter2use` tinyint(1) NOT NULL,
  `filter2option` tinyint(1) NOT NULL,
  `filter2markup` decimal(15,2) NOT NULL,
  `filter3id` int(11) NOT NULL,
  `filter3value` varchar(255) NOT NULL,
  `filter3actual` tinyint(1) NOT NULL,
  `filter3use` tinyint(1) NOT NULL,
  `filter3option` tinyint(1) NOT NULL,
  `filter3markup` decimal(15,2) NOT NULL,
  `filter4id` int(11) NOT NULL,
  `filter4value` varchar(255) NOT NULL,
  `filter4actual` tinyint(1) NOT NULL,
  `filter4use` tinyint(1) NOT NULL,
  `filter4option` tinyint(1) NOT NULL,
  `filter4markup` decimal(15,2) NOT NULL,
  `filter5id` int(11) NOT NULL,
  `filter5value` varchar(255) NOT NULL,
  `filter5actual` tinyint(1) NOT NULL,
  `filter5use` tinyint(1) NOT NULL,
  `filter5option` tinyint(1) NOT NULL,
  `filter5markup` decimal(15,2) NOT NULL,
  `filter6id` int(11) NOT NULL,
  `filter6value` varchar(255) NOT NULL,
  `filter6actual` tinyint(1) NOT NULL,
  `filter6use` tinyint(1) NOT NULL,
  `filter6option` tinyint(1) NOT NULL,
  `filter6markup` decimal(15,2) NOT NULL,
  `filter7id` int(11) NOT NULL,
  `filter7value` varchar(255) NOT NULL,
  `filter7actual` tinyint(1) NOT NULL,
  `filter7use` tinyint(1) NOT NULL,
  `filter7option` tinyint(1) NOT NULL,
  `filter7markup` decimal(15,2) NOT NULL,
  `filter8id` int(11) NOT NULL,
  `filter8value` varchar(255) NOT NULL,
  `filter8actual` tinyint(1) NOT NULL,
  `filter8use` tinyint(1) NOT NULL,
  `filter8option` tinyint(1) NOT NULL,
  `filter8markup` decimal(15,2) NOT NULL,
  `filter9id` int(11) NOT NULL,
  `filter9value` varchar(255) NOT NULL,
  `filter9actual` tinyint(1) NOT NULL,
  `filter9use` tinyint(1) NOT NULL,
  `filter9option` tinyint(1) NOT NULL,
  `filter9markup` decimal(15,2) NOT NULL,
  `filter10id` int(11) NOT NULL,
  `filter10value` varchar(255) NOT NULL,
  `filter10actual` tinyint(1) NOT NULL,
  `filter10use` tinyint(1) NOT NULL,
  `filter10option` tinyint(1) NOT NULL,
  `filter10markup` decimal(15,2) NOT NULL,
  `category1id` int(11) NOT NULL,
  `category2id` int(11) NOT NULL,
  `category3id` int(11) NOT NULL,
  `category4id` int(11) NOT NULL,
  `category5id` int(11) NOT NULL,
  `category6id` int(11) NOT NULL,
  `category7id` int(11) NOT NULL,
  `category8id` int(11) NOT NULL,
  `category9id` int(11) NOT NULL,
  `category10id` int(11) NOT NULL,
  `supplier1id` int(11) NOT NULL,
  `supplier1code` varchar(32) NOT NULL,
  `supplier1price` decimal(15,2) NOT NULL,
  `supplier1article` varchar(32) NOT NULL,
  `supplier1discount` int(11) NOT NULL,
  `supplier1currencyid` int(11) NOT NULL,
  `supplier1avail` tinyint(1) NOT NULL,
  `supplier1availtext` varchar(16) NOT NULL,
  `supplier1date` datetime NOT NULL,
  `supplier1minretail` decimal(15,2) NOT NULL,
  `supplier1minretail_cur_id` int(11) NOT NULL,
  `supplier1recommretail` decimal(15,2) NOT NULL,
  `supplier1recommretail_cur_id` int(11) NOT NULL,
  `supplier1comment` varchar(100) NOT NULL,
  `supplier2id` int(11) NOT NULL,
  `supplier2code` varchar(32) NOT NULL,
  `supplier2price` decimal(15,2) NOT NULL,
  `supplier2article` varchar(32) NOT NULL,
  `supplier2discount` int(11) NOT NULL,
  `supplier2currencyid` int(11) NOT NULL,
  `supplier2avail` tinyint(1) NOT NULL,
  `supplier2availtext` varchar(16) NOT NULL,
  `supplier2date` datetime NOT NULL,
  `supplier2minretail` decimal(15,2) NOT NULL,
  `supplier2minretail_cur_id` int(11) NOT NULL,
  `supplier2recommretail` decimal(15,2) NOT NULL,
  `supplier2recommretail_cur_id` int(11) NOT NULL,
  `supplier2comment` varchar(100) NOT NULL,
  `supplier3id` int(11) NOT NULL,
  `supplier3code` varchar(32) NOT NULL,
  `supplier3price` decimal(15,2) NOT NULL,
  `supplier3article` varchar(32) NOT NULL,
  `supplier3discount` int(11) NOT NULL,
  `supplier3currencyid` int(11) NOT NULL,
  `supplier3avail` tinyint(1) NOT NULL,
  `supplier3availtext` varchar(16) NOT NULL,
  `supplier3date` datetime NOT NULL,
  `supplier3minretail` decimal(15,2) NOT NULL,
  `supplier3minretail_cur_id` int(11) NOT NULL,
  `supplier3recommretail` decimal(15,2) NOT NULL,
  `supplier3recommretail_cur_id` int(11) NOT NULL,
  `supplier3comment` varchar(100) NOT NULL,
  `supplier4id` int(11) NOT NULL,
  `supplier4code` varchar(32) NOT NULL,
  `supplier4price` decimal(15,2) NOT NULL,
  `supplier4article` varchar(32) NOT NULL,
  `supplier4discount` int(11) NOT NULL,
  `supplier4currencyid` int(11) NOT NULL,
  `supplier4avail` tinyint(1) NOT NULL,
  `supplier4availtext` varchar(16) NOT NULL,
  `supplier4date` datetime NOT NULL,
  `supplier4minretail` decimal(15,2) NOT NULL,
  `supplier4minretail_cur_id` int(11) NOT NULL,
  `supplier4recommretail` decimal(15,2) NOT NULL,
  `supplier4recommretail_cur_id` int(11) NOT NULL,
  `supplier4comment` varchar(100) NOT NULL,
  `supplier5id` int(11) NOT NULL,
  `supplier5code` varchar(32) NOT NULL,
  `supplier5price` decimal(15,2) NOT NULL,
  `supplier5article` varchar(32) NOT NULL,
  `supplier5discount` int(11) NOT NULL,
  `supplier5currencyid` int(11) NOT NULL,
  `supplier5avail` tinyint(1) NOT NULL,
  `supplier5availtext` varchar(16) NOT NULL,
  `supplier5date` datetime NOT NULL,
  `supplier5minretail` decimal(15,2) NOT NULL,
  `supplier5minretail_cur_id` int(11) NOT NULL,
  `supplier5recommretail` decimal(15,2) NOT NULL,
  `supplier5recommretail_cur_id` int(11) NOT NULL,
  `supplier5comment` varchar(100) NOT NULL,
  `supplier6id` int(11) NOT NULL,
  `supplier6code` varchar(32) NOT NULL,
  `supplier6price` decimal(15,2) NOT NULL,
  `supplier6article` varchar(32) NOT NULL,
  `supplier6discount` int(11) NOT NULL,
  `supplier6currencyid` int(11) NOT NULL,
  `supplier6avail` tinyint(1) NOT NULL,
  `supplier6availtext` varchar(16) NOT NULL,
  `supplier6date` datetime NOT NULL,
  `supplier6minretail` decimal(15,2) NOT NULL,
  `supplier6minretail_cur_id` int(11) NOT NULL,
  `supplier6recommretail` decimal(15,2) NOT NULL,
  `supplier6recommretail_cur_id` int(11) NOT NULL,
  `supplier6comment` varchar(100) NOT NULL,
  `supplier7id` int(11) NOT NULL,
  `supplier7code` varchar(32) NOT NULL,
  `supplier7price` decimal(15,2) NOT NULL,
  `supplier7article` varchar(32) NOT NULL,
  `supplier7discount` int(11) NOT NULL,
  `supplier7currencyid` int(11) NOT NULL,
  `supplier7avail` tinyint(1) NOT NULL,
  `supplier7availtext` varchar(16) NOT NULL,
  `supplier7date` datetime NOT NULL,
  `supplier7minretail` decimal(15,2) NOT NULL,
  `supplier7minretail_cur_id` int(11) NOT NULL,
  `supplier7recommretail` decimal(15,2) NOT NULL,
  `supplier7recommretail_cur_id` int(11) NOT NULL,
  `supplier7comment` varchar(100) NOT NULL,
  `supplier8id` int(11) NOT NULL,
  `supplier8code` varchar(32) NOT NULL,
  `supplier8price` decimal(15,2) NOT NULL,
  `supplier8article` varchar(32) NOT NULL,
  `supplier8discount` int(11) NOT NULL,
  `supplier8currencyid` int(11) NOT NULL,
  `supplier8avail` tinyint(1) NOT NULL,
  `supplier8availtext` varchar(16) NOT NULL,
  `supplier8date` datetime NOT NULL,
  `supplier8minretail` decimal(15,2) NOT NULL,
  `supplier8minretail_cur_id` int(11) NOT NULL,
  `supplier8recommretail` decimal(15,2) NOT NULL,
  `supplier8recommretail_cur_id` int(11) NOT NULL,
  `supplier8comment` varchar(100) NOT NULL,
  `supplier9id` int(11) NOT NULL,
  `supplier9code` varchar(32) NOT NULL,
  `supplier9price` decimal(15,2) NOT NULL,
  `supplier9article` varchar(32) NOT NULL,
  `supplier9discount` int(11) NOT NULL,
  `supplier9currencyid` int(11) NOT NULL,
  `supplier9avail` tinyint(1) NOT NULL,
  `supplier9availtext` varchar(16) NOT NULL,
  `supplier9date` datetime NOT NULL,
  `supplier9minretail` decimal(15,2) NOT NULL,
  `supplier9minretail_cur_id` int(11) NOT NULL,
  `supplier9recommretail` decimal(15,2) NOT NULL,
  `supplier9recommretail_cur_id` int(11) NOT NULL,
  `supplier9comment` varchar(100) NOT NULL,
  `supplier10id` int(11) NOT NULL,
  `supplier10code` varchar(32) NOT NULL,
  `supplier10price` decimal(15,2) NOT NULL,
  `supplier10article` varchar(32) NOT NULL,
  `supplier10discount` int(11) NOT NULL,
  `supplier10currencyid` int(11) NOT NULL,
  `supplier10avail` tinyint(1) NOT NULL,
  `supplier10availtext` varchar(16) NOT NULL,
  `supplier10date` datetime NOT NULL,
  `supplier10minretail` decimal(15,2) NOT NULL,
  `supplier10minretail_cur_id` int(11) NOT NULL,
  `supplier10recommretail` decimal(15,2) NOT NULL,
  `supplier10recommretail_cur_id` int(11) NOT NULL,
  `supplier10comment` varchar(100) NOT NULL,
  `linkkey` varchar(255) NOT NULL,
  `source` varchar(32) NOT NULL,
  `term` enum('unlimited','day','month','year') NOT NULL,
  `pricebase` decimal(15,2) NOT NULL,
  `pricesell` decimal(15,2) NOT NULL,
  `datelifefrom` date NOT NULL,
  `datelifeto` date NOT NULL,
  `f_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `category1id` (`category1id`,`hidden`),
  KEY `category2id` (`category2id`,`hidden`),
  KEY `category3id` (`category3id`,`hidden`),
  KEY `category4id` (`category4id`,`hidden`),
  KEY `category5id` (`category5id`,`hidden`),
  KEY `category6id` (`category6id`,`hidden`),
  KEY `category7id` (`category7id`,`hidden`),
  KEY `category8id` (`category8id`,`hidden`),
  KEY `category9id` (`category9id`,`hidden`),
  KEY `category10id` (`category10id`,`hidden`),
  KEY `index_supplier1id` (`supplier1id`),
  KEY `index_supplier1code` (`supplier1code`),
  KEY `index_supplier2id` (`supplier2id`),
  KEY `index_supplier2code` (`supplier2code`),
  KEY `index_supplier3id` (`supplier3id`),
  KEY `index_supplier3code` (`supplier3code`),
  KEY `index_supplier4id` (`supplier4id`),
  KEY `index_supplier4code` (`supplier4code`),
  KEY `index_supplier5id` (`supplier5id`),
  KEY `index_supplier5code` (`supplier5code`),
  KEY `price` (`price`),
  KEY `url` (`url`),
  KEY `avail` (`avail`),
  KEY `index_linkkey` (`linkkey`),
  KEY `index_articul` (`articul`),
  KEY `index_seriesname` (`seriesname`),
  KEY `index_seriesname_more` (`avail`,`hidden`,`deleted`,`seriesname`),
  KEY `index_product_list_find` (`avail`,`hidden`,`deleted`,`categoryid`,`datelifefrom`,`datelifeto`),
  KEY `index_brandid` (`brandid`),
  KEY `index_code1c` (`code1c`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopproduct`
--

LOCK TABLES `shopproduct` WRITE;
/*!40000 ALTER TABLE `shopproduct` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopproduct` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopproduct2list`
--

DROP TABLE IF EXISTS `shopproduct2list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopproduct2list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `productid` varchar(255) NOT NULL,
  `listid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_listid` (`listid`),
  KEY `index_productid` (`productid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopproduct2list`
--

LOCK TABLES `shopproduct2list` WRITE;
/*!40000 ALTER TABLE `shopproduct2list` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopproduct2list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopproduct2tag`
--

DROP TABLE IF EXISTS `shopproduct2tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopproduct2tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `productid` int(11) NOT NULL,
  `tagid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `index_link` (`productid`,`tagid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopproduct2tag`
--

LOCK TABLES `shopproduct2tag` WRITE;
/*!40000 ALTER TABLE `shopproduct2tag` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopproduct2tag` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopproductchange`
--

DROP TABLE IF EXISTS `shopproductchange`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopproductchange` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `productid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `cdate` datetime NOT NULL,
  `key` varchar(32) NOT NULL,
  `valueold` text NOT NULL,
  `valuenew` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_productid` (`productid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopproductchange`
--

LOCK TABLES `shopproductchange` WRITE;
/*!40000 ALTER TABLE `shopproductchange` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopproductchange` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopproductcomment`
--

DROP TABLE IF EXISTS `shopproductcomment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopproductcomment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `productid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `text` text NOT NULL,
  `cdate` datetime NOT NULL,
  `rating` int(11) NOT NULL,
  `plus` text NOT NULL,
  `minus` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `answer` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_userid` (`userid`),
  KEY `index_productid` (`productid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopproductcomment`
--

LOCK TABLES `shopproductcomment` WRITE;
/*!40000 ALTER TABLE `shopproductcomment` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopproductcomment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopproductfilter`
--

DROP TABLE IF EXISTS `shopproductfilter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopproductfilter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `hidden` tinyint(11) NOT NULL,
  `filter` tinyint(1) NOT NULL,
  `sort` int(11) NOT NULL,
  `type` enum('interval','intervalselect','intervalslider','select','checkbox','radiobox','color','size') NOT NULL,
  `sorttype` tinyint(11) NOT NULL,
  `linkkey` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_hidden` (`hidden`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopproductfilter`
--

LOCK TABLES `shopproductfilter` WRITE;
/*!40000 ALTER TABLE `shopproductfilter` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopproductfilter` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopproductfiltervalue`
--

DROP TABLE IF EXISTS `shopproductfiltervalue`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopproductfiltervalue` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `productid` int(11) NOT NULL,
  `filterid` int(11) NOT NULL,
  `filtervalue` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `index_productfiltervalue` (`productid`,`filterid`,`filtervalue`),
  UNIQUE KEY `index_valuefilterproduct` (`filtervalue`,`filterid`,`productid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopproductfiltervalue`
--

LOCK TABLES `shopproductfiltervalue` WRITE;
/*!40000 ALTER TABLE `shopproductfiltervalue` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopproductfiltervalue` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopproductgrouped`
--

DROP TABLE IF EXISTS `shopproductgrouped`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopproductgrouped` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categoryid` int(11) NOT NULL,
  `productid` int(11) NOT NULL,
  `first` tinyint(1) NOT NULL,
  `image` varchar(255) NOT NULL,
  `groupedfield` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_productid` (`productid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopproductgrouped`
--

LOCK TABLES `shopproductgrouped` WRITE;
/*!40000 ALTER TABLE `shopproductgrouped` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopproductgrouped` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopproducticon`
--

DROP TABLE IF EXISTS `shopproducticon`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopproducticon` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopproducticon`
--

LOCK TABLES `shopproducticon` WRITE;
/*!40000 ALTER TABLE `shopproducticon` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopproducticon` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopproductlist`
--

DROP TABLE IF EXISTS `shopproductlist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopproductlist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `nameshort` varchar(255) NOT NULL,
  `showinmain` tinyint(1) NOT NULL,
  `linkkey` varchar(255) NOT NULL,
  `hidden` tinyint(1) NOT NULL,
  `showtype` varchar(255) NOT NULL,
  `autoplay` tinyint(1) NOT NULL,
  `logicclass` varchar(255) NOT NULL,
  `setimage` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_linkkey` (`linkkey`),
  KEY `index_hidden` (`hidden`),
  KEY `index_showinmain` (`showinmain`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopproductlist`
--

LOCK TABLES `shopproductlist` WRITE;
/*!40000 ALTER TABLE `shopproductlist` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopproductlist` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopproductpassport`
--

DROP TABLE IF EXISTS `shopproductpassport`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopproductpassport` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `valid` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopproductpassport`
--

LOCK TABLES `shopproductpassport` WRITE;
/*!40000 ALTER TABLE `shopproductpassport` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopproductpassport` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopproductpassportitem`
--

DROP TABLE IF EXISTS `shopproductpassportitem`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopproductpassportitem` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `passportid` int(11) NOT NULL,
  `productid` int(11) NOT NULL,
  `istarget` tinyint(1) NOT NULL,
  `amount` decimal(15,3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopproductpassportitem`
--

LOCK TABLES `shopproductpassportitem` WRITE;
/*!40000 ALTER TABLE `shopproductpassportitem` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopproductpassportitem` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopproductpricetask`
--

DROP TABLE IF EXISTS `shopproductpricetask`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopproductpricetask` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cdate` datetime NOT NULL,
  `pdate` datetime NOT NULL,
  `categoryid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_pdate` (`pdate`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopproductpricetask`
--

LOCK TABLES `shopproductpricetask` WRITE;
/*!40000 ALTER TABLE `shopproductpricetask` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopproductpricetask` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopproductsnoticeofavailability`
--

DROP TABLE IF EXISTS `shopproductsnoticeofavailability`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopproductsnoticeofavailability` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `productid` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `cdate` datetime NOT NULL,
  `senddate` datetime NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopproductsnoticeofavailability`
--

LOCK TABLES `shopproductsnoticeofavailability` WRITE;
/*!40000 ALTER TABLE `shopproductsnoticeofavailability` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopproductsnoticeofavailability` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopproductsupplier`
--

DROP TABLE IF EXISTS `shopproductsupplier`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopproductsupplier` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `productid` int(11) NOT NULL,
  `supplierid` int(11) NOT NULL,
  `code` varchar(32) NOT NULL,
  `price` decimal(15,2) NOT NULL,
  `article` varchar(32) NOT NULL,
  `discount` int(11) NOT NULL,
  `currencyid` int(11) NOT NULL,
  `avail` tinyint(1) NOT NULL,
  `availtext` varchar(16) NOT NULL,
  `date` datetime NOT NULL,
  `minretail` decimal(15,2) NOT NULL,
  `minretail_cur_id` int(11) NOT NULL,
  `recommretail` decimal(15,2) NOT NULL,
  `recommretail_cur_id` int(11) NOT NULL,
  `comment` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_supplierid` (`supplierid`),
  KEY `index_productid` (`productid`),
  KEY `index_codesupplier` (`code`,`supplierid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopproductsupplier`
--

LOCK TABLES `shopproductsupplier` WRITE;
/*!40000 ALTER TABLE `shopproductsupplier` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopproductsupplier` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopproducttag`
--

DROP TABLE IF EXISTS `shopproducttag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopproducttag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `index_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopproducttag`
--

LOCK TABLES `shopproducttag` WRITE;
/*!40000 ALTER TABLE `shopproducttag` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopproducttag` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopproductview`
--

DROP TABLE IF EXISTS `shopproductview`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopproductview` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `productid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `sessionid` varchar(32) NOT NULL,
  `ip` varchar(15) NOT NULL,
  `cdate` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_cdate` (`cdate`),
  KEY `index_productid` (`productid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopproductview`
--

LOCK TABLES `shopproductview` WRITE;
/*!40000 ALTER TABLE `shopproductview` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopproductview` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopredirect`
--

DROP TABLE IF EXISTS `shopredirect`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopredirect` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `urlfrom` varchar(255) NOT NULL,
  `urlto` varchar(255) NOT NULL,
  `code` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `index_urlfrom` (`urlfrom`),
  KEY `index_urlto` (`urlto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopredirect`
--

LOCK TABLES `shopredirect` WRITE;
/*!40000 ALTER TABLE `shopredirect` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopredirect` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopreletedcategory`
--

DROP TABLE IF EXISTS `shopreletedcategory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopreletedcategory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categoryid` int(11) NOT NULL,
  `reletedcategoryid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_categoryid` (`categoryid`),
  KEY `index_reletedcategoryid` (`reletedcategoryid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopreletedcategory`
--

LOCK TABLES `shopreletedcategory` WRITE;
/*!40000 ALTER TABLE `shopreletedcategory` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopreletedcategory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopreport`
--

DROP TABLE IF EXISTS `shopreport`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopreport` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `row` varchar(255) NOT NULL,
  `columns` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopreport`
--

LOCK TABLES `shopreport` WRITE;
/*!40000 ALTER TABLE `shopreport` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopreport` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shoprole`
--

DROP TABLE IF EXISTS `shoprole`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shoprole` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `parentid` int(11) NOT NULL,
  `kpi1id` int(11) NOT NULL,
  `kpi1param` varchar(32) NOT NULL,
  `kpi1value` decimal(10,2) NOT NULL,
  `salary1workflowid` int(11) NOT NULL,
  `salary1koef` float NOT NULL,
  `kpi2id` int(11) NOT NULL,
  `kpi2param` varchar(32) NOT NULL,
  `kpi2value` decimal(10,2) NOT NULL,
  `salary2workflowid` int(11) NOT NULL,
  `salary2koef` float NOT NULL,
  `kpi3id` int(11) NOT NULL,
  `kpi3param` varchar(32) NOT NULL,
  `kpi3value` decimal(10,2) NOT NULL,
  `salary3workflowid` int(11) NOT NULL,
  `salary3koef` float NOT NULL,
  `kpi4id` int(11) NOT NULL,
  `kpi4param` varchar(32) NOT NULL,
  `kpi4value` decimal(10,2) NOT NULL,
  `salary4workflowid` int(11) NOT NULL,
  `salary4koef` float NOT NULL,
  `kpi5id` int(11) NOT NULL,
  `kpi5param` varchar(32) NOT NULL,
  `kpi5value` decimal(10,2) NOT NULL,
  `salary5workflowid` int(11) NOT NULL,
  `salary5koef` float NOT NULL,
  `kpi6id` int(11) NOT NULL,
  `kpi6param` varchar(32) NOT NULL,
  `kpi6value` decimal(10,2) NOT NULL,
  `salary6workflowid` int(11) NOT NULL,
  `salary6koef` float NOT NULL,
  `kpi7id` int(11) NOT NULL,
  `kpi7param` varchar(32) NOT NULL,
  `kpi7value` decimal(10,2) NOT NULL,
  `salary7workflowid` int(11) NOT NULL,
  `salary7koef` float NOT NULL,
  `kpi8id` int(11) NOT NULL,
  `kpi8param` varchar(32) NOT NULL,
  `kpi8value` decimal(10,2) NOT NULL,
  `salary8workflowid` int(11) NOT NULL,
  `salary8koef` float NOT NULL,
  `kpi9id` int(11) NOT NULL,
  `kpi9param` varchar(32) NOT NULL,
  `kpi9value` decimal(10,2) NOT NULL,
  `salary9workflowid` int(11) NOT NULL,
  `salary9koef` float NOT NULL,
  `kpi10id` int(11) NOT NULL,
  `kpi10param` varchar(32) NOT NULL,
  `kpi10value` decimal(10,2) NOT NULL,
  `salary10workflowid` int(11) NOT NULL,
  `salary10koef` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shoprole`
--

LOCK TABLES `shoprole` WRITE;
/*!40000 ALTER TABLE `shoprole` DISABLE KEYS */;
/*!40000 ALTER TABLE `shoprole` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopsearch`
--

DROP TABLE IF EXISTS `shopsearch`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopsearch` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cdate` datetime NOT NULL,
  `sid` varchar(32) NOT NULL,
  `userid` int(11) NOT NULL,
  `query` varchar(255) NOT NULL,
  `countresult` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopsearch`
--

LOCK TABLES `shopsearch` WRITE;
/*!40000 ALTER TABLE `shopsearch` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopsearch` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopseo`
--

DROP TABLE IF EXISTS `shopseo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopseo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) NOT NULL,
  `seotitle` varchar(255) NOT NULL,
  `seoh1` varchar(255) NOT NULL,
  `seokeywords` varchar(255) NOT NULL,
  `seodescription` varchar(255) NOT NULL,
  `seocontent` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `index_url` (`url`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopseo`
--

LOCK TABLES `shopseo` WRITE;
/*!40000 ALTER TABLE `shopseo` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopseo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopseolink`
--

DROP TABLE IF EXISTS `shopseolink`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopseolink` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `keyword` varchar(256) NOT NULL,
  `url` varchar(256) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopseolink`
--

LOCK TABLES `shopseolink` WRITE;
/*!40000 ALTER TABLE `shopseolink` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopseolink` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopsettings`
--

DROP TABLE IF EXISTS `shopsettings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopsettings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `value` text NOT NULL,
  `type` varchar(255) NOT NULL,
  `tabname` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `index_key` (`key`),
  KEY `index_tabname` (`tabname`)
) ENGINE=InnoDB AUTO_INCREMENT=153 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopsettings`
--

LOCK TABLES `shopsettings` WRITE;
/*!40000 ALTER TABLE `shopsettings` DISABLE KEYS */;
INSERT INTO `shopsettings` VALUES (1,'header-phone','Телефоны','(067) 842-32-21, (050) 447-95-30, (044) 383-07-78','string','Контакты','Контактные телефоны, которые оборажаются на сайте'),(2,'header-icq','ICQ','626-191-284','string','Контакты','ICQ, которые оборажаются на сайте'),(3,'header-skype','skype','webproduction_sales','string','Контакты','Skype, которые оборажаются на сайте'),(4,'company-address','Адрес компании','14000, Украина, Чернигов, пр. Победы, 129','string','Контакты',''),(5,'shop-company','Название компании','WebProduction','string','Контакты',''),(6,'header-email','Email','sales@webproduction.ua','string','Контакты','Контактный email, который отображается на сайте'),(7,'work-time','Время работы','Пн-Пт: 10.00-18.00','string','Контакты','Время работы, которое отображается на сайте'),(8,'feed-back-email','Email для функции Написать письмо','support@webproduction.ua','string','Уведомления: email',''),(9,'faq-email','Email для функции Вопрос-ответ','support@webproduction.ua','string','Уведомления: email',''),(10,'call-back-email','Email для функции Обратный звонок','support@webproduction.ua','string','Уведомления: email',''),(11,'email-guestbook','Email для новых отзывов о магазине','support@webproduction.ua','string','Уведомления: email',''),(12,'reverse-email','Обратный адрес Email для писем','no-reply@webproduction.ua','string','Уведомления: email','Адрес с какого будет отправлятся письма пользователям'),(13,'email-orders','Email для уведомления о новых заказах','support@webproduction.ua','html','Уведомления: email','Укажите на какие email будут приходить\n            информация о новых заказах. Укажите свои email, каждый в новой строке.'),(14,'email-tehnical','Email для технических уведомлений','support@webproduction.ua','html','Уведомления: email','Укажите на какие email будут приходить технические\n            сообщения (например, обмен данными с XLS). Укажите свои email, каждый в новой строке.'),(15,'letter-template','Обертка для писем','/templates/default/mail/index.html','string','Уведомления: шаблоны','Путь к шаблону-обертке письма, например (/templates/default/mail/index.html)'),(16,'letter-add-callback','Шаблон письма \"Заказной звонок\"','Subject: Вам был оставлена заявка на \"обратный звонок\"\n\nЗдравствуйте: {|$name|} <br />\nТелефон: {|$phone|}<br />\nВопрос: {|$question|}<br />\nURL: {|$url|}<br />\n{|if $userUrl|}\nКонтакт: {|$userUrl|}<br />\n{|/if|}\n<br /><br />\n\n\n{|$signature|}','html','Уведомления: шаблоны',''),(17,'letter-auto-feedback','Шаблон письма \"Оставьте отзыв\"','Subject: Оставьте отзыв, о заказнных товарах\n\nЗдравствуйте, {|$userName|}! <br />\n{|$cdate|} Вы оформляли у нас заказ #{|$orderNumber|}. Мы благодарны за покупку и просим Вас оставить отзывы на заказанные товары, если это возможно.\n<br />\n<br />\n<table style=\"width: 99%;\">\n    <tr>\n    {|foreach from=$productsArray key=\"k\" item=\"e\"|}\n    <td style=\"width: 30%; padding: 10px; text-align: center; vertical-align: middle;\">\n        <img src=\"{|$e.imageUrl|}\" alt=\"{|$e.name|}\" title=\"{|$e.name|}\" style=\"max-width: 150px; max-height: 150px;\"/>\n        <br />\n        <a href=\"{|$e.url|}\">{|$e.name|}</a>\n    </td>\n\n        {|if $k % 3 == 0|}\n    </tr><tr>\n        {|/if|}\n    {|/foreach|}\n    </tr>\n</table>\n\n<br />\n<br />\n\n\n{|$signature|}','html','Уведомления: шаблоны',''),(18,'letter-signature','Шаблон подписи письма','<hr />\nOneClick<br />\n<a href=\"http://shop.webproduction.com.ua/\">OneClick</a><br />\n','html','Уведомления: шаблоны',''),(19,'letter-add-feedback','Шаблон письма \"Обратная связь\"','Subject: Вам было написано письмо\n\nИмя: {|$name|}<br />\n{|if $phone|}\n    Телефон: {|$phone|}<br />\n{|/if|}\n{|if $email|}\n    E-mail: <a href=\"mailto:{|$email|}\">{|$email|}</a><br />\n{|/if|}\nСообщение: {|$message|}<br />\nURL: {|$url|}<br />\n{|if $userUrl|}\n    Контакт: {|$userUrl|}<br />\n{|/if|}\n<br/><br/>\n\n\n{|$signature|}','html','Уведомления: шаблоны',''),(20,'letter-products-notice-of-availability','Шаблон письма \"Товар уже в наличии\"','Subject: Товар {|$productName|}, уже есть в наличии!\n\nЗдравствуйте {|$name|}! <br /><br />\n\nТовар <a href=\"{|$productUrl|}\">\"{|$productName|}\"</a>, уже есть в наличии!<br/>\n\n{|$signature|}','html','Уведомления: шаблоны',''),(21,'letter-registration','Шаблон письма \"Регистрация\"','Subject: Регистрация\n\nВы зарегистрировались:<br />\n<br />\nЛогин: {|$login|}<br />\nПароль: {|$password|}<br />\n<br />\n{|if $activateURL|}\n    Для активации аккаунта вам нужно перейти по этой ссылке в течении 24 часов: <a href=\"{|$activateURL|}\">{|$activateURL|}</a>\n{|/if|}\n\n{|$signature|}','html','Уведомления: шаблоны',''),(22,'letter-remindpassword','Шаблон письма \"Восстановление пароля\"','Subject: Восстановление пароля\n\nЛогин: {|$login|}<br />\nНовый пароль: {|$password|}<br />\nE-mail: {|$email|}<br />\n<br />\n\n{|$signature|}','html','Уведомления: шаблоны',''),(23,'letter-shop-faq-question','Шаблон письма \"Новый вопрос в раздел FAQ\"','Subject: Был задан новый вопрос в раздел FAQ\n\nЛогин: {|$name|}<br /><br />\n\nВопрос: {|$question|}<br />\n<br />\n\n{|$signature|}','html','Уведомления: шаблоны',''),(24,'letter-shop-faq-answer','Шаблон письма \"Ответ на ваш вопрос в раздел FAQ\"','Subject: Администрация ответила на ваш вопрос в раздел FAQ\n\nЗдравствуйте {|$name|}! <br /><br />\n\nВы задавали вопрос администрации: {|$question|}<br />\n<br />\nОтвет: {|$answer|}<br />\n<br />\n\n{|$signature|}','html','Уведомления: шаблоны',''),(25,'letter-shop-guestbook-answer','Шаблон письма \"Ваш отзыв был опубликован в разделе Отзывы о магазине\"','Subject: Администрация опубликовала Ваш отзыв в разделе Отзывы о магазине\n\nЗдравствуйте {|$name|}! <br /><br />\n\nВы оставили отзыв: {|$response|}<br />\n\n{|$signature|}\n','html','Уведомления: шаблоны',''),(26,'letter-shop-guestbook-response','Шаблон письма \"Новый отзыв в разделе Отзывы о магазине\"','Subject: Был оставлен новый отзыв в разделе Отзывы о магазине\n\nКонтакт: {|$userUrl|}<br /><br />\n\nОтзыв: {|$response|}<br />\n<br />\n\nНомер заказа: {|$orderNumber|}<br />\n<br />\n\n{|$signature|}\n','html','Уведомления: шаблоны',''),(27,'social-button','Отображать кнопки для социальных сетей','1','boolean','Блоки, отображение, внешний вид','Показывать кнопки социальных сетей\n            (Вконтакте, Однакласники, Facebook, ...) на странице товара'),(28,'use-code-1c','Использовать на сайте коды 1С','0','boolean','Интеграции: 1С','Вместо обычныйх ID товаров будут показаны коды 1С'),(29,'interkassa-shopid','InterKassa.com: ik_shop_id','','string','Интеграции: InterKassa.com',''),(30,'interkassa-secretkey','InterKassa.com: secret key','','string','Интеграции: InterKassa.com',''),(31,'integration-cloudim','CloudIM: код интеграции','','html','Интеграции: CloudIM','Позволяет добавить on-line чат системы CloudIM'),(32,'loginza-verification','Loginza.ru: код верификации','','html','Интеграции: Loginza.ru',''),(33,'loginza-widgetid','Loginza.ru: widget ID','','string','Интеграции: Loginza.ru',''),(34,'loginza-secretkey','Loginza.ru: secret key','','string','Интеграции: Loginza.ru',''),(35,'loginza-services','Loginza.ru: список опций входа','google,yandex,vkontakte,facebook,twitter','string','Интеграции: Loginza.ru',''),(36,'integration-googleanalytics','Код интеграции с Google Analytics','','html','Интеграции: Google Analytics','Позволяет добавить код сервиса Google Analytics'),(37,'integration-google-wmt','Meta-тег для подтверждения прав на Google WebMaster Tools','','html','Интеграции: Google WebMaster','Позволяет добавить код для подверждения правообладаниея'),(38,'integration-yandex-wmt','Meta-тег для подтверждения прав на Yandex WebMaster Tools','','html','Интеграции: Yandex WebMaster','Позволяет добавить код для подверждения правообладания'),(39,'integration-yandex-metrika-token','Яндекс.Метрика auth token','','string','Интеграции: Яндекс.Метрика','Для построения отчетов Воронка продаж и т.д.'),(40,'integration-yandex-metrika-counterid','Яндекс.Метрика counter ID','','string','Интеграции: Яндекс.Метрика','Для построения отчетов Воронка продаж и т.д.'),(41,'integration-liveinternet','Код интеграции с LiveInternet','','html','Интеграции: LiveInternet','Позволяет добавить код сервиса LiveInternet'),(42,'integration-yandex-counter','Интеграциия с Яндекс.Счетчик','','html','Интеграции: Яндекс.Счетчик','Счетчик посещаемости веб-сайтов, и анализа поведения пользователей.'),(43,'facebook-widget','Facebook Social Widget','','html','Интеграции: Facebook Social Widget','Позволяет добавить виджет facebook.com'),(44,'integration-comments','Интеграция с системой комментариев','','html','Интеграции: Система комментариев','Вставьте сюда код виджета комментариев facebook,\n            vk.com, disqus или другой. Форма комментирования появиться в каждом товаре.'),(45,'product-export-xml-json','Выгружать продукты в XML + JSON','0','boolean','Интеграции: Учетные системы','Каждый час продукты будут выгружатся в файл формата XML и JSON.'),(46,'brand-export-xml-json','Выгружать бренды в XML + JSON','0','boolean','Интеграции: Учетные системы','Каждый час бренды будут выгружатся в файл формата XML и JSON.'),(47,'category-export-xml-json','Выгружать категории в XML + JSON','0','boolean','Интеграции: Учетные системы','Каждый час категории будут выгружатся в файл формата XML и JSON.'),(48,'turbosms-login','Интеграция с TurboSMS: API login','','string','Интеграции: TurboSMS','Поле для логина сервиса TurboSMS'),(49,'turbosms-password','Интеграция с TurboSMS: API password','','string','Интеграции: TurboSMS','Поле для пароля сервиса TurboSMS'),(50,'turbosms-sender','Интеграция с TurboSMS: отправитель (подпись)','','string','Интеграции: TurboSMS','Позволяет настроить подпись сообщений отправляемых с помощью TurboSMS'),(51,'turbosms-admin-phone','Интеграция с TurboSMS: Номер телефона администратора','','string','Интеграции: TurboSMS','Если вы заполните это поле, то сообщения о\n            заказах будут приходить на этот номер телефона. Формат номера телефона: 380ХХХХХХХХХ'),(52,'public-key','LiqPay: public key','','string','Интеграции: LiqPay','Позволяет настроить платежную систему, для оплаты заказа. '),(53,'private-key','LiqPay: private key','','string','Интеграции: LiqPay','Позволяет настроить платежную систему, для оплаты заказа. '),(54,'ftp-hostname','Синхронизация с 1C: FTP-hostname','','string','Интеграции: 1С','Поле для имени FTP-сервера'),(55,'ftp-port','Синхронизация с 1C: FTP-port','21','string','Интеграции: 1С','Поле для порта к FTP-серверу'),(56,'ftp-login','Синхронизация с 1C: FTP-login','','string','Интеграции: 1С','Поле логина для FTP-соединения'),(57,'ftp-password','Синхронизация с 1C: FTP-password','','string','Интеграции: 1С','Поле пароля для FTP-соединения'),(58,'found-cheaper','Показывать блок \"Нашли дешевле\"','1','boolean','Блоки, отображение, внешний вид','Если Вы согласны уступить цену клиенту,\n            при условие, что на другом сайте такой же товар продается дешевле, поставте галочку.'),(59,'show-filters','Показывать блок \"Блок фильтров\"','1','boolean','Блоки, отображение, внешний вид','Если вы хотите дать возможность клиентам,\n            пользоваться фильтрами по параметрам в спике товаров, включите данную опцию.'),(60,'products-notice-of-availability','Показывать блок \"Сообщите когда появится\"','1','boolean','Блоки, отображение, внешний вид','Ежедневно товары обновляются, и если товар\n            появился в наличии уведомить об этом клиента, путем отправки соответсвующего уведомления на email'),(61,'shop-auth-for-order','Требуется ли авторизация для оформления заказа','0','boolean','Оформление заказов','Данная опция позовляет включить/выключить\n            режим продажи товара незарегестрированным пользователям'),(62,'show-hide-purchase-price','Показывать поставщика и закупочные цены при оформлении заказа','0','boolean','Оформление заказов','Данная опция даст возможность скрыть или показать\n            закупочную цену товара и его поставщики при оформлении заказа'),(63,'shop-email-required-for-order','Обязательный ввод email для оформления заказа','0','boolean','Оформление заказов',''),(64,'response','Отоброжать блок с последними отзывами из раздела \"Отзывы о магазине\"','1','boolean','Блоки, отображение, внешний вид','Настройка отображения блока \"Отзывы о нас\" на сайте'),(65,'product-barcode-show','Показывать штрих-коды на сайте','1','boolean','Блоки, отображение, внешний вид','Включение/отключение отображения штрих-кодов на сайте'),(66,'project-show-line-project','Отображать поле проект для проектов','1','boolean','Внешний вид в админ-панели','Отображать поле проект для проектов, при редактировании проектов в админ-панели'),(67,'company-info-in-user-card','Отображать информацию о компании в карточке контакта','1','boolean','Внешний вид в админ-панели',''),(68,'product-downloadfile-ttl','Скачиваемые товары: время жизни ссылки','1440','string','Оформление заказов','Укажите время жизни ссылки (в минутах)'),(69,'response-maxcount','Блок отзывов: максимальное количество отоброжаемых отзывов','3','string','Блоки, отображение, внешний вид','Позволяет настроить количество выводимых записей в блок \"Отзывы о нас\"'),(70,'shop-onpage','Количество товаров на странице','12','string','Блоки, отображение, внешний вид',''),(71,'watermark-image','Водяной знак: изображение','','image','Водяные знаки','Принимается только формат PNG'),(72,'watermark-position-x','Водяной знак: позиция по ширине','center','string','Водяные знаки','Как накладывать водяной знак на картинку по ширине.\n            Можно указать значения left, right или center. После изменения не забудьте сбросить кеш.'),(73,'watermark-position-y','Водяной знак: позиция по высоте','center','string','Водяные знаки','Как накладывать водяной знак на картинку по высоте.\n            Можно указать значения top, bottom или center. После изменения не забудьте сбросить кеш.'),(74,'watermark-proportion-size','Водяной знак: относительный размер','4','string','Водяные знаки','Отношения размера изображения к размеру вотермарки.'),(75,'characteristics-message','Информация об измении комплектации','Характеристики и комплектация товара могут изменяться производителем без уведомления.','html','Блоки, отображение, внешний вид','Данный текст будет отображается в нижней части карточки товара.'),(76,'used-user-info','Соглашение о предоставлении личных данных','Хранение и использование компанией «WebProduction» предоставленных\n            пользователями личных данных полностью соответствует действующему законодательству\n            Украины о неприкосновенности личной информации. Личные данные пользователей не\n            предоставляются третьим лицам, но сохраняются для предоставления услуги продажи товаров,\n            представленных на нашем сайте. Компания оставляет за собой право\n            использовать данную информацию в маркетинговых целях.','html','Блоки, отображение, внешний вид','Информация, которую клиент видет при регистрации,\n            редактировании своего профиля и офрмлении заказа'),(77,'order-good-message','Сообщение после удачного оформления заказа','Спасибо за ваш заказ! В ближайшее время с вами свяжется наш менеджер.','html','Блоки, отображение, внешний вид','После удачного оформления заказа будет выводится это сообщение'),(78,'registration-good-message','Сообщение после удачной регистрации пользователя','Вы успешно зарегистрированы и вошли.','html','Блоки, отображение, внешний вид','После удачной регистрации будет выводится это сообщение'),(79,'logout-good-message','Сообщение после удачного выхода из системы','Вы успешно вышли из системы.','html','Блоки, отображение, внешний вид','После выхода из системы будет выводиться это сообщение'),(80,'warranty','Гарантии на товар','<ul>\n            <li>12 месяцев официальной гарантии от производителя.</li>\n            <li>обмен/возврат товара в течение 14 дней</li>\n            </ul>','html','Блоки, отображение, внешний вид','Позволяет добавить сообщение о гарантии по умолчанию'),(81,'payment','Оплата товара','<ul>\n            <li>товара может производится по факту получения</li>\n            </ul>','html','Блоки, отображение, внешний вид','Позволяет добавить сообщение об оплате товара по умолчанию'),(82,'delivery','Доставка товара','<ul>\n            <li>по городу: БЕСПЛАТНО!</li>\n            <li>оплата при получении товара</li>\n            </ul>','html','Блоки, отображение, внешний вид','Позволяет добавить сообщение о доставке по умолчанию'),(83,'seo-text-in-index-page','Текст на главную','','text','Блоки, отображение, внешний вид','SEO-текст вверху страницы'),(84,'copyright','Copyright','Copyright &copy; 2010-2015 <a href=\"http://webproduction.ua/\" target=\"_blank\">WebProduction&trade;</a>','html','Блоки, отображение, внешний вид',''),(85,'send-auto-feedback','Отправлять email клиенту, через 3 недели с просьбой, оставить комментарий','0','boolean','Оформление заказов','Включить автоматическую отправку писем, с просьбой оставить комментарий'),(86,'phone-mask','Маска (формат) для номеров телефонов','+38 (099) 999-99-99','string','Оформление заказов','Примеры масок: Украина +38 (099) 999-99-99,\n            Казахстан +7 (799) 999-99-99, Беларусь +375 (99) 999-99-99'),(87,'email-doublicates','Разрешить дубликаты email','0','boolean','Оформление заказов','Разрешить создание контактов с одинаковыми email'),(88,'phone-doublicates','Разрешить дубликаты телефона','0','boolean','Оформление заказов','Разрешить создание контактов с одинаковыми телефонами'),(89,'product-name-doublicates','Разрешить дубликаты товаров','1','boolean','Оформление заказов','Разрешить создание товаров с одинаковыми именами'),(90,'show-menu-brands','Показывать бренды в меню','1','boolean','Блоки, отображение, внешний вид','Включение/отключение  отображения кнопки Бренды в меню'),(91,'show-header-phone','Показывать телефоны в шапке сайта','1','boolean','Блоки, отображение, внешний вид','Включение/отключение  отображения телефонов в шапке сайта'),(92,'show-header-icq','Показывать ICQ в шапке сайта','0','boolean','Блоки, отображение, внешний вид','Включение/отключение  отображения ICQ в шапке сайта'),(93,'show-header-email','Показывать email в шапке сайта','0','boolean','Блоки, отображение, внешний вид','Включение/отключение  отображения email в шапке сайта'),(94,'show-header-address','Показывать адрес в шапке сайта','0','boolean','Блоки, отображение, внешний вид','Включение/отключение  отображения адреса в шапке сайта'),(95,'show-header-skype','Показывать Skype в шапке сайта','0','boolean','Блоки, отображение, внешний вид','Включение/отключение  отображения Skype в шапке сайта'),(96,'unregistered-users-to-post-reviews','Разрешить добавление отзывов незарегистрированными пользователями','1','boolean','Оформление заказов','Разрешить оставлять отзывы о магазине незарегистрированным пользователям'),(97,'image-format','Формат хранения изображений (в том числе thumbnail-файлов)','jpg','string','Блоки, отображение, внешний вид','Доступны: jpg, png. По умолчанию - jpg. Некоторые картинки все равно будут в формате PNG.'),(98,'crop-enable','Пропорции основного изображения: включить','1','boolean','Блоки, отображение, внешний вид','Если включена эта опция, то основное изображение будет только в определенных пропорциях'),(99,'cropwidth','Пропорции основного изображения: ширина','93','string','Блоки, отображение, внешний вид','введите пропорции соотношения ширины для основного изображения (например: 100).\n            Загружаемое изображение должно быть больше заданных пропорций.'),(100,'cropheight','Пропорции основного изображения: высота','70','string','Блоки, отображение, внешний вид','введите пропорции соотношения высоты для основного изображения (например: 100).\n            Загружаемое изображение должно быть больше заданных пропорций.'),(101,'order-dateto-days','Количество дней до выполнения заказа','3','string','Оформление заказов','Позволяет настроить параметр заказа\n            \"Выполнить до\"(по умолчанию +3 дня к дате оформления заказа)'),(102,'product-cansale-unavail','Можно заказывать товар, если его нет в наличии','1','boolean','Оформление заказов','Включение/отключение возможности покупки товара помеченного, как \"нет в наличии\"'),(103,'filtering-product-on-presence','Сортировать по наличию товара','1','boolean','Настройки магазина','Сначала идут товары которые есть в наличии, а потом которых в наличии нет'),(104,'manager-auto-author','Назначать менеджером того, кто создал контакт','1','boolean','Настройки магазина',''),(105,'user-account-activate','Активация аккаунта – подтверждение регистрации на сайте','1','boolean','Блоки, отображение, внешний вид','Включение/отключение подтверждения регистрации через e-mail'),(106,'price-rounding-off','Округление цен','0','boolean','Пересчет цен и наличия',''),(107,'favicon','Favicon','/_images/favicon.ico','image','Блоки, отображение, внешний вид','Изображение, которое  отображается браузером в адресной строке перед URL страницы'),(108,'background-image','Фоновая картинка','','image','Блоки, отображение, внешний вид','Изображение, которое  отображается как фон сайта\n            (Рекомендованные размеры: ширина - 1913px, высота - 1885px)'),(109,'image-404','Картинка 404','','image','Блоки, отображение, внешний вид','Изображение, которое отображается, когда не найдена страница на сайте.'),(110,'topBannerHeightMax','Максимальная высота баннера сверху','340','string','Блоки, отображение, внешний вид','Максимальная высота баннера, в пикселях, имеющего расположение \"Сверху\"'),(111,'shop-name','Название магазина','OneClick','string','Блоки, отображение, внешний вид',''),(112,'shop-slogan','Слоган магазина','OneClick','string','Блоки, отображение, внешний вид',''),(113,'product-url-type','Поле для формирования url-ов для товаров','name','string','SEO','Поле по которому будут формироватся ЧПУ для товаров. Доступные значения: name, code1c'),(114,'autoupdate','Разрешить автообновление системы на новую версию.','0','boolean','Автообновление',''),(115,'box-parser-email','Уведомления OneBox: обратный email','box@webproduction.ua','string','Уведомления OneBox по email','Почта, на которую можно отправлять комментарии к задачам и заказам'),(116,'box-parser-email-projectid','Уведомления OneBox: проект для неизвестных email','','string','Уведомления OneBox по email','Номер проекта, в который поставится задача, если будет неизвестное письмо на ящик box@'),(117,'box-parser-email-workflowid','Уведомления OneBox: бизнес-процесс для неизвестных email','','string','Уведомления OneBox по email','Номер БП, по которому поставится задача, если будет неизвестное письмо на ящик box@'),(118,'box-parser-email-managerid','Уведомления OneBox: ID сотрудника для неизвестных email','','string','Уведомления OneBox по email','Номер сотрудника, на которого поставится задача при неизвестном письме на box@'),(119,'box-email-signature','Общая подпись','<hr />\nС уважением, [name]<br>\n[company]<br>\n<br>\nОтправлено через OneBox - систему управления бизнесом, больше чем crm и erp.<br />\n<a href=\"http://webproduction.ua/onebox\">http://webproduction.ua/onebox</a><br />','html','Уведомления: шаблоны',''),(120,'calendar-show-issue','Какие данные о задаче отображать в календаре','a:2:{i:0;s:4:\"name\";i:1;s:7:\"project\";}','select-calendar-issue','Внешний вид в админ-панели',''),(121,'calendar-show-issue-priority','Сортировать задачи в календаре по времени, иначе по приоритетам','0','boolean','Внешний вид в админ-панели',''),(122,'calendar-show-type','Что отображать в календаре','a:3:{i:0;s:5:\"order\";i:1;s:5:\"issue\";i:2;s:7:\"project\";}','select-calendar-issue-type','Внешний вид в админ-панели',''),(123,'seo-meta-description-product','Шаблон meta description для товара','[avail] [price] грн! Бесплатная доставка по Украине. [phones]. [slogan].','html','SEO',''),(124,'seo-meta-description-category','Шаблон meta description для категории','[count] товаров! Бесплатная доставка по Украине. [phones]. [slogan].','html','SEO',''),(126,'seo-meta-description-brand','Шаблон meta description для бренда','[count] товаров! Бесплатная доставка по Украине. [phones]. [slogan].','html','SEO',''),(127,'seo-title-product','Шаблон title для товара','[name] - купить, цена, отзывы, доставка. [categorypath] [slogan]','html','SEO',''),(128,'seo-title-category','Шаблон title для категории','[categorypath]. Купить, сравнить, цены, отзывы, доставка. [slogan]','html','SEO',''),(129,'seo-title-tag','Шаблон title для SEO-тега','[name], купить, сравнить, цены, отзывы, доставка. [slogan]','html','SEO',''),(130,'seo-title-brand','Шаблон title для бренда','[name]. Купить, цены, отзывы, доставка. [slogan]','html','SEO',''),(131,'seo-hreflang','Alternate hreflang','','html','SEO',''),(139,'automatic-calculate-prices','Автоматический пересчет цен','a:1:{i:0;s:2:\"09\";}','chzn-select-time','Пересчет цен и наличия','Время выполнения автоматического пересчета цен'),(140,'priority-source-product','Приоритет выбора цены','supplier','select-margin-priority','Пересчет цен и наличия','Приоритет выбора цены продукта'),(141,'margin-not-avail-product','Пересчитывать цены для товаров, которых нет в наличии','0','boolean','Пересчет цен и наличия',''),(142,'api-key-novaposhta','Нова Пошта API key','','string','Интеграции: Нова Пошта',''),(143,'api-lang-novaposhta','Нова Пошта API Language','ru','select-language','Интеграции: Нова Пошта','Язык городов и отделений'),(144,'api-product-width-novaposhta','Нова Пошта, ширина товара по умолчанию, см','30','string','Интеграции: Нова Пошта','Расчет стоимости доставки'),(145,'api-product-height-novaposhta','Нова Пошта, высота товара по умолчанию, см','30','string','Интеграции: Нова Пошта','Расчет стоимости доставки'),(146,'api-product-length-novaposhta','Нова Пошта, длина товара по умолчанию, см','30','string','Интеграции: Нова Пошта','Расчет стоимости доставки'),(147,'api-product-weight-novaposhta','Нова Пошта, вес товара по умолчанию, кг','1','string','Интеграции: Нова Пошта','Расчет стоимости доставки'),(148,'api-recipient-city-novaposhta','Нова Пошта, город с которого будет производиться отправка','Чернигов','string','Интеграции: Нова Пошта','Расчет стоимости доставки'),(149,'api-company-novaposhta','Нова Пошта, Компания отправитель','','string','Интеграции: Нова Пошта',''),(150,'api-person-novaposhta','Нова Пошта, Контактное лицо','','string','Интеграции: Нова Пошта',''),(151,'api-phone-novaposhta','Нова Пошта, Контактный телефон','','string','Интеграции: Нова Пошта',''),(152,'api-number-novaposhta','Нова Пошта, Номер отделения','','string','Интеграции: Нова Пошта','Просто число, например 10');
/*!40000 ALTER TABLE `shopsettings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopsource`
--

DROP TABLE IF EXISTS `shopsource`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopsource` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopsource`
--

LOCK TABLES `shopsource` WRITE;
/*!40000 ALTER TABLE `shopsource` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopsource` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopstorage`
--

DROP TABLE IF EXISTS `shopstorage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopstorage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transactionid` int(11) NOT NULL,
  `storagenamefromid` int(11) NOT NULL,
  `storagenametoid` int(11) NOT NULL,
  `productid` int(11) NOT NULL,
  `productname` varchar(255) NOT NULL,
  `parentid` int(11) NOT NULL,
  `isbox` tinyint(1) NOT NULL,
  `serial` varchar(255) NOT NULL,
  `code` varchar(32) NOT NULL,
  `shipment` varchar(255) NOT NULL,
  `contractorid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `cdate` datetime NOT NULL,
  `date` datetime NOT NULL,
  `amount` decimal(15,3) NOT NULL,
  `price` decimal(15,2) NOT NULL,
  `currencyrate` decimal(15,2) NOT NULL,
  `currencyid` int(11) NOT NULL,
  `taxrate` decimal(15,3) NOT NULL,
  `pricebase` decimal(15,2) NOT NULL,
  `type` enum('incoming','transfer','sale','production','outcoming') NOT NULL,
  `storageorderproductid` int(11) NOT NULL,
  `warranty` varchar(255) NOT NULL,
  `document` varchar(255) NOT NULL,
  `workerid` int(11) NOT NULL,
  `workeroperation` varchar(255) NOT NULL,
  `return` tinyint(1) NOT NULL,
  `request` varchar(255) NOT NULL,
  `orderproductid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_storagenametoid` (`storagenametoid`,`code`,`cdate`),
  KEY `index_transactionid` (`transactionid`),
  KEY `index_productid` (`productid`,`date`),
  KEY `index_code` (`code`,`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopstorage`
--

LOCK TABLES `shopstorage` WRITE;
/*!40000 ALTER TABLE `shopstorage` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopstorage` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopstoragebalance`
--

DROP TABLE IF EXISTS `shopstoragebalance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopstoragebalance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `storagenameid` int(11) NOT NULL,
  `productid` int(11) NOT NULL,
  `productname` varchar(255) NOT NULL,
  `code` varchar(32) NOT NULL,
  `shipment` varchar(255) NOT NULL,
  `serial` varchar(255) NOT NULL,
  `cdate` datetime NOT NULL,
  `pricebase` decimal(15,2) NOT NULL,
  `amount` decimal(15,3) NOT NULL,
  `amountlinked` decimal(15,3) NOT NULL,
  `cost` decimal(15,2) NOT NULL,
  `price` decimal(15,2) NOT NULL,
  `currencyrate` decimal(15,2) NOT NULL,
  `currencyid` int(11) NOT NULL,
  `taxrate` decimal(15,3) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_balance1` (`storagenameid`,`productid`,`serial`),
  KEY `index_balance2` (`storagenameid`,`amount`,`productname`),
  KEY `index_productcdate` (`productid`,`cdate`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopstoragebalance`
--

LOCK TABLES `shopstoragebalance` WRITE;
/*!40000 ALTER TABLE `shopstoragebalance` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopstoragebalance` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopstoragebasket`
--

DROP TABLE IF EXISTS `shopstoragebasket`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopstoragebasket` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cdate` datetime NOT NULL,
  `userid` int(11) NOT NULL,
  `type` enum('incoming','transfer','sale','production','stocktaking','outcoming') NOT NULL,
  `orderid` int(11) NOT NULL,
  `productid` int(11) NOT NULL,
  `amount` decimal(15,3) NOT NULL,
  `serial` varchar(255) NOT NULL,
  `orderproductid` int(11) NOT NULL,
  `storageorderproductid` int(11) NOT NULL,
  `storageordersync` tinyint(1) NOT NULL,
  `shipment` varchar(255) NOT NULL,
  `price` decimal(15,2) NOT NULL,
  `currencyid` int(11) NOT NULL,
  `warranty` varchar(255) NOT NULL,
  `tax` tinyint(1) NOT NULL,
  `workerid` int(11) NOT NULL,
  `workeroperation` varchar(255) NOT NULL,
  `storagenamefromid` int(11) NOT NULL,
  `istarget` tinyint(1) NOT NULL,
  `passportid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopstoragebasket`
--

LOCK TABLES `shopstoragebasket` WRITE;
/*!40000 ALTER TABLE `shopstoragebasket` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopstoragebasket` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopstoragelink`
--

DROP TABLE IF EXISTS `shopstoragelink`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopstoragelink` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cdate` datetime NOT NULL,
  `storagebalanceid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `basketid` int(11) NOT NULL,
  `amount` decimal(15,3) NOT NULL,
  `orderid` int(11) NOT NULL,
  `orderproductid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_basketid` (`basketid`),
  KEY `index_orderproductid` (`orderproductid`),
  KEY `index_storagebalanceid` (`storagebalanceid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopstoragelink`
--

LOCK TABLES `shopstoragelink` WRITE;
/*!40000 ALTER TABLE `shopstoragelink` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopstoragelink` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopstoragename`
--

DROP TABLE IF EXISTS `shopstoragename`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopstoragename` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `userid` int(11) NOT NULL,
  `forsale` tinyint(1) NOT NULL,
  `isvendor` tinyint(1) NOT NULL,
  `issold` tinyint(1) NOT NULL,
  `isemployee` tinyint(1) NOT NULL,
  `isoutcoming` tinyint(1) NOT NULL,
  `isproduction` tinyint(1) NOT NULL,
  `hidden` tinyint(1) NOT NULL,
  `linkkey` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_forsale` (`forsale`,`name`),
  KEY `index_isvendor` (`isvendor`,`name`),
  KEY `index_issold` (`issold`,`name`),
  KEY `index_isemployee` (`isemployee`,`name`),
  KEY `index_isoutcoming` (`isoutcoming`,`name`),
  KEY `index_isproduction` (`isproduction`,`name`),
  KEY `index_hidden` (`hidden`,`name`),
  KEY `index_linkkey` (`linkkey`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopstoragename`
--

LOCK TABLES `shopstoragename` WRITE;
/*!40000 ALTER TABLE `shopstoragename` DISABLE KEYS */;
INSERT INTO `shopstoragename` VALUES (1,'Продажи',0,0,0,1,0,0,0,0,''),(2,'Производство',0,0,0,0,0,0,1,0,''),(3,'Расход',0,0,0,0,0,1,0,0,'');
/*!40000 ALTER TABLE `shopstoragename` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopstorageorder`
--

DROP TABLE IF EXISTS `shopstorageorder`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopstorageorder` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cdate` datetime NOT NULL,
  `userid` int(11) NOT NULL,
  `type` enum('incoming','transfer','production') NOT NULL,
  `storagenamefromid` int(11) NOT NULL,
  `storagenametoid` int(11) NOT NULL,
  `isshipped` tinyint(1) NOT NULL,
  `sum` decimal(15,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopstorageorder`
--

LOCK TABLES `shopstorageorder` WRITE;
/*!40000 ALTER TABLE `shopstorageorder` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopstorageorder` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopstorageorder2transaction`
--

DROP TABLE IF EXISTS `shopstorageorder2transaction`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopstorageorder2transaction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `orderid` int(11) NOT NULL,
  `transactionid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopstorageorder2transaction`
--

LOCK TABLES `shopstorageorder2transaction` WRITE;
/*!40000 ALTER TABLE `shopstorageorder2transaction` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopstorageorder2transaction` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopstorageordertproduct`
--

DROP TABLE IF EXISTS `shopstorageordertproduct`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopstorageordertproduct` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `orderid` int(11) NOT NULL,
  `productid` int(11) NOT NULL,
  `amount` decimal(15,3) NOT NULL,
  `price` decimal(15,2) NOT NULL,
  `currencyrate` decimal(15,2) NOT NULL,
  `currencyid` int(11) NOT NULL,
  `taxrate` decimal(15,3) NOT NULL,
  `isshipped` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopstorageordertproduct`
--

LOCK TABLES `shopstorageordertproduct` WRITE;
/*!40000 ALTER TABLE `shopstorageordertproduct` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopstorageordertproduct` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopstoragereportsales`
--

DROP TABLE IF EXISTS `shopstoragereportsales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopstoragereportsales` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cdate` datetime NOT NULL,
  `dateorder` datetime NOT NULL,
  `dateship` datetime NOT NULL,
  `dateincoming` datetime NOT NULL,
  `orderid` int(11) NOT NULL,
  `clientid` int(11) NOT NULL,
  `managerid` int(11) NOT NULL,
  `discountpercent` int(11) NOT NULL,
  `sumorder` decimal(15,2) NOT NULL,
  `sumship` decimal(15,2) NOT NULL,
  `sumcost` decimal(15,2) NOT NULL,
  `orderproductid` int(11) NOT NULL,
  `productid` int(11) NOT NULL,
  `productname` varchar(255) NOT NULL,
  `productprice` decimal(15,2) NOT NULL,
  `productamountorder` decimal(15,3) NOT NULL,
  `productamountship` decimal(15,3) NOT NULL,
  `productsumorder` decimal(15,2) NOT NULL,
  `productsumship` decimal(15,2) NOT NULL,
  `productsumcost` decimal(15,2) NOT NULL,
  `transactionid` int(11) NOT NULL,
  `storagenameid` int(11) NOT NULL,
  `supplierid` int(11) NOT NULL,
  `storageid` int(11) NOT NULL,
  `storageprice` decimal(15,2) NOT NULL,
  `storageamountorder` decimal(15,3) NOT NULL,
  `storageamountship` decimal(15,3) NOT NULL,
  `storagesumorder` decimal(15,2) NOT NULL,
  `storagesumship` decimal(15,2) NOT NULL,
  `storagesumcost` decimal(15,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopstoragereportsales`
--

LOCK TABLES `shopstoragereportsales` WRITE;
/*!40000 ALTER TABLE `shopstoragereportsales` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopstoragereportsales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopstoragereserve`
--

DROP TABLE IF EXISTS `shopstoragereserve`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopstoragereserve` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `storagenameid` int(11) NOT NULL,
  `productid` int(11) NOT NULL,
  `amount` decimal(15,3) NOT NULL,
  `rrc` decimal(15,2) NOT NULL,
  `currencyid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `index_storagenameid_productid` (`storagenameid`,`productid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopstoragereserve`
--

LOCK TABLES `shopstoragereserve` WRITE;
/*!40000 ALTER TABLE `shopstoragereserve` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopstoragereserve` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopstoragetransaction`
--

DROP TABLE IF EXISTS `shopstoragetransaction`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopstoragetransaction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `cdate` datetime NOT NULL,
  `date` datetime NOT NULL,
  `amount` decimal(15,3) NOT NULL,
  `cost` decimal(15,2) NOT NULL,
  `type` enum('incoming','transfer','sale','production','outcoming') NOT NULL,
  `storagenamefromid` int(11) NOT NULL,
  `storagenametoid` int(11) NOT NULL,
  `return` tinyint(1) NOT NULL,
  `returntransactionid` int(11) NOT NULL,
  `document` varchar(255) NOT NULL,
  `request` varchar(255) NOT NULL,
  `orderid` int(11) NOT NULL,
  `client` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_type` (`type`,`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopstoragetransaction`
--

LOCK TABLES `shopstoragetransaction` WRITE;
/*!40000 ALTER TABLE `shopstoragetransaction` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopstoragetransaction` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopsupplier`
--

DROP TABLE IF EXISTS `shopsupplier`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopsupplier` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `contactid` int(11) NOT NULL,
  `workflowid` int(11) NOT NULL,
  `hidden` tinyint(1) NOT NULL,
  `color` varchar(7) NOT NULL,
  `deliverytime` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_contactid` (`contactid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopsupplier`
--

LOCK TABLES `shopsupplier` WRITE;
/*!40000 ALTER TABLE `shopsupplier` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopsupplier` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shoptablecolumn`
--

DROP TABLE IF EXISTS `shoptablecolumn`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shoptablecolumn` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `key` varchar(255) NOT NULL,
  `visible` tinyint(1) NOT NULL,
  `datasource` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_datasource` (`datasource`),
  KEY `index_useridatasource` (`userid`,`datasource`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shoptablecolumn`
--

LOCK TABLES `shoptablecolumn` WRITE;
/*!40000 ALTER TABLE `shoptablecolumn` DISABLE KEYS */;
/*!40000 ALTER TABLE `shoptablecolumn` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shoptextpage`
--

DROP TABLE IF EXISTS `shoptextpage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shoptextpage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `btnname` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `parentid` int(11) NOT NULL,
  `logicclass` varchar(255) NOT NULL,
  `sort` int(11) NOT NULL,
  `hidden` tinyint(1) NOT NULL,
  `main` tinyint(1) NOT NULL,
  `url` varchar(100) NOT NULL,
  `key` varchar(255) NOT NULL,
  `seodescription` varchar(255) NOT NULL,
  `seotitle` varchar(255) NOT NULL,
  `seoh1` varchar(255) NOT NULL,
  `seocontent` text NOT NULL,
  `seokeywords` varchar(255) NOT NULL,
  `linkkey` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_url` (`url`),
  KEY `index_linkkey` (`linkkey`),
  KEY `index_parent` (`parentid`,`hidden`,`sort`,`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shoptextpage`
--

LOCK TABLES `shoptextpage` WRITE;
/*!40000 ALTER TABLE `shoptextpage` DISABLE KEYS */;
/*!40000 ALTER TABLE `shoptextpage` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shoptimework`
--

DROP TABLE IF EXISTS `shoptimework`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shoptimework` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `datefrom` datetime NOT NULL,
  `dateto` datetime NOT NULL,
  `comment` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shoptimework`
--

LOCK TABLES `shoptimework` WRITE;
/*!40000 ALTER TABLE `shoptimework` DISABLE KEYS */;
/*!40000 ALTER TABLE `shoptimework` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopuser2group`
--

DROP TABLE IF EXISTS `shopuser2group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopuser2group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `groupid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `index_groupiduserid` (`groupid`,`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopuser2group`
--

LOCK TABLES `shopuser2group` WRITE;
/*!40000 ALTER TABLE `shopuser2group` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopuser2group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopuseremail`
--

DROP TABLE IF EXISTS `shopuseremail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopuseremail` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `userid` bigint(20) unsigned NOT NULL,
  `email` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `index_emailuserid` (`email`,`userid`),
  KEY `index_userid` (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopuseremail`
--

LOCK TABLES `shopuseremail` WRITE;
/*!40000 ALTER TABLE `shopuseremail` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopuseremail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopusereventprediction`
--

DROP TABLE IF EXISTS `shopusereventprediction`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopusereventprediction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `cdate` datetime NOT NULL,
  `pdate` datetime NOT NULL,
  `probablity` float NOT NULL,
  `comment` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopusereventprediction`
--

LOCK TABLES `shopusereventprediction` WRITE;
/*!40000 ALTER TABLE `shopusereventprediction` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopusereventprediction` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopusereventrecommend`
--

DROP TABLE IF EXISTS `shopusereventrecommend`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopusereventrecommend` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `day` int(11) NOT NULL,
  `time` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopusereventrecommend`
--

LOCK TABLES `shopusereventrecommend` WRITE;
/*!40000 ALTER TABLE `shopusereventrecommend` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopusereventrecommend` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopuserfield`
--

DROP TABLE IF EXISTS `shopuserfield`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopuserfield` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `groupid` int(11) NOT NULL,
  `idkey` varchar(255) NOT NULL,
  `name` varchar(64) NOT NULL,
  `type` varchar(32) NOT NULL,
  `hidden` tinyint(1) NOT NULL,
  `filterable` tinyint(1) NOT NULL,
  `showinpreview` tinyint(1) NOT NULL,
  `showinorder` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `index_idkeygroupid` (`idkey`,`groupid`),
  UNIQUE KEY `index_namegroupid` (`groupid`,`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopuserfield`
--

LOCK TABLES `shopuserfield` WRITE;
/*!40000 ALTER TABLE `shopuserfield` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopuserfield` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopusergroup`
--

DROP TABLE IF EXISTS `shopusergroup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopusergroup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `group` varchar(50) NOT NULL,
  `sort` int(11) NOT NULL,
  `logicclass` varchar(255) NOT NULL,
  `colour` varchar(255) NOT NULL,
  `pricelevel` int(11) NOT NULL,
  `cnt` int(11) NOT NULL,
  `cntlast` int(11) NOT NULL,
  `parentid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_group` (`group`),
  KEY `index_sort` (`sort`),
  KEY `index_parentid` (`parentid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopusergroup`
--

LOCK TABLES `shopusergroup` WRITE;
/*!40000 ALTER TABLE `shopusergroup` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopusergroup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopuserlegal`
--

DROP TABLE IF EXISTS `shopuserlegal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopuserlegal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `format` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_userid` (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopuserlegal`
--

LOCK TABLES `shopuserlegal` WRITE;
/*!40000 ALTER TABLE `shopuserlegal` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopuserlegal` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopuserlegaldata`
--

DROP TABLE IF EXISTS `shopuserlegaldata`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopuserlegaldata` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `legalid` int(11) NOT NULL,
  `key` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_legalid` (`legalid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopuserlegaldata`
--

LOCK TABLES `shopuserlegaldata` WRITE;
/*!40000 ALTER TABLE `shopuserlegaldata` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopuserlegaldata` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopuserlink`
--

DROP TABLE IF EXISTS `shopuserlink`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopuserlink` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user1id` int(11) NOT NULL,
  `user2id` int(11) NOT NULL,
  `comment` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopuserlink`
--

LOCK TABLES `shopuserlink` WRITE;
/*!40000 ALTER TABLE `shopuserlink` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopuserlink` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopuserphone`
--

DROP TABLE IF EXISTS `shopuserphone`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopuserphone` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `userid` bigint(20) unsigned NOT NULL,
  `phone` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `index_phoneuserid` (`phone`,`userid`),
  KEY `index_userid` (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopuserphone`
--

LOCK TABLES `shopuserphone` WRITE;
/*!40000 ALTER TABLE `shopuserphone` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopuserphone` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopuservoip`
--

DROP TABLE IF EXISTS `shopuservoip`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopuservoip` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from` varchar(32) NOT NULL,
  `to` varchar(32) NOT NULL,
  `cdate` datetime NOT NULL,
  `udate` datetime NOT NULL,
  `status` varchar(32) NOT NULL,
  `channel` varchar(32) NOT NULL,
  `line` varchar(32) NOT NULL,
  `duration` varchar(10) NOT NULL,
  `closed` tinyint(1) NOT NULL,
  `comment` text NOT NULL,
  `contactfromid` int(11) NOT NULL,
  `contacttoid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_to` (`to`),
  KEY `index_from` (`from`),
  KEY `index_fromid` (`contactfromid`),
  KEY `index_toid` (`contacttoid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopuservoip`
--

LOCK TABLES `shopuservoip` WRITE;
/*!40000 ALTER TABLE `shopuservoip` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopuservoip` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopuservoipactive2`
--

DROP TABLE IF EXISTS `shopuservoipactive2`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopuservoipactive2` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `number` varchar(32) NOT NULL,
  `contactid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopuservoipactive2`
--

LOCK TABLES `shopuservoipactive2` WRITE;
/*!40000 ALTER TABLE `shopuservoipactive2` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopuservoipactive2` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopuserworktime`
--

DROP TABLE IF EXISTS `shopuserworktime`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopuserworktime` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `cdate` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `index_usercdate` (`userid`,`cdate`),
  KEY `userid` (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopuserworktime`
--

LOCK TABLES `shopuserworktime` WRITE;
/*!40000 ALTER TABLE `shopuserworktime` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopuserworktime` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopworkflowmenu`
--

DROP TABLE IF EXISTS `shopworkflowmenu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopworkflowmenu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `linkkey` varchar(255) NOT NULL,
  `sort` int(11) NOT NULL,
  `workflowid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopworkflowmenu`
--

LOCK TABLES `shopworkflowmenu` WRITE;
/*!40000 ALTER TABLE `shopworkflowmenu` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopworkflowmenu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopworkflowstatusblock`
--

DROP TABLE IF EXISTS `shopworkflowstatusblock`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopworkflowstatusblock` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `contentid` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopworkflowstatusblock`
--

LOCK TABLES `shopworkflowstatusblock` WRITE;
/*!40000 ALTER TABLE `shopworkflowstatusblock` DISABLE KEYS */;
INSERT INTO `shopworkflowstatusblock` VALUES (1,'Название','box-admin-block-name'),(2,'Описание','box-admin-block-description'),(3,'Инструкция к этапу','box-admin-block-stage-instruction'),(4,'История статусов','box-admin-block-stage-history'),(5,'Информация о контакте полная','box-admin-block-client-info-full'),(6,'Список активных заказов','box-admin-block-active-order'),(7,'Продукты','box-admin-block-product-list'),(8,'Дерево проекта','box-admin-block-project-tree'),(9,'Структура','box-admin-block-issue-structure'),(10,'Лента комментариев','box-admin-block-comment-list'),(11,'Информация полная','box-admin-block-info'),(12,'Информация о контакте','box-admin-block-client-info'),(13,'Информация о статусе','box-admin-block-status-info'),(14,'График активности проекта','box-admin-block-graph-activities'),(15,'График нагрузки на исполнителей проекта','box-admin-block-graph-load'),(16,'Визуализация бизнес-процесса','box-admin-block-workflow-visual'),(17,'Продукты сокращенный','box-admin-block-product-list-short'),(18,'Вложенные файлы','box-admin-block-files'),(19,'Внести результат','box-admin-block-make-result'),(20,'Написать письмо','box-admin-block-write-letter'),(21,'Позвонить','box-admin-block-call'),(22,'Короткая информация о заказе','box-admin-block-info-short'),(23,'Заполнить карточку контакта','box-admin-block-user-card-fill'),(24,'Поставить задачи','box-admin-block-issues-add'),(25,'Похожие задачи','box-admin-block-issues-like'),(26,'Мои заказы','box-admin-block-my-order'),(27,'Список задач проекта','box-admin-block-project-order'),(28,'Новая Почта','box-admin-block-novaposhta');
/*!40000 ALTER TABLE `shopworkflowstatusblock` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopworkflowstatusstructureblock`
--

DROP TABLE IF EXISTS `shopworkflowstatusstructureblock`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopworkflowstatusstructureblock` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `statusid` int(11) NOT NULL,
  `structureid` int(11) NOT NULL,
  `blockid` int(11) NOT NULL,
  `sort` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopworkflowstatusstructureblock`
--

LOCK TABLES `shopworkflowstatusstructureblock` WRITE;
/*!40000 ALTER TABLE `shopworkflowstatusstructureblock` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopworkflowstatusstructureblock` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopworkflowtype`
--

DROP TABLE IF EXISTS `shopworkflowtype`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopworkflowtype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `multiplename` varchar(255) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `typeaddpage` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopworkflowtype`
--

LOCK TABLES `shopworkflowtype` WRITE;
/*!40000 ALTER TABLE `shopworkflowtype` DISABLE KEYS */;
INSERT INTO `shopworkflowtype` VALUES (1,'Проект','','','project',''),(2,'Задача','','','issue',''),(3,'Заказ','','','order','');
/*!40000 ALTER TABLE `shopworkflowtype` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `smsutils_que`
--

DROP TABLE IF EXISTS `smsutils_que`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `smsutils_que` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cdate` datetime NOT NULL,
  `status` tinyint(1) NOT NULL,
  `pdate` datetime NOT NULL,
  `sender` varchar(255) NOT NULL,
  `to` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `result` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `smsutils_que`
--

LOCK TABLES `smsutils_que` WRITE;
/*!40000 ALTER TABLE `smsutils_que` DISABLE KEYS */;
/*!40000 ALTER TABLE `smsutils_que` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `useracl`
--

DROP TABLE IF EXISTS `useracl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `useracl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `acl` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_userid` (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `useracl`
--

LOCK TABLES `useracl` WRITE;
/*!40000 ALTER TABLE `useracl` DISABLE KEYS */;
/*!40000 ALTER TABLE `useracl` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `useraclkey`
--

DROP TABLE IF EXISTS `useraclkey`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `useraclkey` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_key` (`key`),
  KEY `index_name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=2767 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `useraclkey`
--

LOCK TABLES `useraclkey` WRITE;
/*!40000 ALTER TABLE `useraclkey` DISABLE KEYS */;
INSERT INTO `useraclkey` VALUES (2581,'discount','Скидки'),(2582,'brands','Бренды'),(2583,'category','Категории'),(2584,'products','Продукты'),(2585,'products-owner-edit','Продукты :: редактирование своих продуктов'),(2586,'products-edit','Продукты :: редактирование всех продуктов'),(2587,'products-edit-quick','Продукты: быстрое редактирование всех продуктов'),(2588,'products-noticeavailability','Продукты :: Уведомить о наличии'),(2589,'products-copy','Продукты :: копирование продуктов'),(2590,'products-lists','Продукты :: Cписки продуктов'),(2591,'products-delete','Продукты :: удаление продуктов'),(2592,'products-add','Продукты :: добавление продуктов'),(2593,'products-related','Продукты :: управление связанными продуктами'),(2594,'products-views','Продукты :: статистика просмотров'),(2595,'products-comments','Продукты :: управление комментариями'),(2596,'products-orders','Продукты :: просмотр заказов'),(2597,'products-history','Продукты :: просмотр истории'),(2598,'products-filters','Продукты :: фильтры и характеристики'),(2599,'products-suppliers','Продукты :: поставщики'),(2600,'products-import','Продукты :: импорт продуктов'),(2601,'products-keywords-import','Продукты :: импорт ключевых слов'),(2602,'products-import-from-yml','Продукты :: импорт из YML'),(2603,'products-icon','Продукты :: значки продуктов'),(2604,'settings','Настройки'),(2605,'comments','Комментарии'),(2606,'pages','Текстовые страницы'),(2607,'priceplaces','Управление прайс-площадками'),(2608,'prices','Управление прайсами'),(2609,'activity','Просмотр истории и активности'),(2610,'statistic','Просмотр статистики'),(2611,'news','Управление новостями, блогом, статьями'),(2612,'products-list','Продукты :: просмотр всех списков продукта'),(2613,'callback','Управление заказными звонками'),(2614,'feedback','Управление обратной связью'),(2615,'timework','Управление расписанием работы'),(2616,'logo','Управление логотипами'),(2617,'contractors','Управление юридическими лицами'),(2618,'faq','Управление вопросами и ответами (FAQ)'),(2619,'delivery','Управление способами доставки'),(2620,'banner','Управление баннерами'),(2621,'payment','Управление способами оплаты'),(2622,'supplier','Управление списком поставщиков'),(2623,'guestbook','Управление отзывами о проекте'),(2624,'ticket-support','Support ticket'),(2625,'block','Управление блоками'),(2626,'redirect','URL и редиректы'),(2627,'gallery','Управление галереей'),(2628,'report_callcenter','Отчеты :: Call-центр'),(2629,'report_notify','Отчеты :: Уведомления системы'),(2630,'report_summary','Отчеты :: Сводные данные'),(2631,'role','Настройки :: Дерево ролей'),(2632,'comment_template','acl-comment_template'),(2633,'structure','Структура компании'),(2634,'quiz','Опросы'),(2635,'users','Контакты'),(2636,'users-online','Контакты :: Контакты online'),(2637,'users-mass-mailing','Контакты :: Массовая рассылка'),(2638,'users-groups','Контакты :: Группы'),(2639,'users-add','Контакты :: Добавление нового контакта'),(2640,'users-all-view','Контакты :: Все контакты :: Просмотр'),(2641,'users-all-edit','Контакты :: Все контакты :: Управление'),(2642,'users_kpi','Контакты :: KPI'),(2643,'users-group-0-view','Контакты :: Доступ по группе ::  Без группы :: Просмотр'),(2644,'users-group-0-change','Контакты :: Доступ по группе ::  Без группы :: Управление'),(2645,'users-manager-0-view','Контакты :: Доступ по менеджеру :: Без менеджера :: Просмотр'),(2646,'users-manager-0-change','Контакты :: Доступ по менеджеру :: Без менеджера :: Управление'),(2647,'users-level-0-view','Контакты :: Доступ по уровню :: Заблокированные :: Просмотр'),(2648,'users-level-0-change','Контакты :: Доступ по уровню :: Заблокированные :: Управление'),(2649,'users-level-1-view','Контакты :: Доступ по уровню :: Клиенты и контакты :: Просмотр'),(2650,'users-level-1-change','Контакты :: Доступ по уровню :: Клиенты и контакты :: Управление'),(2651,'users-level-2-view','Контакты :: Доступ по уровню :: Менеджеры :: Просмотр'),(2652,'users-level-2-change','Контакты :: Доступ по уровню :: Менеджеры :: Управление'),(2653,'users-level-3-view','Контакты :: Доступ по уровню :: Администраторы :: Просмотр'),(2654,'users-level-3-change','Контакты :: Доступ по уровню :: Администраторы :: Управление'),(2655,'report_event','События'),(2656,'orders','Заказы'),(2657,'order-delete','Заказы :: Удаление и восстановление заказов'),(2658,'orders-all-view','Заказы :: Все заказы :: Просмотр'),(2659,'orders-all-edit','Заказы :: Все заказы :: Управление'),(2660,'orders-direction-in','Заказы :: Направление :: Входящие'),(2661,'orders-direction-out','Заказы :: Направление :: Исходящие'),(2662,'orders-add','Заказы :: Добавление нового заказа'),(2663,'report-productmatrix','Отчеты :: Матрица продуктов и клиентов'),(2664,'report-topproducts','Отчеты :: Самые заказываемые продукты'),(2665,'product-seo-tags-edit','Редактирование seo тегов'),(2666,'orders-status-all-view','Заказы :: Доступ по статусу ::  Все статусы :: Просмотр'),(2667,'orders-status-all-change','Заказы :: Доступ по статусу ::  Все статусы :: Управление'),(2668,'orders-status-1-view','Заказы :: Доступ по статусу :: Новый Заказ :: #0 / Новый :: Просмотр'),(2669,'orders-status-1-change','Заказы :: Доступ по статусу :: Новый Заказ :: #0 / Новый :: Управление'),(2670,'orders-manager-all-view','Заказы :: Доступ по менеджеру ::  Все менеджеры :: Просмотр'),(2671,'orders-manager-all-change','Заказы :: Доступ по менеджеру ::  Все менеджеры :: Управление'),(2672,'orders-category-all-view','Заказы :: Доступ по категории ::  Все категории :: Просмотр'),(2673,'orders-category-all-change','Заказы :: Доступ по категории ::  Все категории :: Управление'),(2674,'orders-category-1-view','Заказы :: Доступ по категории :: Новый Заказ :: Просмотр'),(2675,'orders-category-1-change','Заказы :: Доступ по категории :: Новый Заказ :: Управление'),(2676,'orders-category-0-view','Заказы :: Доступ по категории :: Без категории :: Просмотр'),(2677,'orders-category-0-change','Заказы :: Доступ по категории :: Без категории :: Управление'),(2678,'notify-order-category-1','Автоматический наблюдатель :: Заказы :: Новый Заказ'),(2679,'documents','Документы'),(2680,'documents-all-view','Документы :: Все документы :: Просмотр'),(2681,'documents-all-edit','Документы :: Все документы :: Редактирование'),(2682,'documents-all-delete','Документы :: Все документы :: Удаление'),(2683,'document-print-7','Документы :: Создание документов :: Акт выполненных работ (EN)'),(2684,'document-print-4','Документы :: Создание документов :: Акт выполненных работ (RU)'),(2685,'document-print-1','Документы :: Создание документов :: Акт выполненных работ (UA)'),(2686,'document-print-9','Документы :: Создание документов :: Накладная заказа (EN)'),(2687,'document-print-20','Документы :: Создание документов :: Накладная заказа (EN)'),(2688,'document-print-6','Документы :: Создание документов :: Накладная заказа (RU)'),(2689,'document-print-16','Документы :: Создание документов :: Накладная заказа (RU)'),(2690,'document-print-3','Документы :: Создание документов :: Накладная заказа (UA)'),(2691,'document-print-12','Документы :: Создание документов :: Накладная заказа (UA)'),(2692,'document-print-21','Документы :: Создание документов :: Перемещение (EN)'),(2693,'document-print-17','Документы :: Создание документов :: Перемещение (RU)'),(2694,'document-print-13','Документы :: Создание документов :: Перемещение (UA)'),(2695,'document-print-8','Документы :: Создание документов :: Счет-фактура (EN)'),(2696,'document-print-5','Документы :: Создание документов :: Счет-фактура (RU)'),(2697,'document-print-2','Документы :: Создание документов :: Счет-фактура (UA)'),(2698,'document-print-19','Документы :: Создание документов :: Штрих-коды внешние (EN)'),(2699,'document-print-15','Документы :: Создание документов :: Штрих-коды внешние (RU)'),(2700,'document-print-11','Документы :: Создание документов :: Штрих-коды внешние (UA)'),(2701,'document-print-18','Документы :: Создание документов :: Штрих-коды внутренние (EN)'),(2702,'document-print-14','Документы :: Создание документов :: Штрих-коды внутренние (RU)'),(2703,'document-print-10','Документы :: Создание документов :: Штрих-коды внутренние (UA)'),(2704,'finance','Финансовый учет'),(2705,'finance-report-category','Финансовый учет :: <strong>Отчет по категориям</strong>'),(2706,'finance-report-account','Финансовый учет :: <strong>Отчет по аккаунтам</strong>'),(2707,'finance-report-balance','Финансовый учет :: <strong>Отчет Баланс по клиенту</strong>'),(2708,'finance-invoice','Финансовый учет :: Инвойсы'),(2709,'storage','Складской учет'),(2710,'storage-incoming','Складской учет :: Оприходование'),(2711,'storage-transfer','Складской учет :: Перемещение/Производство'),(2712,'storage-sale','Складской учет :: Отгрузка'),(2713,'storage-sale-quick','Складской учет :: Быстрая продажа'),(2714,'storage-production','Складской учет :: Производство'),(2715,'storage-outcoming','Складской учет :: Списание'),(2716,'storage-balance','Складской учет :: Просмотр баланса'),(2717,'storage-balance-vendors','Складской учет :: Отчет о закупках'),(2718,'storage-balance-sales','Складской учет :: Отчет об отгрузках'),(2719,'storage-motionlog','Складской учет :: Журнал'),(2720,'storage-motionlog-edit','Складской учет :: Редактирование записей журнала'),(2721,'storage-motionlog-delete','Складской учет :: Удаление записей журнала'),(2722,'storage-motionlog-return','Складской учет :: Возврат'),(2723,'storage-report-sales','Складской учет :: Отчет по прибыли'),(2724,'storage-report-motion','Складской учет :: Отчет об изменении баланса'),(2725,'storage-barcode','Складской учет :: Штрих-кодирование'),(2726,'storage-settings','Складской учет :: Настройки'),(2727,'storage-passports','Складской учет :: Паспорта товаров'),(2728,'storage-orders','Складской учет :: Заказы'),(2729,'storage-orders-edit','Складской учет :: Заказы: редактирование'),(2730,'storagename-1-read','Складской учет :: Просмотр баланса :: Просмотр баланса Продажи'),(2731,'storagename-1-motionlog','Складской учет :: Журнал :: Журнал Продажи'),(2732,'storagename-3-read','Складской учет :: Просмотр баланса :: Просмотр баланса  склада Расход'),(2733,'storagename-3-motionlog','Складской учет :: Журнал :: Журнал  склада Расход'),(2734,'project','Проекты'),(2735,'project-delete','Проекты :: Удаление и восстановление заказов'),(2736,'issue','Задачи'),(2737,'issue-delete','Задачи :: Удаление и восстановление заказов'),(2738,'project-status-all-view','Проекты :: Доступ по статусу ::  Все статусы :: Просмотр'),(2739,'project-status-all-change','Проекты :: Доступ по статусу ::  Все статусы :: Управление'),(2740,'issue-status-all-view','Задачи :: Доступ по статусу ::  Все статусы :: Просмотр'),(2741,'issue-status-all-change','Задачи :: Доступ по статусу ::  Все статусы :: Управление'),(2742,'project-manager-all-view','Проекты :: Доступ по менеджеру ::  Все менеджеры :: Просмотр'),(2743,'project-manager-all-change','Проекты :: Доступ по менеджеру ::  Все менеджеры :: Управление'),(2744,'issue-manager-all-view','Задачи :: Доступ по менеджеру ::  Все менеджеры :: Просмотр'),(2745,'issue-manager-all-change','Задачи :: Доступ по менеджеру ::  Все менеджеры :: Управление'),(2746,'project-category-all-view','Проекты :: Доступ по бизнес-процессу ::  Все категории :: Просмотр'),(2747,'project-category-all-change','Проекты :: Доступ по бизнес-процессу ::  Все категории :: Управление'),(2748,'issue-category-all-view','Задачи :: Доступ по бизнес-процессу ::  Все категории :: Просмотр'),(2749,'issue-category-all-change','Задачи :: Доступ по бизнес-процессу ::  Все категории :: Управление'),(2750,'files','Файлы'),(2751,'report-clientorder','Отчеты :: Заказы клиентов'),(2752,'report-clientbalance','Отчеты :: Баланс клиентов'),(2753,'report-orderdate','Отчеты :: Заказы по датам'),(2754,'report-orderstatus','Отчеты :: Этапы заказов'),(2755,'report-orderpayment','Отчеты :: Оплаты заказов'),(2756,'report-sourceorders','Отчеты :: Каналы заказов'),(2757,'report-sourceclients','Отчеты :: Каналы клиентов'),(2758,'report-managercompare','Отчеты :: Сравнение менеджеров'),(2759,'report-compareorderplan','Отчеты :: Сравнение плана заказов'),(2760,'report-eventdate','Отчеты :: События по датам'),(2761,'report-eventtree','Отчеты :: Карта событий'),(2762,'report-utm','Отчеты :: UTM'),(2763,'report-comparekpi','Отчеты :: Сравнение KPI план-факт'),(2764,'report-projectcheck','Отчеты :: Состояние проектов'),(2765,'seo','SEO (Search engine optimization)'),(2766,'marginrule','Наценки и пересчет цен');
/*!40000 ALTER TABLE `useraclkey` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `userauth`
--

DROP TABLE IF EXISTS `userauth`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `userauth` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `userid` bigint(20) unsigned NOT NULL,
  `adate` datetime NOT NULL,
  `sdate` datetime NOT NULL,
  `sid` char(32) NOT NULL,
  `ip` char(15) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `index_sid` (`sid`),
  KEY `index_userid` (`userid`),
  KEY `index_adate` (`adate`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `userauth`
--

LOCK TABLES `userauth` WRITE;
/*!40000 ALTER TABLE `userauth` DISABLE KEYS */;
/*!40000 ALTER TABLE `userauth` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `level` int(11) NOT NULL,
  `cdate` datetime NOT NULL,
  `email` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `namelast` varchar(255) NOT NULL,
  `namemiddle` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `phones` text NOT NULL,
  `address` text NOT NULL,
  `bdate` date NOT NULL,
  `urls` text NOT NULL,
  `emails` text NOT NULL,
  `skype` text NOT NULL,
  `jabber` varchar(255) NOT NULL,
  `whatsapp` varchar(255) NOT NULL,
  `parentid` int(11) NOT NULL,
  `time` varchar(255) NOT NULL,
  `commentadmin` text NOT NULL,
  `managerid` int(11) NOT NULL,
  `company` varchar(255) NOT NULL,
  `post` varchar(255) NOT NULL,
  `groupid` int(11) NOT NULL,
  `pricelevel` int(11) NOT NULL,
  `discountid` int(11) NOT NULL,
  `activatecode` varchar(16) NOT NULL,
  `distribution` tinyint(1) NOT NULL,
  `tags` varchar(255) NOT NULL,
  `edate` datetime NOT NULL,
  `udate` datetime NOT NULL,
  `contractorid` int(11) NOT NULL,
  `sourceid` int(11) NOT NULL,
  `authorid` int(11) NOT NULL,
  `typesex` varchar(16) NOT NULL,
  `activitydate` datetime NOT NULL,
  `activitydatein` datetime NOT NULL,
  `activitydateout` datetime NOT NULL,
  `employer` tinyint(1) NOT NULL,
  `allowreferal` int(11) NOT NULL,
  `utm_source` varchar(255) NOT NULL,
  `utm_medium` varchar(255) NOT NULL,
  `utm_campaign` varchar(255) NOT NULL,
  `utm_content` varchar(255) NOT NULL,
  `utm_term` varchar(255) NOT NULL,
  `utm_date` datetime NOT NULL,
  `utm_referrer` varchar(255) NOT NULL,
  `identifier` varchar(35) NOT NULL,
  `lost_basket` datetime NOT NULL,
  `lost_basket_date1` datetime NOT NULL,
  `lost_basket_date2` datetime NOT NULL,
  `lost_basket_date3` datetime NOT NULL,
  `lost_basket_date4` datetime NOT NULL,
  `lost_basket_date5` datetime NOT NULL,
  `notify_email_one` tinyint(1) NOT NULL,
  `notify_email_group` tinyint(1) NOT NULL,
  `notify_sms` tinyint(1) NOT NULL,
  `controlip` varchar(15) NOT NULL,
  `deleted` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_activatecode` (`activatecode`),
  KEY `index_loginemail` (`login`,`email`),
  KEY `index_typesex` (`typesex`),
  KEY `index_company` (`company`),
  KEY `index_employername` (`employer`,`deleted`,`namelast`,`name`),
  KEY `index_lostbasket` (`lost_basket`),
  KEY `index_name` (`name`),
  KEY `index_namelast` (`namelast`),
  KEY `index_namemiddle` (`namemiddle`),
  KEY `index_post` (`post`),
  KEY `index_email` (`email`),
  KEY `index_phone` (`phone`),
  KEY `index_deleted` (`deleted`,`namelast`,`name`),
  KEY `index_parentid` (`parentid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin','47b651994c19bb174350faf482f7ce32',3,'0000-00-00 00:00:00','support@webproduction.ua','','','','','','','','0000-00-00','','','','','',0,'','',0,'','',0,0,0,'',0,'','0000-00-00 00:00:00','0000-00-00 00:00:00',0,0,0,'','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',0,0,'','','','','','0000-00-00 00:00:00','','','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',0,0,0,'',0);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-09-07 17:53:31

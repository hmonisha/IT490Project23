-- MariaDB dump 10.19  Distrib 10.6.12-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: IT490
-- ------------------------------------------------------
-- Server version	10.6.12-MariaDB-0ubuntu0.22.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `book_reviews`
--

DROP TABLE IF EXISTS `book_reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `book_reviews` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `bookName` varchar(100) NOT NULL,
  `reviewerName` varchar(50) NOT NULL,
  `reviewDate` date NOT NULL,
  `rating` int(2) NOT NULL,
  `review_text` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=54129 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `book_reviews`
--

LOCK TABLES `book_reviews` WRITE;
/*!40000 ALTER TABLE `book_reviews` DISABLE KEYS */;
INSERT INTO `book_reviews` VALUES (15425,'Harry Potter','John Smith','2020-10-22',4,'This book is pretty good and nice.'),(15554,'The Shining','Luis Soriano','2020-02-22',5,'This book is scary'),(54128,'The Hunger Games','Jack Cruz','2019-02-22',5,'I love this book!');
/*!40000 ALTER TABLE `book_reviews` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `books`
--

DROP TABLE IF EXISTS `books`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `books` (
  `bookName` varchar(100) NOT NULL,
  `publishedBy` varchar(50) NOT NULL,
  `publishedDate` date NOT NULL,
  `description` text NOT NULL,
  `image` longblob NOT NULL,
  `pageCount` int(5) NOT NULL,
  `authors` varchar(50) NOT NULL,
  `id` varchar(100) DEFAULT NULL,
  `language` varchar(50) NOT NULL,
  `publishedCountry` varchar(50) NOT NULL,
  `printType` varchar(50) NOT NULL,
  `category` varchar(50) NOT NULL,
  `price` float(6,2) NOT NULL,
  `link` varchar(3000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `books`
--

LOCK TABLES `books` WRITE;
/*!40000 ALTER TABLE `books` DISABLE KEYS */;
INSERT INTO `books` VALUES ('Gone with the Wind','Random House UK','2020-02-21','Margaret Mitchells page-turning sweeping American epic has been a classic for over eighty years.','https://books.google.com/books/content?id=jZMpaRdaUzsC&printsec=frontcover&img=1&zoom=1&edge=curl&imgtk=AFLRE70_MF1ZSW3DWMgVIZMES18PDJJ51EDaZfbVO_On2s36e238OUoweYOZyiK_qA3cSRcO_-De80I_nrNNXKNRpeuKR3CDaglEQ0Zw1fHBcAkSdwkkm9-70U9utEuNp3sb8W4d_qe8',1072,'Margaret Mitchell','45651','English','United States','Hard copy','Fiction',34.41,NULL),('Percy Jackson and the Lightning Thief','Puffin Books','2009-12-01','Look, I didn\'t want to be a half-blood. I never asked to be the son of a Greek god. I was just a normal kid, going to school, playing basketball, skateboarding. The usual. Until I accidentally vaporized my maths teacher. That\'s when things started really going wrong. Now I spend my time fighting with swords, battling monsters with my friends and generally trying to stay alive. This is the one where Zeus, God of the Sky, thinks I\'ve stolen his lightning bolt - and making Zeus angry is a very bad idea. Can Percy find the lightning bolt before a fully fledged WAR OF THE GODS ERUPTS? Follow the author on his blog Also available: Percy Jackson and the Battle of the Labyrinth Percy Jackson and the Last Olympian Percy Jackson and the Lightning Thief (audio) Percy Jackson and the Lightning Thief (film tie-in) Percy Jackson and the Sea of Monsters Percy Jackson and the Titan\'s Curse Percy Jackson: The Demigod Files','https://covers.openlibrary.org/b/isbn/0141329998-L.jpg',374,'Array','141329998','en','US','BOOK','Array',6.99,'https://www.amazon.com/Lightning-Thief-Percy-Jackson-Olympians/dp/0786838655/ref=sr_1_1?keywords=Percy+Jackson+and+the+Lightning+Thief+paperback&qid=1679365812&sr=8-1'),('Percy Jackson and the Lightning Thief','Puffin Books','2009-12-01','Look, I didn\'t want to be a half-blood. I never asked to be the son of a Greek god. I was just a normal kid, going to school, playing basketball, skateboarding. The usual. Until I accidentally vaporized my maths teacher. That\'s when things started really going wrong. Now I spend my time fighting with swords, battling monsters with my friends and generally trying to stay alive. This is the one where Zeus, God of the Sky, thinks I\'ve stolen his lightning bolt - and making Zeus angry is a very bad idea. Can Percy find the lightning bolt before a fully fledged WAR OF THE GODS ERUPTS? Follow the author on his blog Also available: Percy Jackson and the Battle of the Labyrinth Percy Jackson and the Last Olympian Percy Jackson and the Lightning Thief (audio) Percy Jackson and the Lightning Thief (film tie-in) Percy Jackson and the Sea of Monsters Percy Jackson and the Titan\'s Curse Percy Jackson: The Demigod Files','https://covers.openlibrary.org/b/isbn/0141329998-L.jpg',374,'Array','0141329998','en','US','BOOK','Array',6.99,'https://www.amazon.com/Lightning-Thief-Percy-Jackson-Olympians/dp/0786838655/ref=sr_1_1?keywords=Percy+Jackson+and+the+Lightning+Thief+paperback&qid=1679366244&sr=8-1'),('The Lightning Thief','Disney Electronic Content','2010-02-02','Percy Jackson is about to be kicked out of boarding school...again. And that\'s the least of his troubles. Lately, mythological monsters and the gods of Mount Olympus seem to be walking straight out of the pages of Percy\'s Greek mythology textbook and into his life. Book #1 in the NYT best-selling series, with cover art from the feature film, The Lightning Thief.','https://covers.openlibrary.org/b/isbn/9781423140344-L.jpg',400,'Array','9781423140344','en','US','BOOK','Array',6.99,'https://www.amazon.com/Lightning-Thief-Percy-Jackson-Olympians/dp/0786838655/ref=sr_1_1?keywords=The+Lightning+Thief+paperback&qid=1679366263&sr=8-1'),('Battle of the Labyrinth, The (Percy Jackson and the Olympians, Book 4)','Disney Electronic Content','2009-05-02','Percy Jackson isn\'t expecting freshman orientation to be any fun. But when a mysterious mortal acquaintance appears on campus, followed by demon cheerleaders, things quickly move from bad to diabolical. In this latest installment of the blockbuster series, time is running out as war between the Olympians and the evil Titan lord Kronos draws near.','https://covers.openlibrary.org/b/isbn/9781423131984-L.jpg',366,'Array','9781423131984','en','US','BOOK','Array',7.99,'https://www.amazon.com/Battle-Labyrinth-Percy-Jackson-Olympians/dp/1423101499/ref=sr_1_1?keywords=Battle+of+the+Labyrinth%2C+The+%28Percy+Jackson+and+the+Olympians%2C+Book+4%29+paperback&qid=1679366279&sr=8-1'),('Percy Jackson Demigod Collection','Disney-Hyperion','2019-09-24','A book of firsts! One epic collection containing the first book from three different New York Times #1 best-selling series by Rick Riordan. THE LIGHTNING THIEF: Zeus\'s master lightning bolt has been stolen and Percy Jackson is the prime suspect. He and his friends have ten days to find and return it and bring peace to a warring Mount Olympus. To succeed, Percy has come to terms with the father who abandoned him, solve the riddle of the Oracle that warns of betrayal by a friend, and unravel a treachery more powerful than the gods themselves. THE LOST HERO: Jason, Piper, and Leo find themselves at Camp Half-Blood where people won\'t stop talking about a curse and a camper named Percy who\'s gone AWOL.These three friends must rely on one another and their newfound demigod gifts as they embark on an epic quest to save Mount Olympus. THE HIDDEN ORACLE: Apollo, once the glorious god of the sun, music, and poetry, has been cast down to Earth in punishment by Zeus. Now, as awkward mortal teenager Lester Papadopoulos, he\'s been tasked with restoring five Oracles that have gone dark in order to regain his place on Mount Olympus. How is he supposed to accomplish that without any godly powers? He needs help, and a demigod named Percy Jackson shows him where to find it: at a training camp on Long Island called Camp Half-Blood. This primer of heroes and demigods will start readers on three unforgettable adventures. Bonus first chapters from two other amazing series promise more exciting journeys.','https://covers.openlibrary.org/b/isbn/1368057489-L.jpg',0,'Array','1368057489','en','US','BOOK','Array',18.09,'https://www.amazon.com/Percy-Jackson-Demigod-Collection-Olympians/dp/1368057489/ref=sr_1_1?keywords=Percy+Jackson+Demigod+Collection+paperback&qid=1679366286&sr=8-1'),('Titan\'s Curse, The (Percy Jackson and the Olympians, Book 3)','Disney Electronic Content','2009-05-02','When the goddess Artemis goes missing, she is believed to have been kidnapped. And now it\'s up to Percy and his friends to find out what happened. Who is powerful enough to kidnap a goddess?','https://covers.openlibrary.org/b/isbn/9781423131977-L.jpg',317,'Array','9781423131977','en','US','BOOK','Array',7.99,'https://www.amazon.com/Titans-Curse-Percy-Jackson-Olympians/dp/1423101480/ref=sr_1_1?keywords=Titans+Curse%2C+The+%28Percy+Jackson+and+the+Olympians%2C+Book+3%29+paperback&qid=1679366294&sr=8-1'),('Percy Jackson\'s Greek Gods','Disney Electronic Content','2014-08-19','\"A publisher in New York asked me to write down what I know about the Greek gods, and I was like, Can we do this anonymously? Because I don\'t need the Olympians mad at me again. But if it helps you to know your Greek gods, and survive an encounter with them if they ever show up in your face, then I guess writing all this down will be my good deed for the week.\" So begins Percy Jackson\'s Greek Gods, in which the son of Poseidon adds his own magic--and sarcastic asides--to the classics. He explains how the world was created, then gives readers his personal take on a who\'s who of ancients, from Apollo to Zeus. Percy does not hold back. \"If you like horror shows, blood baths, lying, stealing, backstabbing, and cannibalism, then read on, because it definitely was a Golden Age for all that.\" Dramatic full-color illustrations throughout by Caldecott Honoree John Rocco make this volume--a must for home, library, and classroom shelves--as stunning as it is entertaining.','https://covers.openlibrary.org/b/isbn/9781484702185-L.jpg',336,'Array','9781484702185','en','US','BOOK','Array',9.99,NULL),('Demigods and Monsters','BenBella Books','2013-07-02','Which Greek god makes the best parent? Would you want to be one of Artemis\' Hunters? Why do so many monsters go into retail? Spend a little more time in Percy Jackson\'s world—a place where the gods bike among us, monsters man snack bars, and each of us has the potential to become a hero. Find out: • Why Dionysus might actually be the best director Camp Half-Blood could have • How to recognize a monster when you see one • Why even if we aren\'t facing manticores and minotaurs, reading myth can still help us deal with the scary things in our own lives Plus, consult our glossary of people, places, and things from Greek myth: how Medusa got her snake hair extensions, why Chiron isn\'t into partying and paintball like the rest of his centaur family, and the whole story on Percy\'s mythical namesake.','https://covers.openlibrary.org/b/isbn/9781937856366-L.jpg',258,'Array','9781937856366','en','US','BOOK','Array',12.95,'https://www.amazon.com/Demigods-Monsters-Favorite-Riordans-Olympians/dp/1937856364/ref=sr_1_1?keywords=Demigods+and+Monsters+paperback&qid=1679366313&sr=8-1'),('Percy Jackson\'s Greek Heroes','Disney Electronic Content','2015-08-18','Who cut off Medusa\'s head? Who was raised by a she-bear? Who tamed Pegasus? It takes a demigod to know, and Percy Jackson can fill you in on the all the daring deeds of Perseus, Atalanta, Bellerophon, and the rest of the major Greek heroes. Told in the funny, irreverent style readers have come to expect from Percy, ( I\'ve had some bad experiences in my time, but the heroes I\'m going to tell you about were the original old school hard luck cases. They boldly screwed up where no one had screwed up before. . .) and enhanced with vibrant artwork by Caldecott Honoree John Rocco, this story collection will become the new must-have classic for Rick Riordan\'s legions of devoted fans--and for anyone who needs a hero. So get your flaming spear. Put on your lion skin cape. Polish your shield and make sure you\'ve got arrows in your quiver. We\'re going back about four thousand years to decapitate monsters, save some kingdoms, shoot a few gods in the butt, raid the Underworld, and steal loot from evil people. Then, for dessert, we\'ll die painful tragic deaths. Ready? Sweet. Let\'s do this.','https://covers.openlibrary.org/b/isbn/9781484729380-L.jpg',336,'Array','9781484729380','en','US','BOOK','Array',10.99,'https://www.amazon.com/Percy-Jacksons-Greek-Heroes-Riordan/dp/1484776437/ref=sr_1_1?keywords=Percy+Jacksons+Greek+Heroes+paperback&qid=1679366326&sr=8-1'),('The Percy Jackson and the Olympians: Ultimate Guide','Hyperion','2010-01-18','It\'s the handbook no half-blood should be without: a fully illustrated, in-depth guide to gods, monsters, and all things Percy. This novelty companion to the best-selling series comes complete with trading cards, full-color diagrams, and maps, all packaged in a handy, \"manual-size\" POB with a crisp, magnetic flap enclosure./DIVDIV','https://covers.openlibrary.org/b/isbn/1423121716-L.jpg',0,'Array','1423121716','en','US','BOOK','Array',21.50,'https://www.amazon.com/Percy-Jackson-Olympians-Ultimate-Chinese/dp/7544828506/ref=sr_1_1?keywords=The+Percy+Jackson+and+the+Olympians%3A+Ultimate+Guide+paperback&qid=1679366333&sr=8-1'),('Percy Jackson pbk 5-book boxed set','Hyperion','2011-08-30','At last the wait is over! All five books in the blockbuster Percy Jackson and the Olympus series, in paperback, have been collected in a box fit for demigods. This value-priced set includes the best-selling The Lightning Thief, The Sea of Monsters,The Titan\'s Curse, The Battle of the Labyrinth, and The Last Olympians. Whether it is for readers who are experiencing Percy\'s thrilling adventures with Greek gods and monsters for the first time or for fans who want to devour the saga again, this gift will be prized by young and old.','https://covers.openlibrary.org/b/isbn/1423136802-L.jpg',1824,'Array','1423136802','en','US','BOOK','Array',62.99,'https://www.amazon.com/Percy-Jackson-Olympians-Hardcover-Boxed/dp/142314189X/ref=sr_1_1?keywords=Percy+Jackson+pbk+5-book+boxed+set+paperback&qid=1679366337&sr=8-1');
/*!40000 ALTER TABLE `books` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `forum_posts`
--

DROP TABLE IF EXISTS `forum_posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `forum_posts` (
  `post_id` int(11) NOT NULL AUTO_INCREMENT,
  `topic_id` int(11) NOT NULL,
  `post_content` text DEFAULT NULL,
  `post_date` datetime DEFAULT NULL,
  `post_owner` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`post_id`)
) ENGINE=InnoDB AUTO_INCREMENT=54625 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `forum_posts`
--

LOCK TABLES `forum_posts` WRITE;
/*!40000 ALTER TABLE `forum_posts` DISABLE KEYS */;
INSERT INTO `forum_posts` VALUES (1234,5546,'Anyone else likes the main character?','2022-06-05 05:13:55','Luis Soriano'),(5462,4471,'This book does a good job of showing character actions','2021-06-05 05:10:55','John Smith'),(54624,44717,'I hate the main character in this book.','2023-06-09 11:10:55','Jack Cruz');
/*!40000 ALTER TABLE `forum_posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `forum_topics`
--

DROP TABLE IF EXISTS `forum_topics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `forum_topics` (
  `topic_id` int(11) NOT NULL AUTO_INCREMENT,
  `topic_title` varchar(100) NOT NULL,
  `topic_time` datetime DEFAULT NULL,
  `topic_owner` varchar(100) NOT NULL,
  PRIMARY KEY (`topic_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `forum_topics`
--

LOCK TABLES `forum_topics` WRITE;
/*!40000 ALTER TABLE `forum_topics` DISABLE KEYS */;
/*!40000 ALTER TABLE `forum_topics` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `readBook`
--

DROP TABLE IF EXISTS `readBook`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `readBook` (
  `bookID` int(16) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `readBook`
--

LOCK TABLES `readBook` WRITE;
/*!40000 ALTER TABLE `readBook` DISABLE KEYS */;
/*!40000 ALTER TABLE `readBook` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `userLogin`
--

DROP TABLE IF EXISTS `userLogin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `userLogin` (
  `username` varchar(30) NOT NULL,
  `passHash` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `userLogin`
--

LOCK TABLES `userLogin` WRITE;
/*!40000 ALTER TABLE `userLogin` DISABLE KEYS */;
INSERT INTO `userLogin` VALUES ('John Smith','hello44'),('Adam Poll','howdy4'),('Luis Soriano','bye555');
/*!40000 ALTER TABLE `userLogin` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-03-21 14:02:06

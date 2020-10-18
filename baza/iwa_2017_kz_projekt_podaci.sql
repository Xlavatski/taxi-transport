SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
USE `iwa_2017_kz_projekt` ;

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Dumping data for table `tip_korisnika`
--

INSERT INTO `tip_korisnika` (`tip_id`, `naziv`) VALUES
(0, 'administrator'),
(1, 'voditelj'),
(2, 'korisnik');

--
-- Dumping data for table `korisnik`
--

INSERT INTO `korisnik` (`korisnik_id`, `tip_id`, `korisnicko_ime`, `lozinka`, `ime`, `prezime`, `email`, `slika`) VALUES
(1, 0, 'admin', 'foi', 'Administrator', '', '', 'korisnici/admin.jpg'),
(2, 1, 'voditelj', '123456', 'voditelj', '', '', 'korisnici/admin.jpg'),
(3, 2, 'pkos', '123456', 'Pero', 'Kos', 'pkos@fff.hr', 'korisnici/pkos.jpg'),
(4, 2, 'vzec', '123456', 'Vladimir', 'Zec', 'vzec@fff.hr', 'korisnici/vzec.jpg'),
(5, 2, 'qtarantino', '123456', 'Quentin', 'Tarantino', 'qtarantino@foi.hr', 'korisnici/qtarantino.jpg'),
(6, 2, 'mbellucci', '123456', 'Monica', 'Bellucci', 'mbellucci@foi.hr', 'korisnici/mbellucci.jpg'),
(7, 2, 'vmortensen', '123456', 'Viggo', 'Mortensen', 'vmortensen@foi.hr', 'korisnici/vmortensen.jpg'),
(8, 2, 'jgarner', '123456', 'Jennifer', 'Garner', 'jgarner@foi.hr', 'korisnici/jgarner.jpg'),
(9, 2, 'nportman', '123456', 'Natalie', 'Portman', 'nportman@foi.hr', 'korisnici/nportman.jpg'),
(10, 2, 'dradcliffe', '123456', 'Daniel', 'Radcliffe', 'dradcliffe@foi.hr', 'korisnici/dradcliffe.jpg'),
(11, 2, 'hberry', '123456', 'Halle', 'Berry', 'hberry@foi.hr', 'korisnici/hberry.jpg'),
(12, 2, 'vdiesel', '123456', 'Vin', 'Diesel', 'vdiesel@foi.hr', 'korisnici/vdiesel.jpg'),
(13, 2, 'ecuthbert', '123456', 'Elisha', 'Cuthbert', 'ecuthbert@foi.hr', 'korisnici/ecuthbert.jpg'),
(14, 2, 'janiston', '123456', 'Jennifer', 'Aniston', 'janiston@foi.hr', 'korisnici/janiston.jpg'),
(15, 2, 'ctheron', '123456', 'Charlize', 'Theron', 'ctheron@foi.hr', 'korisnici/ctheron.jpg'),
(16, 2, 'nkidman', '123456', 'Nicole', 'Kidman', 'nkidman@foi.hr', 'korisnici/nkidman.jpg'),
(17, 2, 'ewatson', '123456', 'Emma', 'Watson', 'ewatson@foi.hr', 'korisnici/ewatson.jpg'),
(18, 1, 'kdunst', '123456', 'Kirsten', 'Dunst', 'kdunst@foi.hr', 'korisnici/kdunst.jpg'),
(19, 2, 'sjohansson', '123456', 'Scarlett', 'Johansson', 'sjohansson@foi.hr', 'korisnici/sjohansson.jpg'),
(20, 2, 'philton', '123456', 'Paris', 'Hilton', 'philton@foi.hr', 'korisnici/philton.jpg'),
(21, 2, 'kbeckinsale', '123456', 'Kate', 'Beckinsale', 'kbeckinsale@foi.hr', 'korisnici/kbeckinsale.jpg'),
(22, 2, 'tcruise', '123456', 'Tom', 'Cruise', 'tcruise@foi.hr', 'korisnici/tcruise.jpg'),
(23, 2, 'hduff', '123456', 'Hilary', 'Duff', 'hduff@foi.hr', 'korisnici/hduff.jpg'),
(24, 2, 'ajolie', '123456', 'Angelina', 'Jolie', 'ajolie@foi.hr', 'korisnici/ajolie.jpg'),
(25, 2, 'kknightley', '123456', 'Keira', 'Knightley', 'kknightley@foi.hr', 'korisnici/kknightley.jpg'),
(26, 2, 'obloom', '123456', 'Orlando', 'Bloom', 'obloom@foi.hr', 'korisnici/obloom.jpg'),
(27, 2, 'llohan', '123456', 'Lindsay', 'Lohan', 'llohan@foi.hr', 'korisnici/llohan.jpg'),
(28, 2, 'jdepp', '123456', 'Johnny', 'Depp', 'jdepp@foi.hr', 'korisnici/jdepp.jpg'),
(29, 2, 'kreeves', '123456', 'Keanu', 'Reeves', 'kreeves@foi.hr', 'korisnici/kreeves.jpg'),
(30, 1, 'thanks', '123456', 'Tom', 'Hanks', 'thanks@foi.hr', 'korisnici/thanks.jpg'),
(31, 2, 'elongoria', '123456', 'Eva', 'Longoria', 'elongoria@foi.hr', 'korisnici/elongoria.jpg'),
(32, 2, 'rde', '123456', 'Robert', 'De', 'rde@foi.hr', 'korisnici/rde.jpg'),
(33, 2, 'jheder', '123456', 'Jon', 'Heder', 'jheder@foi.hr', 'korisnici/jheder.jpg'),
(34, 2, 'rmcadams', '123456', 'Rachel', 'McAdams', 'rmcadams@foi.hr', 'korisnici/rmcadams.jpg'),
(35, 2, 'cbale', '123456', 'Christian', 'Bale', 'cbale@foi.hr', 'korisnici/cbale.jpg'),
(36, 1, 'jalba', '123456', 'Jessica', 'Alba', 'jalba@foi.hr', 'korisnici/jalba.jpg'),
(37, 2, 'bpitt', '123456', 'Brad', 'Pitt', 'bpitt@foi.hr', 'korisnici/bpitt.jpg'),
(43, 2, 'apacino', '123456', 'Al', 'Pacino', 'apacino@foi.hr', 'korisnici/apacino.jpg'),
(44, 2, 'wsmith', '123456', 'Will', 'Smith', 'wsmith@foi.hr', 'korisnici/wsmith.jpg'),
(45, 2, 'ncage', '123456', 'Nicolas', 'Cage', 'ncage@foi.hr', 'korisnici/ncage.jpg'),
(46, 2, 'vanne', '123456', 'Vanessa', 'Anne', 'vanne@foi.hr', 'korisnici/vanne.jpg'),
(47, 2, 'kheigl', '123456', 'Katherine', 'Heigl', 'kheigl@foi.hr', 'korisnici/kheigl.jpg'),
(48, 2, 'gbutler', '123456', 'Gerard', 'Butler', 'gbutler@foi.hr', 'korisnici/gbutler.jpg'),
(49, 2, 'jbiel', '123456', 'Jessica', 'Biel', 'jbiel@foi.hr', 'korisnici/jbiel.jpg'),
(50, 2, 'ldicaprio', '123456', 'Leonardo', 'DiCaprio', 'ldicaprio@foi.hr', 'korisnici/ldicaprio.jpg'),
(51, 2, 'mdamon', '123456', 'Matt', 'Damon', 'mdamon@foi.hr', 'korisnici/mdamon.jpg'),
(52, 2, 'hpanettiere', '123456', 'Hayden', 'Panettiere', 'hpanettiere@foi.hr', 'korisnici/hpanettiere.jpg'),
(53, 2, 'rreynolds', '123456', 'Ryan', 'Reynolds', 'rreynolds@foi.hr', 'korisnici/rreynolds.jpg'),
(54, 2, 'jstatham', '123456', 'Jason', 'Statham', 'jstatham@foi.hr', 'korisnici/jstatham.jpg'),
(55, 2, 'enorton', '123456', 'Edward', 'Norton', 'enorton@foi.hr', 'korisnici/enorton.jpg'),
(56, 2, 'mwahlberg', '123456', 'Mark', 'Wahlberg', 'mwahlberg@foi.hr', 'korisnici/mwahlberg.jpg'),
(57, 2, 'jmcavoy', '123456', 'James', 'McAvoy', 'jmcavoy@foi.hr', 'korisnici/jmcavoy.jpg'),
(58, 2, 'epage', '123456', 'Ellen', 'Page', 'epage@foi.hr', 'korisnici/epage.jpg'),
(59, 2, 'mcyrus', '123456', 'Miley', 'Cyrus', 'mcyrus@foi.hr', 'korisnici/mcyrus.jpg'),
(60, 2, 'kstewart', '123456', 'Kristen', 'Stewart', 'kstewart@foi.hr', 'korisnici/kstewart.jpg'),
(61, 2, 'mfox', '123456', 'Megan', 'Fox', 'mfox@foi.hr', 'korisnici/mfox.jpg'),
(62, 2, 'slabeouf', '123456', 'Shia', 'LaBeouf', 'slabeouf@foi.hr', 'korisnici/slabeouf.jpg'),
(63, 2, 'ceastwood', '123456', 'Clint', 'Eastwood', 'ceastwood@foi.hr', 'korisnici/ceastwood.jpg'),
(64, 2, 'srogen', '123456', 'Seth', 'Rogen', 'srogen@foi.hr', 'korisnici/srogen.jpg'),
(65, 2, 'nreed', '123456', 'Nikki', 'Reed', 'nreed@foi.hr', 'korisnici/nreed.jpg'),
(66, 2, 'agreene', '123456', 'Ashley', 'Greene', 'agreene@foi.hr', 'korisnici/agreene.jpg'),
(67, 2, 'zdeschanel', '123456', 'Zooey', 'Deschanel', 'zdeschanel@foi.hr', 'korisnici/zdeschanel.jpg'),
(68, 2, 'dfanning', '123456', 'Dakota', 'Fanning', 'dfanning@foi.hr', 'korisnici/dfanning.jpg'),
(69, 2, 'tlautner', '123456', 'Taylor', 'Lautner', 'tlautner@foi.hr', 'korisnici/tlautner.jpg'),
(70, 2, 'rpattinson', '123456', 'Robert', 'Pattinson', 'rpattinson@foi.hr', 'korisnici/rpattinson.jpg');

--
-- Dumping data for table `zupanija`
--

INSERT INTO `zupanija` (`zupanija_id`, `moderator_id`, `naziv`, `broj_vozila`) VALUES
(1, 2, 'Varaždinska županija', 4),
(2, 2, 'Međimurska županija', 5),
(3, 18, 'Koprivničko-križevačka županija', 3),
(4, 30, 'Sisačko-moslavačka županija', 4),
(5, 36, 'Krapinsko-zagorska županija', 4);

--
-- Dumping data for table `vozilo`
--

INSERT INTO `vozilo` (`vozilo_id`, `zupanija_id`, `oznaka`) VALUES
(1, 1, 'TAXI-VŽ-1'),
(2, 1, 'TAXI-VŽ-2'),
(3, 1, 'TAXI-VŽ-3'),
(4, 1, 'TAXI-VŽ-4'),
(5, 2, 'TAXI-MŽ-1'),
(6, 2, 'TAXI-MŽ-2'),
(7, 2, 'TAXI-MŽ-3'),
(8, 2, 'TAXI-MŽ-4'),
(9, 2, 'TAXI-MŽ-5'),
(10, 3, 'TAXI-KKŽ-1'),
(11, 3, 'TAXI-KKŽ-2'),
(12, 3, 'TAXI-KKŽ-3'),
(13, 4, 'TAXI-SMŽ-1'),
(14, 4, 'TAXI-SMŽ-2'),
(15, 4, 'TAXI-SMŽ-3'),
(16, 4, 'TAXI-SMŽ-4'),
(17, 5, 'TAXI-KZŽ-1'),
(18, 5, 'TAXI-KZŽ-2'),
(19, 5, 'TAXI-KZŽ-3'),
(20, 5, 'TAXI-KZŽ-4');

--
-- Dumping data for table `adresa`
--

INSERT INTO `adresa` (`adresa_id`, `zupanija_id`, `grad`, `ulica`) VALUES 
(1, 1, 'Varaždin', 'Ulica Zrinskih i Frankopana'),
(2, 1, 'Varaždin', 'Pavlinska ulica'),
(3, 1, 'Ludbreg', 'Ulica Braće Radić'),
(4, 1, 'Varaždinske Toplice', 'Ulica Ivana Tkalčića'),
(5, 2, 'Čakovec', 'Ulica Ivana Gorana Kovačića'),
(6, 2, 'Čakovec', 'Kolodvorska ulica'),
(7, 2, 'Čakovec', 'Ulica kralja Tomislava'),
(8, 2, 'Mursko Središće', 'Ulica Josipa Broza Tita'),
(9, 2, 'Prelog', 'Ulica Nikole Tesle'),
(10, 3, 'Križevci', 'Ulica Petra Zrinskog'),
(11, 3, 'Križevci', 'Ulica Tome Sermagea'),
(12, 4, 'Sisak', 'Trg Republike'),
(13, 5, 'Zabok', 'Ulica Matije Gupca');

--
-- Dumping data for table `rezervacija`
--

INSERT INTO `rezervacija` (`rezervacija_id`, `korisnik_id`, `vozilo_id`, `adresa_polaska_id`, `adresa_odredista_id`, `datum_vrijeme_polaska`, `datum_vrijeme_dolaska`, `komentar`, `status`) VALUES
(1, 3, 1, 1, 2, '2017-10-28 09:40:00', '2017-10-28 09:45:00', 'Odlična usluga.', 1),
(2, 3, 2, 1, 3, '2017-10-28 12:15:00', '2017-10-28 12:47:00', 'Prekrasan krajolik.', 1),
(3, 4, 3, 1, 4, '2017-10-28 14:30:00', '2017-10-28 15:03:00', '', 1),
(4, 6, 5, 5, 6, '2017-10-30 10:30:00', '2017-10-30 10:37:00', 'Svakako preporučujem!', 1),
(5, 6, 6, 5, 7, '2017-10-31 09:15:00', '2017-10-31 09:20:00', 'Odlična usluga.', 1),
(6, 6, 7, 5, 8, '2017-10-31 09:15:00', '2017-10-31 09:40:00', 'Prekrasan krajolik.', 1),
(7, 6, 8, 5, 9, '2017-10-31 13:15:00', '2017-10-31 13:41:00', '', 1),
(8, 9, 10, 10, 11, '2017-11-01 08:00:00', '2017-11-01 08:04:00', 'Brzo i pouzdano do odredišta.', 1),
(9, 4, 4, 3, 1, '2017-11-01 08:00:00', '2017-11-01 08:32:00', '', 1),
(10, 4, 1, 2, 1, '2017-11-01 09:00:00', '2017-11-01 09:05:00', 'Odlična usluga.', 1),
(11, 5, 2, 2, 3, '2017-11-01 09:05:00', '2017-11-01 09:47:00', 'Gužva u prometu.', 1),
(12, 5, 3, 2, 4, '2017-11-01 09:10:00', '2017-11-01 09:45:00', 'Gužva u prometu.', 1),
(13, 7, 9, 6, 5, '2017-11-01 08:00:00', '2017-11-01 08:07:00', 'Svakako preporučujem!', 1),
(14, 7, 5, 7, 5, '2017-11-02 15:00:00', '2017-11-02 15:05:00', 'Odlična usluga.', 1),
(15, 7, 6, 8, 5, '2017-11-02 16:00:00', '2017-11-02 16:25:00', '', 1),
(16, 7, 7, 9, 5, '2017-11-02 17:00:00', '2017-11-02 17:26:00', '', 1),
(17, 8, 8, 5, 7, '2017-11-03 10:00:00', '2017-11-03 10:03:00', 'Brzo i pouzdano do odredišta.', 1),
(18, 8, 9, 5, 8, '2017-11-03 12:00:00', '2017-11-03 12:22:00', 'Prekrasan krajolik.', 1),
(19, 8, 5, 5, 9, '2017-11-03 14:00:00', '2017-11-03 14:27:00', '', 1),
(20, 10, 11, 11, 10, '2017-11-03 15:00:00', '2017-11-03 15:04:00', 'Brzo i pouzdano do odredišta.', 1), 
(21, 3, 4, 1, 3, '2017-11-04 23:50:00', '2017-11-05 00:22:00', '', 1),
(22, 11, 12, 10, 11, '2017-11-05 11:50:00', '', '',0),
(23, 12, 10, 11,10, '2017-11-05 12:50:00', '', '',0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
#popis svih korisnika
SELECT * FROM `korisnik`

#popis svih zupanija
SELECT * FROM `zupanija`

#popis svih moderatora/taksista
SELECT * FROM `korisnik` WHERE `tip_id` = 1

#popis svih adresa polaska/odredista za zupaniju sa ID-om 1 (Varazdinska zupanija)
SELECT CONCAT(`ulica`, ', ', `grad`) AS adresa FROM `adresa` WHERE `zupanija_id` = 1

#popis komentara za adresu sa ID-om 2 (Pavlinska ulica) u zupaniji sa ID-om 1 (Varazdinska zupanija)
SELECT r.`komentar` FROM `adresa` a, `rezervacija` r 
WHERE r.`adresa_polaska_id` = a.`adresa_id` AND a.`adresa_id` = 2 AND a.`zupanija_id` = 1

#zadnje tri adrese koje su imale prijevoz u zupaniji sa ID-om 1 (Varazdinska zupanija)
SELECT a.`ulica` , a.`grad` , r.`datum_vrijeme_polaska`
FROM `adresa` a, `rezervacija` r
WHERE a.`adresa_id` = r.`adresa_polaska_id`
AND a.`zupanija_id` =1
ORDER BY r.`datum_vrijeme_polaska` DESC
LIMIT 3 

#popis zahtjeva za rezervacijama u zupanijama moderatora/taksista sa ID-om 18 (kdunst) - status 0 (poslan)
SELECT * FROM `rezervacija` r, `adresa` a, `zupanija` z 
WHERE r.`adresa_polaska_id` = a.`adresa_id` AND a.`zupanija_id` = z.`zupanija_id` 
AND z.`moderator_id` = 18 AND r.`status` = 0 

#popis zauzetih vozila u zupaniji sa ID-om 1 (Varazdinska zupanija) - status 1 (potvrden)
#za trazeno vrijeme polaska 2017-11-04 23:00:00 i dolaska 2017-11-04 23:51:00
SELECT r.`rezervacija_id`, v.`oznaka`, r.`datum_vrijeme_polaska`,r.`datum_vrijeme_dolaska`  FROM `rezervacija` r, `vozilo` v 
WHERE (r.`datum_vrijeme_polaska` BETWEEN '2017-11-04 23:00:00' 
AND '2017-11-04 23:51:00' 
OR r.`datum_vrijeme_dolaska` BETWEEN '2017-11-04 23:00:00' AND  '2017-11-04 23:51:00')
AND r.`vozilo_id` = v.`vozilo_id` AND v.`zupanija_id` = 1 AND r.`status` =  1 

#provjera slobodnih vozila u zupaniji sa ID-om 1 (Varazdinska zupanija) - status 1 (potvrden)
#za trazeno vrijeme polaska 2017-11-04 22:50:00 i dolaska 2017-11-04 23:50:00
SELECT * FROM `vozilo` v 
WHERE v.`zupanija_id` = 1 AND v.`vozilo_id` NOT IN (SELECT v.`vozilo_id`  FROM `rezervacija` r, `vozilo` v 
WHERE (r.`datum_vrijeme_polaska` BETWEEN '2017-11-04 22:50:00' 
AND '2017-11-04 23:50:00' 
OR r.`datum_vrijeme_dolaska` BETWEEN '2017-11-04 22:50:00' AND  '2017-11-04 23:50:00')
AND r.`vozilo_id` = v.`vozilo_id` AND v.`zupanija_id` = 1 AND r.`status` =  1 ) 

#top lista adresa zupanija sa najvise rezervacija moderatora/taksista sa ID-om 2 (voditelj)
SELECT a.`ulica`, a.`grad`, COUNT(*) AS `broj_rezervacija` 
FROM `rezervacija` r, `adresa` a, `zupanija` z 
WHERE r.`adresa_polaska_id` = a.`adresa_id` AND a.`zupanija_id` = z.`zupanija_id` 
AND z.`moderator_id` = 2 AND r.`status` = 1
GROUP BY adresa ORDER BY `broj_rezervacija` DESC

#ukupan broj odrađenih prijevoza po vozilu za određeni vremenski period 
#npr. od 2017-11-01 00:00:00 - 2017-11-05 23:55:00
#po zupanijama moderatora/taksista sa ID-om 2 (voditelj) 
SELECT z.`naziv` AS `zupanija`, v.`oznaka` AS oznaka, COUNT(*) AS `odradeni_prijevozi` 
FROM `rezervacija` r, `vozilo` v, `zupanija` z 
WHERE r.`vozilo_id` = v.`vozilo_id` AND v.`zupanija_id` = z.`zupanija_id` 
AND z.`moderator_id` = 2 AND r.`datum_vrijeme_dolaska`
BETWEEN '2017-11-01 00:00:00'AND '2017-11-05 23:55:00' AND r.`status` = 1 
GROUP BY v.`oznaka` 

#izracun datuma i vremena zavrsetka nakon potvrde rezervacije pod ID-om 23
#zavrsetak jednako početak + vrijeme trajanja (npr. 30 minuta). 
UPDATE `rezervacija` SET `status` = '1', 
datum_vrijeme_dolaska = datum_vrijeme_polaska + INTERVAL 30 MINUTE
WHERE `rezervacija`.`rezervacija_id` = 23 
 
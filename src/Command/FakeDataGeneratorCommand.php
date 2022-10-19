<?php

namespace App\Command;

use App\DoctrineRepositoryGetter;
use App\Entity\Arta;
use App\Entity\Cazare;
use App\Entity\MancareBautura;
use App\Entity\MonumenteIstorice;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FakeDataGeneratorCommand extends Command
{
    private OutputInterface $output;

    public function __construct(
        private readonly DoctrineRepositoryGetter $doctrineRepositoryGetter,
        private readonly EntityManagerInterface $entityManager,
    ) {
        parent::__construct();
    }

    protected function configure()
    {
        parent::configure();

        $this->setName('app:fake:generator');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->output = $output;
        $this->generateMonuments();
        $this->generateArt();
        $this->generateHotels();
        $this->generateRestaurantCafe();

        return 0;
    }

    private function truncateTable(string $tableName)
    {
        $connection = $this->entityManager->getConnection();
        $dbPlatform = $connection->getDatabasePlatform();
        $connection->query('SET FOREIGN_KEY_CHECKS=0');
        $q = $dbPlatform->getTruncateTableSql($tableName);
        $connection->executeUpdate($q);
        $connection->query('SET FOREIGN_KEY_CHECKS=1');
    }

    protected function generateMonuments()
    {
        $monumenteIstoriceRepository=$this->doctrineRepositoryGetter->getRepository(MonumenteIstorice::class);
        $count = $monumenteIstoriceRepository->count([]);
        if ($count > 0) {
            $this->truncateTable('monumente_istorice');
        }
        $names = [
            'Catedrala Sfantul Vitus',
            'Vechea Sinagoga Noua',
            'Manastirea Strahov',
            'Biserica Tyn',
            'Manastirea Loreta',
            'Biserica Sfantul Nicolae',
            'Catedrala Sfintii Chiril si Metodiu',
            'Sinagoga Spaniola',
            'Cartierul Mala Strana',
            'Turnul de Pulbere',
            'Turnul Petrin',
            'Castelul din Praga',
            'Palatul Regal de vara',
            'Palatul si gradinile Wallenstein',
            'Palatul Lobkowicz',
            'Vechiul Palat Regal',
            'Castelul si cimitirul Vysehard',
            'Palatul Schwarzenberg',
            'Palatul Sternberg',
            'Palatul Lucerna',
            'Podul Carol',
            'Cartierul evreiesc',
            'Piata Wenceslas',
            'Piata Orasului Vechi',
            'Strada de aur',
            'Ceasul Astronomic',
            'Monumentul Jan Hus',
            'Turnul Daliborka',
            'Monumentul maresalului Konev',
        ];
        $cats = [
            'Catedrala',
            'Sinagoga',
            'Manastrire',
            'Biserica',
            'Manastrire',
            'Biserica',
            'Catedrala',
            'Sinagoga',
            'Cartier',
            'Turn',
            'Turn',
            'Castel',
            'Palat',
            'Palat',
            'Palat',
            'Palat',
            'Castel',
            'Palat',
            'Palat',
            'Palat',
            'Pod',
            'Cartier',
            'Piata',
            'Piata',
            'Cartier',
            'Diverse',
            'Diverse',
            'Turn',
            'Diverse',
        ];
        $year = [
            '1344' ,
            '1344' ,
            '1143' ,
            '1365' ,
            '1631' ,
            '1755' ,
            '1736' ,
            '1868' ,
            '1257' ,
            '1475' ,
            '1891' ,
            '1929' ,
            '1560' ,
            '1623' ,
            '1945' ,
            '1135' ,
            '1841' ,
            '1576' ,
            '1707' ,
            '1920' ,
            '1402' ,
            '1850' ,
            '1348' ,
            '1915' ,
            '1864' ,
            '1410' ,
            '1915' ,
            '1980' ,
            '1980' ,
        ];
        $address = [
            'III. nádvoří 48/2, 119 01 Praha 1-Hradčany' ,
            'Červená ulice, Staré Město' ,
            'Strahovské nádvoří 1/132, 118 00 Praha 1-Strahov' ,
            'Staroměstské nám., 110 00 Staré Město' ,
            'Loretánské nám. 7, 118 00 Praha 1-Hradčany' ,
            'Malostranské nám., 118 00 Malá Strana' ,
            'Resslova 307, 120 00 Nové Město' ,
            'Vězeňská 1, 110 00 Staré Město' ,
            'Malá Strana' ,
            'nám. Republiky 5, 110 00 Staré Město' ,
            'Petřínské sady 633, 118 00 Praha 1-Malá Strana' ,
            'Hradčany, 119 08 Prague 1' ,
            'Třetí nádvoří Pražského hradu 48' ,
            'Letenská 123/4, 118 00 Malá Strana' ,
            'Jiřská 3, 119 00 Praha 1-Hradčany' ,
            'Hradčany, 119 08 Prague 1' ,
            'V Pevnosti 159/5b, 128 00 Praha 2-Vyšehrad' ,
            'Hradčanské nám. 2, 118 00 Praha 1-Hradčany' ,
            'Hradčanské nám. 57/15, 118 00 Praha 1-Hradčany' ,
            'Vodičkova 704/36, 110 00 Nové Město' ,
            'Karlův most, 110 00 Praha 1' ,
            'Široká 3, 110 00 Josefov' ,
            'Václavské nám 110 00 Nové Město' ,
            'Staroměstské nám., 110 00 Josefov' ,
            'Hradčany, 119 00 Praga 1' ,
            'Staroměstské nám. 1, 110 00 Josefov' ,
            'Staroměstské nám., 110 00 Staré Město' ,
            'Zlatá ulička u Daliborky 12, 119 00 Praha 1-Hradčany' ,
            'Nám. Interbrigády 160 00 Praha 6' ,
        ];
        $oreDeschidere = [9, 10, 11, 12, 13];
        $oreInchidere = [16, 17, 18, 19];

        for ($index = 1; $index <= 29; $index++) {
            $monument = new MonumenteIstorice();
            $monument->setNume($names[$index - 1]);
            $monument->setCategorie($cats[$index - 1]);
            $monument->setOraDeschidere((new \DateTime())->setTime($oreDeschidere[random_int(0, 4)], 0, 0));
            $monument->setOraInchidere((new \DateTime())->setTime($oreInchidere[random_int(0, 3)], 0, 0));
            $monument->setPretBilet(rand(100,500));
            $monument->setAnConstructie($year[$index - 1]);
            $monument->setAdresa($address[$index - 1]);
            $this->entityManager->persist($monument);
        }
        $this->entityManager->flush();
    }

    protected function generateArt()
    {
        $artaRepository=$this->doctrineRepositoryGetter->getRepository(Arta::class);
        $count = $artaRepository->count([]);
        if ($count > 0) {
           $this->truncateTable('arta');
        }
        $names = [
            'Galeria Jaroslav Fragner' ,
            'Muzeul National' ,
            'Muzeul Franz Kafka' ,
            'Galeria Nationala' ,
            'Muzeul Dvorak' ,
            'Muzeul de arte decorative' ,
            'Muzeul comunismului' ,
            'Muzeul W.A. Mozart' ,
            'Muzeul Kampa' ,
            'Muzeul Mucha' ,
            'Muzeul militar' ,
            'Muzeul Instrumentelor Medievale de Tortura' ,
            'Muzeul Figurilor de Ceară' ,
            'Muzeul de Ciocolată “Choco Story”' ,
            'Muzeul Jucariilor și Papusilor' ,
            'Muzeul berii cehe' ,
            'Muzeul Karel Zeman' ,
            'Muzeul Speculum Alchemiae' ,
            'Muzeul KGB' ,
            'Muzeul evreiesc' ,
            'Muzeul Transportului Public' ,
            'Muzeul torturii' ,
            'Casa care danseaza' ,
            'Teatru National' ,
            'Teatrul Svanda din Smichov ' ,
            'Teatrul Estates' ,
            'Rudolfinum' ,
            'Teatrul Negru' ,
            'Opera de Stat ' ,
            'Detska' ,
        ];
        $cats = [
            'Galerie' ,
            'Muzeu' ,
            'Muzeu' ,
            'Galerie' ,
            'Muzeu' ,
            'Muzeu' ,
            'Muzeu' ,
            'Muzeu' ,
            'Muzeu' ,
            'Muzeu' ,
            'Muzeu' ,
            'Muzeu' ,
            'Muzeu' ,
            'Muzeu' ,
            'Muzeu' ,
            'Muzeu' ,
            'Muzeu' ,
            'Muzeu' ,
            'Muzeu' ,
            'Muzeu' ,
            'Muzeu' ,
            'Muzeu' ,
            'Diverse' ,
            'Teatru' ,
            'Teatru' ,
            'Teatru' ,
            'Teatru' ,
            'Teatru' ,
            'Opera' ,
            'Opera' ,
        ];
        $address = [
            'Betlémské nám. 169, 110 00 Staré Město' ,
            'Václavské nám. 68, 115 79 Praha 1' ,
            'Cihelná 635 / 2b, 118 00 Praha 1-Malá Strana' ,
            'Staroměstské nám. 1, 110 15 Staré Město' ,
            'Ke Karlovu 462/20, 120 00 Nové Město' ,
            '17. listopadu 2, 110 00 Josefov' ,
            'V Celnici 1031/4, 118 00 Nové Město' ,
            'Mozartova 169, 150 00 Praha 5' ,
            'U Sovových mlýnů 2, 118 00 Malá Strana' ,
            'Panská 7, 110 00 Nové Město' ,
            'U Památníku 1600/2, 130 00 Praha 3-Žižkov' ,
            'Celetná 558, 110 00 Staré Město' ,
            'Celetná 555/6, 110 00 Staré Město' ,
            'Old Town, 110 00 Prague 1' ,
            'Jirska 4, Praga 1' ,
            'Husova Husova 241/7, 110 00 Praha 1' ,
            'Saská 3, 118 00 Praha 1-Malá Strana' ,
            'Haštalská 1, 110 00 Staré Město' ,
            'Vlašská 591/13, 118 00 Malá Strana' ,
            'U Staré školy 141/1, 110 00 Praha 1-Staré Město' ,
            'Patočkova 4, 162 00 Praha 6' ,
            'Křižovnické náměstí 1/194, Praga 1' ,
            'Jiráskovo nám. 1981/6, 120 00 Nové Město' ,
            'Národní 2, 110 00 Nové Město' ,
            'Štefánikova 6/57, 150 00 Praha 5-Smíchov' ,
            'Železná, 110 00 Staré Město' ,
            'Alšovo nábř. 12, 110 00 Josefov' ,
            'Karoliny Světlé 18, 110 00 Nové Město' ,
            'Wilsonova 4, 110 00 Praha 1-Vinohrady' ,
            'Týnská 627, 110 00 Staré Město' ,
        ];
        $oreDeschidere = [9, 10, 11, 12, 13];
        $oreInchidere = [16, 17, 18, 19];

        for ($index = 1; $index <= 30; $index++) {
            $arta = new Arta();
            $arta->setNume($names[$index - 1]);
            $arta->setCategorie($cats[$index-1]);
            $arta->setOraDeschidere((new \DateTime())->setTime($oreDeschidere[random_int(0, 4)], 0, 0));
            $arta->setOraInchidere((new \DateTime())->setTime($oreInchidere[random_int(0, 3)], 0, 0));
            $arta->setPretBilet(rand(100,500));
            $arta->setAdresa($address[$index-1]);
            $this->entityManager->persist($arta);
        }
        $this->entityManager->flush();
    }

    protected function generateHotels()
    {
        $hotelsRepository=$this->doctrineRepositoryGetter->getRepository(Cazare::class);
        $count = $hotelsRepository->count([]);
        if ($count > 0) {
            $this->truncateTable('cazare');
        }
        $names = [
            'Residence Agnes' ,
            'Cube' ,
            'Pytloun Boutique' ,
            'BoHO' ,
            'Mandarin Oriental' ,
            'Remember Residence' ,
            'Schwaiger' ,
            'Bishops House' ,
            'Four Seasons' ,
            'Cosmopolitan' ,
            'Maximilian' ,
            'Republica & Suites  ' ,
            'Anyday' ,
            'Little Tom' ,
            'Radisson Blu' ,
            'Garden court' ,
            'Malostranska Residence' ,
            'House at the big Boot' ,
            'At the White Lily' ,
            'Grandium' ,
            'Rezidence Vysehrad' ,
            'Aparthotel City 5' ,
            'MeetMe23' ,
            'Rott' ,
            'Archibald At The Charles Bridge' ,
            'Seven Wishes Boutique Residence' ,
            'Mamaison Residence Downtown' ,
            'Golden star' ,
            'MOOo Downtown' ,
            'Alchymist Grand' ,
        ];
        $cats = [
            'Hotel' ,
            'Hotel' ,
            'Hotel' ,
            'Hotel' ,
            'Hotel' ,
            'Hotel ' ,
            'Hotel' ,
            'Hotel' ,
            'Hotel' ,
            'Hotel' ,
            'Hotel' ,
            'Hotel' ,
            'Apartament' ,
            'Apartament' ,
            'Hotel' ,
            'Hotel' ,
            'Hotel' ,
            'Hotel' ,
            'Hotel' ,
            'Hotel' ,
            'Hotel' ,
            'Apartament' ,
            'Hotel' ,
            'Hotel' ,
            'Hotel' ,
            'Apartament' ,
            'Hotel' ,
            'Hotel' ,
            'Hotel' ,
            'Hotel' ,
        ];
        $address = [
            '19, Haštalská 943, 110 00 Praha' ,
            'Křemencova 18, 110 00 Nové Město' ,
            'Václavské nám. 779/16, 110 00 Nové Město' ,
            'Senovážná 1254/4, 110 00 Nové Město' ,
            'Nebovidská 459/1, 118 00 Malá Strana' ,
            'Vodní 528/9, 150 00 Praha 5-Smíchov,' ,
            'Schwaigerova 59/3, 160 00 Praha 6-Bubeneč' ,
            'Dražického nám. 62/6, 118 00 Malá Strana' ,
            'Veleslavínova 1098/2a, 110 00 Josefov' ,
            'Zlatnická 1126, 110 00 Nové Město' ,
            'Haštalská 752/14, 110 00 Staré Město' ,
            'Petrská 5, 110 00 Petrská čtvrť' ,
            '9, Sokolská 454, Nové Město, 120 00 Praha 2' ,
            'omáškova 3, 150 00 Praha 5-Smíchov' ,
            'Žitná 561/8, 120 00 Nové Město' ,
            'Spálená 90/17, 110 00 Nové Město' ,
            'Malostranské nám. 38, 118 00 Malá Strana' ,
            'Vlašská 30, 118 00 Malá Strana' ,
            'Jánský vršek 310/4, 118 00 Malá Strana' ,
            'Politických vězňů 913/12, 110 00 Nové Město' ,
            'Lumírova 1715, 140 00 Praha 4-Nusle' ,
            'Vltavská 11, 150 00 Praha 5-Smíchov' ,
            '23, Washingtonova 1568, Nové Město, 110 00 Praha' ,
            'Malé Nám. 138/4, 110 00 Staré Město' ,
            '15, Na Kampě 508, Malá Strana, 118 00 Praha' ,
            'Vítkova 14, 186 00 Karlín' ,
            'Na Rybníčku 1329/5, 120 00 Nové Město' ,
            'Nerudova 48, 118 00 Praha 1-Hradčany' ,
            'Myslíkova 263/22, 120 00 Nové Město' ,
            'Tržiště 19, 118 00 Malá Strana' ,
        ];


        for ($index = 1; $index <= 30; $index++) {
            $hotels = new Cazare();
            $hotels->setNume($names[$index - 1]);
            $hotels->setCategorie($cats[$index-1]);
            $hotels->setRating(rand(1,5));
            $hotels->setNrCamere(rand(10,100));
            $hotels->setPretNoapte(rand(100,1000));
            $hotels->setAdresa($address[$index-1]);
            $this->entityManager->persist($hotels);
        }
        $this->entityManager->flush();
    }

    protected function generateRestaurantCafe()
    {
        $restaurantCafeRepository=$this->doctrineRepositoryGetter->getRepository(MancareBautura::class);
        $count = $restaurantCafeRepository->count([]);
        if ($count > 0) {
            $this->truncateTable('mancare_bautura');
        }
        $names = [
            'Kandelábr' ,
            'Public Chilli' ,
            'Brasileiro' ,
            'El Arriero' ,
            'Mlýnec' ,
            'Zvonice' ,
            'Café Imperial' ,
            'Le Grill' ,
            'La Piccola Perla' ,
            'Kogo Havelská ristorant' ,
            'Agave' ,
            'Brasileiro U Zelené žáby' ,
            'Kozlovna Apropos' ,
            'Czech Slovak' ,
            'U Houmra' ,
            'PAPRIKA - Mediterranean Kitchen & Bar' ,
            'La Finestra in Cucina' ,
            'George Prime Steak' ,
            'U Modré Kachničky' ,
            'Cafe Designum' ,
            'Cafe No. 3' ,
            'Kafe Damu' ,
            'Týnská 9' ,
            'La Bohème Café' ,
            'Artisan Cafe & Bistrot' ,
            'Café Louvre' ,
            'Café Kristián' ,
            'Caffé Famoso' ,
            'The Miners Old Town' ,
            'Anonymous Bar' ,
            'ALIBI. cocktail&music bar Praha' ,
            'American Bar in the Municipal House' ,
            'Hemingway Bar' ,
            'Crazy Daisy' ,
            'Gastro Bar 1401' ,
            'L Fleur' ,
            'Tynska Bar and Books' ,
            'Green Devil s Absinth Bar & Shop' ,
            'Tretter s New York Bar' ,
            'CakeShop' ,
            'Cukrárna u Moučků' ,
            'Pâtisserie Saint Tropez' ,
            'Vanille' ,
            'Trdelník pâtisserie traditionnelle' ,
            'Ovocný Světozor' ,
            ];
        $cats = [
            'Restaurant' ,
            'Restaurant' ,
            'Restaurant' ,
            'Restaurant' ,
            'Restaurant' ,
            'Restaurant' ,
            'Cafenea' ,
            'Restaurant' ,
            'Restaurant' ,
            'Restaurant' ,
            'Restaurant' ,
            'Restaurant' ,
            'Restaurant' ,
            'Restaurant' ,
            'Restaurant' ,
            'Restaurant' ,
            'Restaurant' ,
            'Restaurant' ,
            'Restaurant' ,
            'Cafenea' ,
            'Cafenea' ,
            'Cafenea' ,
            'Cafenea' ,
            'Cafenea' ,
            'Cafenea' ,
            'Cafenea' ,
            'Cafenea' ,
            'Cafenea' ,
            'Cafenea' ,
            'Bar' ,
            'Bar' ,
            'Bar' ,
            'Bar' ,
            'Bar' ,
            'Bar' ,
            'Bar' ,
            'Bar' ,
            'Bar' ,
            'Bar' ,
            'Cofetarie' ,
            'Cofetarie' ,
            'Patriserie' ,
            'Cofetarie' ,
            'Patriserie' ,
            'Cofetarie' ,
        ];
        $stil = [
            'Divers' ,
            'Divers' ,
            'Brazilian' ,
            'Divers' ,
            'Divers' ,
            'Divers' ,
            'Divers' ,
            'Grill' ,
            'Italian' ,
            'Italian' ,
            'Mexican' ,
            'Brazilian' ,
            'Ceh' ,
            'Ceh' ,
            'Ceh' ,
            'Mediteranean' ,
            'Italian' ,
            'Grill' ,
            'Ceh' ,
            'Divers' ,
            'Divers' ,
            'Divers' ,
            'Divers' ,
            'Divers' ,
            'Divers' ,
            'Divers' ,
            'Divers' ,
            'Divers' ,
            'Divers' ,
            'Cocktail' ,
            'Cocktail' ,
            'Divers' ,
            'Divers' ,
            'Divers' ,
            'Divers' ,
            'Divers' ,
            'Divers' ,
            'Cocktail' ,
            'Cocktail' ,
            'Divers' ,
            'Divers' ,
            'Divers' ,
            'Divers' ,
            'Divers' ,
            'Divers' ,
        ];
        $address = [
            'QUBIX Office Building, Štětkova 1638/18, 140 00 Praha 4' ,
            'Ovocný trh 12, 110 00 Staré Město' ,
            'U Radnice 110 00, 110 00 Staré Město' ,
            'Radlická 380/23, 150 00 Praha 5-Smíchov' ,
            'Novotného lávka 9, 110 00 Staré Město' ,
            'Jindřišská 33, 110 00 věž-Nové Město' ,
            'Na Poříčí 1072/15, 110 00 Petrská čtvrť' ,
            '12, Hybernská 1002, Nové Město, 110 00 Praha 1' ,
            'Perlová 412/1, 110 00 Staré Město' ,
            'Havelská 496/29, 110 00 Staré Město' ,
            '2, Masná 620/2, Staré Město, 110 00 Praha' ,
            'U Radnice 8/13, 110 00 Staré Město' ,
            'Křižovnická 4, 110 00 Staré Město' ,
            '20, Újezd 423, Malá Strana, 118 00 Praha 1' ,
            'Šumavská 20, 120 00 Praha 2-Vinohrady' ,
            'Rumunská 8/16, 120 00 Vinohrady' ,
            'Platnéřská 90/13, 110 00 Staré Město' ,
            '19, Platnéřská 111, Staré Město, 110 00 Praha 1' ,
            'Nebovidská 460/6, 118 00 Malá Strana' ,
            'Nerudova 27, 118 00 Malá Strana' ,
            'Jakubská 676/3, 110 00 Staré Město' ,
            'Karlova 26, 110 00 Staré Město' ,
            'Týnská 626/9, 110 00 Staré Město' ,
            'Sázavská 2031/32, 120 00 Vinohrady' ,
            'Vejvodova 445/1, 110 00 Staré Město' ,
            'Národní 22, 110 00 Nové Město' ,
            'Na Příkopě 853, 110 00 Nové Město' ,
            'Masarykovo nábř. 30, 110 00 Nové Město' ,
            'Železná 490/14, 110 00 Staré Město' ,
            'Michalská 432, 110 00 Staré Město' ,
            'Žitná 1575, 110 00 Nové Město' ,
            'Náměstí Republiky 5, 110 00 Staré Město' ,
            'Karoliny Světlé 26, 110 00 Staré Město' ,
            'Václavské nám. 773/4, 110 00 Můstek' ,
            'Michalská 970/20, 110 00 Staré Město' ,
            'V Kolkovně 920, 110 00 Staré Město' ,
            ' 19, Týnská 1053, 110 00 Praha 1' ,
            'Týn 637/7, 110 00 Staré Město' ,
            'V Kolkovně 3, 110 00 Staré Město' ,
            'Celetná 598/11, 110 00 Staré Město' ,
            'Revoluční 383, 251 63 Strančice' ,
            'Karmelitská 20, 110 00 Malá Strana' ,
            'Náměstí Míru 342, 120 00 Vinohrady' ,
            'Celetná 565, 110 00 Staré Město' ,
            'Vodičkova 39, 110 00 Nové Město' ,
        ];
        $oreDeschidere = [8, 9, 10, 11, 12, 13];
        $oreInchidere = [18, 19, 20, 21, 22, 23];

        for ($index = 1; $index <= 45; $index++) {
            $restaurantCafe = new MancareBautura();
            $restaurantCafe->setNume($names[$index - 1]);
            $restaurantCafe->setCategorie($cats[$index-1]);
            $restaurantCafe->setOraDeschidere((new \DateTime())->setTime($oreDeschidere[random_int(0, 5)], 0, 0));
            $restaurantCafe->setOraInchidere((new \DateTime())->setTime($oreInchidere[random_int(0, 5)], 0, 0));
            $restaurantCafe->setStil($stil[$index - 1]);
            $restaurantCafe->setRating(rand(1,5));
            $restaurantCafe->setAdresa($address[$index - 1]);
            $this->entityManager->persist($restaurantCafe);
        }
        $this->entityManager->flush();
    }
}

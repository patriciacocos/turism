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
            'III. n??dvo???? 48/2, 119 01 Praha 1-Hrad??any' ,
            '??erven?? ulice, Star?? M??sto' ,
            'Strahovsk?? n??dvo???? 1/132, 118 00 Praha 1-Strahov' ,
            'Starom??stsk?? n??m., 110 00 Star?? M??sto' ,
            'Loret??nsk?? n??m. 7, 118 00 Praha 1-Hrad??any' ,
            'Malostransk?? n??m., 118 00 Mal?? Strana' ,
            'Resslova 307, 120 00 Nov?? M??sto' ,
            'V??ze??sk?? 1, 110 00 Star?? M??sto' ,
            'Mal?? Strana' ,
            'n??m. Republiky 5, 110 00 Star?? M??sto' ,
            'Pet????nsk?? sady 633, 118 00 Praha 1-Mal?? Strana' ,
            'Hrad??any, 119 08 Prague 1' ,
            'T??et?? n??dvo???? Pra??sk??ho hradu 48' ,
            'Letensk?? 123/4, 118 00 Mal?? Strana' ,
            'Ji??sk?? 3, 119 00 Praha 1-Hrad??any' ,
            'Hrad??any, 119 08 Prague 1' ,
            'V Pevnosti 159/5b, 128 00 Praha 2-Vy??ehrad' ,
            'Hrad??ansk?? n??m. 2, 118 00 Praha 1-Hrad??any' ,
            'Hrad??ansk?? n??m. 57/15, 118 00 Praha 1-Hrad??any' ,
            'Vodi??kova 704/36, 110 00 Nov?? M??sto' ,
            'Karl??v most, 110 00 Praha 1' ,
            '??irok?? 3, 110 00 Josefov' ,
            'V??clavsk?? n??m 110 00 Nov?? M??sto' ,
            'Starom??stsk?? n??m., 110 00 Josefov' ,
            'Hrad??any, 119 00 Praga 1' ,
            'Starom??stsk?? n??m. 1, 110 00 Josefov' ,
            'Starom??stsk?? n??m., 110 00 Star?? M??sto' ,
            'Zlat?? uli??ka u Daliborky 12, 119 00 Praha 1-Hrad??any' ,
            'N??m. Interbrig??dy 160 00 Praha 6' ,
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
            'Muzeul Figurilor de Cear??' ,
            'Muzeul de Ciocolat?? ???Choco Story???' ,
            'Muzeul Jucariilor ??i Papusilor' ,
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
            'Betl??msk?? n??m. 169, 110 00 Star?? M??sto' ,
            'V??clavsk?? n??m. 68, 115 79 Praha 1' ,
            'Ciheln?? 635 / 2b, 118 00 Praha 1-Mal?? Strana' ,
            'Starom??stsk?? n??m. 1, 110 15 Star?? M??sto' ,
            'Ke Karlovu 462/20, 120 00 Nov?? M??sto' ,
            '17. listopadu 2, 110 00 Josefov' ,
            'V Celnici 1031/4, 118 00 Nov?? M??sto' ,
            'Mozartova 169, 150 00 Praha 5' ,
            'U Sovov??ch ml??n?? 2, 118 00 Mal?? Strana' ,
            'Pansk?? 7, 110 00 Nov?? M??sto' ,
            'U Pam??tn??ku 1600/2, 130 00 Praha 3-??i??kov' ,
            'Celetn?? 558, 110 00 Star?? M??sto' ,
            'Celetn?? 555/6, 110 00 Star?? M??sto' ,
            'Old Town, 110 00 Prague 1' ,
            'Jirska 4, Praga 1' ,
            'Husova Husova 241/7, 110 00 Praha 1' ,
            'Sask?? 3, 118 00 Praha 1-Mal?? Strana' ,
            'Ha??talsk?? 1, 110 00 Star?? M??sto' ,
            'Vla??sk?? 591/13, 118 00 Mal?? Strana' ,
            'U Star?? ??koly 141/1, 110 00 Praha 1-Star?? M??sto' ,
            'Pato??kova 4, 162 00 Praha 6' ,
            'K??i??ovnick?? n??m??st?? 1/194, Praga 1' ,
            'Jir??skovo n??m. 1981/6, 120 00 Nov?? M??sto' ,
            'N??rodn?? 2, 110 00 Nov?? M??sto' ,
            '??tef??nikova 6/57, 150 00 Praha 5-Sm??chov' ,
            '??elezn??, 110 00 Star?? M??sto' ,
            'Al??ovo n??b??. 12, 110 00 Josefov' ,
            'Karoliny Sv??tl?? 18, 110 00 Nov?? M??sto' ,
            'Wilsonova 4, 110 00 Praha 1-Vinohrady' ,
            'T??nsk?? 627, 110 00 Star?? M??sto' ,
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
            '19, Ha??talsk?? 943, 110 00 Praha' ,
            'K??emencova 18, 110 00 Nov?? M??sto' ,
            'V??clavsk?? n??m. 779/16, 110 00 Nov?? M??sto' ,
            'Senov????n?? 1254/4, 110 00 Nov?? M??sto' ,
            'Nebovidsk?? 459/1, 118 00 Mal?? Strana' ,
            'Vodn?? 528/9, 150 00 Praha 5-Sm??chov,' ,
            'Schwaigerova 59/3, 160 00 Praha 6-Bubene??' ,
            'Dra??ick??ho n??m. 62/6, 118 00 Mal?? Strana' ,
            'Veleslav??nova 1098/2a, 110 00 Josefov' ,
            'Zlatnick?? 1126, 110 00 Nov?? M??sto' ,
            'Ha??talsk?? 752/14, 110 00 Star?? M??sto' ,
            'Petrsk?? 5, 110 00 Petrsk?? ??tvr??' ,
            '9, Sokolsk?? 454, Nov?? M??sto, 120 00 Praha 2' ,
            'om????kova 3, 150 00 Praha 5-Sm??chov' ,
            '??itn?? 561/8, 120 00 Nov?? M??sto' ,
            'Sp??len?? 90/17, 110 00 Nov?? M??sto' ,
            'Malostransk?? n??m. 38, 118 00 Mal?? Strana' ,
            'Vla??sk?? 30, 118 00 Mal?? Strana' ,
            'J??nsk?? vr??ek 310/4, 118 00 Mal?? Strana' ,
            'Politick??ch v??z???? 913/12, 110 00 Nov?? M??sto' ,
            'Lum??rova 1715, 140 00 Praha 4-Nusle' ,
            'Vltavsk?? 11, 150 00 Praha 5-Sm??chov' ,
            '23, Washingtonova 1568, Nov?? M??sto, 110 00 Praha' ,
            'Mal?? N??m. 138/4, 110 00 Star?? M??sto' ,
            '15, Na Kamp?? 508, Mal?? Strana, 118 00 Praha' ,
            'V??tkova 14, 186 00 Karl??n' ,
            'Na Rybn????ku 1329/5, 120 00 Nov?? M??sto' ,
            'Nerudova 48, 118 00 Praha 1-Hrad??any' ,
            'Mysl??kova 263/22, 120 00 Nov?? M??sto' ,
            'Tr??i??t?? 19, 118 00 Mal?? Strana' ,
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
            'Kandel??br' ,
            'Public Chilli' ,
            'Brasileiro' ,
            'El Arriero' ,
            'Ml??nec' ,
            'Zvonice' ,
            'Caf?? Imperial' ,
            'Le Grill' ,
            'La Piccola Perla' ,
            'Kogo Havelsk?? ristorant' ,
            'Agave' ,
            'Brasileiro U Zelen?? ????by' ,
            'Kozlovna Apropos' ,
            'Czech Slovak' ,
            'U Houmra' ,
            'PAPRIKA - Mediterranean Kitchen & Bar' ,
            'La Finestra in Cucina' ,
            'George Prime Steak' ,
            'U Modr?? Kachni??ky' ,
            'Cafe Designum' ,
            'Cafe No. 3' ,
            'Kafe Damu' ,
            'T??nsk?? 9' ,
            'La Boh??me Caf??' ,
            'Artisan Cafe & Bistrot' ,
            'Caf?? Louvre' ,
            'Caf?? Kristi??n' ,
            'Caff?? Famoso' ,
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
            'Cukr??rna u Mou??k??' ,
            'P??tisserie Saint Tropez' ,
            'Vanille' ,
            'Trdeln??k p??tisserie traditionnelle' ,
            'Ovocn?? Sv??tozor' ,
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
            'QUBIX Office Building, ??t??tkova 1638/18, 140 00 Praha 4' ,
            'Ovocn?? trh 12, 110 00 Star?? M??sto' ,
            'U Radnice 110 00, 110 00 Star?? M??sto' ,
            'Radlick?? 380/23, 150 00 Praha 5-Sm??chov' ,
            'Novotn??ho l??vka 9, 110 00 Star?? M??sto' ,
            'Jind??i??sk?? 33, 110 00 v????-Nov?? M??sto' ,
            'Na Po???????? 1072/15, 110 00 Petrsk?? ??tvr??' ,
            '12, Hybernsk?? 1002, Nov?? M??sto, 110 00 Praha 1' ,
            'Perlov?? 412/1, 110 00 Star?? M??sto' ,
            'Havelsk?? 496/29, 110 00 Star?? M??sto' ,
            '2, Masn?? 620/2, Star?? M??sto, 110 00 Praha' ,
            'U Radnice 8/13, 110 00 Star?? M??sto' ,
            'K??i??ovnick?? 4, 110 00 Star?? M??sto' ,
            '20, ??jezd 423, Mal?? Strana, 118 00 Praha 1' ,
            '??umavsk?? 20, 120 00 Praha 2-Vinohrady' ,
            'Rumunsk?? 8/16, 120 00 Vinohrady' ,
            'Platn????sk?? 90/13, 110 00 Star?? M??sto' ,
            '19, Platn????sk?? 111, Star?? M??sto, 110 00 Praha 1' ,
            'Nebovidsk?? 460/6, 118 00 Mal?? Strana' ,
            'Nerudova 27, 118 00 Mal?? Strana' ,
            'Jakubsk?? 676/3, 110 00 Star?? M??sto' ,
            'Karlova 26, 110 00 Star?? M??sto' ,
            'T??nsk?? 626/9, 110 00 Star?? M??sto' ,
            'S??zavsk?? 2031/32, 120 00 Vinohrady' ,
            'Vejvodova 445/1, 110 00 Star?? M??sto' ,
            'N??rodn?? 22, 110 00 Nov?? M??sto' ,
            'Na P????kop?? 853, 110 00 Nov?? M??sto' ,
            'Masarykovo n??b??. 30, 110 00 Nov?? M??sto' ,
            '??elezn?? 490/14, 110 00 Star?? M??sto' ,
            'Michalsk?? 432, 110 00 Star?? M??sto' ,
            '??itn?? 1575, 110 00 Nov?? M??sto' ,
            'N??m??st?? Republiky 5, 110 00 Star?? M??sto' ,
            'Karoliny Sv??tl?? 26, 110 00 Star?? M??sto' ,
            'V??clavsk?? n??m. 773/4, 110 00 M??stek' ,
            'Michalsk?? 970/20, 110 00 Star?? M??sto' ,
            'V Kolkovn?? 920, 110 00 Star?? M??sto' ,
            ' 19, T??nsk?? 1053, 110 00 Praha 1' ,
            'T??n 637/7, 110 00 Star?? M??sto' ,
            'V Kolkovn?? 3, 110 00 Star?? M??sto' ,
            'Celetn?? 598/11, 110 00 Star?? M??sto' ,
            'Revolu??n?? 383, 251 63 Stran??ice' ,
            'Karmelitsk?? 20, 110 00 Mal?? Strana' ,
            'N??m??st?? M??ru 342, 120 00 Vinohrady' ,
            'Celetn?? 565, 110 00 Star?? M??sto' ,
            'Vodi??kova 39, 110 00 Nov?? M??sto' ,
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

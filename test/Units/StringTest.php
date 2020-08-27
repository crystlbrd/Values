<?php


namespace crystlbrd\Values\Tests\Units;


use crystlbrd\Values\Exceptions\InvalidArgumentException;
use crystlbrd\Values\Exceptions\UnsupportedFeatureException;
use crystlbrd\Values\NumVal;
use crystlbrd\Values\StrVal;
use PHPUnit\Framework\TestCase;

class StringTest extends TestCase
{
    /**
     * Tests, if String generates random values correctly
     * @throws InvalidArgumentException*@throws \crystlbrd\Values\Exceptions\UnsupportedFeatureException
     * @throws UnsupportedFeatureException
     * @author crystlbrd
     * @small
     */
    public function testRandom()
    {
        /// CONFIG

        // Different test scenarios
        $datasets = [
            [
                'pool' => 'abcdefghijklmnopqrstuvwxyz',
                'length' => 10,
            ],
            [
                'pool' => '0123456789abcdef',
                'length' => 16
            ]
        ];

        // Number of iteration per set
        $iterations = 100;


        /// TEST

        foreach ($datasets as $dataset) {
            for ($i = 0; $i < $iterations; $i++) {
                // Generate random string
                $string = StrVal::random($dataset['pool'], $dataset['length']);

                // Validate type
                self::assertIsString($string);

                // Validate string
                self::assertRegExp('/^[' . $dataset['pool'] . ']{' . $dataset['length'] . '}$/', $string);
            }
        }
    }

    /**
     * Tests, if random throws an Exception, if length is lesser than 0
     * @throws InvalidArgumentException
     * @throws UnsupportedFeatureException
     */
    public function testInvalidCallingOfRandom()
    {
        $this->expectException(InvalidArgumentException::class);
        StrVal::random('abc', -1);
    }

    /**
     * Test, if String returns random hex values correctly
     * @throws InvalidArgumentException
     * @throws UnsupportedFeatureException
     */
    public function testRandomHex()
    {
        /// CONFIG

        // Amount of iterations
        $iterations = 100;


        /// TEST

        for ($i = 0; $i < $iterations; $i++) {
            /// Lower case

            // get a random length
            $length = NumVal::random(32);

            // generate a random string
            $string = StrVal::randomHex($length);

            // validate
            self::assertIsString($string);
            self::assertRegExp('/^[abcdef0123456789]{' . $length . '}$/', $string);


            /// Upper case

            // get a random length
            $length = NumVal::random(32);

            // generate a random string
            $string = StrVal::randomHex($length, true);

            // validate
            self::assertIsString($string);
            self::assertRegExp('/^[ABCDEF0123456789]{' . $length . '}$/', $string);
        }
    }

    /**
     * Tests, if randomHex throws an Exception, if length is lesser than 0
     * @throws InvalidArgumentException
     * @throws UnsupportedFeatureException
     */
    public function testInvalidCallingOfRandomHex()
    {
        $this->expectException(InvalidArgumentException::class);
        StrVal::randomHex(-1);
    }

    public function testSanitizeUrl()
    {
        $datasets = [
            'Hello World!' => 'hello-world',
            '„Wegbereiter der Inklusion“ soll ausgezeichnet werden!' => 'wegbereiter-der-inklusion-soll-ausgezeichnet-werden',
            'Ersatzverkehr zwischen Neumünster Süd und Kaltenkirchen' => 'ersatzverkehr-zwischen-neumuenster-sued-und-kaltenkirchen',
            'Einzelcoaching Existenzgründung, Bewerbercoaching, Mikrofinanzierung' => 'einzelcoaching-existenzgruendung-bewerbercoaching-mikrofinanzierung',
            'kikudoo - Kurse einfach machen' => 'kikudoo-kurse-einfach-machen',
            'GBS Bürofachmarkt - www.gbs-buerofachmarkt.de' => 'gbs-buerofachmarkt-www-gbs-buerofachmarkt-de',
            'Ätherische Öle: Viel mehr als nur ein schöner Duft' => 'aetherische-oele-viel-mehr-als-nur-ein-schoener-duft',
            'Hallo, ich bin ein Titel' => 'hallo-ich-bin-ein-titel',
            'Test“„ ! – - " %%&/)";öäüp neu' => 'test-oeaeuep-neu',
            '"moin_Karriere": Nachwuchswerbung via Instagram' => 'moin_karriere-nachwuchswerbung-via-instagram',
            'Land und UKSH stellen „Zukunftspakt UKSH“ vor' => 'land-und-uksh-stellen-zukunftspakt-uksh-vor',
            'Innenminister Grote überreicht Preis an Blekendorfer Umweltprojekt' => 'innenminister-grote-ueberreicht-preis-an-blekendorfer-umweltprojekt',
            'Fachkräfte: Land verlängert Ausbildungsprojekte der Türkischen Gemeinde' => 'fachkraefte-land-verlaengert-ausbildungsprojekte-der-tuerkischen-gemeinde',
            'Schleswig-Holstein immer attraktiver für dänische Firmen' => 'schleswig-holstein-immer-attraktiver-fuer-daenische-firmen',
            'Neues Konzept für 2020: Imagemagazin Kieler Förde für Gäste' => 'neues-konzept-fuer-2020-imagemagazin-kieler-foerde-fuer-gaeste',
            ' Ihr Partner in der Elektrotechnik, Lackiertechnik und Heizung & Sanitär' => 'ihr-partner-in-der-elektrotechnik-lackiertechnik-und-heizung-sanitaer',
            'Bestellung einer/eines ehrenamtlichen Ortsnaturschutzbeauftragten' => 'bestellung-einer-eines-ehrenamtlichen-ortsnaturschutzbeauftragten',
            'Der Norden droht weiter abgehängt zu werden' => 'der-norden-droht-weiter-abgehaengt-zu-werden',
            'Ärztegenossenschaft Nord mahnt Änderungen im Digitale-Versorgung-Gesetz an.' => 'aerztegenossenschaft-nord-mahnt-aenderungen-im-digitale-versorgung-gesetz-an',
            'TüV NORD gibt Tipps für den Straßenverkehr im Herbst' => 'tuev-nord-gibt-tipps-fuer-den-strassenverkehr-im-herbst',
            'Rhetorik-Seminar: „Frauen, ergreift das Wort!“' => 'rhetorik-seminar-frauen-ergreift-das-wort',
            'Umweltbildungsprogramm: „Klasse! EnergieForscher“' => 'umweltbildungsprogramm-klasse-energieforscher',
        ];

        foreach ($datasets as $in =>  $out) {
            self::assertSame($out, StrVal::urlSanitize($in));
        }
    }
}
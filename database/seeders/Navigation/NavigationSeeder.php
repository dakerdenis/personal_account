<?php

namespace Database\Seeders\Navigation;

use App\Models\MenuItem;
use App\Models\Navigation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Symfony\Component\Console\Output\ConsoleOutput;

class NavigationSeeder extends Seeder
{
    public function run()
    {
        $navigation = Navigation::create([
            'name'         => 'Main Navigation',
            'machine_name' => 'main_navigation',
        ]);
        $menu_items = [
            ['title' => 'Главная страница', 'slug' => '/', 'active' => 0, 'navigation_id' => $navigation->id],
            [
                'title'         => 'Fərdi şəxslərə',
                'slug'          => Str::slug('Fərdi şəxslərə'),
                'active'        => 1,
                'navigation_id' => $navigation->id,
                'children'      => [
                    [
                        'title'         => 'Tibbi',
                        'slug'          => Str::slug('Tibbi'),
                        'active'        => 1,
                        'navigation_id' => $navigation->id,
                        'children'      => [
                            ['title' => 'Könüllü tibbi sığorta', 'slug' => Str::slug('Könüllü tibbi sığorta'), 'active' => 1, 'navigation_id' => $navigation->id],
                        ],
                    ],
                    [
                        'title'         => 'Nəqliyyat',
                        'slug'          => Str::slug('Nəqliyyat'),
                        'active'        => 1,
                        'navigation_id' => $navigation->id,
                        'children'      => [
                            ['title' => 'İcbari avtonəqliyyat sığortası', 'slug' => Str::slug('Könüllü tibbi sığorta'), 'active' => 1, 'navigation_id' => $navigation->id],
                            ['title' => 'Könüllü avtonəqliyyat sığortası (Kasko)', 'slug' => Str::slug('Könüllü avtonəqliyyat sığortası (Kasko)'), 'active' => 1, 'navigation_id' => $navigation->id],
                        ],
                    ],
                    [
                        'title'         => 'Səyahət',
                        'slug'          => Str::slug('Səyahət'),
                        'active'        => 1,
                        'navigation_id' => $navigation->id,
                        'children'      => [
                            ['title' => 'Səyahət sığortası', 'slug' => Str::slug('Könüllü tibbi sığorta'), 'active' => 1, 'navigation_id' => $navigation->id],
                        ],
                    ],
                    [
                        'title'         => 'Əmlak',
                        'slug'          => Str::slug('Əmlak'),
                        'active'        => 1,
                        'navigation_id' => $navigation->id,
                        'children'      => [
                            ['title' => 'İcbari daşınmaz əmlak sığortası', 'slug' => Str::slug('İcbari daşınmaz əmlak sığortası'), 'active' => 1, 'navigation_id' => $navigation->id],
                            ['title' => 'Könüllü daşınmaz əmlak sığortası', 'slug' => Str::slug('Könüllü daşınmaz əmlak sığortası'), 'active' => 1, 'navigation_id' => $navigation->id],
                        ],
                    ],
                ],
            ],
            [
                'title'         => 'Korporativ müştərililərə',
                'slug'          => Str::slug('Korporativ müştərililərə'),
                'active'        => 1,
                'navigation_id' => $navigation->id,
                'children'      => [
                    [
                        'title'         => 'Tibbi',
                        'slug'          => Str::slug('Tibbi'),
                        'active'        => 1,
                        'navigation_id' => $navigation->id,
                        'children'      => [
                            ['title' => 'Könüllü tibbi sığorta', 'slug' => Str::slug('Könüllü tibbi sığorta'), 'active' => 1, 'navigation_id' => $navigation->id],
                        ],
                    ],
                    [
                        'title'         => 'Nəqliyyat',
                        'slug'          => Str::slug('Nəqliyyat'),
                        'active'        => 1,
                        'navigation_id' => $navigation->id,
                        'children'      => [
                            ['title' => 'İcbari avtonəqliyyat sığortası', 'slug' => Str::slug('Könüllü tibbi sığorta'), 'active' => 1, 'navigation_id' => $navigation->id],
                            ['title' => 'Könüllü avtonəqliyyat sığortası (Kasko)', 'slug' => Str::slug('Könüllü avtonəqliyyat sığortası (Kasko)'), 'active' => 1, 'navigation_id' => $navigation->id],
                        ],
                    ],
                    [
                        'title'         => 'Səyahət',
                        'slug'          => Str::slug('Səyahət'),
                        'active'        => 1,
                        'navigation_id' => $navigation->id,
                        'children'      => [
                            ['title' => 'Səyahət sığortası', 'slug' => Str::slug('Könüllü tibbi sığorta'), 'active' => 1, 'navigation_id' => $navigation->id],
                        ],
                    ],
                    [
                        'title'         => 'Əmlak',
                        'slug'          => Str::slug('Əmlak'),
                        'active'        => 1,
                        'navigation_id' => $navigation->id,
                        'children'      => [
                            ['title' => 'İcbari daşınmaz əmlak sığortası', 'slug' => Str::slug('İcbari daşınmaz əmlak sığortası'), 'active' => 1, 'navigation_id' => $navigation->id],
                            ['title' => 'Könüllü daşınmaz əmlak sığortası', 'slug' => Str::slug('Könüllü daşınmaz əmlak sığortası'), 'active' => 1, 'navigation_id' => $navigation->id],
                        ],
                    ],
                ],
            ],
        ];
        foreach ($menu_items as $item) {
            MenuItem::create(
                $item
            );
        }

        $navigation = Navigation::create([
            'name'         => 'Footer&Side Navigation',
            'machine_name' => 'footer_navigation',
        ]);

        $menu_items = [
            [
                'title'         => 'Haqqımızda',
                'slug'          => Str::slug('Haqqımızda'),
                'active'        => 1,
                'navigation_id' => $navigation->id,
                'children'      => [
                    [
                        'title'         => 'Ümumi məlumat',
                        'slug'          => Str::slug('Ümumi məlumat'),
                        'active'        => 1,
                        'navigation_id' => $navigation->id
                    ],
                    [
                        'title'         => 'İş fəlsəfəsi',
                        'slug'          => Str::slug('İş fəlsəfəsi'),
                        'active'        => 1,
                        'navigation_id' => $navigation->id,
                    ],
                    [
                        'title'         => 'Faktlar və rəqəmlər',
                        'slug'          => Str::slug('Faktlar və rəqəmlər'),
                        'active'        => 1,
                        'navigation_id' => $navigation->id,
                    ],
                    [
                        'title'         => 'Rəhbərlik',
                        'slug'          => Str::slug('Rəhbərlik'),
                        'active'        => 1,
                        'navigation_id' => $navigation->id,
                    ],
                    [
                        'title'         => 'Maliyyə hesabatları',
                        'slug'          => Str::slug('Maliyyə hesabatları'),
                        'active'        => 1,
                        'navigation_id' => $navigation->id,
                    ],
                    [
                        'title'         => 'Sığorta şirkətinin ehtiyatları',
                        'slug'          => Str::slug('Sığorta şirkətinin ehtiyatları'),
                        'active'        => 1,
                        'navigation_id' => $navigation->id,
                    ],
                    [
                        'title'         => 'Sifarişçilər',
                        'slug'          => Str::slug('Sifarişçilər'),
                        'active'        => 1,
                        'navigation_id' => $navigation->id,
                    ],
                    [
                        'title'         => 'Xarici Partnyorlar',
                        'slug'          => Str::slug('Xarici Partnyorlar'),
                        'active'        => 1,
                        'navigation_id' => $navigation->id,
                    ],
                    [
                        'title'         => 'Tövsiyə məktubları və Rəylər',
                        'slug'          => Str::slug('Tövsiyə məktubları və Rəylər'),
                        'active'        => 1,
                        'navigation_id' => $navigation->id,
                    ],
                    [
                        'title'         => 'Sertifikatlar',
                        'slug'          => Str::slug('Sertifikatlar'),
                        'active'        => 1,
                        'navigation_id' => $navigation->id,
                    ],
                    [
                        'title'         => 'Mükafat və təltiflər',
                        'slug'          => Str::slug('Sertifikatlar'),
                        'active'        => 1,
                        'navigation_id' => $navigation->id,
                    ],
                ],
            ],
            [
                'title'         => 'Fərdi şəxslərə',
                'slug'          => Str::slug('Fərdi şəxslərə'),
                'active'        => 1,
                'navigation_id' => $navigation->id,
                'children'      => [
                    [
                        'title'         => 'Tibbi',
                        'slug'          => Str::slug('Tibbi'),
                        'active'        => 1,
                        'navigation_id' => $navigation->id,
                        'children'      => [
                            ['title' => 'Könüllü tibbi sığorta', 'slug' => Str::slug('Könüllü tibbi sığorta'), 'active' => 1, 'navigation_id' => $navigation->id],
                        ],
                    ],
                    [
                        'title'         => 'Nəqliyyat',
                        'slug'          => Str::slug('Nəqliyyat'),
                        'active'        => 1,
                        'navigation_id' => $navigation->id,
                        'children'      => [
                            ['title' => 'İcbari avtonəqliyyat sığortası', 'slug' => Str::slug('Könüllü tibbi sığorta'), 'active' => 1, 'navigation_id' => $navigation->id],
                            ['title' => 'Könüllü avtonəqliyyat sığortası (Kasko)', 'slug' => Str::slug('Könüllü avtonəqliyyat sığortası (Kasko)'), 'active' => 1, 'navigation_id' => $navigation->id],
                        ],
                    ],
                    [
                        'title'         => 'Səyahət',
                        'slug'          => Str::slug('Səyahət'),
                        'active'        => 1,
                        'navigation_id' => $navigation->id,
                        'children'      => [
                            ['title' => 'Səyahət sığortası', 'slug' => Str::slug('Könüllü tibbi sığorta'), 'active' => 1, 'navigation_id' => $navigation->id],
                        ],
                    ],
                    [
                        'title'         => 'Əmlak',
                        'slug'          => Str::slug('Əmlak'),
                        'active'        => 1,
                        'navigation_id' => $navigation->id,
                        'children'      => [
                            ['title' => 'İcbari daşınmaz əmlak sığortası', 'slug' => Str::slug('İcbari daşınmaz əmlak sığortası'), 'active' => 1, 'navigation_id' => $navigation->id],
                            ['title' => 'Könüllü daşınmaz əmlak sığortası', 'slug' => Str::slug('Könüllü daşınmaz əmlak sığortası'), 'active' => 1, 'navigation_id' => $navigation->id],
                        ],
                    ],
                ],
            ],
            [
                'title'         => 'Korporativ müştərililərə',
                'slug'          => Str::slug('Korporativ müştərililərə'),
                'active'        => 1,
                'navigation_id' => $navigation->id,
                'children'      => [
                    [
                        'title'         => 'Tibbi',
                        'slug'          => Str::slug('Tibbi'),
                        'active'        => 1,
                        'navigation_id' => $navigation->id,
                        'children'      => [
                            ['title' => 'Könüllü tibbi sığorta', 'slug' => Str::slug('Könüllü tibbi sığorta'), 'active' => 1, 'navigation_id' => $navigation->id],
                        ],
                    ],
                    [
                        'title'         => 'Nəqliyyat',
                        'slug'          => Str::slug('Nəqliyyat'),
                        'active'        => 1,
                        'navigation_id' => $navigation->id,
                        'children'      => [
                            ['title' => 'İcbari avtonəqliyyat sığortası', 'slug' => Str::slug('Könüllü tibbi sığorta'), 'active' => 1, 'navigation_id' => $navigation->id],
                            ['title' => 'Könüllü avtonəqliyyat sığortası (Kasko)', 'slug' => Str::slug('Könüllü avtonəqliyyat sığortası (Kasko)'), 'active' => 1, 'navigation_id' => $navigation->id],
                        ],
                    ],
                    [
                        'title'         => 'Səyahət',
                        'slug'          => Str::slug('Səyahət'),
                        'active'        => 1,
                        'navigation_id' => $navigation->id,
                        'children'      => [
                            ['title' => 'Səyahət sığortası', 'slug' => Str::slug('Könüllü tibbi sığorta'), 'active' => 1, 'navigation_id' => $navigation->id],
                        ],
                    ],
                    [
                        'title'         => 'Əmlak',
                        'slug'          => Str::slug('Əmlak'),
                        'active'        => 1,
                        'navigation_id' => $navigation->id,
                        'children'      => [
                            ['title' => 'İcbari daşınmaz əmlak sığortası', 'slug' => Str::slug('İcbari daşınmaz əmlak sığortası'), 'active' => 1, 'navigation_id' => $navigation->id],
                            ['title' => 'Könüllü daşınmaz əmlak sığortası', 'slug' => Str::slug('Könüllü daşınmaz əmlak sığortası'), 'active' => 1, 'navigation_id' => $navigation->id],
                        ],
                    ],
                ],
            ],
            [
                'title'         => 'Dəstək xidməti',
                'slug'          => Str::slug('Dəstək xidməti'),
                'active'        => 1,
                'navigation_id' => $navigation->id,
                'children'      => [
                    [
                        'title'         => 'Görüləcək tədbirlər üçün təlimat',
                        'slug'          => Str::slug('Görüləcək tədbirlər üçün təlimat'),
                        'active'        => 1,
                        'navigation_id' => $navigation->id
                    ],
                    [
                        'title'         => 'Alarm center',
                        'slug'          => Str::slug('Alarm center'),
                        'active'        => 1,
                        'navigation_id' => $navigation->id,
                    ],
                    [
                        'title'         => 'Tez-tez verilən suallar',
                        'slug'          => Str::slug('Tez-tez verilən suallar'),
                        'active'        => 1,
                        'navigation_id' => $navigation->id,
                    ],
                    [
                        'title'         => 'Ekspertlərin çağırılması',
                        'slug'          => Str::slug('Ekspertlərin çağırılması'),
                        'active'        => 1,
                        'navigation_id' => $navigation->id,
                    ],
                    [
                        'title'         => 'Geri ödəniş üçün müraciət proseduru',
                        'slug'          => Str::slug('Geri ödəniş üçün müraciət proseduru'),
                        'active'        => 1,
                        'navigation_id' => $navigation->id,
                    ],
                    [
                        'title'         => 'İnstruksiyalar',
                        'slug'          => Str::slug('İnstruksiyalar'),
                        'active'        => 1,
                        'navigation_id' => $navigation->id,
                    ],
                ],
            ],
            [
                'title'         => 'Şikayətlər və onların baxılması',
                'slug'          => Str::slug('Şikayətlər və onların baxılması'),
                'active'        => 1,
                'navigation_id' => $navigation->id,
                'children'      => [
                    [
                        'title'         => 'Şikayətin API vasitasilə yoxlanılmasıt',
                        'slug'          => Str::slug('Şikayətin API vasitasilə yoxlanılmasıt'),
                        'active'        => 1,
                        'navigation_id' => $navigation->id
                    ],
                ],
            ],
            [
                'title'         => 'Xəbərlər',
                'slug'          => Str::slug('Xəbərlər'),
                'active'        => 1,
                'navigation_id' => $navigation->id,
                'children'      => [
                    [
                        'title'         => 'Press-relizlər',
                        'slug'          => Str::slug('Press-relizlər'),
                        'active'        => 1,
                        'navigation_id' => $navigation->id
                    ],
                    [
                        'title'         => 'Xüsusi təkliflər',
                        'slug'          => Str::slug('Xüsusi təkliflər'),
                        'active'        => 1,
                        'navigation_id' => $navigation->id
                    ],
                    [
                        'title'         => 'Elektron KİV',
                        'slug'          => Str::slug('Elektron KİV'),
                        'active'        => 1,
                        'navigation_id' => $navigation->id
                    ],
                ],
            ],
            [
                'title'         => 'Mobil tətbiq',
                'slug'          => Str::slug('Mobil tətbiq'),
                'active'        => 1,
                'navigation_id' => $navigation->id,
                'children'      => [
                    [
                        'title'         => 'Tətbiq haqqında ümuni məlumat',
                        'slug'          => Str::slug('Tətbiq haqqında ümuni məlumat'),
                        'active'        => 1,
                        'navigation_id' => $navigation->id
                    ],
                    [
                        'title'         => 'API vasitasilə axtarış',
                        'slug'          => Str::slug('API vasitasilə axtarış'),
                        'active'        => 1,
                        'navigation_id' => $navigation->id
                    ],
                    [
                        'title'         => 'Həkimlərin API vasitasilə axtarışı',
                        'slug'          => Str::slug('Həkimlərin API vasitasilə axtarışı'),
                        'active'        => 1,
                        'navigation_id' => $navigation->id
                    ],
                    [
                        'title'         => 'Telemetriya haqqında',
                        'slug'          => Str::slug('Telemetriya haqqında'),
                        'active'        => 1,
                        'navigation_id' => $navigation->id
                    ],
                ],
            ],
            [
                'title'         => 'Əlaqə',
                'slug'          => Str::slug('Əlaqə'),
                'active'        => 1,
                'navigation_id' => $navigation->id,
                'children'      => [
                    [
                        'title'         => 'Ünvan, əlaqə məlumatları və xəritə',
                        'slug'          => Str::slug('Ünvan, əlaqə məlumatları və xəritə'),
                        'active'        => 1,
                        'navigation_id' => $navigation->id
                    ],
                    [
                        'title'         => 'Şöbə seçimi ilə müraciət forması',
                        'slug'          => Str::slug('Şöbə seçimi ilə müraciət forması'),
                        'active'        => 1,
                        'navigation_id' => $navigation->id
                    ],
                ],
            ],
            [
                'title'         => 'Karyera',
                'slug'          => Str::slug('Karyera'),
                'active'        => 1,
                'navigation_id' => $navigation->id,
                'children'      => [
                    [
                        'title'         => 'Kadr siyasəti',
                        'slug'          => Str::slug('Kadr siyasəti'),
                        'active'        => 1,
                        'navigation_id' => $navigation->id
                    ],
                    [
                        'title'         => 'Vakansiyalar',
                        'slug'          => Str::slug('Vakansiyalar'),
                        'active'        => 1,
                        'navigation_id' => $navigation->id
                    ],
                    [
                        'title'         => 'CV göndərmək',
                        'slug'          => Str::slug('CV göndərmək'),
                        'active'        => 1,
                        'navigation_id' => $navigation->id
                    ],
                ],
            ],
        ];

        foreach ($menu_items as $item) {
            MenuItem::create(
                $item
            );
        }

        $navigation = Navigation::create([
            'name'         => 'Button Navigation',
            'machine_name' => 'button_navigation',
        ]);

        $menu_items = [
            ['title' => 'Onlayn odenis', 'slug' => Str::slug('Onlayn odenis'), 'active' => 1, 'navigation_id' => $navigation->id],
            ['title' => 'Daxil Ol', 'slug' => Str::slug('Daxil ol'), 'active' => 1, 'navigation_id' => $navigation->id],
        ];

        foreach ($menu_items as $item) {
            MenuItem::create(
                $item
            );
        }

        Navigation::create([
            'name'         => 'Service Navigation',
            'machine_name' => 'service_navigation',
        ]);


        $output = new ConsoleOutput();
        $output->writeln("<fg=red>Navigations created</>");
    }
}
